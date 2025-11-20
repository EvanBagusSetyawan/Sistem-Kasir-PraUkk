<?php

include "../../config/koneksi.php";
// mengambil data dari form dengan name
$NamaPelanggan = $_POST['NamaPelanggan'];
$Alamat = $_POST['Alamat'];
$NomerTelephone = $_POST['NomerTelephone'];

mysqli_query($koneksi, "INSERT INTO tb_pelanggan VALUES (
    NULL,
    '$NamaPelanggan',
    '$Alamat',
    '$NomerTelephone'
)");

header("location:pelanggan_data.php");
exit;
