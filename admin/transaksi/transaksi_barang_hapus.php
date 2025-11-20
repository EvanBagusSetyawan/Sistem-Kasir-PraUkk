<?php
include '../../config/koneksi.php';

// Ambil data dari form POST
$ProdukId     = $_POST['ProdukId'] ?? null;
$PenjualanId  = $_POST['PenjualanId'] ?? null;
$DetailId     = $_POST['DetailId'] ?? null;

// Cek apakah semua data tersedia
if (!$ProdukId || !$PenjualanId || !$DetailId) {
    die("Data tidak lengkap.");
}

// Ambil data detail penjualan
$BarangDelete = mysqli_query($koneksi, "SELECT * FROM tb_detail_penjualan WHERE DetailId = '$DetailId' AND ProdukId = '$ProdukId' AND PenjualanId = '$PenjualanId'");
$BarangDeleteData = mysqli_fetch_assoc($BarangDelete);

if (!$BarangDeleteData) {
    die("Barang tidak ditemukan.");
}

// Ambil data produk
$Produk = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE ProdukId = '$ProdukId'");
$produkData = mysqli_fetch_assoc($Produk);

if (!$produkData) {
    die("Produk tidak ditemukan.");
}

// Kembalikan stok produk
$JumlahProduk = $produkData['Stok'] + $BarangDeleteData['JumlahProduk'];
mysqli_query($koneksi, "UPDATE tb_produk SET Stok = '$JumlahProduk' WHERE ProdukId = '$ProdukId'");

// Hapus detail penjualan
mysqli_query($koneksi, "DELETE FROM tb_detail_penjualan WHERE DetailId = '$DetailId'");

// Redirect ke halaman tambah transaksi
// header("Location: transaksi_tambah.php?NomorTransaksi=$PenjualanId");
if (isset($_POST['edit'])) {
    $from = $_POST['edit'];
}; // default ke tambah

if ($from === 'edit') {
    header("Location: transaksi_edit.php?NomorTransaksi=$PenjualanId");
} else {
    header("Location: transaksi_tambah.php?NomorTransaksi=$PenjualanId");
}
exit;
