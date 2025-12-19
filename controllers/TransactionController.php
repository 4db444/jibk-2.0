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

        static function CreateTransaction (string $type, string $title, float $amount, string $description, string $date, $card_id){

            if(empty($date)){
                $sql = "insert into $type (title, amount, description, card_id) values ('$title', $amount, '$description', $card_id)";
            }else {
                $sql = "insert into $type (title, amount, description, date, card_id) values ('$title', $amount, '$description', '$date', $card_id)";
            }

            $query = self::$connection->query($sql);
        }

        static function ShowAllTransactions (){
            return self::$connection->query("
                select *, 'incomes' as 'table' from incomes 
                union select *, 'expenses' as 'table' from expenses
                order by date desc
            ");
        }

        static function DeleteTransaction(string $table, int $id){
            self::$connection->query("delete from $table where id = $id");
        }

        static function ShowTransaction(string $table, int $id){
            return self::$connection->query("select * from $table where id = $id");
        }

        static function UpdateTransaction (int $id, string $type, string $title, float $amount, string $description, string $date){
            if(empty($date)){
                $sql = "update $type 
                    set title = \"$title\", amount = $amount, description = \"$description\"
                    where id = $id
                ";
            }else {
                $sql = "update $type
                set title = \"$title\", amount = $amount, description = \"$description\", date = \"$date\"
                where id = $id
            ";
            }

            $query = self::$connection->query($sql);
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