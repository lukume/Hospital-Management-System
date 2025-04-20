<?php
    session_start();
    include '../../db_connect.php';

    $qry = $conn->query("SELECT * FROM doctors");
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
        <div class="well text-center"><h3>Doctor Details (<?=$qry->num_rows ?>)</h3></div>
        <hr>
        <table id="table_id" class="table table-bordered table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>docid</th>
                    <th>Name</th>
                    <th>Specification</th>
                    <th>Doc Fees</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $serial = 1;
                    while ($row = $qry->fetch_array()) {
                        ?>
                            <tr>
                                <td><?=$serial; ?></td>
                                <td><?=htmlentities($row['docid']); ?></td>
                                <td><?=htmlentities($row['docname']); ?></td>
                                <td><?=htmlentities($row['docspec']); ?></td>
                                <td><?="KES".number_format(htmlentities($row['docfees']), 2); ?></td>
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