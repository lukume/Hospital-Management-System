<?php
    include '../db_connect.php';

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $qry = $conn->query("SELECT * FROM patients_visit WHERE id=".$_GET['id'])->fetch_array();
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
                <label for="" class="form-control-label">Select Patient</label>
                <select name="patient" id="" class="form-control">
                    <option value="">--- select patient ---</option>
                    <?php
                        $s = $conn->query("SELECT * FROM patients");
                        while ($row = $s->fetch_array()) {
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
                <label for="" class="form-control-label">Visit Date</label>
                <input type="date" name="vdate" id="vdate" class="form-control" value="<?=isset($visit_date) ? $visit_date : ""; ?>" required>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Next Visit Date</label>
                <input type="date" name="nvdate" id="nvdate" class="form-control" value="<?=isset($next_visit_date) ? $next_visit_date : ""; ?>" required>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">BP</label>
                <input type="text" name="bp" id="" class="form-control" value="<?=isset($bp) ? $bp : ""; ?>" required>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Weight</label>
                <input type="number" name="weight" id="" class="form-control" value="<?=isset($weight) ? $weight : ""; ?>" required>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Select Doctor</label>
                <select name="doctor" id="" class="form-control">
                    <option value="">--- select doctor ---</option>
                    <?php
                        $s = $conn->query("SELECT * FROM doctors");
                        while ($row = $s->fetch_array()) {
                            ?>
                                <option value="<?=$row['id'] ?>" <?=isset($doc_id) && $doc_id == $row['id'] ? "selected" : "" ?>><?=$row['docname']." - ".$row['docid']." - ".$row['docspec']  ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Disease</label>
                <textarea name="disease" id="" cols="30" rows="8" class="form-control">
                    <?=isset($disease) ? $disease : "" ?>
                </textarea>
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
    $('#vdate').attr('min', maxDate);
    $('#nvdate').attr('min', maxDate);
    
    $('#sub_form').submit(function(e){
        e.preventDefault()

        start_loader()
        $.ajax({
            url: '../process.php?p=add_patient_visit',
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

                    $.jGrowl("Patient visit data saved successfully")
                    setTimeout(() => {
                        location.reload()
                    }, 1500);
                }

                if (resp == 2) {
                    end_loader()
                    $.jGrowl("Patient Visit already registered", {header: "error message"})
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