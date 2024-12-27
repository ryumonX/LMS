<div class="row-fluid">
    <!-- block -->
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left">Add Teacher</div>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <form method="post">
                    <!--
                        <label>Photo:</label>
                        <div class="control-group">
                          <div class="controls">
                               <input class="input-file uniform_on" id="fileInput" type="file" required>
                          </div>
                        </div>
                    -->
                    
                    <div class="control-group">
                        <label>Department:</label>
                        <div class="controls">
                            <select name="department" class="" required>
                                <option></option>
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM department ORDER BY department_name");
                                while ($row = mysqli_fetch_array($query)) {
                                ?>
                                    <option value="<?php echo $row['department_id']; ?>">
                                        <?php echo $row['department_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <input class="input focused" name="firstname" id="focusedInput" type="text" placeholder="Firstname">
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <input class="input focused" name="lastname" id="focusedInput" type="text" placeholder="Lastname">
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <button name="save" class="btn btn-info">
                                <i class="icon-plus-sign icon-large"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /block -->
</div>

<?php
if (isset($_POST['save'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $department_id = $_POST['department'];
    $username = rand(1000, 9999); // Generate username with 4 random digits
    $password = str_pad(rand(0, 999999), 6, "0", STR_PAD_LEFT); // Generate 6-digit random password
    $password_hashed = md5($password); 

    $query = mysqli_query($conn, "SELECT * FROM teacher WHERE firstname = '$firstname' AND lastname = '$lastname'") or die(mysqli_error($conn));
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        echo '<script>alert("Data Already Exist");</script>';
    } else {
        // Show the generated password before hashing
        echo '<script>alert("Teacher added successfully! your password: ' . $password . '");</script>';

        mysqli_query($conn, "INSERT INTO teacher (firstname, lastname, username, location, department_id, password)
                            VALUES ('$firstname', '$lastname', '$username', 'uploads/NO-IMAGE-AVAILABLE.jpg', '$department_id', '$password_hashed')")
        or die(mysqli_error($conn));

        echo '<script>window.location = "teachers.php";</script>';
    }
}
?>
