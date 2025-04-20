<?php
    include '../db_connect.php';

    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        ?>
            <select name="med_id" id="" class="form-control">
                <?php
                    $qry = $conn->query("SELECT * FROM med_details WHERE med_id='$id'");
                    while ($row = $qry->fetch_array()) {
                        ?>
                            <option value="<?=$row['id'] ?>"><?=$row['packing'] ?></option>
                        <?php
                    }
                ?>
            </select>
        <?php
    }