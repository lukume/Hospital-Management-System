<?php
    include '../db_connect.php';

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $qry = $conn->query("SELECT * FROM patients WHERE id=".$_GET['id'])->fetch_array();
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
                <label for="" class="form-control-label">Patient Full Names</label>
                <input type="text" name="name" id="" class="form-control" value="<?=isset($pname) ? $pname : ""; ?>" required>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Patient Phone</label>
                <input type="tel" name="phone" id="" class="form-control" value="<?=isset($pphone) ? $pphone : ""; ?>" required>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Patient ID Number</label>
                <input type="number" name="idno" id="" class="form-control" value="<?=isset($pidno) ? $pidno : ""; ?>" required>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Patient Address</label>
                <input type="text" name="address" id="" class="form-control" value="<?=isset($paddress) ? $paddress : ""; ?>" required>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Patient Gender</label>
                <select name="gender" id="" class="form-control">
                    <option value="male" <?=isset($pgender) && $pgender == "male" ? "selected" : "" ?>>Male</option>
                    <option value="female" <?=isset($pgender) && $pgender == "female" ? "selected" : "" ?>>Female</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Patient Age</label>
                <input type="number" name="age" id="" class="form-control" value="<?=isset($age) ? $age : ""; ?>" required>
            </div>
        </div>
    </div>
</form>

<script>
    $('#sub_form').submit(function(e){
        e.preventDefault()

        start_loader()
        $.ajax({
            url: '../process.php?p=add_patient',
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

                    $.jGrowl("Patient data saved successfully")
                    setTimeout(() => {
                        location.reload()
                    }, 1500);
                }

                if (resp == 2) {
                    end_loader()
                    $.jGrowl("ID and Names must not be empty", {header: "warning message"})
                }

                if (resp == 3) {
                    end_loader()
                    $.jGrowl("Invalid ID Format", {header: "error message"})
                }

                if (resp == 4) {
                    end_loader()
                    $.jGrowl("Invalid Phone Number", {header: "error message"})
                }

                if (resp == 5) {
                    end_loader()
                    $.jGrowl("Patient already registered", {header: "error message"})
                }
            },
            cache: false,
            contentType: false,
            processData: false
        })
    })
</script>