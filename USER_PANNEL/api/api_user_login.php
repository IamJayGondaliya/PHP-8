<?php

    header("Access-Controll-Allow-Methods: POST");
    header("Content-Type: application/json");

    include("../config/config.php");

    $config = new Config();

    $res = array();


    if($_SERVER['REQUEST_METHOD'] == "POST") {

        $email = $_POST['email'];
        $psw = $_POST['psw'];

        $res['msg'] = $config->login($email,$psw);

    }
    else {
        $res['msg'] = "Only POST method is allowed... !!";
    }

    echo json_encode($res);

?>