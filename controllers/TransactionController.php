<?php
    class TransactionController {

        private static $connection;

        static function Connect () {
            try {
                self::$connection = new PDO("mysql:host=localhost;dbname=jibk2.0", "root", "Brahim@444");
            }catch(PDOException $e){
                echo "Error: " . $e->getMessage();
            }
        }

        static function CreateTransaction (string $type, string $title, float $amount, string $description, $date, int $card_id,$category_id){

            if (empty($date)){
                $create_transaction_statment = self::$connection->prepare("
                    insert into $type (title, amount, description, card_id, category_id)
                    values (:title, :amount, :description, :card_id, :category_id)
                ");
    
                $create_transaction_statment->execute([
                    ":title" => $title,
                    ":amount" => $amount,
                    ":description" => $description,
                    ":card_id" => $card_id,
                    ":category_id" => $category_id
                ]);
            }else{
                $create_transaction_statment = self::$connection->prepare("
                    insert into $type (title, amount, description, date, card_id, category_id)
                    values (:title, :amount, :description, :date, :card_id, :category_id)
                ");
    
                $create_transaction_statment->execute([
                    ":title" => $title,
                    ":amount" => $amount,
                    ":description" => $description,
                    ":date" => $date,
                    ":card_id" => $card_id,
                    ":category_id" => $category_id
                ]);
            }
        }

        static function ShowAllTransactions (){
            return self::$connection->query("
                (
                    select incomes.id, title, amount, description, date, bank, type, 'incomes' as 'table' from incomes 
                    join cards on cards.id = incomes.card_id
                    where cards.user_id = 1
                )
                union all
                (
                    select expenses.id, title, amount, description, date, bank, type, 'expenses' as 'table' from expenses
                    join cards on expenses.card_id = cards.id
                    where cards.user_id = 1
                ) 
                ORDER BY date desc, id desc
            ")->fetchAll(PDO::FETCH_ASSOC);
        }

        static function DeleteTransaction(string $table, int $id){
            self::$connection->query("delete from $table where id = $id");
        }

        static function ShowTransaction(string $table, int $id){
            return self::$connection->query("select * from $table where id = $id");
        }

        static function UpdateTransaction (int $id, string $type, string $title, float $amount, string $description, $date, int $card_id,$category_id){
            if (empty($date)){
                $create_transaction_statment = self::$connection->prepare("
                    update $type
                    set title = :title, amount = :amount, description = :description, card_id = :card_id, category_id = :category_id
                    where id = :id
                ");
    
                $create_transaction_statment->execute([
                    ":id" => $id,
                    ":title" => $title,
                    ":amount" => $amount,
                    ":description" => $description,
                    ":card_id" => $card_id,
                    ":category_id" => $category_id
                ]);
            }else{
                $create_transaction_statment = self::$connection->prepare("
                    update $type
                    set title = :title, amount = :amount, description = :description, date = :date, card_id = :card_id, category_id = :category_id
                    where id = :id
                ");
    
                $create_transaction_statment->execute([
                    ":id" => $id,
                    ":title" => $title,
                    ":amount" => $amount,
                    ":description" => $description,
                    ":date" => $date,
                    ":card_id" => $card_id,
                    ":category_id" => $category_id
                ]);
            }
        }

        static function GetTotoalTransactions (string $table){
            $sql = "select sum(amount) as sum from $table";

            return self::$connection->query($sql)->fetch(PDO::FETCH_ASSOC)["sum"]; 
        }

        static function GetCurrentMonthTransactions (string $table){
            $sql = "
                select sum(amount) as total
                from $table
                where month(date) = month(CURRENT_TIME);
            ";

            return self::$connection->query($sql)->fetch(PDO::FETCH_ASSOC)["total"];
        }

        static function GetTotoalTransactionsPerMonth (string $table){
            $sql = "select MONTHNAME(date) as month, sum(amount) as total
                from $table
                GROUP BY month
                limit 12;
            ";

            return self::$connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }

        static function GetCategegories (string $table) {
            return self::$connection->query("
                SELECT *
                FROM {$table}_categories
            ")->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    TransactionController::Connect();