<?php
    $qry = $conn->query("SELECT  patients_visit.*, patients.pno, doctors.docid FROM  patients_visit INNER JOIN patients ON patients.id=patients_visit.patient_id INNER JOIN doctors ON doctors.id=patients_visit.doc_id ORDER BY patients_visit.id DESC");
?>

<div class="section-header">
    <h3>Patient Visit List (<?=$qry->num_rows ?>)</h3>
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
                <th>Patient N0</th>
                <th>Doctor N0</th>
                <th>Visit Date</th>
                <th>Next Visit Date</th>
                <th>BP</th>
                <th>Weight</th>
                <th>Disease</th>
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
                            <td><?=htmlentities(date('d M, Y', strtotime($row['visit_date']))); ?></td>
                            <td><?=$row['next_visit_date'] == NULL ? "" : htmlentities(date('d M, Y', strtotime($row['next_visit_date']))); ?></td>
                            <td><?=htmlentities($row['bp']); ?></td>
                            <td><?=htmlentities($row['weight']); ?></td>
                            <td><?=htmlentities($row['disease']); ?></td>
                            <td>
                                <button class="btn btn-outline-primary edit_btn" data-id="<?=htmlentities($row['id']); ?>"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-outline-info pres_btn" data-id="<?=htmlentities($row['id']); ?>"><i class="fas fa-pen"></i> priscribe</button>
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
        uni_modal("Add Medicine", "manage_patient_visit.php")
    })

    $('.edit_btn').on('click', function() {
        uni_modal("Edit Medicine Details", "manage_patient_visit.php?id="+$(this).data('id'))
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
                url: '../process.php?p=delete_patient_visit',
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