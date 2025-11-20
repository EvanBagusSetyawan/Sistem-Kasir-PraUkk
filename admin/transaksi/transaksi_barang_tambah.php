<?php
include '../../config/koneksi.php';

$NomorTransaksi = $_POST['NomorTransaksi'];
$ProdukId       = $_POST['produk'];
$Jumlah         = $_POST['Jumlah'];

// hitung subtotal
$produkData = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE ProdukId = '$ProdukId'");
$produk = mysqli_fetch_assoc($produkData);
$subTotal = $produk['Harga'] * $Jumlah;

// insert ke tb_detail_penjualan
mysqli_query($koneksi, "INSERT INTO tb_detail_penjualan (PenjualanId, ProdukId, JumlahProduk, SubTotal) VALUES ('$NomorTransaksi', '$ProdukId', '$Jumlah', '$subTotal')");

// update stok produk
$stokBaru = $produk['Stok'] - $Jumlah;
mysqli_query($koneksi, "UPDATE tb_produk SET Stok = '$stokBaru' WHERE ProdukId = '$ProdukId'");

// cek dari mana datang (tambah atau edit)
$from = $_POST['edit'] ?? 'tambah'; // default 'tambah'

// redirect sesuai halaman
if ($from === 'edit') {
    header("Location: transaksi_edit.php?NomorTransaksi=$NomorTransaksi");
} else {
    header("Location: transaksi_tambah.php?NomorTransaksi=$NomorTransaksi");
}
exit;
