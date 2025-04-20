<?php
    $qry = $conn->query("SELECT * FROM doctors");
?>

<div class="section-header">
    <h3>Doctors List (<?=$qry->num_rows ?>)</h3>
</div>
<hr>
<div class="section-body">
    <div class="btn-group gap-1">
        <!-- <a href="doctorpdf.php" target="__blank" class="btn btn-secondary btn_download"><i class="fas fa-download"></i> PDF</a> -->
        <button class="btn btn-secondary print_btn"><i class="fas fa-print"></i> PRINT</button>
        <button class="btn btn-primary add_btn"><i class="fas fa-plus"></i> ADD</button>
    </div>
    <hr>
    <table id="table_id" class="cell-border hover nowrap" style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>docid</th>
                <th>Name</th>
                <th>Specification</th>
                <th>Doc Fees</th>
                <th>Reg Date</th>
                <th>Action</th>
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
                            <td><?=htmlentities(date('d M, Y H:n', strtotime($row['reg_date']))); ?></td>
                            <td>
                                <button class="btn btn-outline-primary edit_btn" data-id="<?=htmlentities($row['id']); ?>"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-outline-danger delete_btn" data-id="<?=htmlentities($row['id']); ?>"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    <?php
                    $serial++;
                }
            ?>
        </tbody>
    </table>
</div>

<script>
    $('.add_btn').on('click', function(){
        uni_modal("Add Doctor", "manage_doctor.php")
    })

    $('.edit_btn').on('click', function() {
        uni_modal("Edit Doctor Details", "manage_doctor.php?id="+$(this).data('id'))
    })

    $('.btn_download').on('click', function(){
        location.href = 'doctorpdf.php'
    })

    $('.print_btn').on('click', function() {
        var wnd = window.open('prints/docprint.php', '__blank', 'width=1000, height=800')
        setTimeout(() => {
            wnd.print()
            setTimeout(() => {
                wnd.close()
            }, 500);
        }, 100);
    })

    $('.delete_btn').on('click', function(){
        $conf = confirm("Do you really want to delete doctor")
        if ($conf == true) {
            $.ajax({
                url: '../process.php?p=delete_doctor',
                method: 'POST',
                data: {id: $(this).data('id')},
                success: function(resp) {
                    if (resp == 1) {
                        $.jGrowl("Deleted Successfully")

                        setTimeout(() => {
                            location.reload()
                        }, 1500);
                    }
                }
            })
        } else {
            $.jGrowl("Delete Canceled")
        }
    })
</script>