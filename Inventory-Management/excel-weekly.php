<?php
include "db_conn.php";
$output = '';

if(isset($_POST["export_excel"])){
    date_default_timezone_set("Asia/Manila");
    $dt_week_start_date = date('Y-m-d 20:00:01',strtotime("last Monday"));
    $dt_week_end_date = date('Y-m-d 20:00:00',strtotime("next Monday"));
    $sql = "SELECT inv.*,ord.* FROM  inventory inv, done_orders ord WHERE ord.itemid = inv.id && ord.date BETWEEN '".$dt_week_start_date ."' AND '".$dt_week_end_date."'";
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
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=weekly-sales.xls"); 
        echo $output;
    }
}


?>