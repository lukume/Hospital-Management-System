<?php
    $id = $_GET['id'];
    $qry = $conn->query("SELECT * FROM medicine WHERE id='$id'");
    foreach ($qry->fetch_array() as $k => $val) {
        $meta[$k] = $val;
    }
?>

<div class="section-header">
    <h3><?=$meta['mname'] ?> List</h3>
</div>
<hr>
<div class="section-body">
    <div class="btn-group gap-1">
        <!-- <a href="doctorpdf.php" target="__blank" class="btn btn-secondary btn_download"><i class="fas fa-download"></i> PDF</a> -->
        <button class="btn btn-primary back_btn" onclick="return history.back()"><i class="fas fa-arrow-left"></i> BACK</button>
        <button class="btn btn-secondary print_btn"><i class="fas fa-print"></i> PRINT</button>
        <button class="btn btn-primary add_btn"><i class="fas fa-plus"></i> ADD</button>
    </div>
    <hr>
    <table id="table_id" class="cell-border hover nowrap" style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Medicine</th>
                <th>Packing</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $serial = 1;
                $qry2 = $conn->query("SELECT med_details.*, medicine.mname FROM med_details INNER JOIN medicine ON medicine.id=med_details.med_id WHERE med_details.med_id='$id'");
                while ($row = $qry2->fetch_array()) {
                    ?>
                        <tr>
                            <td><?=$serial; ?></td>
                            <td><?=htmlentities($row['mname']); ?></td>
                            <td><?=htmlentities($row['packing']); ?></td>
                            <td><?=htmlentities("KES".number_format($row['price'], 2)); ?></td>
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
        uni_modal("Add Medicine Details", "manage_med_details.php?med_id=<?php echo $_GET['id']; ?>")
    })

    $('.edit_btn').on('click', function() {
        uni_modal("Edit Medicine Details", "manage_med_details.php?id="+$(this).data('id')+"&med_id=<?php echo $_GET['id']; ?>")
    })

    $('.btn_download').on('click', function(){
        location.href = 'doctorpdf.php'
    })

    $('.print_btn').on('click', function() {
        var wnd = window.open('prints/meddetailsprint.php?id=<?php echo $_GET['id'] ?>', '__blank', 'width=1000, height=800')
        setTimeout(() => {
            wnd.print()
            setTimeout(() => {
                wnd.close()
            }, 500);
        }, 100);
    })

    $('.delete_btn').on('click', function(){
        $conf = confirm("Do you really want to delete medicine details")
        if ($conf == true) {
            $.ajax({
                url: '../process.php?p=delete_med_details',
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