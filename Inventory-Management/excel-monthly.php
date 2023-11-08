<?php
include "db_conn.php";
$output = '';

if(isset($_POST["export_excel"])){
    date_default_timezone_set("Asia/Manila");

    $sql = "SELECT ord.*,inv.* FROM done_orders ord,inventory inv WHERE ord.itemid = inv.id && MONTH(ord.date) = MONTH(CURRENT_DATE())";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) > 0){
        $output .= '
                    <table class="table" bordered="1">
                        <tr>
                            <th>
                                    #
                            </th>
                            <th>
                                Product Description
                            </th>
                            <th>
                                Date
                            </th>
                            <th>
                                Price
                            </th>
                            <th>
                                Quantity
                            </th>
                            <th>
                                Amount
                            </th>
                        </tr>';
        while ($row = mysqli_fetch_array($result)){
            $output .= '
            <tr> 
                <td>' .$row["product_code"]. '</td>
                <td>' .$row["product_name"]. '</td>
                <td>' .$row["date"]. '</td>
                <td>' .$row["unit_cost"]. '</td>
                <td>' .$row["total_quantity"]. '</td>
                <td>' .$row["total_cost"]. '</td>
            </tr>';
        }
        $output .= '</table>';
        header("Content-Type: application/cvs");
        header("Content-Disposition: attachment; filename=monthly-sales.xls"); 
        echo $output;
    }
}


?>