<?php

    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json");

    include("../config/config.php");

    $config = new Config();

    $res = array();

    if($_SERVER['REQUEST_METHOD'] == "POST") {

        $data = $_FILES;

        print_r($data);

        $name = $_POST['name'];
        $path = $data['image']['tmp_name'];
        $imag_name = $data['image']['name'];

        $destination = "../uploads/" . uniqid("img-") . $imag_name;

        $uploaded = move_uploaded_file($path,$destination);

        if($uploaded) {            
            $config->insert_media($name,$destination);
        }
        else {   

        }



    }
    else {

        $res['msg'] = "Only POST method is allowed... !!";

    }

    echo json_encode($res);

?>