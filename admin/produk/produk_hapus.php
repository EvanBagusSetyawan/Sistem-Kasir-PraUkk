<?php

include '../../config/koneksi.php';

$ProdukId = $_POST['ProdukId']; 

mysqli_query($koneksi, "DELETE FROM tb_produk Where ProdukId = '$ProdukId'");

header("Location: produk_data.php");
exit;
