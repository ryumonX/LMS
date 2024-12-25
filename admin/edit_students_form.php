<?php
// Koneksi ke database
include('dbcon.php');

// Ambil ID siswa dari parameter URL
$get_id = $_GET['id'];

// Ambil data siswa berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM student 
                              LEFT JOIN class ON class.class_id = student.class_id 
                              WHERE student_id = '$get_id'") or die(mysqli_error($conn));
$row = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Siswa</title>
  <link rel="stylesheet" href="path/to/your/css/file.css"> <!-- Tambahkan file CSS jika ada -->
</head>

<body>
  <div class="row-fluid">
    <a href="students.php" class="btn btn-info"><i class="icon-plus-sign icon-large"></i> Tambah Siswa</a>
    <!-- Block -->
    <div class="block">
      <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Edit Siswa</div>
      </div>
      <div class="block-content collapse in">
        <div class="span12">
          <form method="post">

            <!-- Pilih Kelas -->
            <div class="control-group">
              <div class="controls">
                <select name="cys" class="" required>
                  <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                  <?php
                  $cys_query = mysqli_query($conn, "SELECT * FROM class ORDER BY class_name");
                  while ($cys_row = mysqli_fetch_array($cys_query)) {
                  ?>
                    <option value="<?php echo $cys_row['class_id']; ?>"><?php echo $cys_row['class_name']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <!-- Input ID Number -->
            <div class="control-group">
              <div class="controls">
                <input name="un" value="<?php echo $row['username']; ?>" class="input focused" id="focusedInput" type="text" placeholder="ID Number" required>
              </div>
            </div>

            <!-- Input Firstname -->
            <div class="control-group">
              <div class="controls">
                <input name="fn" value="<?php echo $row['firstname']; ?>" class="input focused" id="focusedInput" type="text" placeholder="Firstname" required>
              </div>
            </div>

            <!-- Input Lastname -->
            <div class="control-group">
              <div class="controls">
                <input name="ln" value="<?php echo $row['lastname']; ?>" class="input focused" id="focusedInput" type="text" placeholder="Lastname" required>
              </div>
            </div>

            <!-- Input Password -->
            <div class="control-group">
              <div class="controls">
                <input name="pw" value="<?php echo $row['password']; ?>" class="input focused" id="focusedInput" type="text" placeholder="Password" required>
              </div>
            </div>

            <!-- Tombol Update -->
            <div class="control-group">
              <div class="controls">
                <button name="update" class="btn btn-success"><i class="icon-save icon-large"></i> Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /Block -->
  </div>

  <?php
  // Proses update data
  if (isset($_POST['update'])) {
    $un = $_POST['un'];
    $fn = $_POST['fn'];
    $ln = $_POST['ln'];
    $cys = $_POST['cys'];
    $pw = $_POST['pw'];

    // Update data ke database
    mysqli_query($conn, "UPDATE student 
                         SET username = '$un', 
                             firstname = '$fn', 
                             lastname = '$ln', 
                             class_id = '$cys', 
                             password = '$pw' 
                         WHERE student_id = '$get_id'") or die(mysqli_error($conn));

    // Redirect ke halaman students.php
    echo "<script>
            alert('Data updated successfully!');
            window.location = 'students.php';
          </script>";
  }
  ?>
</body>

</html>
