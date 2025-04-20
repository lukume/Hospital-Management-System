<?php
    // $qry = $conn->query("SELECT * FROM patients");
    if (isset($_POST['submit'])) {
        $d_from = $_POST['d_from'];
        $d_to = $_POST['d_to'];

        $qry = $conn->query("SELECT  patients_visit.*, patients.pno, doctors.docid FROM  patients_visit INNER JOIN patients ON patients.id=patients_visit.patient_id INNER JOIN doctors ON doctors.id=patients_visit.doc_id WHERE patients_visit.visit_date BETWEEN '$d_from' AND '$d_to'");
    }
?>

<div class="section-header">
    <h3>Report Generation</h3>
</div>
<hr>
<div class="section-body">
    <div class="">
        <!-- <a href="doctorpdf.php" target="__blank" class="btn btn-secondary btn_download"><i class="fas fa-download"></i> PDF</a> -->
        <!-- <button class="btn btn-secondary print_btn"><i class="fas fa-print"></i> PRINT</button>
        <button class="btn btn-primary add_btn"><i class="fas fa-plus"></i> ADD</button> -->
        <h4>Patient Visits</h4>
        <form action="" method="POST">
            <div class="row mt-4">
                <div class="col-md-3 mb-4">
                    <div class="form-group">
                        <label for="" class="form-control-label">Visit Date From</label>
                        <input type="date" name="d_from" id="" class="form-control" reqired>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="form-group">
                        <label for="" class="form-control-label">Visit Date To</label>
                        <input type="date" name="d_to" id="" class="form-control" required>
                    </div>
                </div>
            </div>
            <input type="submit" name="submit" value="Generate" class="btn btn-primary">
        </form>
    </div>
    <hr>
    <?php
        if (isset($_POST['submit'])) {
            ?>
                <table id="table_id" class="cell-border hover nowrap" style="width: 100%;">
                <a href="visit_report.php?d_from=<?=isset($_POST['d_from']) ? $_POST['d_from'] : "" ?>&d_to=<?=isset($_POST['d_to']) ? $_POST['d_to'] : "" ?>" target="__blank" class="btn btn-secondary mb-3"><i class="fas fa-download"></i> PDF</a>
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
                                </tr>
                            <?php
                            $serial++;
                        }
                    ?>
                </tbody>
            </table>
            <?php
        }
    ?>
    
</div>

<script>
    $('.add_btn').on('click', function(){
        uni_modal("Add Partient", "manage_patient.php")
    })

    $('.edit_btn').on('click', function() {
        uni_modal("Edit Patient Details", "manage_patient.php?id="+$(this).data('id'))
    })

    $('.btn_download').on('click', function(){
        location.href = 'doctorpdf.php'
    })

    $('.print_btn').on('click', function() {
        var wnd = window.open('prints/patientprint.php', '__blank', 'width=1000, height=800')
        setTimeout(() => {
            wnd.print()
            setTimeout(() => {
                wnd.close()
            }, 500);
        }, 100);
    })

    $('.delete_btn').on('click', function(){
        $conf = confirm("Do you really want to delete patient")
        if ($conf == true) {
            $.ajax({
                url: '../process.php?p=delete_patient',
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