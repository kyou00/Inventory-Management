<?php
include "db_conn.php";
session_start();

if(isset($_POST['submit'])) {
    $old_total_cost= $_POST['old_total_cost'];
    $total_quantity= $_POST['total_quantity'];
    $product_name= $_POST['product_name'];
    $branch_name= $_POST['branch_name'];
    $customer_name= $_POST['customer_name'];
    date_default_timezone_set("Asia/Manila");
    $date = date("Y-m-d H:i:s");


    // $sql = "INSERT INTO `inventory`(`id`, `product_code`, `product_name`, `description`, `category`, `unit_cost`, `quantity`, `supplier`) 
    //         VALUES (NULL,'$product_code','$product_name ','$description','$category','$unit_cost','$quantity','$supplier')";

    // $result = mysqli_query($conn,$sql);

    // if($result){
    //     header("Location: index.php?msg=New record created successfully");
    // }
    // else {
    //     echo "Failed: ".mysqli_error($conn);
    // }

    $sql = "SELECT unit_cost,quantity,id FROM inventory WHERE product_name='$product_name';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $price = $row['unit_cost'];
    $quantity = $row['quantity'];
    $productid = $row['id'];


    $total_cost = (int)$price * (int)$total_quantity;
    
    $sql = "SELECT id FROM customers WHERE customer_name='$customer_name';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $customerid = $row['id'];    
   
    $sql = "SELECT id FROM branches WHERE branch_name='$branch_name';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $branchid = $row['id'];      

    if ($total_quantity > $quantity) {
        echo
        "<script> alert('Image Size Is Too Large'); </script>"
        ;
    } else {
        $sql .= "INSERT INTO `orders`(`id`, `total_cost`, `total_quantity`, `itemid`, `customerid`, `branchid`, `status`) VALUES (NULL,'$total_cost','$total_quantity','$productid','$customerid','$branchid','Pending');";
        $sql .= "INSERT INTO `user_activity`(`id`, `user`, `activity`, `date`) VALUES (NULL,'{$_SESSION['username']}','Added new order','$date')";
    }

    $result = mysqli_multi_query($conn,$sql);

    if($result){
        header("Location: orders.php?msg=New record created successfully");
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
                        <p>Order Details</p>
                        <div>
                        <input class="input2" type="text" placeholder="Orders" id="live_search"/>
                            <button class="add_new" id="show-login" onclick="openForm()">Add New</button>
                            <a href="complete-order.php"><button class="add_new" id="show-login">Done Orders</button></a>
                            
                        </div>
                    </div>
                    <div id="searchresult">
                    </div> 
                    <div class="table_section" id="table_section" style="height: 850px;">
                        <table>
                            <thead class="table-dark">
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Total Cost</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Branch</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "db_conn.php";
                                    // $sql = "SELECT ord.id, inv.product_name, inv.unit_cost,ord.total_quantity,cus.customer_name,bra.branch_name FROM inventory inv, orders ord,customers cus, branches bra WHERE ord.itemid=inv.item_id";
                                    $sql = "SELECT ord.id,inv.product_name,ord.total_cost,ord.total_quantity,bran.branch_name,cus.customer_name,ord.status FROM orders ord, inventory inv, customers cus, branches bran WHERE ord.itemid = inv.id && cus.id = ord.customerid && bran.id ORDER BY ord.id DESC";
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
                                            <td><?php echo $row['id'] ?></td>
                                            <td><?php echo $row['product_name'] ?></td>
                                            <td><?php echo $row['total_cost'] ?></td>
                                            <td><?php echo $row['total_quantity'] ?></td>
                                            <td><?php echo $row['branch_name'] ?></td>
                                            <td><?php echo $row['customer_name'] ?></td>
                                            <td><?php echo $row['status'] ?></td>
                                            <td>
                                                <a href="edit-orders.php?id=<?php echo $row['id'] ?>" ><i class='bx bxs-edit' style="font-size: 25px"></i></a>
                                                <a href="delete-orders.php?id=<?php echo $row['id'] ?>" style="display:<?=$validation?>"><i class='bx bx-trash' style="font-size: 25px"></i></a>
                                                <a href="done-orders.php?id=<?php echo $row['id'] ?>"><i class='bx bx-check-square' style="font-size: 25px"></i></a>
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
            <h2>Add Order</h2>
            <div class="form-element">
            <select name="product_name">
                        <option value="">Select Item</option>
                        <?php 
                        $query ="SELECT product_name FROM inventory WHERE `status` = 'enable'";
                        $result = $conn->query($query);
                        if($result->num_rows> 0){
                            while($optionData=$result->fetch_assoc()){
                            $option =$optionData['product_name'];
                        ?>
                        <?php
                        //selected option
                        if(!empty($product_name) && $product_name== $option){
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
                <input type="text" class="form-control"  name="total_quantity" placeholder="Enter quantity">
            </div>

            <select name="branch_name">
                        <option value="">Select Branch</option>
                        <?php 
                        $query ="SELECT branch_name FROM branches";
                        $result = $conn->query($query);
                        if($result->num_rows> 0){
                            while($optionData=$result->fetch_assoc()){
                            $option =$optionData['branch_name'];
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
            <select name="customer_name">
                    <option value="">Select Customer</option>
                    <?php 
                    $query ="SELECT customer_name FROM customers";
                    $result = $conn->query($query);
                    if($result->num_rows> 0){
                        while($optionData=$result->fetch_assoc()){
                        $option =$optionData['customer_name'];
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
                <button type="submit" class="btn btn-success" name="submit" onclick="closeForm()">Save</button>
            </div>
            <div class="form-element">
            <a href="orders.php">Cancel</a> 
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
                        url:"livesearch-order.php",
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