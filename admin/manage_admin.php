<?php
    include '../db_connect.php';

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $qry = $conn->query("SELECT * FROM admin WHERE id=".$_GET['id'])->fetch_array();
        foreach ($qry as $k => $val) {
            $$k = $val;
        }
    }
?>

<form action="" id="sub_form">
    <input type="hidden" name="id" value="<?=isset($_GET['id']) ? $_GET['id'] : ""; ?>">
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Admin Name</label>
                <input type="text" name="name" id="" class="form-control" value="<?=isset($aname) ? $aname : ""; ?>" required>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Admin Email</label>
                <input type="email" name="email" id="" class="form-control" value="<?=isset($aemail) ? $aemail : ""; ?>" required>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Admin Phone</label>
                <input type="tel" name="phone" id="" class="form-control" value="<?=isset($aphone) ? $aphone : ""; ?>" required>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Admin Password</label>
                <input type="password" name="password" id="" class="form-control" value="" required>
            </div>
        </div>
    </div>
</form>

<script>
    $('#sub_form').submit(function(e){
        e.preventDefault()

        start_loader()
        $.ajax({
            url: '../process.php?p=add_admin',
            method: 'POST',
            data: new FormData($(this)[0]),
            error: err => {
                console.log(err)
                $.jGrowl("An error occured")
            },
            success: function(resp) {
                if (resp == 1) {
                    $('#uni_modal').modal('hide')
                    end_loader()

                    $.jGrowl("Admin data saved successfully")
                    setTimeout(() => {
                        location.reload()
                    }, 1500);
                }

                if (resp == 2) {
                    end_loader()
                    $.jGrowl("Email and Password must not be empty", {header: "warning message"})
                }

                if (resp == 3) {
                    end_loader()
                    $.jGrowl("Invalid Email Format", {header: "error message"})
                }

                if (resp == 4) {
                    end_loader()
                    $.jGrowl("Invalid Phone Number", {header: "error message"})
                }

                if (resp == 5) {
                    end_loader()
                    $.jGrowl("Email already taken", {header: "error message"})
                }
            },
            cache: false,
            contentType: false,
            processData: false
        })
    })
</script>