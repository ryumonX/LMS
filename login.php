<?php
include('admin/dbcon.php');
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

/* Student Login */
$query = "SELECT * FROM student WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = mysqli_fetch_array($result);
$num_row = mysqli_num_rows($result);

/* Teacher Login - Only Activated Teachers */
$query_teacher = "SELECT * FROM teacher WHERE username='$username' AND password='$password' AND teacher_stat='Activated'";
$result_teacher = mysqli_query($conn, $query_teacher) or die(mysqli_error($conn));
$num_row_teacher = mysqli_num_rows($result_teacher);
$row_teacher = mysqli_fetch_array($result_teacher);

if ($num_row > 0) { 
    // Student Login Successful
    $_SESSION['id'] = $row['student_id'];
    echo 'true_student';    
} else if ($num_row_teacher > 0) {
    // Teacher Login Successful
    $_SESSION['id'] = $row_teacher['teacher_id'];
    echo 'true';
} else { 
    // Login Failed
    echo 'false';
}
?>
