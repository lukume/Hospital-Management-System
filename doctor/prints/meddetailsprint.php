<?php
    session_start();
    include '../../db_connect.php';

    $id = $_GET['id'];
    $qry = $conn->query("SELECT * FROM medicine WHERE id='$id'");
    foreach ($qry->fetch_array() as $k => $val) {
        $meta[$k] = $val;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS</title>
    <!-- css links start -->
    <link rel="stylesheet" href="../../assets/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <!-- css links end -->

    <!-- js start -->
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/bootstrap.min.js"></script>
    <!-- js end -->
</head>
<body>
    <div class="container-fluid py-5">
        <div class="well text-center"><h3><?=$meta['mname'] ?> Details</h3></div>
        <hr>
        <table id="table_id" class="table table-bordered table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Medicine</th>
                    <th>Packing</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $serial = 1;
                    $qry2 = $conn->query("SELECT med_details.*, medicine.mname FROM med_details INNER JOIN medicine ON medicine.id=med_details.med_id WHERE med_details.med_id='$id'");
                    while ($row = $qry2->fetch_array()) {
                        ?>
                            <tr>
                                <td><?=$serial; ?></td>
                                <td><?=htmlentities($row['mname']); ?></td>
                                <td><?=htmlentities($row['packing']); ?></td>
                                <td><?=htmlentities("KES".number_format($row['price'], 2)); ?></td>
                            </tr>
                        <?php
                        $serial++;
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>