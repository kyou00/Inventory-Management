<?php
include("db_conn.php");
if(isset($_POST['input'])){

    $input = $_POST['input'];

    $query = "SELECT * FROM users WHERE name LIKE '{$input}%' OR username LIKE '{$input}%'";

    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){?>
            <div class="table_section" style="height: 850px;">
                <table>
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">Full Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Number</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "db_conn.php";
                            while ($row = mysqli_fetch_assoc($result)){

                                $name = $row['name'];
                                $username = $row['username'];
                                $email = $row['email'];
                                $role = $row['role'];
                                $number = $row['number'];
                                ?>
                                <tr>
                                    <th><?php echo $name; ?></th>
                                    <td><?php echo $username; ?></td>
                                    <td><?php echo $email; ?></td>
                                    <td><?php echo $role; ?></td>
                                    <td><?php echo $number; ?></td>
                                    <td>
                                        <a href="edit-users.php?id=<?php echo $row['id'] ?>" >Edit</a>
                                        
                                        <a href="delete-user.php?id=<?php echo $row['id'] ?>">Delete</a>
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