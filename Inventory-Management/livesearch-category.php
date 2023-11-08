<?php
include("db_conn.php");
if(isset($_POST['input'])){

    $input = $_POST['input'];

    $query = "SELECT cat.id,cat.category_name , SUM(inv.quantity) FROM inventory inv, category cat WHERE cat.id = inv.categoryid && category_name LIKE '{$input}%' GROUP BY cat.category_name";

    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){?>
        <div class="table_section" style="height: 850px;">
            <table>
                <thead class="table-dark">
                <tr>
                    <th scope="col">Category Name</th>
                    <th scope="col">Total Items</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    include "db_conn.php";
                        while ($row = mysqli_fetch_assoc($result)){
                            $name = $row['category_name'];
                            $email = $row['SUM(inv.quantity)'];
                            ?>
                            <tr>
                                <th><?php echo $row['category_name'] ?></th>
                                <td><?php echo $row['SUM(inv.quantity)'] ?></td>
                                <td>
                                    <a href="edit-category.php?id=<?php echo $row['id'] ?>" ><i class='bx bxs-edit'></i></a>
                                    <a href="delete-category.php?id=<?php echo $row['id'] ?>"><i class='bx bx-trash'></i></a>
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