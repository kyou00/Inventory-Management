<?php
include "db_conn.php";
session_start();
$id = $_GET['id'];

$sql = "UPDATE `inventory` SET `status`='enable' WHERE id = '$id';";
$result = mysqli_multi_query($conn, $sql);


if($result){
    header("Location: index-disabled.php?msg=Record Updated Successfully");
}
else{
    echo "Failed: " . mysqli_error($conn);
}
?>