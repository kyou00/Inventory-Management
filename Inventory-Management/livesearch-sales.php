<?php
include("db_conn.php");
if(isset($_POST['input'])){

    $input = $_POST['input'];

    $query = "SELECT sal.*,inv.*,cat.category_name FROM sales sal,inventory inv,category cat WHERE sal.itemid = inv.id && inv.categoryid = cat.id && inv.product_name LIKE '{$input}%' OR sal.itemid = inv.id && inv.categoryid = cat.id && inv.product_code LIKE '{$input}%' OR sal.itemid = inv.id && inv.categoryid = cat.id && cat.category_name LIKE '{$input}%'";
    

    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){?>
            <div class="table_section" style="height: 850px;">
                <table>
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">Product Code</th>
                        <th scope="col">Product Image</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Total Sales Price</th>
                        <th scope="col">Total Sales Count</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "db_conn.php";
                            while ($row = mysqli_fetch_assoc($result)){

                                $product_code = $row['product_code'];
                                $product_name = $row['product_name'];
                                $category = $row['category_name'];
                                $total_sales = $row['total_sales'];
                                $sales_count = $row['sales_count'];
                                ?>
                                <tr>
                                        <th><?php echo $row['product_code'] ?></th>
                                        <td><img src="img/<?php echo $row['image'] ?>" alt=""></td>
                                        <th><?php echo $row['product_name'] ?></th>
                                        <th><?php echo $row['category_name'] ?></th>
                                        <td><?php echo $row['total_sales'] ?></td>
                                        <td><?php echo $row['sales_count'] ?></td>
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