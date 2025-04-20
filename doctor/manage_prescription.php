<?php
    include '../db_connect.php';
?>

<form action="" id="sub_form">
    <input type="hidden" name="vid" value="<?=$_GET['vid'] ?>">
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Select Medicine</label>
                <select name="patient" id="" class="form-control">
                    <option value="">--- select medicine ---</option>
                    <?php
                        $s = $conn->query("SELECT * FROM medicine");
                        while ($row = $s->fetch_array()) {
                            ?>
                                <option value="<?=$row['id'] ?>" ><?=$row['mname'] ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Packing</label>
                <div id="med">
                    <select name="" id="" class="form-control">
                        <option value="">--- select packing ---</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="" class="form-control-label">Dosage</label>
                <input type="text" name="dosage" id="" class="form-control">
            </div>
        </div>
    </div>
</form>

<script>
    $('[name="patient"]').on('change', function() {
        $.ajax({
            url: 'ajax.php',
            method: 'POST',
            data: {id: $(this).val()},
            success: function(resp) {
                $('#med').html(resp)
            }
        })
    })

    $('#sub_form').submit(function(e){
        e.preventDefault()

        start_loader()
        $.ajax({
            url: '../process.php?p=add_prescription',
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

                    $.jGrowl("Prescription data saved successfully")
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