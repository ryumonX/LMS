<?php
$conn = mysqli_connect('localhost', 'root', '', 'capstone');

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

echo "Koneksi berhasil!";
?>