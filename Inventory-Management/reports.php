<?php
include "db_conn.php";
session_start();


if(isset($_POST['submit'])) {
    $product_name = $_POST['product_name'];
    $product_code = $_POST['product_code'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $quantity= $_POST['quantity'];
    $supplier= $_POST['supplier'];
    $unit_cost = $_POST['unit_cost'];

    // $sql = "INSERT INTO `inventory`(`id`, `product_code`, `product_name`, `description`, `category`, `unit_cost`, `quantity`, `supplier`) 
    //         VALUES (NULL,'$product_code','$product_name ','$description','$category','$unit_cost','$quantity','$supplier')";

    // $result = mysqli_query($conn,$sql);

    // if($result){
    //     header("Location: index.php?msg=New record created successfully");
    // }
    // else {
    //     echo "Failed: ".mysqli_error($conn);
    // }

    $fileName = $_FILES["image"]["name"];
    $fileSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];
    date_default_timezone_set("Asia/Manila");
    $date = date("Y-m-d H:i:s");
    $itemdate = $_POST['itemdate'];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $fileName);
    $imageExtension = strtolower(end($imageExtension));
    if($_FILES['image']['name'] == "") {
        $query = "INSERT INTO `inventory`(`id`, `product_code`, `product_name`, `description`, `category`, `unit_cost`, `quantity`, `supplier`,`date`) VALUES (NULL,'$product_code','$product_name ','$description','$category','$unit_cost','$quantity','$supplier','$itemdate');";
        $query .= "INSERT INTO `user_activity`(`id`, `user`, `activity`, `date`) VALUES (NULL,'{$_SESSION['username']}','Added new product - $product_name','$date')";
    }
    else if(!in_array($imageExtension, $validImageExtension)){
        echo
        "<script> alert('Invalid Image Extension'); </script>"
        ;
    }
    else if($fileSize > 1000000){
        echo
        "<script> alert('Image Size Is Too Large'); </script>"
        ;
    }
    else{
        $newImageName = uniqid();
        $newImageName .= '.' . $imageExtension;

        move_uploaded_file($tmpName, 'img/' .  $newImageName);
        $query = "INSERT INTO `inventory`(`id`, `product_code`, `product_name`, `description`, `category`, `unit_cost`, `quantity`, `supplier`, `image` ) 
                VALUES (NULL,'$product_code','$product_name ','$description','$category','$unit_cost','$quantity','$supplier', '$newImageName');";
        $query .= "INSERT INTO `user_activity`(`id`, `user`, `activity`) VALUES (NULL,'{$_SESSION['username']}','Added new product - $product_name')";
        mysqli_multi_query($conn, $query);
        // echo
        // "<script> alert('Successfully Added'); </script>"
        // ;
    }
    $result = mysqli_multi_query($conn,$query);

    if($result){
        header("Location: index.php?msg=Data Updated Successfully");
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
        <link href='index.css' rel='stylesheet'>
        <link rel="stylesheet" href="reports.css">
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
                <div class="cardBox">
                    <a href="index.php"><div class="card">
                        <div>
                                <?php
                                    $sql = "SELECT COUNT(product_name) FROM inventory";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                ?>
                                <div class="numbers"><?php echo $row['COUNT(product_name)'] ?></div>
                            <div class="cardName">Products</div>
                        </div>
                        <div class="iconBx"><i class='bx bx-box' ></i></div>
                    </div></a>
                    <a href="sales.php">
                        <div class="card">
                            <div>
                                <?php
                                    $sql = "SELECT SUM(total_sales) FROM sales";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                ?>
                                <div class="numbers"><p>₱ <?php echo $row['SUM(total_sales)'] ?></p></div>
                                <div class="cardName">Sales</div>
                            </div>
                            <div class="iconBx" style="font-size: 1.5em;"><i class='bx bx-money-withdraw'></i></i></div>
                        </div>
                    </a>
                    <a href="customers.php">
                        <div class="card">
                            <div>
                                <?php
                                    $sql = "SELECT COUNT(id) FROM customers";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                ?>
                                <div class="numbers"><?php echo $row['COUNT(id)'] ?></div>
                                <div class="cardName">Customers</div>
                            </div>
                            <div class="iconBx" ><i class='bx bx-body'></i></div>
                        </div>
                    </a>
                    <a href="orders.php">
                        <div class="card">
                            <div>
                                <?php
                                    $sql = "SELECT COUNT(id) FROM orders";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                ?>
                                <div class="numbers"><?php echo $row['COUNT(id)'] ?></div>
                                <div class="cardName">Orders</div>
                            </div>
                            <div class="iconBx"><i class='bx bxs-briefcase'></i></div>
                        </div>
                    </a>
                </div>

                <div class="cardBox">
                    <a href="sales-daily.php"><div class="card">
                        <div>
                                <?php
                                    date_default_timezone_set("Asia/Manila");
                                    $daily = date("Y-m-d");
                                    $sql = "SELECT SUM(total_cost) FROM done_orders WHERE `date` LIKE '{$daily}%'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                ?>
                                <div class="numbers"><p>₱ <?php echo $row['SUM(total_cost)'];?></p></div>
                            <div class="cardName">Daily Sales</div>
                        </div>
                        <div class="iconBx"style="font-size: 1.5em;"><i class='bx bx-money'></i></div>
                    </div></a>
                    <a href="sales-weekly.php">
                        <div class="card">
                            <div>
                                <?php
                                    date_default_timezone_set("Asia/Manila");
                                    $dt_week_start_date = date('Y-m-d 20:00:01',strtotime("last Monday"));
                                    $dt_week_end_date = date('Y-m-d 20:00:00',strtotime("next Monday"));
                                    $sql = "SELECT SUM(total_cost) FROM done_orders WHERE `date` BETWEEN '".$dt_week_start_date ."' AND '".$dt_week_end_date."'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                ?>
                                <div class="numbers"><p>₱ <?php echo $row['SUM(total_cost)'] ?></p></div>
                                <div class="cardName">Weekly Sales</div>
                            </div>
                            <div class="iconBx"style="font-size: 1.5em;"><i class='bx bx-money'></i></div>
                        </div>
                    </a>
                    <a href="sales-monthly.php">
                        <div class="card">
                            <div>
                                <?php
                                    date_default_timezone_set("Asia/Manila");
                                    $sql = "SELECT SUM(total_cost) FROM done_orders WHERE MONTH(date) = MONTH(CURRENT_DATE())";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                ?>
                                <div class="numbers"><p>₱ <?php echo $row['SUM(total_cost)'] ?></p></div>
                                <div class="cardName">Monthly Sales</div>
                            </div>
                            <div class="iconBx"style="font-size: 1.5em;"><i class='bx bx-money'></i></div>
                        </div>
                    </a>
                    <a href="sales-yearly.php">
                        <div class="card">
                            <div>
                                <?php
                                    date_default_timezone_set("Asia/Manila");
                                    $sql = "SELECT SUM(total_cost) FROM done_orders WHERE YEAR(date) = YEAR(CURRENT_DATE())";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                ?>
                                <div class="numbers"><p>₱ <?php echo $row['SUM(total_cost)'] ?></p></div>
                                <div class="cardName">Yearly Sales</div>
                            </div>
                            <div class="iconBx"style="font-size: 1.5em;"><i class='bx bx-money'></i></div>
                        </div>
                    </a>
                </div>



                
                <div class="details">
                <div class="recentOrders">
                        <div class="cardHeader">
                            <h2>Recent Sales</h2>
                            <a href="complete-order.php" class="btn">View All</a>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Total Cost</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                include "db_conn.php";
                                    // $sql = "SELECT ord.id, inv.product_name, inv.unit_cost,ord.total_quantity,cus.customer_name,bra.branch_name FROM inventory inv, orders ord,customers cus, branches bra WHERE ord.itemid=inv.item_id";
                                    $sql = "SELECT ord.date,ord.id,ord.total_cost,ord.total_quantity,inv.product_name,cus.customer_name FROM done_orders ord, inventory inv, customers cus WHERE ord.itemid = inv.id && ord.customerid = cus.id ORDER BY ord.id DESC LIMIT 6";
                                    $result = mysqli_query($conn,$sql);
                                    while ($row = mysqli_fetch_assoc($result)){
                                        ?>
                                        <tr>
                                            <td><?php echo $row['product_name'] ?></td>
                                            <td><?php echo $row['total_cost'] ?></td>
                                            <td><?php echo $row['total_quantity'] ?></td>
                                            <td><?php echo $row['customer_name'] ?></td>
                                            <td><?php echo $row['date'] ?></td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Top Selling Products</h2>
                    </div>
                    <table>
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Total Sales</th>
                            </tr>
                            </thead>
                        <tbody>
                                <?php
                                include "db_conn.php";
                                    $sql = "SELECT inv.product_name, sal.total_sales FROM sales sal, inventory inv WHERE sal.itemid = inv.id ORDER BY total_sales DESC LIMIT 7";
                                    $result = mysqli_query($conn,$sql);
                                    while ($row = mysqli_fetch_assoc($result)){
                                        ?>
                                        <tr>
                                            <th><?php echo $row['product_name'] ?></th>
                                            <td><p>₱ <?php echo $row['total_sales'] ?></p></td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                    </table>
                </div>
                </div>

                <div class="details">
                    <div class="recentOrders">
                        <div class="cardHeader">
                            <h2>Recent Orders</h2>
                            <a href="orders.php" class="btn" >View All</a>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Total Cost</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Customer</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                include "db_conn.php";
                                    // $sql = "SELECT ord.id, inv.product_name, inv.unit_cost,ord.total_quantity,cus.customer_name,bra.branch_name FROM inventory inv, orders ord,customers cus, branches bra WHERE ord.itemid=inv.item_id";
                                    $sql = "SELECT ord.id,ord.total_cost,ord.total_quantity,inv.product_name,cus.customer_name FROM orders ord, inventory inv, customers cus WHERE ord.itemid = inv.id && ord.customerid = cus.id ORDER BY ord.id DESC LIMIT 6";
                                    $result = mysqli_query($conn,$sql);
                                    while ($row = mysqli_fetch_assoc($result)){
                                        ?>
                                        <tr>
                                            <td><?php echo $row['product_name'] ?></td>
                                            <td><?php echo $row['total_cost'] ?></td>
                                            <td><?php echo $row['total_quantity'] ?></td>
                                            <td><?php echo $row['customer_name'] ?></td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Regular Customers</h2>
                    </div>
                    <table>
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">City</th>
                                <th scope="col">Total Orders</th>
                            </tr>
                            </thead>
                        <tbody>
                                <?php
                                include "db_conn.php";
                                    $sql = "SELECT * FROM `customers` ORDER BY total_orders DESC LIMIT 7";
                                    $result = mysqli_query($conn,$sql);
                                    while ($row = mysqli_fetch_assoc($result)){
                                        ?>
                                        <tr>
                                            <th><?php echo $row['customer_name'] ?></th>
                                            <td><?php echo $row['city'] ?></td>
                                            <td><?php echo $row['total_orders'] ?></td>
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
                <h2>Add Product</h2>
                <div class="form-element">
                    <input type="text" class="form-control" id="email" name="product_code" placeholder="Enter code">
                </div>
                <div class="form-element">
                    <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" value="">
                </div>
                <div class="form-element">
                    <input type="text" class="form-control" id="name" name="product_name" placeholder="Enter name">
                </div>
                <div class="form-element">
                    <input type="text" class="form-control" id="description" name="description" placeholder="Enter description">
                </div>
                    <select name="category">
                            <option value="">Select Category</option>
                            <?php 
                            $query ="SELECT name FROM category";
                            $result = $conn->query($query);
                            if($result->num_rows> 0){
                                while($optionData=$result->fetch_assoc()){
                                $option =$optionData['name'];
                            ?>
                            <?php
                            //selected option
                            if(!empty($name) && $name== $option){
                            // selected option
                            ?>
                            <option value="<?php echo $option; ?>" selected><?php echo $option; ?> </option>
                            <?php 
                        continue;
                        }?>
                            <option value="<?php echo $option; ?>" ><?php echo $option; ?> </option>
                        <?php
                            }}
                            ?>
                    </select>
                
                <div class="form-element">
                    <input type="text" class="form-control" id="email" name="unit_cost" placeholder="Enter unit cost">
                </div>
                <div class="form-element">
                    <input type="text" class="form-control" id="email" name="quantity" placeholder="Enter quantity">
                </div>
                <select name="supplier">
                            <option value="">Select Supplier</option>
                            <?php 
                            $query ="SELECT name FROM suppliers";
                            $result = $conn->query($query);
                            if($result->num_rows> 0){
                                while($optionData=$result->fetch_assoc()){
                                $option =$optionData['name'];
                            ?>
                            <?php
                            //selected option
                            if(!empty($name) && $name== $option){
                            // selected option
                            ?>
                            <option value="<?php echo $option; ?>" selected><?php echo $option; ?> </option>
                            <?php 
                        continue;
                        }?>
                            <option value="<?php echo $option; ?>" ><?php echo $option; ?> </option>
                        <?php
                            }}
                            ?>
                    </select>
                <input type="datetime-local" name="itemdate" class="form-control">
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
                        url:"livesearch.php",
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