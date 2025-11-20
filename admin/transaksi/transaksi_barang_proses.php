<?php

include '../../config/koneksi.php';

// Ambil data dari form
$PenjualanId = $_POST['nomorTransaksi'];
$TotalHarga = $_POST['total'];
$UserId = $_POST['UserId'];
$TanggalPenjualan = $_POST['Tanggal'] ?? date('Y-m-d H:i:s');
$PelangganId = $_POST['pelanggan'] ?? null;

// Cek apakah pelanggan dipilih
if (empty($PelangganId)) {
    echo "<script>alert('Pelanggan belum dipilih!'); window.history.back();</script>";
    exit;
}

// Query insert yang benar
// Cek apakah PenjualanId sudah ada
$cek = mysqli_query($koneksi, "SELECT PenjualanId FROM tb_penjualan WHERE PenjualanId = '$PenjualanId'");
if (mysqli_num_rows($cek) > 0) {
    // Jika sudah ada, update total harga dan pelanggan
    mysqli_query(
        $koneksi,
        "UPDATE tb_penjualan 
         SET TotalHarga = '$TotalHarga', 
             PelangganId = '$PelangganId', 
             UserId = '$UserId', 
             TanggalPenjualan = '$TanggalPenjualan'
         WHERE PenjualanId = '$PenjualanId'"
    );
} else {
    // Jika belum ada, insert baru
    mysqli_query(
        $koneksi,
        "INSERT INTO tb_penjualan 
        (PenjualanId, TanggalPenjualan, TotalHarga, PelangganId, UserId) 
        VALUES 
        ('$PenjualanId', '$TanggalPenjualan', '$TotalHarga', '$PelangganId', '$UserId')"
    );
}

header("location: transaksi_data.php");
exit;


// Arahkan kembali ke halaman data transaksi
header("location: transaksi_data.php");
exit;
