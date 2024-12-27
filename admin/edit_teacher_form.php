<div class="row-fluid">
    <a href="teachers.php" class="btn btn-info"><i class="icon-plus-sign icon-large"></i> Add Teacher</a>
    <!-- block -->
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left">Edit Teacher</div>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <form method="post">
                    <?php
                    // Ambil data teacher berdasarkan id
                    $query = mysqli_query($conn, "SELECT * FROM teacher WHERE teacher_id = '$get_id'") or die(mysqli_error($conn));
                    $row = mysqli_fetch_array($query);
                    ?>
                    <div class="control-group">
                        <label>Department:</label>
                        <div class="controls">
                            <select name="department" class="chzn-select" required>
                                <?php
                                // Ambil data department saat ini
                                $query_teacher = mysqli_query($conn, "SELECT * FROM teacher JOIN department ON teacher.department_id = department.department_id WHERE teacher.teacher_id = '$get_id'") or die(mysqli_error($conn));
                                $row_teacher = mysqli_fetch_array($query_teacher);
                                ?>
                                <option value="<?php echo $row_teacher['department_id']; ?>">
                                    <?php echo $row_teacher['department_name'] ?? ''; ?>
                                </option>
                                <?php
                                // Ambil daftar semua department
                                $department = mysqli_query($conn, "SELECT * FROM department ORDER BY department_name");
                                while ($department_row = mysqli_fetch_array($department)) {
                                ?>
                                    <option value="<?php echo $department_row['department_id']; ?>"><?php echo $department_row['department_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <input class="input focused" value="<?php echo $row['firstname']; ?>" name="firstname" id="focusedInput" type="text" placeholder="Firstname" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <input class="input focused" value="<?php echo $row['lastname']; ?>" name="lastname" id="focusedInput" type="text" placeholder="Lastname" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <input class="input focused" name="password" id="passwordInput" type="password" placeholder="Enter New Password" >
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button name="update" class="btn btn-success"><i class="icon-save icon-large"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /block -->
</div>

<?php
if (isset($_POST['update'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $department_id = $_POST['department'];
    $password = $_POST['password']; // Ambil password dari input form

    // Cek apakah data dengan nama yang sama sudah ada
    $query = mysqli_query($conn, "SELECT * FROM teacher WHERE firstname = '$firstname' AND lastname = '$lastname' AND teacher_id != '$get_id'") or die(mysqli_error($conn));
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        echo '<script>alert("Data Already Exist");</script>';
    } else {
        // Cek jika password tidak kosong
        if (!empty($password)) {
            // Hash password sebelum menyimpannya
            $password = md5($password);
            $query = "UPDATE teacher SET firstname = '$firstname', lastname = '$lastname', department_id = '$department_id', password = '$password' WHERE teacher_id = '$get_id'";
        } else {
            // Update tanpa mengubah password
            $query = "UPDATE teacher SET firstname = '$firstname', lastname = '$lastname', department_id = '$department_id' WHERE teacher_id = '$get_id'";
        }

        mysqli_query($conn, $query) or die(mysqli_error($conn));
        echo '<script>window.location = "teachers.php";</script>';
    }
}

?>