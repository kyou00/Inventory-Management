<?php
include "db_conn.php";
session_start();
$id = $_GET['id'];
$username = $_SESSION['username'];
date_default_timezone_set("Asia/Manila");
$date = date("Y-m-d H:i:s");

$sql = "DELETE FROM `branches` WHERE id = $id;";
$sql .= "INSERT INTO `user_activity`(`id`, `user`, `activity`, `date`) VALUES (NULL,'{$_SESSION['username']}','Deleted a branch', '$date')";
$result = mysqli_multi_query($conn, $sql);


if($result){
    header("Location: branches.php?msg=Record Deleted Successfully");
}
else{
    echo "Failed: " . mysqli_error($conn);
}
?>