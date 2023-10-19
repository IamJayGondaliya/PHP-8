<?php

    header("Access-Controll-Allow-Methods: PUT, PATCH");
    header("Content-Type: application/json");

    include("../config/config.php");

    $config = new Config();

    $res = array();

    if($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH') {

        $data = file_get_contents("php://input");   //String

        $record = array();

        parse_str($data,$record); //String  => Array

        $id = $record['id'];
        $name = $record['name'];
        $age = $record['age'];
        $course = $record['course'];

        $res['msg'] = $config->update($id,$name,$age,$course);

    }
    else {
        $res['msg'] = "Only PUT or PATCH methods are allowed...";
    }

    echo json_encode($res);

?>