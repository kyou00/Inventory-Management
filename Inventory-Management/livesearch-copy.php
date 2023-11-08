<?php
include("db_conn.php");
session_start();
if(isset($_POST['input'])){

    $input = $_POST['input'];

    $query = "SELECT inv.*,cat.category_name,sup.supplier_name FROM inventory inv, category cat,suppliers sup WHERE `status` = 'disabled' && inv.categoryid = cat.id && inv.supplierid = sup.id && inv.product_name LIKE '{$input}%' OR `status` = 'disabled' && inv.categoryid = cat.id && inv.supplierid = sup.id && inv.product_code LIKE '{$input}%' OR `status` = 'disabled' && inv.categoryid = cat.id && inv.supplierid = sup.id && cat.category_name LIKE '{$input}%'";

    $result = mysqli_query($conn,$query);

    function getRole($n){
        // Is number less than 11
        if($n == 'User') return "none";
        // Return default (black) for all other numbers
        return "block";
    }

    if(mysqli_num_rows($result) > 0){
            ?>
            <div class="table_section" style="height: 850px;">
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
                            function getColor($n){
                                // Is number less than 11
                                if($n<30) return "red";
                                // Return default (black) for all other numbers
                                return "black";
                            }    
                            while ($row = mysqli_fetch_assoc($result)){
                                $color=getColor($row['quantity']);
                                $validation=getRole($_SESSION['role']);

                                $product_code = $row['product_code'];
                                $product_name = $row['product_name'];
                                $description = $row['description'];
                                $category = $row['category_name'];
                                $unit_cost = $row['unit_cost'];
                                $quantity = $row['quantity'];
                                $supplier = $row['supplier_name'];
                                $date = $row['date'];
                                ?>
                                <tr style="color:<?=$color?>">
                                    <th><?php echo $product_code; ?></th>
                                    <td><img src="img/<?php echo $row['image'] ?>" alt=""></td>
                                    <td><?php echo $product_name; ?></td>
                                    <td><?php echo $description; ?></td>
                                    <td><?php echo $category; ?></td>
                                    <td><?php echo $unit_cost; ?></td>
                                    <td><?php echo $quantity; ?></td>
                                    <td><?php echo $supplier; ?></td>
                                    <td><?php echo $date; ?></td>
                                    <td>
                                        <a href="edit-inventory.php?id=<?php echo $row['id'] ?>" ><i class='bx bxs-edit'></i></a>
                                        <a href="disable-inventory.php?id=<?php echo $row['id'] ?>" ><i class='bx bx-low-vision'></i></a>
                                        <a href="delete-inventory.php?id=<?php echo $row['id'] ?>" style="display:<?=$validation?>"><i class='bx bx-trash'></i></a>  
                                    </td>
                                </tr>
                                <?php

                            }
                        ?>
                    </tbody>
                </table>
            </div>

        <?php

    }else{
        echo "<h6 class='text-danger text-center mt-3'>No Data Found</h6>";
    }
}
?>