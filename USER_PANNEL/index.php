<?php

    include('config/config.php');

    //Object
    $config = new Config();

    // Subperglobal:    built in variables
    /*
            $_GET           => Associative array (Map)
            $_POST          => Associative array (Map)
            $_REQUEST       => Associative array (Map)
            $_SERVER       => Associative array (Map)
    */

    $submit_btn = @$_REQUEST['sbm_button'];
    $res = null;

    //isset($var)       => check variable is assigned or not

    if(isset($submit_btn)) {

        // header("Location: demo.php");

        $name = $_POST['fname'];
        $age = $_POST['age'];
        $course = $_POST['course'];

        $res = $config->insert($name,$age,$course);
    }

    
    $delete_btn = @$_REQUEST['delete_btn'];
    
    if(isset($delete_btn)) {
        
        $delete_id = $_POST['delete_id'];
        
        $delete_res = $config->delete($delete_id);
        
        if($delete_res) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success !!</strong> Record deleted successfully !!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Failed !!</strong> Id not found !!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        
    }
    
    $update_btn = @$_REQUEST['update_btn'];
    $fetched_single_record = null;
    
    
    if(isset($update_btn)) {
        
        $update_id = $_POST['update_id'];
        
        $update_res = $config->fetch_single_record($update_id);
        
        $fetched_single_record = mysqli_fetch_assoc($update_res);
        
        var_dump($fetched_single_record);       

    }
    
    $upd_button = @$_REQUEST['upd_button'];
    
    if(isset($upd_button)) {            
        
        $id = $_POST['id'];
        $name = $_POST['fname'];
        $age = $_POST['age'];
        $course = $_POST['course'];
        
        $upd_res = $config->update($id,$name,$age,$course);
        
        var_dump($upd_res);
        
        if($upd_res) {
            echo "$id Updated...";
        }
        else {
            echo "Failled to update...";
        }
        
    }
    
    
    $records = $config->getAllRecords();
    
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP-8</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
</head>
<body>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> -->
    
    <center><h1>PHP Form</h1></center> 
    <hr>

<!-- HTTP: Hypertext Transfer Protocol -->
<!-- GET:   Data fetch              | SELECT -->
<!-- POST:   Data create, insert    | INSERT -->
<!-- PUT/PATCH:   update,modify     | UPDATE -->
<!-- DELETE:   remove data          | DELETE -->

    <div class="container">
        <?php if($res) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success !!</strong> Record inserted successfully !!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <?php } else if($res == null) { ?>
            <div></div>
        <?php } else { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>

    <div class="container">
        <form action="" method="post">

            <input type="hidden" name="id" value="<?php if($fetched_single_record != null) {echo $fetched_single_record['id'];}?>">

            <div class="mb-3">
                <label for="fname" class="form-label">Name</label>
                <input type="text" class="form-control" id="fname" placeholder="Enter name" name="fname" value="<?php if($fetched_single_record != null){echo$fetched_single_record['name'];}?>">
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" placeholder="Enter age" name="age" value="<?php if($fetched_single_record != null){echo$fetched_single_record['age'];}?>">
            </div>
            <div class="mb-3">
                <label for="course" class="form-label">Course</label>
                <input type="text" class="form-control" id="course" placeholder="Enter course" name="course" value="<?php if($fetched_single_record != null){echo$fetched_single_record['course'];}?>">
            </div>
            <input type="submit" class="btn btn-outline-success" name="<?php if($fetched_single_record != null){echo "upd_button";} else {echo "sbm_button";}?>" value="<?php
            
                if($fetched_single_record != null) {
                    echo "Update";
                }
                else {
                    echo "Submit";
                }

            ?>"></input>
        </form>
    </div>


    <div class="container">

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">Course</th>
                    <th scope="col span-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($res = mysqli_fetch_assoc($records)) {?>
                <tr>
                    <th scope="row"> <?php echo $res['id'];?> </th>
                    <td> <?php echo $res['name'];?> </td>
                    <td> <?php echo $res['age'];?> </td>
                    <td> <?php echo $res['course'];?> </td>

                    <form action="" method="post">  
                        <input type="hidden" name="update_id" value="<?php echo $res['id'];?>">                      
                        <td> <input type="submit" class="btn btn-warning" name="update_btn" value="Update"></input> </td>
                    </form>

                    <form action="" method="post">
                        <input type="hidden" name="delete_id" value="<?php echo $res['id'];?>">
                        <td> <input type="submit" class="btn btn-danger" name="delete_btn" value="Delete" ></input> </td>
                    </form>
                    
                </tr>
                <?php }?>
            </tbody>
        </table>

            


            

    </div>

</body>
</html>
