<?php
include "db_conn.php";
session_start();
$id = $_GET['id'];

if(isset($_POST['submit'])) {
    date_default_timezone_set("Asia/Manila");
    $date = date("Y-m-d H:i:s");


    $res = mysqli_query($conn,"SELECT * FROM `inventory` WHERE id = $id");
    while($row=mysqli_fetch_array($res)){
        $img=$row["image"];
    }
    $imgpath = "img/".$img;
    unlink( $imgpath );

    $sql = "DELETE FROM `sales` WHERE itemid = '$id';";
    $sql .= "DELETE FROM `inventory` WHERE id = '$id';";
    $sql .= "INSERT INTO `user_activity`(`id`, `user`, `activity`, `date`) VALUES (NULL,'{$_SESSION['username']}','Deleted a product', '$date')";
    $result = mysqli_multi_query($conn, $sql);


    if($result){
        header("Location: index.php?msg=Record Deleted Successfully");
    }
    else{
        echo "Failed: " . mysqli_error($conn);
    }

}

?>
<html>
    <head>
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"  >
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link href='sidebar.css' rel='stylesheet'>
        <link rel="stylesheet" href="edit.css">
        <title>Advanz Tools - Home</title>
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
            <li>
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
            <li>
                <a href="user_activity.php">
                <i class='bx bx-info-circle'></i>
                    <span class="links_name">User Activities</span>
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
        
        <div class="popup" id="myForm">
        <form action="" method="post" enctype="multipart/form-data">
            <a href="index.php"><div class="close-btn" onclick="closeForm()">&times;</div></a>
            <?php
            $sql = "SELECT * FROM inventory WHERE id = $id LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
        ?>
            <div class="form">
                <h2>Confirmation</h2>
                
                <p>Product Code: <?php echo $row['product_code'] ?></p>
                <p>Product Name: <?php echo $row['product_name'] ?></p>
                <p>Total Cost: <?php echo $row['unit_cost'] ?></p>
                <p>Quantity: <?php echo $row['quantity'] ?></p>
                <p>Date Supplied: <?php echo $row['date'] ?></p>

                <div class="form-element">
                    <button type="submit" class="btn btn-success" name="submit" onclick="closeForm()">Save</button>
                </div>
                <div class="form-element">
                <a href="index.php">Cancel</a> 
                </div>
            </div>
        </form>
    </div>  
        </div>
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
        
    </script>  
   
    </body>
</html>