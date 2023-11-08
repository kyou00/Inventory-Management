<?php
include "db_conn.php";

if(isset($_POST['submit'])) {
    $product_name = $_POST['product_name'];
    $product_code = $_POST['product_code'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $quantity= $_POST['quantity'];
    $supplier= $_POST['supplier'];
    $unit_cost = $_POST['unit_cost'];

    $sql = "INSERT INTO `inventory`(`id`, `product_code`, `product_name`, `description`, `category`, `unit_cost`, `quantity`, `supplier`) 
    VALUES (NULL,'$product_code','$product_name ','$description','$category','$unit_cost','$quantity','$supplier')";

    $result = mysqli_query($conn,$sql);

    if($result){
        header("Location: index.php?msg=New record created successfully");
    }
    else{
        echo "Failed: ".mysqli_error($conn);
    }
}
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="index.css">.
        <title>Advanz Tools - Home</title>
    </head>
    <body>
        <img src="advanz.png" alt="advanz-tool" class="Advanz-logo" >
        <img src="items-logo.png" alt="advanz-tool" class="Items-logo">
        <img src="stocks-logo.png" alt="advanz-tool" class="Stocks-logo">
        <img src="log-logo.png" alt="advanz-tool" class="Log-logo">
        <img src="accounts-logo.png" alt="advanz-tool" class="Accounts-logo">
        <h1 class="Items">
            Items
        </h1 >
        <h1 class="Stocks">
            Stocks
        </h1>
        <h1 class="Sales">
            Sales
        </h1>
        <h1 class="Accounts">
            Accounts
        </h1>
        <h1 class="Log">
            Log
        </h1>
        <h1 class="Inventory-text">
            INVENTORY: ADD NEW PRODUCT
        </h1>
        <form action="" method="post">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" name="product_code" placeholder="Product Code">
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="product_name" placeholder="Item Name">
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="description" placeholder="Full Description">
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="category" placeholder="Category">
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="quantity" placeholder="Quantity">
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="supplier" placeholder="Supplier">
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="unit_cost" placeholder="Unit Cost">
                </div>
                
                <div>
                    <button type="submit" class="btn btn-success" name="submit">Save</button>
                    <a href="index.php">Back</a>
                </div>
            </div>
        </form>
    </body>
</html>