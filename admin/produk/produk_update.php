<?php

include '../../config/koneksi.php';

$ProdukId = $_POST['ProdukId'];
$NamaProduk = $_POST['NamaProduk'];
$Harga = $_POST['Harga'];
$Stok = $_POST['Stok'];

mysqli_query($koneksi, "UPDATE tb_produk SET NamaProduk = '$NamaProduk', Harga = '$Harga', Stok = '$Stok' Where ProdukId = '$ProdukId' ");

header("Location: produk_data.php");
exit;