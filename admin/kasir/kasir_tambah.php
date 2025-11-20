<?php

include '../../config/koneksi.php';

// mengambil data dari form dengan name
$Username = $_POST['username'];
$Email = $_POST['email'];
$Password = md5($_POST['password']);
$Role = 'Petugas';

mysqli_query($koneksi, "INSERT INTO tb_user VALUES (
    NULL,
    '$Email',
    '$Username',
    '$Passwrord',
    '$Role'
)");

header("location:kasir_data.php");
exit;