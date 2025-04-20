<?php
    $vid = $_GET['id'];
    $qry = $conn->query("SELECT  prescription.*, med_details.id as mid, med_details.packing, med_details.price, medicine.mname FROM  prescription INNER JOIN med_details ON med_details.id=prescription.med_id INNER JOIN medicine On medicine.id=med_details.med_id WHERE prescription.visit_id='$vid'");

    $doc_idd = $conn->query("SELECT * FROM patients_visit WHERE id='$vid'")->fetch_array()['doc_id'];
    $doc = $conn->query("SELECT * FROM doctors WHERE id='$doc_idd'");
    foreach ($doc->fetch_array() as $k => $val) {
        $m[$k] = $val;
    }
    $ch = $conn->query("SELECT * FROM bill WHERE visit_id='$vid'")->num_rows;
?>

<div class="section-header">
    <h3>Prescrition List (<?=$qry->num_rows ?>) Doctor fee - <?="KES".number_format($m['docfees'], 2); ?></h3>
</div>
<hr>
<div class="section-body">
    <div class="btn-group gap-1">
        <!-- <a href="doctorpdf.php" target="__blank" class="btn btn-secondary btn_download"><i class="fas fa-download"></i> PDF</a> -->
        <button class="btn btn-primary back_btn" onclick="return history.back()"><i class="fas fa-arrow-left"></i> BACK</button>
        <?php if ($ch == 0): ?>
        <button class="btn btn-primary add_btn"><i class="fas fa-plus"></i> ADD</button>
        <?php endif; ?>
    </div>
    <hr>
    <table id="table_id" class="cell-border hover nowrap" style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Medicine</th>
                <th>Packing</th>
                <th>Price</th>
                <th>Dosage</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $serial = 1;
                $total = 0; 
                while ($row = $qry->fetch_array()) {
                    ?>
                        <tr>
                            <td><?=$serial; ?></td>
                            <td><?=htmlentities($row['mname']); ?></td>
                            <td><?=htmlentities($row['packing']); ?></td>
                            <td><?="KES".number_format(htmlentities($row['price']), 2); ?></td>
                            <td><?=htmlentities($row['dosage']); ?></td>
                            <td>
                                <button class="btn btn-outline-danger delete_btn" data-id="<?=htmlentities($row['id']); ?>"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    <?php
                    $serial++;
                    $total += $row['price'];
                    $grand_total = $total + $m['docfees'];
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <th><b>Total</b></th>
                <td><?php echo "KES".number_format($total, 2); ?></td>
                <th><b>Grand Total</b></th>
                <td><?php echo "KES".number_format($grand_total, 2); ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <?php
                        if ($ch > 0) {
                            ?>
                                <span class="badge bg-success">Bill Generated</span>
                            <?php
                        } else {
                            ?>
                                <button class="btn btn-primary add_bill" data-amount="<?=$grand_total; ?>">Add to Bill</button>
                            <?php
                        }
                    ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<script>
    $('.add_bill').on('click', function() {
        start_loader()

        $.ajax({
            url: '../process.php?p=add_bill',
            method: 'POST',
            data: {vid: <?php echo $vid; ?>, amount: $(this).data('amount')},
            success: function(resp) {
                if (resp == 1) {
                    end_loader()

                    $.jGrowl("Bill added successfully")
                    setTimeout(() => {
                        location.reload()
                    }, 1500);
                }

                if (resp == 2) {
                    end_loader()

                    $.jGrowl("Bill already added", {header: "error message"})
                }
            }
        })
    })

    $('.add_btn').on('click', function(){
        uni_modal("Add Medicine", "manage_prescription.php?vid=<?php echo $_GET['id'] ?>")
    })

    $('.edit_btn').on('click', function() {
        uni_modal("Edit Medicine Details", "manage_prescription.php?id="+$(this).data('id')+"&vid=<?php echo $_GET['id'] ?>")
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
        $conf = confirm("Do you really want to delete prescription")
        if ($conf == true) {
            $.ajax({
                url: '../process.php?p=delete_prescription',
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