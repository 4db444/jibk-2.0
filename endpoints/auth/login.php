<?php
    include "../../conf.php";
    include BASE_PATH . "/controllers/UserController.php";
    session_start();

    if ($_SERVER["REQUEST_METHODE"] = "POST"){
        $email = trim($_POST["email"]);
        $password = $_POST["password"];

        $result = UserController::login($email, $password);

        if($result["success"]){
            $_SESSION["user"] = $result["user"];
        } else {
            $_SESSION["error"] = $result["error"];
        }

        header("location: " . BASE_URL . "/views/transactions/transactions.php");
    }