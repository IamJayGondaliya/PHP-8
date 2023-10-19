<?php

    header("Access-Control-Allow-Methods: GET");
    header("Content-Type: application/json");

    include("../config/config.php");

    $config = new Config();

    $res = array();

    if($_SERVER['REQUEST_METHOD'] == "GET") {

        $data = $config->getAllRecords();

        $limit = mysqli_num_rows($data);

        $all_records = array();
        $res['data'] = array();

        while($record = mysqli_fetch_assoc($data)) {
            array_push($all_records,$record);
        }

        for($i = 0; $i < $limit; $i++) {
            array_push($res['data'],$all_records[$i]);
        }

        $res['limit'] = $limit;

        echo json_encode($res);
    }
    else {

        $res['msg'] = "Only GET method is allowed !!";

        echo json_encode($res);

    }

?>