<?php

    include("../config/config.php");

    $config = new Config();

    
    $sbm_buttom = @$_REQUEST['sbm-button'];
    
    if(isset($sbm_buttom)) {
        
        $name = $_POST['image_name'];
        $image_path = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        
        $destination = '../uploads/' . uniqid("img-") . $image_name;
        
        if(move_uploaded_file($image_path,$destination)) {
            $config->insert_media($name,$destination);
        }
        
    }
    
    $image_data = $config->getAllMedia();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


    <div class="container p-5">
        <form action="" method="post" enctype="multipart/form-data">

            Name: <input type="text" name="image_name"> <br>
            Image: <input type="file" name="image"> <br>

            <input type="submit" name="sbm-button">

        </form>
    </div>


    <div class="container p-5">
        
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">name</th>
                    <th scope="col">image</th>
                    <th scope="col span-2">actions</th>
                </tr>
            </thead>
            <tbody>

                <?php while($record = mysqli_fetch_assoc($image_data)) { ?>

                    <tr>
                        <th scope="row"> <?php echo $record['id']; ?> </th>
                        <td> <?php echo $record['name']; ?> </td>
                        <td> <img src="<?php echo $record['path']; ?>" height="50px"> </td>
                    </tr>

                <?php }?>
               
            </tbody>
        </table>

    </div>
    
</body>
</html>