<?php
include("db_conn.php");
if(isset($_POST['input'])){

    $input = $_POST['input'];

    $query = "SELECT * FROM branches WHERE branch_name LIKE '{$input}%'";

    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){?>
            <div class="table_section" style="height: 850px;">
                <table>
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">Branch Name</th>
                        <th scope="col">Total Sales Price</th>
                        <th scope="col">Total Sales Count</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "db_conn.php";
                            while ($row = mysqli_fetch_assoc($result)){

                                $name = $row['branch_name'];
                                $total_sales_price = $row['total_sales_price'];
                                $total_sales_count = $row['total_sales_count'];
                                ?>
                                <tr>
                                    <th><?php echo $name; ?></th>
                                    <td><?php echo $total_sales_price; ?></td>
                                    <td><?php echo $total_sales_count; ?></td>
                                    <td>
                                                <a href="edit-branches.php?id=<?php echo $row['id'] ?>" ><i class='bx bxs-edit'></i></a>
                                                <a href="delete-branches.php?id=<?php echo $row['id'] ?>"><i class='bx bx-trash'></i></a>
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