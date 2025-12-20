<?php

    class CardController {
        private static $connection;

        static function Connect (){
            try {
                self::$connection = new PDO("mysql:host=localhost;dbname=jibk2.0", "root", "Brahim@444");
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            }catch (PDOException $e){
                echo "error: " . $e->getMessage();
            }
        }

        static function Create (string $bank, string $type, int $is_main, string $email) {

            $user_statment = self::$connection->prepare("
                SELECT `id`
                FROM `users`
                WHERE `email` = :email
            ");
            
            
            $user_statment->execute([
                ":email" => $email
            ]);
            
            $user_id = $user_statment->fetch(PDO::FETCH_ASSOC)["id"];

            $insert_card_statment = self::$connection->prepare("
                insert into cards (bank, type, is_main, user_id)
                values (:bank, :type, :is_main, :user_id)
            ");

            $insert_card_statment->execute([
                ":bank" => $bank,
                ":type" => $type,
                ":is_main" => $is_main,
                ":user_id" => $user_id
            ]);
        }

        static function GetAllUserCards (int $user_id){
            return self::$connection->query("
                SELECT *
                FROM cards
                WHERE id = $user_id
            ")->fetchAll(PDO::FETCH_ASSOC);
        }

        static function GetTotalExpenses(int $id){
            return self::$connection->query("select sum(amount) AS total from expenses")->fetch(PDO::FETCH_ASSOC)["total"];
        }

        static function GetTotalIncomes(int $id){
            return self::$connection->query("select sum(amount) AS total from incomes")->fetch(PDO::FETCH_ASSOC)["total"];
        }

        static function destroy (int $id) {
            $user_id = $_SESSION["user"]["id"];

            $count_cards_statment = self::$connection->prepare("
                select count(*) as total
                from cards
                where user_id = :user_id
            ");

            $count_cards_statment->execute([
                ":user_id" => $user_id
            ]);

            if ($count_cards_statment->fetch()["total"] > 1){
                $delete_card_statment = self::$connection->prepare("
                    delete from cards
                    where id = :id and user_id = user_id
                ");

                $delete_card_statment->execute([
                    ":id" => $id,
                    ":user_id" => $user_id,
                ]);

                return [
                    "success" => true,
                ];
            }else{
                return [
                    "success" => false,
                    "error" => "You can not delete this card, this is the only remaining one!"
                ];
            }
        }
    }

    CardController::Connect();