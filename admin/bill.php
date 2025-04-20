<?php
    $qry = $conn->query("SELECT  * FROM  bill ORDER BY id DESC");
?>

<div class="section-header">
    <h3>Bill List (<?=$qry->num_rows ?>)</h3>
</div>
<hr>
<div class="section-body">
    <!-- <div class="btn-group gap-1">
         <a href="doctorpdf.php" target="__blank" class="btn btn-secondary btn_download"><i class="fas fa-download"></i> PDF</a>
        <button class="btn btn-primary add_btn"><i class="fas fa-plus"></i> ADD</button>
    </div> -->
    <hr>
    <table id="table_id" class="cell-border hover nowrap" style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Invoice N0</th>
                <th>Bill Date</th>
                <th>Amount Payable</th>
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
                            <td><?=htmlentities($row['invoice_no']); ?></td>
                            <td><?=htmlentities(date('d M, Y', strtotime($row['bill_date']))); ?></td>
                            <th><?="KES".number_format($row['total'], 2) ?></th>
                            <td>
                                <?php if ($row['status'] == 1): ?>
                                    <span class="badge bg-danger">Not Paid</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Paid</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="generate_bill.php?vid=<?=$row['visit_id'] ?>" target="__blank" class="btn btn-primary">Generate Bill</a>
                                <?php if ($row['status'] == 1): ?>
                                    <button class="btn btn-success pay_btn" data-id="<?=htmlentities($row['id']); ?>">PAY</button>
                                <?php endif; ?>
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
    $('.pay_btn').on('click', function(){
        uni_modal("Pay Bill (MPESA Payment)", "manage_pay_bill.php?bid="+$(this).data('id'))
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