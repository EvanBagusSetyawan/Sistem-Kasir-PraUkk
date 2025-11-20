<?php

include '../../config/koneksi.php';

// mengambil data dari form dengan name
$NamaProduk = $_POST['NamaProduk'];
$Harga = $_POST['Harga'];
$Stok = $_POST['Stok'];

mysqli_query($koneksi, "INSERT INTO tb_produk VALUES (
    NULL,
    '$NamaProduk',
    '$Harga',
    '$Stok'
)");

header("location:produk_data.php");
exit;