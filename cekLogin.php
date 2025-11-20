<?php
include "config/koneksi.php";

session_start();

$user = $_POST['username'];
$password = md5($_POST['password']);

$user = mysqli_real_escape_string($koneksi, $user);
$password = mysqli_real_escape_string($koneksi, $password);

$query = "SELECT * FROM tb_user WHERE username = '$user' AND password = '$password'";
$login = mysqli_query($koneksi, $query);
$cek = mysqli_num_rows($login);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($login);

    if ($data['role'] == 'Admin') {
        $_SESSION['UserId'] = $data['UserId'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['role'] = $data['role'];
        header("Location: admin/dashboard/index.php");
        exit();
    } elseif ($data['role'] == 'Petugas') {
        $_SESSION['UserId'] = $data['UserId'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];
        header("Location: admin/dashboard/index.php");
        exit();
    }
} else {
    header("Location: index.php?pesan=gagal login, silakan coba lagi.");
}
