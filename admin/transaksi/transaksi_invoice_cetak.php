<?php
include '../../config/koneksi.php';
session_start();

if (empty($_SESSION['username'])) {
    header("Location: ../../../index.php?pesan=belum login");
    exit;
}

$PenjualanId = $_GET['PenjualanId'];
$Penjualans = mysqli_query($koneksi, "SELECT * FROM tb_penjualan 
    INNER JOIN tb_pelanggan ON tb_penjualan.PelangganId = tb_pelanggan.PelangganId
    INNER JOIN tb_user ON tb_penjualan.UserId = tb_user.UserId
    WHERE PenjualanId = '$PenjualanId'");

$Penjualan = mysqli_fetch_array($Penjualans);

$detailBarang = mysqli_query($koneksi, "SELECT * FROM tb_detail_penjualan 
    INNER JOIN tb_produk ON tb_detail_penjualan.ProdukId = tb_produk.ProdukId
    WHERE PenjualanId = '$PenjualanId'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi</title>

    <link rel="stylesheet" href="../../Komponent/dist/assets/modules/bootstrap/css/bootstrap.min.css">
    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f8f9fa;
            font-family: "Courier New", monospace;

            padding-top: 20px;
            padding-bottom: 20px;
        }

        .receipt {
            width: 350px;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .receipt hr {
            border: 0;
            border-top: 1px dashed #aaa;
            margin: 10px 0;
        }

        .receipt-header {
            text-align: center;
        }

        .receipt-header h3 {
            margin-bottom: 0;
            font-weight: bold;
        }

        .receipt-header small {
            color: #666;
        }

        .item-list p {
            margin: 0;
        }

        .item {
            display: flex;
            justify-content: space-between;
            font-size: 15px;
            padding: 2px 0;
        }

        .item .name {
            flex: 1;
        }

        .total-section h5,
        .total-section h4 {
            margin: 0;
        }

        .thankyou {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        @media print {
            @page {
                size: A4;
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
                background: white;
            }

            .receipt {
                width: 100%;
                max-width: 100%;
                box-shadow: none;
                border: none;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="receipt">
        <div class="receipt-header">
            <h3>🛍️ TOKO SEJAHTERA</h3>
            <small>Jl. Raya Kebon Agung No. 8, Jember</small>
            <hr>
            <p class="mb-0">
                Invoice: <strong>#<?= str_pad($Penjualan['PenjualanId'], 6, '0', STR_PAD_LEFT); ?></strong><br>
                Kasir: <?= ucfirst($Penjualan['username']); ?><br>
                Tanggal: <?= date('d M Y, H:i', strtotime($Penjualan['TanggalPenjualan'])); ?>
            </p>
        </div>

        <hr>

        <div class="item-list">

            <?php
            foreach ($detailBarang as $item) { ?>
                <div class="item">
                    <span><?= $item['JumlahProduk'] ?> <?= $item['NamaProduk'] ?></span>
                    <span><?= "Rp. " . number_format($item['SubTotal'], 0, ',', '.'); ?></span>
                </div>
            <?php
            };
            ?>

        </div>

        <hr>

        <div class="total-section">
            <div class="d-flex justify-content-between">
                <h5>Total Harga:</h5>
                <h5>Rp <?= number_format($Penjualan['TotalHarga'], 0, ',', '.'); ?></h5>
            </div>
            <div class="d-flex justify-content-between">
                <h5>Pembayaran:</h5>
                <h5>Rp <?= number_format($Penjualan['TotalHarga'], 0, ',', '.'); ?></h5>
            </div>
            <div class="d-flex justify-content-between">
                <h5>Kembalian:</h5>
                <h5>Rp 0</h5>
            </div>
        </div>

        <hr>

        <div class="thankyou">
            <p>Terima Kasih Telah Berbelanja 💙</p>
            <p><em>Barang yang sudah dibeli tidak dapat dikembalikan</em></p>
        </div>
    </div>

    <script type="text/javascript">
        window.onload = function() {
            window.print();
        };

        // Setelah user menutup dialog print (apapun pilihannya)
        window.onafterprint = function() {
            // arahkan balik ke halaman transaksi
            window.location.href = 'transaksi_data.php';
        };
    </script>

</body>

</html>