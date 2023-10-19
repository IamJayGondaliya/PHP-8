<?php

    header("Access-Control-Allow-Methods: DELETE");
    header("Content-Type: application/json");

    include("../config/config.php");

    $config = new Config();

    $res = array();

    if($_SERVER['REQUEST_METHOD'] == "DELETE") {

        $data = file_get_contents('php://input');

        parse_str($data,$res);

        $result = $config->delete($res['id']);

        $res['msg'] = $result ? "Record deleted.." : "ID not found";

        echo json_encode($res);        
    }

?>