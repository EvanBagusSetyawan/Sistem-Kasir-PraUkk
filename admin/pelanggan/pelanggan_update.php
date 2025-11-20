<?php

include '../../config/koneksi.php';

$PelangganID = $_POST['PelangganId'];
$NamaPelanggan = $_POST['NamaPelanggan'];
$Alamat = $_POST['Alamat'];
$NomerTelephone = $_POST['NomerTelephone'];

mysqli_query($koneksi, "UPDATE tb_pelanggan SET NamaPelanggan = '$NamaPelanggan', Alamat = '$Alamat', NomerTelephone = '$NomerTelephone' Where PelangganId = '$PelangganID' ");

header("Location: pelanggan_data.php");
exit;