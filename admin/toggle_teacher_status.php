<?php
include('dbcon.php');

if (isset($_GET['id'])) {
    $get_id = $_GET['id'];

    // Ambil status saat ini
    $query = mysqli_query($conn, "SELECT teacher_stat FROM teacher WHERE teacher_id = '$get_id'") or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($query);
    $current_status = $row['teacher_stat'];

    // Toggle status
    $new_status = ($current_status === 'Activated') ? 'Deactivated' : 'Activated';
    mysqli_query($conn, "UPDATE teacher SET teacher_stat = '$new_status' WHERE teacher_id = '$get_id'") or die(mysqli_error($conn));

    // Redirect ke halaman daftar guru
    header('location:teachers.php');
    exit();
} else {
    echo "Invalid request.";
    exit();
}
?>
