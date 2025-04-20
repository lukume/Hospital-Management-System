<?php
    $qry = $conn->query("SELECT  appointment.*, patients.pno, doctors.docid FROM  appointment INNER JOIN patients ON patients.id=appointment.patient_id INNER JOIN doctors ON doctors.id=appointment.doc_id ORDER BY appointment.id DESC");
?>

<div class="section-header">
    <h3>Appointment List (<?=$qry->num_rows ?>)</h3>
</div>
<hr>
<div class="section-body">
    <div class="btn-group gap-1">
        <!-- <a href="doctorpdf.php" target="__blank" class="btn btn-secondary btn_download"><i class="fas fa-download"></i> PDF</a> -->
        <button class="btn btn-primary add_btn"><i class="fas fa-plus"></i> ADD</button>
    </div>
    <hr>
    <table id="table_id" class="cell-border hover nowrap" style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Patient N0</th>
                <th>Doctor N0</th>
                <th>Appointment Date</th>
                <th>Status</th>
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
                            <td><?=htmlentities($row['pno']); ?></td>
                            <td><?=htmlentities($row['docid']); ?></td>
                            <td><?=$row['appointment_date'] == NULL ? "" : htmlentities(date('d M, Y', strtotime($row['appointment_date']))); ?></td>
                            <td>
                                <?php if ($row['status'] == 1): ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php elseif ($row['status'] == 2): ?>
                                    <span class="badge bg-success">Approved</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Canceled</span>
                                <?php endif; ?>
                            </td>
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
        uni_modal("Add Appointmrent", "manage_appointment.php")
    })

    $('.edit_btn').on('click', function() {
        uni_modal("Edit Medicine Details", "manage_appointment.php?id="+$(this).data('id'))
    })

    $('.btn_download').on('click', function(){
        location.href = 'doctorpdf.php'
    })

    $('.print_btn').on('click', function() {
        var wnd = window.open('prints/patientvisitprint.php', '__blank', 'width=1000, height=800')
        setTimeout(() => {
            wnd.print()
            setTimeout(() => {
                wnd.close()
            }, 500);
        }, 100);
    })

    $('.delete_btn').on('click', function(){
        $conf = confirm("Do you really want to delete patient visit")
        if ($conf == true) {
            $.ajax({
                url: '../process.php?p=delete_appointment',
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

    $('.pres_btn').on('click', function() {
        location.href = "./?page=prescription&id="+$(this).data('id')
    })
</script>