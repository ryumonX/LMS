<?php
include('admin/dbcon.php');
include('session.php');

if (isset($_POST['read'])) {
    // Periksa apakah 'selector' diatur dan tidak kosong
    if (isset($_POST['selector']) && !empty($_POST['selector'])) {
        $id = $_POST['selector'];
        $N = count($id);

        for ($i = 0; $i < $N; $i++) {
            mysqli_query($conn, "INSERT INTO notification_read (student_id, student_read, notification_id) VALUES ('$session_id', 'yes', '$id[$i]')") or die(mysqli_error($conn));
        }
    } else {
        // Jika tidak ada item yang dipilih
        echo "<script>alert('No notifications selected.');</script>";
    }
}
?>

<script>
window.location = 'student_notification.php';
</script>
