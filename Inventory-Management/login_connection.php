<?php
class simpleCRUD{
    public static function connection(){
        try{
            $con=new PDO("mysql:host=localhost;dbname=advanz-inventory",'root','');
            return $con;
        }catch(PDOException $error1){
            echo $error1->getMessage();
        }catch(Exception $error2){
            echo $error2->getMessage();
        }
    }
    public static function insert($name,$email,$role,$number,$password,$username){
        $insert=simpleCRUD::connection()->prepare("INSERT INTO users(`id`,`name`,`email`,`role`,`number`,`password`,`username`) VALUES (NULL,:n,:e,:r,:k,:p,:u)");
        $insert->bindValue(':n',$name);
        $insert->bindValue(':e',$email);
        $insert->bindValue(':r',$role);
        $insert->bindValue(':k',$number);
        $insert->bindValue(':p',$password);
        $insert->bindValue(':u',$username);
        $insert->execute();
        if($insert){
            echo "<script>alert('Registered!')</script>";
        }else{
            echo "<script>alert('Not Registered!')</script>";
        }
    }   
    public static function login($username,$password){
        $login=simpleCRUD::connection()->prepare("SELECT role FROM users WHERE username=:u and password=:p");
        $login->bindValue(':u',$username);
        $login->bindValue(':p',$password);
        $login->execute();
        if($login->rowCount()>0){
            $fetch=$login->fetch(PDO::FETCH_ASSOC);
            session_start();
            if($fetch){
                switch ($fetch['role']){
                    case 'Admin';
                        $_SESSION['role']='Admin';
                        $_SESSION['username']=$username;
                        header('location:reports.php');
                        break;
                    case 'User';
                        $_SESSION['role']='User';
                        $_SESSION['username']=$username;
                        header('location:reports.php');
                        break;  
                }
            }
        }else{
            echo "<script>alert('User not Registered!')</script>";
        }
    }
}

?>