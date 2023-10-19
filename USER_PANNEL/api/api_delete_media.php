<?php

    header("Access-Control-Allow-Methods: DELETE");
    header("Content-Type: application/json");

    include("../config/config.php");

    $config = new Config();

    $res = array();

    if($_SERVER['REQUEST_METHOD'] == "DELETE") {

        $str = file_get_contents("php://input");   //String
        $data = array();
        parse_str($str,$data);  // Array

        $id = $data['id'];

        $res['msg'] = $config->delete_media($id);

    }

    echo json_encode($res);

?>