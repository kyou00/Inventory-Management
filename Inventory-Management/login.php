<?php
require 'login_connection.php';
if (isset($_POST['login'])){
    $name=$_POST['name'];
    $password=$_POST['password'];

    if(!empty($_POST['name'])&&!empty($_POST['password'])){
        $login=simpleCRUD::login($name,$password);
    }else{
        echo "<script>alert('Please, all fields are required!')</script>";
    }
}


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head>
<body>
    <form action="login.php " method="post">
    <div class="box" id="box">
        <div class="form">
            <h2>Sign in</h2>
            <div class="inputBox">
                <input type="text" name="name" required="required">
                <span>Username</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="password" name="password" required="required">
                <span>Password</span>
                <i></i>
            </div>
            <div class="links">
                <a href="#"></a>
                <a href="#" class="toggleBtn1">Data Privacy Notice</a>
            </div>
            <!-- <a href="index.php"><input type="submit" value="Login"></a> -->
            <input type="submit" value="Login" name="login">
        </div>
    </div>
    </form>
   
    <div class="container" id="container">
        <div class="content">
            <h2>Data Privacy Notice</h2>
            <p>Advanz Tool & Die Supplies is committed to protecting the privacy and security of your personal information. In compliance with the Data Privacy Act of 2012, we would like to inform you of the following:</p>

            <p>Data Sharing: Advanz Tool & Die Supplies will not share your personal information with third parties unless it is necessary to provide our services, required by law, or with your prior consent.</p>
            
            <p>Data Security: Advanz Tool & Die Supplies implements appropriate physical, technical, and organizational security measures to protect your personal information from unauthorized access, disclosure, or use.</p>

            <p>Access to Personal Information: You have the right to access your personal information and request for its correction or deletion.</p>

            <p>Thank you for trusting Advanz Tool & Die Supplies with your personal information. We are committed to upholding the principles of data privacy and security.</p>
        </div>
        <div class="toggleBtn" id="toggleBtn"></div>
    </div>

    <script>
        let toggleBtn = document.querySelector('.toggleBtn');
        let toggleBtn1 = document.querySelector('.toggleBtn1');
        let container = document.querySelector('.container');
        toggleBtn.onclick = function(){
            container.classList.toggle("active");
        }
        toggleBtn1.onclick = function(){
            container.classList.toggle("active");
        }
        
        function openForm() {
        document.getElementById("box").style.display = "none";
        }

        function closeForm() {
        document.getElementById("box").style.display = "block";
        }

    </script>
</body>
</html>