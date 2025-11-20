<?php

include '../../config/koneksi.php';

$PelangganId = $_POST['PelangganId']; 

mysqli_query($koneksi, "DELETE FROM tb_pelanggan Where PelangganID = '$PelangganId'");

header("Location: pelanggan_data.php");
exit;
