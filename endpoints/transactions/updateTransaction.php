<?php
    include "../../controllers/TransactionController.php";

    $id = $_POST["id"];
    $type = $_POST["type"];
    $title = $_POST["title"];
    $amount = $_POST["amount"];
    $description = $_POST["description"];
    $date = $_POST["date"];

    TransactionController::updateTransaction($id, $type, $title, $amount, $description, $date);

    header("location: ../../views/transactions/transactions.php");

    exit;
