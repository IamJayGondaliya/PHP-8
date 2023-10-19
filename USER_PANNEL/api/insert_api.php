<?php

    // header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Method: POST");
    header("Content-Type: application/json");

    include("../config/config.php");

    $config = new Config();

    $res = array();

    //POST
    if($_SERVER['REQUEST_METHOD'] == "POST") {

        $name = @$_POST['name'];
        $age = @$_POST['age'];
        $course = @$_POST['course'];

        $result = $config->insert($name,$age,$course);

        if($result) {
            $res = ["msg" => "Record inserted successfully !!"];
            http_response_code(201);
            // $res['msg'] = "Inserted successfully !!";
        }
        else {
            $res = ["msg" => "Record insertion failled !!"];
        }

        echo json_encode($res);
    }
    else {
        
        $res = [
            'msg' => "Only POST method is allowed !!",
        ];
        
        http_response_code(403);

        echo json_encode($res);
    }

?>