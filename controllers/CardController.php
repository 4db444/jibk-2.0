<?php

    class CardController {
        private static $connection;

        static function Connect (){
            try {
                self::$connection = new PDO("mysql:host=localhost;dbname=jibk2.0", "root", "Brahim@444");
            }catch (PDOException $e){
                echo "error: " . $e->getMessage();
            }
        }

        static function Create (string $bank, string $type, string $username) {

            $user_statment = self::$connection->prepare("
                SELECT id
                FROM users
                WHERE username = :username
            ");

            $user_statment->execute([
                ":username" => $username
            ]);

            $user_id = $user_statment->fetch(PDO::FETCH_ASSOC)["id"];

            $insert_card_statment = self::$connection->prepare("
                insert into cards (bank, type, user_id)
                values (:bank, :type, :user_id)
            ");

            $insert_card_statment->execute([
                ":bank" => $bank,
                ":type" => $type,
                ":user_id" => $user_id
            ]);
        }

        static function GetAllCards (){
            return self::$connection->query("
                SELECT *
                FROM cards
            ")->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    CardController::Connect();