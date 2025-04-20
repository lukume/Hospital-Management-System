<?php
    include '../db_connect.php';

    if (isset($_GET['bid']) && !empty($_GET['bid'])) {
        $qry = $conn->query("SELECT * FROM bill WHERE id=".$_GET['bid'])->fetch_array();
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
                <label for="" class="form-control-label">Phone Number</label>
                <input type="tel" name="phone_number" id="" class="form-control" value="" required>
            </div>
        </div>
        <input type="hidden" name="amount" value="<?=$total ?>">
        
    </div>
</form>

<script>
    $('#sub_form').submit(function(e){
        e.preventDefault()

        start_loader()
        $.ajax({
            url: '../process.php?p=pay_bill',
            method: 'POST',
            data: new FormData($(this)[0]),
            error: err => {
                console.log(err)
                $.jGrowl("An error occured")
            },
            success: function(resp) {
                if (resp == 1) {
                    $('#uni_modal').modal('hide')
                    $.jGrowl("Mpesa payment initialized.....", {sticky: true})
                    end_loader()

                    $.jGrowl("Bill Paid Sucessfully")
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