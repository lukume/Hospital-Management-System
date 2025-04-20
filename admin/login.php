<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Hospital management System</title>

    <!-- css links start -->
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/jquery.dataTables.css">
    <link rel="stylesheet" href="../assets/css/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
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
    <header>
        <a href="index.php"><span class="fas fa-plus"></span> Advanced Hospital Management System</a>
    </header>
    <div class="banner2">
        <h4>Admin Login Page > <a href="../index.php">Home</a></h4>
    </div>
    <div class="form-container">
        <div class="row d-flex align-items-center justify-content-center py-4">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h4>Login Here</h4>
                    </div>
                    <div class="card-body">
                        <form action="" id="s_form">
                            <div class="form-group mb-4">
                                <label for="" class="form-control-label">Email Address</label>
                                <input type="email" name="email" id="" class="form-control">
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="form-control-label">Password</label>
                                <input type="password" name="password" id="" class="form-control">
                            </div>
                            <input type="submit" value="Login" class="btn btn-primary w-100">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('#s_form').submit(function(e) {
                e.preventDefault()

                $.jGrowl("Verifying.......")
                $.ajax({
                    url: '../process.php?p=admin_login',
                    method: 'POST',
                    data: new FormData($(this)[0]),
                    success: function(resp)  {
                        if (resp == 1) {
                            $.jGrowl("Credentials verified successfully")
                            $.jGrowl("Redirecting to homepage...")
                            setTimeout(() => {
                                location.href = './'
                            }, 2000);
                        }

                        if (resp == 2) {
                            $.jGrowl("Sorry! Invalid Credentials")
                        }
                    },
                    cache: false,
                    processData: false,
                    contentType: false
                })
            })
        })
    </script>
</body>
</html>