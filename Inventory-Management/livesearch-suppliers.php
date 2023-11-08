<?php
include("db_conn.php");
if(isset($_POST['input'])){

    $input = $_POST['input'];

    $query = "SELECT * FROM suppliers WHERE supplier_name LIKE '{$input}%' OR email LIKE '{$input}%'";

    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){?>
        <div class="table_section" style="height: 850px;">
            <table>
                <thead class="table-dark">
                <tr>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Address</th>
                    <th scope="col">City</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    include "db_conn.php";
                        while ($row = mysqli_fetch_assoc($result)){

                            $name = $row['supplier_name'];
                            $email = $row['email'];
                            $address = $row['address'];
                            $city = $row['city'];
                            $phone = $row['phone'];
                            ?>
                            <tr>
                                <th><?php echo $name; ?></th>
                                <td><?php echo $email; ?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $city; ?></td>
                                <td><?php echo $phone; ?></td>
                                <td>
                                    <a href="edit-suppliers.php?id=<?php echo $row['id'] ?>" >Edit</a>
                                    
                                    <a href="delete-suppliers.php?id=<?php echo $row['id'] ?>">Delete</a>
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