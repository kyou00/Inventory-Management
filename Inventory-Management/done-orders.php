<?php
include "db_conn.php";
$id = $_GET['id'];
session_start();

if(isset($_POST['submit'])) {
    date_default_timezone_set("Asia/Manila");
    $date = date("Y-m-d H:i:s");
    $old_total_cost= $_POST['old_total_cost'];
    $total_quantity = $_POST['total_quantity'];
    $total_cost = $old_total_cost * $total_quantity;
    $old_quantity = $_POST['old_quantity'];
    $ord_product_name = $_POST['ord_product_name'];
    $old_branch_name = $_POST['old_branch_name'];
    $ord_customer_name = $_POST['ord_customer_name'];
    $inventory_id = $_POST['inventory_id'];
    
    
    $old_total_orders = $_POST['old_total_orders'];

    $old_total_price = $_POST['old_total_price'];
    $old_total_count = $_POST['old_total_count'];
    $sales_old_total_price = $_POST['sales_old_total_price'];
    $sales_old_total_count = $_POST['sales_old_total_count'];
    $inventoryid = $_POST['inventoryid'];

    $total_sales = (int)$sales_old_total_price + (int)$old_total_cost;
    $sales_count = (int)$sales_old_total_count + (int)$total_quantity;

    $total_sales_price = (int)$old_total_price + (int)$old_total_cost;
    $total_sales_count = (int)$old_total_count + (int)$total_quantity;

    $new_quantity = (int)$old_quantity - (int)$total_quantity;

    $total_orders = (int)$old_total_orders + 1;

    $sql = "SELECT id FROM inventory WHERE `product_name`='$ord_product_name';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $id_item = $row['id'];

    
    $sql = "SELECT id FROM customers WHERE `customer_name`='$ord_customer_name';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $id_customer = $row['id'];


    $sql = "SELECT id FROM branches WHERE `branch_name`='$ord_branch_name';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $id_branch = $row['id'];


    $query = "SELECT id FROM inventory WHERE id = '$inventory_id'";

    $result = $conn->query($query);
    
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $sql = "UPDATE `inventory` SET `quantity`='$new_quantity' WHERE product_name = '$ord_product_name';";
            $sql .= "UPDATE `branches` SET `total_sales_price`='$total_sales_price',`total_sales_count`='$total_sales_count' WHERE `branch_name` = '$old_branch_name';";
            $sql .= "UPDATE sales SET `total_sales`='$total_sales',`sales_count`='$sales_count' WHERE `itemid` = '$inventoryid';";
            $sql .= "UPDATE customers SET `total_orders`='$total_orders' WHERE `customer_name` = '$ord_customer_name';";
            $sql .= "INSERT INTO `done_orders`(`id`, `total_cost`, `total_quantity`, `itemid`, `customerid`, `branchid`, `status`, `date`) VALUES ($id,'$old_total_cost','$total_quantity','$id_item','$id_customer','$id_branch','Paid','$date');";
            $sql .= "DELETE FROM `orders` WHERE id = $id";
        } else {
            $sql = "UPDATE `inventory` SET `quantity`='$new_quantity' WHERE product_name = '$ord_product_name';";
            $sql .= "UPDATE `branches` SET `total_sales_price`='$total_sales_price',`total_sales_count`='$total_sales_count' WHERE `branch_name` = '$old_branch_name';";
            $sql .= "INSERT INTO `sales`(`id`,`itemid`) VALUES (NULL,'$inventoryid');";
            $sql .= "UPDATE sales SET `total_sales`='$total_sales',`sales_count`='$sales_count' WHERE `itemid` = '$inventoryid';";
            $sql .= "UPDATE customers SET `total_orders`='$total_orders' WHERE `customer_name` = '$ord_customer_name';";
            $sql .= "INSERT INTO `done_orders`(`id`, `total_cost`, `total_quantity`, `itemid`, `customerid`, `branchid`, `status`, `date`) VALUES ($id,'$old_total_cost','$total_quantity','$id_item','$id_customer','$id_branch','Paid','$date');";
            $sql .= "DELETE FROM `orders` WHERE id = $id";
        }
    } else {
        echo 'Error: ' . mysqli_error();
    }



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
        <?php
            $sql = "SELECT ord.id,inv.id, cus.id,ord.total_cost,inv.product_name,cus.customer_name,ord.total_quantity FROM orders ord, inventory inv,customers cus WHERE ord.id = $id && ord.itemid = inv.id && ord.customerid = cus.id LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
        ?>
        <div class="popup" id="myForm">
        <form action="" method="post" enctype="multipart/form-data">
            <a href="orders.php"><div class="close-btn" onclick="closeForm()">&times;</div></a>
            <div class="form">
                <h2>Confirm Order</h2>
                <div class="form-element">
                    <input type="hidden" class="form-control" name="old_total_cost" placeholder="Enter unit cost"value="<?php echo $row['total_cost'] ?>">
                </div>
                <p>Total Cost:</p>
                <p><?php echo $row['total_cost'] ?></p>
                <div class="form-element">
                    <input type="hidden" class="form-control" name="ord_product_name" placeholder="Enter unit cost"value="<?php echo $row['product_name'] ?>">
                </div>
                <p>Item Name: <?php echo $row['product_name'] ?></p>
                
                <div class="form-element">
                    <input type="hidden" class="form-control" name="ord_customer_name" placeholder="Enter unit cost"value="<?php echo $row['customer_name'] ?>">
                </div>
                <p>Customer Name: <?php echo $row['customer_name'] ?></p>
                <div class="form-element">
                    <input type="hidden" class="form-control" name="total_quantity" placeholder="Enter quantity"value="<?php echo $row['total_quantity'] ?>">
                </div>
                <p>Total Quantity: <?php echo $row['total_quantity'] ?></p>
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

                <?php
                $sql = "SELECT bran.branch_name,bran.total_sales_price, bran.total_sales_count FROM branches bran,orders ord WHERE bran.id=ord.branchid && ord.id = $id";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                ?>
                <div class="form-element">
                    <input type="hidden" class="form-control" name="old_branch_name" placeholder="Enter name" value="<?php echo $row['branch_name'] ?>">
                </div>
                <div class="form-element">
                    <input type="hidden" class="form-control" name="old_total_price" placeholder="Enter name" value="<?php echo $row['total_sales_price'] ?>">
                </div>
                <div class="form-element">
                    <input type="hidden" class="form-control" name="old_total_count" placeholder="Enter name" value="<?php echo $row['total_sales_count'] ?>">
                </div>


                <?php
                $sql = "SELECT inv.id FROM inventory inv, orders ord WHERE inv.id=ord.itemid && ord.id = $id";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                ?>
                <div class="form-element">
                    <input type="hidden" class="form-control" name="inventoryid" placeholder="Enter name" value="<?php echo $row['id'] ?>">
                </div>



                <?php
                $sql = "SELECT inv.id, inv.product_name, sal.total_sales, sal.sales_count FROM sales sal, inventory inv,orders ord WHERE sal.itemid = inv.id && ord.itemid = inv.id && ord.id = $id";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                ?>
                <div class="form-element">
                    <input type="hidden" class="form-control" name="inventory_id" placeholder="Enter name" value="<?php echo $row['id'] ?>">
                </div>
                <div class="form-element">
                    <input type="hidden" class="form-control" name="sales_old_total_price" placeholder="Enter name" value="<?php echo $row['total_sales'] ?>">
                </div>
                <div class="form-element">
                    <input type="hidden" class="form-control" name="sales_old_total_count" placeholder="Enter name" value="<?php echo $row['sales_count'] ?>">
                </div>
                

                <?php
                $sql = "SELECT cus.total_orders FROM customers cus,orders ord WHERE cus.id=ord.customerid && ord.id = $id";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                ?>
                <div class="form-element">
                    <input type="hidden" class="form-control" name="old_total_orders" placeholder="Enter name" value="<?php echo $row['total_orders'] ?>">
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