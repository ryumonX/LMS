<?php
include('admin/dbcon.php');
session_start();

$username = $_POST['username'];
$password_student = $_POST['password']; // Password murid tanpa hashing
$password_teacher = md5($_POST['password']); // Hash password guru dengan md5

/* Student Login */
$query_student = "SELECT * FROM student WHERE username='$username' AND password='$password_student'";
$result_student = mysqli_query($conn, $query_student) or die(mysqli_error($conn));
$row_student = mysqli_fetch_array($result_student);
$num_row_student = mysqli_num_rows($result_student);

/* Teacher Login - Only Activated Teachers */
$query_teacher = "SELECT * FROM teacher WHERE username='$username' AND password='$password_teacher' AND teacher_stat='Activated'";
$result_teacher = mysqli_query($conn, $query_teacher) or die(mysqli_error($conn));
$row_teacher = mysqli_fetch_array($result_teacher);
$num_row_teacher = mysqli_num_rows($result_teacher);

if ($num_row_student > 0) { 
    // Student Login Successful
    $_SESSION['id'] = $row_student['student_id'];
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
