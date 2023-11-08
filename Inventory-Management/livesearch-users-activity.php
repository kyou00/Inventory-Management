<?php
include("db_conn.php");
if(isset($_POST['input'])){

    $input = $_POST['input'];

    $query = "SELECT * FROM user_activity WHERE user LIKE '{$input}%' OR activity LIKE '{$input}%' OR `date` LIKE '{$input}%'";

    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){?>
            <div class="table_section" style="height: 850px;">
                <table>
                    <thead class="table-dark">
                    <tr>
                            <th scope="col">User</th>
                            <th scope="col">Activity</th>
                            <th scope="col">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "db_conn.php";
                            while ($row = mysqli_fetch_assoc($result)){

                                $user = $row['user'];
                                $activity = $row['activity'];
                                $date = $row['date'];
                                ?>
                                <tr>
                                    <th><?php echo $row['user'] ?></th>
                                    <th><?php echo $row['activity'] ?></th>
                                    <th><?php echo $row['date'] ?></th>
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