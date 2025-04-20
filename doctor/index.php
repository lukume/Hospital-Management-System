<?php
    session_start();
    include '../db_connect.php';

    if (strlen($_SESSION['docid']) == 0) {
        header('Location: login.php');
    }

    if (isset($_SESSION['docid'])) {
        $docid = $_SESSION['docid'];
        $qry = $conn->query("SELECT * FROM doctors WHERE docid='$docid'")->fetch_array();
        foreach ($qry as $k => $val) {
            $doctor[$k] = $val;
        }
    }

    $did = $doctor['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital management System</title>
    <!-- css links start -->
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/jquery.dataTables.css">
    <link rel="stylesheet" href="../assets/css/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/jquery.jgrowl.min.css">
    <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
    <!-- css links end -->

    <!-- js start -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery.dataTables.js"></script>
    <script src="../assets/js/jquery.datetimepicker.full.min.js"></script>
    <script src="../assets/js/jquery.jgrowl.min.js"></script>
    <!-- js end -->
</head>
<body>
    <!-- Preloader -->
    <div class="preloader"></div>
    <!-- Preloader end -->

    <!-- Header start -->
    <?php include 'include/header.php' ?>
    <!-- Header end -->

    <!-- Sidebar start -->
    <?php include 'include/sidebar.php' ?>
    <!-- Sidebar end -->

    <!-- Main Content start -->
    <main>
        <div class="container-fluid">
            <?php $page = isset($_GET['page']) ? $_GET['page'] : "home" ?>
            <?php include $page.".php" ?>
        </div>
    </main>
    <!-- Main Content end -->

    <!-- Footer start -->
    <?php include 'include/footer.php' ?>
    <!-- Footer end -->

    <!-- Modal start -->
    <div class="modal fade" id="uni_modal" tabindex="-1" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenteredScrollableTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="$('#uni_modal form').submit()">Save</button>
            </div>
            </div>
        </div>
    </div>
    <!-- Modal ends -->

    <script>
        $(document).ready(function(){
            $('.btn-menu').click(function(){
                $(this).toggleClass('fa-arrow-right')
                $('.sidebar').toggleClass('active')
            })

            $('#table_id').DataTable({
                scrollX: true,
                scrollCollapse: true,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All']
                ]
            });

            setTimeout(() => {
                $('.preloader').fadeOut('slow', function(){
                    $(this).remove()
                })
            }, 100);

            window.start_loader = function() {
                $('body').prepend('<div class="preloader2"></div>')
            }

            window.end_loader = function() {
                $('.preloader2').fadeOut('slow', function(){
                    $(this).remove()
                })
            }

            window.uni_modal = function($title="", $url="") {
                start_loader()

                $.ajax({
                    url: $url,
                    error: err => {
                        console.log(err)
                        $.jGrowl('An error occured')
                        end_loader()
                    },
                    success: function(resp) {
                        $('#uni_modal .modal-title').html($title)
                        $('#uni_modal .modal-body').html(resp)
                        $('#uni_modal').modal('show')

                        end_loader()
                    }
                })
            }
        })
    </script>
</body>
</html>