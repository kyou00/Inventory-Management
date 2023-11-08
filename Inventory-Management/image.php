<?php
require 'db_conn.php';
if(isset($_POST["submit"])){
    $product_name = $_POST["product_name"];
    if($_FILES["image"]["error"] === 4){
        echo
        "<script> alert('Image Does Not Exist'); </script>"
        ;
    }
    else{
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));
        if(!in_array($imageExtension, $validImageExtension)){
            echo
            "<script> alert('Invalid Image Extension'); </script>"
            ;
        }
        else if($fileSize > 1000000){
            echo
            "<script> alert('Image Size Is Too Large'); </script>"
            ;
        }
        else{
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;

            move_uploaded_file($tmpName, 'img/' .  $newImageName);
            $query = "INSERT INTO `inventory`(`id`, `product_name`, `image`) 
                        VALUES (NULL,'$product_name ','$newImageName')";
            mysqli_query($conn, $query);
            echo
            "<script> alert('Successfully Added'); </script>"
            ;
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
        <label for="name">Name: </label>
        <input type="text" name="product_name" id="product_name" required value=""><br>
        <label for="image">Image: </label>
        <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" value=""> <br> <br>
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>