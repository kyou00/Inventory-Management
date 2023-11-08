<?php
include "db_conn.php";
$id = $_GET['id'];
session_start();

if(isset($_POST['submit'])) {
    $old_total_cost= $_POST['old_total_cost'];
    $total_quantity = $_POST['total_quantity'];
    $total_cost = $old_total_cost * $total_quantity;
    $old_quantity = $_POST['old_quantity'];
    $ord_product_name = $_POST['ord_product_name'];
    $date = date("Y-m-d H:i:s");


    $new_quantity = $old_quantity - $total_quantity;


    $sql = "UPDATE `orders` SET `total_cost`='$total_cost',`total_quantity`='$total_quantity' WHERE id=$id;";
    $sql .= "UPDATE `inventory` SET `quantity`='$new_quantity' WHERE product_name = '$ord_product_name';";
    $sql .= "INSERT INTO `user_activity`(`id`, `user`, `activity`, `date`) VALUES (NULL,'{$_SESSION['username']}','Edited a order', '$date')";


    $result = mysqli_multi_query($conn,$sql);

    if($result){
        header("Location: orders.php?msg=Data Updated Successfully");
    }
    else{
        echo "Failed: ".mysqli_error($conn);
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
        <?php
            $sql = "SELECT inv.product_name, inv.unit_cost,ord.total_quantity FROM inventory inv, orders ord WHERE inv.id = ord.itemid && ord.id = $id LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
        ?>
        <div class="popup" id="myForm">
        <form action="" method="post" enctype="multipart/form-data">
            <a href="orders.php"><div class="close-btn" onclick="closeForm()">&times;</div></a>
            <div class="form">
                <h2>Edit Orders</h2>
                <div class="form-element">
                    <input type="hidden" class="form-control" name="old_total_cost" placeholder="Enter unit cost"value="<?php echo $row['unit_cost'] ?>">
                </div>
                <p><?php echo $row['unit_cost'] ?></p>
                <div class="form-element">
                    <input type="hidden" class="form-control" name="ord_product_name" placeholder="Enter unit cost"value="<?php echo $row['product_name'] ?>">
                </div>
                <p><?php echo $row['product_name'] ?></p>
                <div class="form-element">
                    <input type="text" class="form-control" name="total_quantity" placeholder="Enter quantity"value="<?php echo $row['total_quantity'] ?>">
                </div>
                <div class="form-element">
                    <button type="submit" class="btn btn-success" name="submit" onclick="closeForm()">Save</button>
                </div>
                <div class="form-element">
                <a href="orders.php">Cancel</a> 
                </div>
                <?php
                $sql = "SELECT inv.quantity FROM inventory inv,orders ord WHERE inv.id=ord.itemid && ord.id = $id";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                ?>
                <div class="form-element">
                    <input type="hidden" class="form-control" name="old_quantity" placeholder="Enter name" value="<?php echo $row['quantity'] ?>">
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