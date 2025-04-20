<?php
    session_start();
    include '../../db_connect.php';

    $qry = $conn->query("SELECT * FROM patients");
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
        <div class="well text-center"><h3>PAtients Details (<?=$qry->num_rows ?>)</h3></div>
        <hr>
        <table id="table_id" class="table table-bordered table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient N0</th>
                    <th>Names</th>
                    <th>Phone Number</th>
                    <th>ID Number</th>
                    <th>Address</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Reg Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $serial = 1;
                    while ($row = $qry->fetch_array()) {
                        ?>
                            <tr>
                                <td><?=$serial; ?></td>
                                <td><?=htmlentities($row['pno']); ?></td>
                                <td><?=htmlentities($row['pname']); ?></td>
                                <td><?=htmlentities($row['pphone']); ?></td>
                                <td><?=htmlentities($row['pidno']); ?></td>
                                <td><?=htmlentities($row['paddress']); ?></td>
                                <td><?=htmlentities($row['pgender']); ?></td>
                                <td><?=htmlentities($row['age']); ?></td>
                                <td><?=htmlentities(date('d M, Y H:n', strtotime($row['reg_date']))); ?></td>
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