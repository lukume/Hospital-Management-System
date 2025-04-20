<?php
    include '../db_connect.php';

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $qry = $conn->query("SELECT * FROM appointment WHERE id=".$_GET['id'])->fetch_array();
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
                <label for="" class="form-control-label">Patient</label>
                <select name="patient" id="" class="form-control">
                    <option value="">--- select patient ---</option>
                    <?php
                        $qry = $conn->query("SELECT * FROM patients");
                        while ($row = $qry->fetch_array()) {
                            ?>
                                <option value="<?=$row['id'] ?>" <?=isset($patient_id) && $patient_id == $row['id'] ? "selected" : "" ?>><?=$row['pname']." - ".$row['pno'] ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Doctor</label>
                <select name="doctor" id="" class="form-control">
                    <option value="">--- select doctor ---</option>
                    <?php
                        $qry = $conn->query("SELECT * FROM doctors");
                        while ($row = $qry->fetch_array()) {
                            ?>
                                <option value="<?=$row['id'] ?>" <?=isset($doc_id) && $doc_id == $row['id'] ? "selected" : "" ?>><?=$row['docname']." - ".$row['docspec'] ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Appointment Date</label>
                <input type="date" name="adate" id="adate" class="form-control" value="<?=isset($appointment_date) ? $appointment_date : ""; ?>" required>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Status</label>
                <select name="status" id="" class="form-control">
                    <option value="1" <?=isset($status) && $status == 1 ? "selected" : "" ?>>Pending</option>
                    <option value="2" <?=isset($status) && $status == 2 ? "selected" : "" ?>>Confirmed</option>
                    <option value="3" <?=isset($status) && $status == 3 ? "selected" : "" ?>>Canceled</option>
                </select>
            </div>
        </div>
    </div>
</form>

<script>
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString()

    var maxDate = year + '-' + month + '-' + day;
    $('#adate').attr('min', maxDate);

    $('#sub_form').submit(function(e){
        e.preventDefault()

        start_loader()
        $.ajax({
            url: '../process.php?p=add_appointment',
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

                    $.jGrowl("Appointment data saved successfully")
                    setTimeout(() => {
                        location.reload()
                    }, 1500);
                }

                if (resp == 2) {
                    end_loader()
                    $.jGrowl("Appointment already exists", {header: "error message"})
                }

                if (resp == 3) {
                    end_loader()
                    $.jGrowl("Medicine name must not be empty", {header: "error message"})
                }
            },
            cache: false,
            contentType: false,
            processData: false
        })
    })
</script>