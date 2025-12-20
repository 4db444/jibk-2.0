<?php
    include "../../conf.php";
    include  BASE_PATH . "/controllers/CardController.php";
    session_start();
    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $id = $_POST["id"];
        $result = CardController::destroy($id);
        if (!$result["success"]){
            $_SESSION["error"] = $result["error"];
        }
        header("location: " . BASE_URL . "/views/card/");
    }else {
        header("location: " . $_SERVER["HTTP_REFERER"]);
    }