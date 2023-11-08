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

    $sql = "SELECT id FROM category WHERE `category_name`='$category';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $id_category = $row['id'];


    $sql = "SELECT id FROM suppliers WHERE `supplier_name`='$supplier';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $id_supplier = $row['id'];

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
        $query = "INSERT INTO `inventory`(`id`, `product_code`, `product_name`, `description`, `categoryid`, `unit_cost`, `quantity`, `supplierid`,`date`,`status`) VALUES (NULL,'$product_code','$product_name ','$description','$id_category','$unit_cost','$quantity','$id_supplier','$itemdate','enable');";
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
        $query = "INSERT INTO `inventory`(`id`, `product_code`, `product_name`, `description`, `category`, `unit_cost`, `quantity`, `supplier`, `image` ,`status`) 
                VALUES (NULL,'$product_code','$product_name ','$description','$category','$unit_cost','$quantity','$supplier', '$newImageName','enable');";
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
                        <p>Product Details - Disabled</p>
                        <div>
                        <input class="input2" type="text" placeholder="Product" id="live_search"/>
                            <button class="add_new" id="show-login" onclick="openForm()">Add New</button>
                            <a href="index.php">
                                <button class="add_new" id="show-login">View Enable</button>
                            </a>
                        </div>
                    </div>
                    <div id="searchresult">
                    </div> 
                    <div class="table_section" id="table_section">
                        <table>
                            <thead class="table-dark">
                            <tr>
                                <th scope="col">Product Code</th>
                                <th scope="col">Product Photo</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Category</th>
                                <th scope="col">Unit Cost</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Supplier</th>
                                <th scope="col">Date Supplied</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "db_conn.php";
                                    $sql = "SELECT inv.*,cat.category_name,sup.supplier_name FROM inventory inv, category cat,suppliers sup WHERE `status` = 'disabled' && inv.categoryid = cat.id && inv.supplierid = sup.id";
                                    $result = mysqli_query($conn,$sql);
                                    function getColor($n){
                                        // Is number less than 11
                                        if($n<11) return "red";
                                        // Return default (black) for all other numbers
                                        return "black";
                                    }
                                    function getRole($n){
                                        // Is number less than 11
                                        if($n == 'User') return "none";
                                        // Return default (black) for all other numbers
                                        return "block";
                                    }
                                    while ($row = mysqli_fetch_assoc($result)){
                                        $color=getColor($row['quantity']);
                                        $validation=getRole($_SESSION['role'])
                                        ?>
                                        <tr style="color:<?=$color?>">
                                            <th><?php echo $row['product_code'] ?></th>
                                            <td><img src="img/<?php echo $row['image'] ?>" alt=""></td>
                                            <td><?php echo $row['product_name'] ?></td>
                                            <td><?php echo $row['description'] ?></td>
                                            <td><?php echo $row['category_name'] ?></td>
                                            <td><?php echo $row['unit_cost'] ?></td>
                                            <td><?php echo $row['quantity'] ?></td>
                                            <td><?php echo $row['supplier_name'] ?></td>
                                            <td><?php echo $row['date'] ?></td>
                                            <td>
                                                <a href="edit-inventory.php?id=<?php echo $row['id'] ?>" ><i class='bx bxs-edit'></i></a>
                                                <a href="enable-inventory.php?id=<?php echo $row['id'] ?>" ><i class='bx bx-show'></i></a>
                                                <a href="delete-inventory.php?id=<?php echo $row['id'] ?>" style="display:<?=$validation?>"><i class='bx bx-trash'></i></a>
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
                <h2>Add Product</h2>
                <div class="form-element">
                    <input type="text" class="form-control" name="product_code" placeholder="Enter code" minlength="5" maxlength="5" required name="i1">
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
                            $query ="SELECT category_name FROM category";
                            $result = $conn->query($query);
                            if($result->num_rows> 0){
                                while($optionData=$result->fetch_assoc()){
                                $option =$optionData['category_name'];
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
                            $query ="SELECT supplier_name FROM suppliers";
                            $result = $conn->query($query);
                            if($result->num_rows> 0){
                                while($optionData=$result->fetch_assoc()){
                                $option =$optionData['supplier_name'];
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
                        url:"livesearch-copy.php",
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