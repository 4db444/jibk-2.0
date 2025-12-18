<?php

    include __DIR__ . "/CardController.php";
    include __DIR__ . "/TransactionController.php";
    include __DIR__ . "/MailController.php";

    class UserController {
        private static $connection;

        static function Connect (){
            try {
                self::$connection = new PDO("mysql:host=localhost;dbname=jibk2.0", "root", "Brahim@444");
            }catch (PDOException $e){
                echo "error: " . $e->getMessage();
            }
        }

        static function Create (string $username, string $email, string $password) {
            $insert_user_statment = self::$connection->prepare("
                INSERT INTO users (username, email, password)
                VALUES (:username, :email, :password)
            ");

            $insert_user_statment->execute([
                ":username" => $username,
                ":email" => $email,
                ":password" => password_hash($password, PASSWORD_DEFAULT)
            ]);
        }

        static function SignUp (string $username, string $email, string $password, string $password_confirmation, string $bank, int $initial_balance, string $type) {
            $errors = [];

            if (strlen($username) < 6) $errors["username"] = "User name must be at least 6 characters.";
            if (!preg_match('/^[a-z0-9]+@[a-z0-9]+\.[a-z]+$/i', $email)) $errors ["email"] = "Invalide email";
            if (strlen($password) < 8) $errors["password"] = "Password must be at least 8 characters.";
            if ($password !== $password_confirmation) $errors["password_confirmation"] = "Wrong password confirmation.";
            if (!$bank) $errors["bank"] = "Invalide bank name.";
            if ($initial_balance < 0) $errors["initial_balance"] = "Initial balance can't be negative.";

            if (!empty($errors)){
                return ["success" => false, "errors" => $errors];
            }

            $check_email_statment = self::$connection->prepare("SELECT 1 FROM users WHERE email = :email");

            $check_email_statment->execute([
                ":email" => $email
            ]);

            if ($check_email_statment->fetch()) return [
                "success" => false,
                "errors" => ["email" => "This email already exists"]
            ];

            // creating the user record
            self::Create($username, $email, $password);

            // creating the card record.
            CardController::create($bank, $type, $username);

            $card_id = self::$connection->query("
                SELECT id
                FROM cards
            ")->fetch(PDO::FETCH_ASSOC)["id"];

            // inserting the initial balance.
            TransactionController::CreateTransaction ("incomes", "Initial Balance", $initial_balance, "the initial balance when you created your acount", "", $card_id);
            
            return ["success" => true];
        }

        static function login (string $email, string $password){
            $errors = [];

            $user_statment = self::$connection->prepare("
                SELECT * 
                FROM users
                WHERE email = :email
            ");

            $user_statment->execute([
                ":email" => $email
            ]);

            $user = $user_statment->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user["password"])){
                $otp_statment = self::$connection->prepare("insert into otp (otp, expire_at, user_id) values (:otp, :expire_at, :user_id)");

                $otp_statment->execute([
                    ":otp" => random_int(100000, 999999),
                    ":expire_at" => (new DateTime())->modify("+10 minutes")->format("Y-m-d H:i:s"),
                    ":user_id" => $user["id"]
                ]);



                return [
                    "success" => true,
                    "user" => $user
                ];
            }

            return [
                "success" => false,
                "error" => "Wrong credentials"
            ];
        }
    }

    UserController::connect();