<!DOCTYPE html>
<html lang="en">

<head>
    <link href="print_style.css" rel="stylesheet">
    <meta charset="utf-8">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="paper.css">
    <link rel="stylesheet" href="normalize.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>@page {
        size: A4 portrait;
        margin-top: 8px;
        margin-bottom: 10px;
        margin-left: 20px;
    }</style>
    <style>
        /* Three image containers (use 25% for four, and 50% for two, etc) */
        .column {
            float: left;
            padding: 5px;
        }

        /* Clear floats after image containers */
        .row::after {
            content: "";
            clear: both;
            display: table;
        }

        table tbody tr td {
            padding: 2px !important;
            line-height: 1.35 !important;
        }

        @media print {
            .box-body {
                margin-top: 10px !important;
                margin-bottom: 10px;
            }
        }
    </style>

    <script>
        /*window.onload = function () {
          window.print();
           window.top.close();

        }*/
    </script>
    <style>
        .center-me {
            font-size: 15px;
            margin: auto;
            height: 10px;
            max-width: 500px;
            margin: 75px auto 40px auto;
            display: flex;
        }
    </style>
</head>
<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4 portrait">

<!-- Each sheet element should have the class "sheet" -->
<!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
<section class="sheet" id="content-print">
    <style>
        table {
            /*border-collapse: unset !important;*/
        }
    </style>

    <div class="box-body" id="box_data" style="display: flex;padding: 5px 10px 0 10px;margin-bottom: -21px;">
        <div style="width: 100%;padding-right: 10px;" class="col-md-12">
            <div class="row">
                <div class="col-lg-4" style="width: 70%;padding-left: 20px;">
                    <h4 style="font-weight:bold;">Sales Report</h4>
                </div>
                <div class="col-lg-8" style="width: 30%;">
                    <h5 style="font-size: 20px;margin-bottom: 15px;margin-top: 45px;">Advanz Tools</h5>

                    <p style="font-size: 12px;margin: 0;padding: 0;">2098 Captain M. Reyes St</p>

                    <p style="font-size: 12px;margin: 0;padding-top: 3px;;">Makati, 1230 Metro Manila</p>

                    <!-- <p style="font-size: 12px;margin: 0;padding-top: 5px;;">Phone: (000) 000-0000</p> -->
                    <br>
                </div>
            </div>
            <div class="" style="display: flex;margin-top: -62px;">
            <table border="1" style="width:30%">
                <tr class="" style="background: rgba(217,225,242,1.0)">
                    <td style="font-size: 14px;"  class="db text-center" width="100px">
                        Date & TIme
                    </td>
                </tr>
                <tr><?php
                    date_default_timezone_set("Asia/Manila");
                    $date = date("Y-m-d H:i:s");
                    session_start();
                ?>
                <tr>
                    <td style="font-size: 12px;"><?php echo $date ?></td>            
                </tr>
            </table>
            </div>
            <br>

            <table width="100%" border="1">
                <tr style="background: rgba(217,225,242,1.0)">
                    <th class="text-center" colspan="2" style="width: 25%;">Sales Report - Yearly / Year: <?php echo date('Y');?></th>
                </tr>
            </table>
            <br>
            <table width="100%" border="1px">
                <tr style="background: rgba(217,225,242,1.0);">
                    <th class="text-center">
                        #
                    </th>
                    <th class="text-center" colspan="3">
                        Product Description
                    </th>
                    <th class="text-center">
                        Date
                    </th>
                    <th class="text-center">
                        Price
                    </th>
                    <th class="text-center">
                        Quantity
                    </th>
                    <th class="text-center">
                        Amount
                    </th>
                </tr>
                <tbody>
                <?php
                    include "db_conn.php";
                        date_default_timezone_set("Asia/Manila");
                        $sql = "SELECT ord.*, inv.* FROM done_orders ord, inventory inv WHERE ord.itemid = inv.id && YEAR(ord.date) = YEAR(CURRENT_DATE())";
                        $result = mysqli_query($conn,$sql);
                        function getRole($n){
                            if($n == 'User') return "none";
                            return "block"; 
                        }
                        while ($row = mysqli_fetch_assoc($result)){
                            $validation=getRole($_SESSION['role'])
                            ?>
                            <tr><td><?php echo $row['product_code'] ?></td>
                            <td colspan="3"><?php echo $row['product_name'] ?></td>
                            <td style="text-align: center;"><?php echo $row['date'] ?></td>
                            <td style="text-align: right;">₱ <?php $unitcostt = $row['unit_cost']; echo number_format($unitcostt, 2); ?></td>
                            <td style="text-align: center;"><?php echo $row['total_quantity'] ?></td>
                            <td style="text-align: right;">₱ <?php $totalcost = $row['total_cost']; echo number_format($totalcost, 2); ?>
                            </td></tr>
                            <?php
                        }
                ?>
                </tbody>
                <tfoot>
                <?php
                    $sql = "SELECT SUM(total_cost) FROM done_orders WHERE YEAR(date) = YEAR(CURRENT_DATE())";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                 ?>
                <tr style="background: rgba(217,225,242,1.0);">
                    <td colspan="2"></td>
                    <td colspan="2"></td>
                    <td></td>
                    <td colspan="2">Final Amount</td>
                    <td style="text-align: right;">₱ <?php $totalcost = $row['SUM(total_cost)']; echo number_format($totalcost, 2); ?></td>
                </tr>
                </tfoot>
            </table>
            <br>
            <table width="94%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="19%" rowspan="3" valign="top"><strong class="asd"> &nbsp;<br></strong></td>
                    <td width="65%" align="center" valign="top">
                        <h6>Generated By: <?php echo $_SESSION['username'] ?></h6> 
                    <td width="16%" valign="top"><h6 style="margin-bottom: 0;">
                        <span style="text-decoration: dashed; padding-left: 100%;color: #000; border-bottom: 1px solid black;"></span>
                    </h6>
                        <h6 class="text-center"
                        style="margin-top: 5px;">Signature and Seal</h6></td>
                </tr>
            </table>
        </div>

    </div>

</section>
<a href="reports.php" style="text-decoration:none;color:black;"><button>Back</button></a>
    <button onclick="window.print()">PDF</button>     
    <form method="post" action="excel-yearly.php" >
        <!-- <input type="submit" name="export_excel" class="btn btn-success" value="Export to Excel"/> -->
        <button type="submit" name="export_excel">Excel</button>
    </form>
</body>
</html>
