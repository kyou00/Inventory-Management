<?php
include "db_conn.php";
session_start();
$id = $_GET['id'];
date_default_timezone_set("Asia/Manila");
$date = date("Y-m-d H:i:s");

$sql = "DELETE FROM `suppliers` WHERE id = $id;";
$sql .= "INSERT INTO `user_activity`(`id`, `user`, `activity`, `date`) VALUES (NULL,'{$_SESSION['username']}','Deleted a supplier', '$date')";
$result = mysqli_multi_query($conn, $sql);


if($result){
    header("Location: suppliers.php?msg=Record Deleted Successfully");
}
else{
    echo "Failed: " . mysqli_error($conn);
}
?>