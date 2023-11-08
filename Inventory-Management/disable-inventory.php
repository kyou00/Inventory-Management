<?php
include "db_conn.php";
session_start();
$id = $_GET['id'];

$sql = "UPDATE `inventory` SET `status`='disabled' WHERE id = '$id';";
$result = mysqli_multi_query($conn, $sql);


if($result){
    header("Location: index.php?msg=Record Updated Successfully");
}
else{
    echo "Failed: " . mysqli_error($conn);
}
?>