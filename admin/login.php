<?php
include('dbcon.php');
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'") or die(mysqli_error($conn));
$count = mysqli_num_rows($query);
$row = mysqli_fetch_array($query);

if ($count > 0) {
    $_SESSION['id'] = $row['user_id'];

    echo 'true';

    // Menyisipkan log login ke database
    mysqli_query($conn, "INSERT INTO user_log (username, login_date, user_id) VALUES ('$username', NOW(), " . $row['user_id'] . ")") or die(mysqli_error($conn));
} else {
    echo 'false';
}
?>
