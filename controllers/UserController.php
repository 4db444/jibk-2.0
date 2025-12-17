<?php

    include __DIR__ . "/CardController.php";
    include __DIR__ . "/TransactionController.php";

    class UserController {
        private static $connection;

        static function Connect (){
            try {
                self::$connection = new PDO("mysql:host=localhost;dbname=jibk2.0", "root", "Brahim@444");
            }catch (PDOException $e){
                echo "error: " . $e->getMessage();
            }
        }

        static function SignUp (string $username, string $password, string $password_confirmation, string $bank, int $initial_balance, string $type) {
            $errors = [];

            if (strlen($username) < 6) $errors["username"] = "User name must be at least 6 characters.";
            if (strlen($password) < 8) $errors["password"] = "Password must be at least 8 characters.";
            if ($password !== $password_confirmation) $errors["password_confirmation"] = "Wrong password confirmation.";
            if (!$bank) $errors["bank"] = "Invalide bank name.";
            if ($initial_balance < 0) $errors["initial_balance"] = "Initial balance can't be negative.";

            if (!empty($errors)){
                return ["success" => false, "errors" => $errors];
            }

            $check_username_statment = self::$connection->prepare("SELECT 1 FROM users WHERE username = :username");

            $check_username_statment->execute([
                ":username" => $username
            ]);

            if ($check_username_statment->fetch()) return [
                "success" => false,
                "errors" => ["username" => "This username already exists"]
            ];

            // creating the user record
            $insert_user_statment = self::$connection->prepare("
                INSERT INTO users(username, password) 
                values (:username, :password)"
            );

            $insert_user_statment->execute([
                ":username" => $username,
                ":password" => password_hash($password, PASSWORD_DEFAULT)
            ]);

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
    }

    UserController::connect();