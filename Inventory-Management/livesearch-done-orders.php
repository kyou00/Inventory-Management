<?php
include("db_conn.php");
if(isset($_POST['input'])){

    $input = $_POST['input'];

    $query = "SELECT ord.*,inv.product_name,cus.customer_name,bran.branch_name FROM done_orders ord, inventory inv,customers cus,branches bran WHERE ord.itemid = inv.id && ord.customerid = cus.id && ord.branchid = bran.id && ord.id LIKE '{$input}%' OR ord.itemid = inv.id && ord.customerid = cus.id && ord.branchid = bran.id && cus.customer_name LIKE '{$input}%' OR ord.itemid = inv.id && ord.customerid = cus.id && ord.branchid = bran.id && inv.product_name LIKE '{$input}%' OR branch_name LIKE '{$input}%'";

    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){?>
            <div class="table_section" style="height: 850px;">
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
                            while ($row = mysqli_fetch_assoc($result)){

                                $id = $row['id'];
                                $product_name = $row['product_name'];
                                $total_cost = $row['total_cost'];
                                $total_quantity = $row['total_quantity'];
                                $branch_name = $row['branch_name'];
                                $customer_name = $row['customer_name'];
                                $status = $row['status'];
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
                                                <a href="edit-orders.php?id=<?php echo $row['id'] ?>" ><i class='bx bxs-edit'></i></a>
                                                <a href="delete-orders.php?id=<?php echo $row['id'] ?>"><i class='bx bx-trash'></i></a>
                                                <a href="done-orders.php?id=<?php echo $row['id'] ?>"><i class='bx bx-check-square'></i></a>
                                        
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