<?php
include "db_conn.php";
session_start();

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $phone= $_POST['phone'];
    date_default_timezone_set("Asia/Manila");
    $date = date("Y-m-d H:i:s");

    $sql = "INSERT INTO `suppliers`(`id`, `supplier_name`, `email`, `address`, `city`, `phone`) VALUES (NULL,'$name','$email','$address','$city','$phone');";
    $sql .= "INSERT INTO `user_activity`(`id`, `user`, `activity`, `date`) VALUES (NULL,'{$_SESSION['username']}','Added new supplier - $name','$date')";

    $result = mysqli_multi_query($conn,$sql);

    if($result){
        header("Location: suppliers.php?msg=New record created successfully");
    }
    else{
        echo "Failed: ".mysqli_error($conn);
    }
}
?>


<html>
    <head>
        <title>Advanz Tools - Home</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"  >
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link href='sidebar.css' rel='stylesheet'>
        <link rel="stylesheet" href="index.css">
    </head>
    <body>
    <div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <i class='bx bxl-c-plus-plus'></i>
                <div class="logo_name">Advanz Tools</div>
            </div>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav_list">
            <li>
                    <i class='bx bx-search' ></i>
                    <input type="text" placeholder="Search...">
                </a>
                <span class="tooltip">Search</span>
            </li>
            <li>
                <a href="reports.php">
                <i class='bx bx-bar-chart-alt'></i>
                    <span class="links_name">Reports</span>
                </a>
                <span class="tooltip">Reports</span>
            </li>
            <li>
                <a href="index.php">
                    <i class='bx bx-box' ></i>
                    <span class="links_name">Inventory</span>
                </a>
                <span class="tooltip">Inventory</span>
            </li>
            <li>
                <a href="category.php">
                <i class='bx bxs-window-alt' ></i>
                    <span class="links_name">Category</span>
                </a>
                <span class="tooltip">Category</span>
            </li>
            <?php
                function getRoleee($n){
                    // Is number less than 11
                    if($n == 'User') return "none";
                    // Return default (black) for all other numbers
                    return "block";
                }
                $validation=getRoleee($_SESSION['role'])
            ?>
            <li style="display:<?=$validation?>">
                <a href="users.php">
                    <i class='bx bx-user' ></i>
                    <span class="links_name">Users</span>
                </a>
                <span class="tooltip">Users</span>
            </li>
            <li>
                <a href="customers.php">
                <i class='bx bx-body'></i>
                    <span class="links_name">Customer</span>
                </a>
                <span class="tooltip">Customer</span>
            </li>
            <li>
                <a href="branches.php">
                <i class='bx bx-store-alt'></i>
                    <span class="links_name">Branch</span>
                </a>
                <span class="tooltip">Branch</span>
            </li>
            <li>
                <a href="suppliers.php">
                <i class='bx bxs-factory'></i>
                    <span class="links_name">Supplier</span>
                </a>
                <span class="tooltip">Supplier</span>
            </li>
            <li>
                <a href="orders.php">
                <i class='bx bxs-briefcase'></i>
                    <span class="links_name">Orders</span>
                </a>
                <span class="tooltip">Orders</span>
            </li>
            <li>
                <a href="sales.php">
                <i class='bx bx-money-withdraw'></i>
                    <span class="links_name">Sales</span>
                </a>
                <span class="tooltip">Sales</span>
            </li>
            <?php
                function getRolee($n){
                    // Is number less than 11
                    if($n == 'User') return "none";
                    // Return default (black) for all other numbers
                    return "block";
                }
                $validation=getRolee($_SESSION['role'])
            ?>
            <li style="display:<?=$validation?>">
                <a href="user_activity.php">
                <i class='bx bx-info-circle'></i>
                    <span class="links_name" >User Activities</span>
                </a>
                <span class="tooltip">User Activities</span>
            </li>
        </ul>
        <div class="profile_content">
            <div class="profile">
                <div class="profile_details">
                    <img src="stocks-logo.png" alt="">
                    <div class="name_job">
                        <div class="job"><?php echo $_SESSION['username']; ?></div>
                        <div class="job"><?php echo $_SESSION['role']; ?></div>
                    </div>
                </div>
                <a href="login.php"><i class='bx bx-log-out' id="log_out" ></i></a>
            </div>
        </div>
    </div>
    
    <div class="home_content">
        <div class="text">
            <div class="container">
                <div class="table">
                    <div class="table_header">
                        <p>Supplier Details</p>
                        <div>
                        <input class="input2" type="text" placeholder="Supplier" id="live_search"/>
                            <button class="add_new" id="show-login" onclick="openForm()">Add New</button>
                        </div>
                    </div>
                    <div id="searchresult">
                    </div> 
                    <div class="table_section" id="table_section" style="height: 850px;">
                        <table>
                            <thead class="table-dark">
                            <tr>
                                <th scope="col">Full Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Address</th>
                                <th scope="col">City</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "db_conn.php";

                                    $sql = "SELECT * FROM `suppliers`";
                                    $result = mysqli_query($conn,$sql);
                                    function getRole($n){
                                        // Is number less than 11
                                        if($n == 'User') return "none";
                                        // Return default (black) for all other numbers
                                        return "block";
                                    }
                                    while ($row = mysqli_fetch_assoc($result)){
                                        $validation=getRole($_SESSION['role'])
                                        ?>
                                        <tr>
                                            <th><?php echo $row['supplier_name'] ?></th>
                                            <td><?php echo $row['email'] ?></td>
                                            <td><?php echo $row['address'] ?></td>
                                            <td><?php echo $row['city'] ?></td>
                                            <td><?php echo $row['phone'] ?></td>
                                            <td>
                                                <a href="edit-suppliers.php?id=<?php echo $row['id'] ?>" ><i class='bx bxs-edit' style="font-size: 25px"></i></a>
                                                <a href="delete-suppliers.php?id=<?php echo $row['id'] ?>" style="display:<?=$validation?>"><i class='bx bx-trash' style="font-size: 25px"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>      
            </div>
        </div>
    </div>
    
    <div class="popup" id="myForm">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="close-btn" onclick="closeForm()">&times;</div>
            <div class="form">
                <h2>Add Supplier</h2>
                <div class="form-element">
                    <input type="text" class="form-control" name="name" placeholder="Enter name">
                </div>
                <div class="form-element">
                    <input type="text" class="form-control"  name="email" placeholder="Enter email">
                </div>
                <div class="form-element">
                    <input type="text" class="form-control" name="address" placeholder="Enter address">
                </div>
                <div class="form-element">
                    <input type="text" class="form-control"name="city" placeholder="Enter city">
                </div>
                <div class="form-element">
                    <input type="text" class="form-control" name="phone" placeholder="Enter number">
                </div>
                <div class="form-element">
                    <button type="submit" class="btn btn-success" name="submit" onclick="closeForm()">Save</button>
                </div>
                <div class="form-element">
                <a href="index.php">Cancel</a> 
                </div>
            </div>
        </form>
    </div>      

    <script>
        let btn = document.querySelector("#btn");
        let sidebar = document.querySelector(".sidebar");
        let searchBtn = document.querySelector(".bx-search");

        btn.onclick = function(){
            sidebar.classList.toggle("active");
        }
        searchBtn.onclick = function(){
            sidebar.classList.toggle("active");
        }
        
        document.querySelector("#show-login").addEventListener("click",function(){
            document.querySelector(".popup").classList.add("active");
        });
        document.querySelector(".popup .close-btn").addEventListener("click",function(){
            document.querySelector(".popup").classList.remove("active");
        });

        function openForm() {
        document.getElementById("myForm").style.display = "block";
        }

        function closeForm() {
        document.getElementById("myForm").style.display = "none";
        }
    </script>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#live_search").keyup(function(){
                var input = $(this).val();

                if(input != ""){
                    $.ajax({
                        url:"livesearch-suppliers.php",
                        method:"POST",
                        data:{input:input},

                        success:function(data){
                            $("#searchresult").html(data);
                            $("#searchresult").css("display","block");
                            $("#table_section").css("display","none");
                        }
                    });
                }else{
                    $("#searchresult").css("display","none");
                    $("#table_section").css("display","block");
                }
            });
        });
    </script>
    </body>
</html>