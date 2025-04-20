<?php
    include '../db_connect.php';

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $qry = $conn->query("SELECT * FROM medicine WHERE id=".$_GET['id'])->fetch_array();
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
                <label for="" class="form-control-label">Medicine Name</label>
                <input type="text" name="name" id="" class="form-control" value="<?=isset($mname) ? $mname : ""; ?>" required>
            </div>
        </div>
    </div>
</form>

<script>
    $('#sub_form').submit(function(e){
        e.preventDefault()

        start_loader()
        $.ajax({
            url: '../process.php?p=add_medicine',
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

                    $.jGrowl("Medicine data saved successfully")
                    setTimeout(() => {
                        location.reload()
                    }, 1500);
                }

                if (resp == 2) {
                    end_loader()
                    $.jGrowl("Medicine already exists", {header: "error message"})
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