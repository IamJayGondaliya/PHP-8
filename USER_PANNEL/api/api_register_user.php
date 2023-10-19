<?php

    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json");

    include("../config/config.php");

    $config = new Config();

    $res = array();

    if($_SERVER['REQUEST_METHOD'] == "POST") {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $psw = password_hash($_POST['psw'],PASSWORD_DEFAULT);

        $ans = $config->register_user($name,$email,$psw);

        if($ans) {
            $res['msg'] = "Inserted...";
            http_response_code(201);
        }
        else {
            $res['msg'] = "Failled...";
        }

    }
    else {
        $res['msg'] = "Only POST method is allowed...";
    }

    echo json_encode($res);

?>