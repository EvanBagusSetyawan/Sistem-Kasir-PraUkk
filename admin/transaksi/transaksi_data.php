<?php
define('PAGE_ID', 'transaksi');

$title = "Data Transaksi MarKets Shop";

include '../layout/header.php';
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Data Transaksi</h1>
            <a href="transaksi_tambah.php" class="btn btn-icon icon-left btn-primary">
                <i class="far fa-plus"></i> Tambah Transaksi
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Daftar Transaksi</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Tanggal Transaksi</th>
                                <th>Nama Pelanggan</th>
                                <th>Pelayanan</th>
                                <th>Total Harga</th>
                                <th>Aksi</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $UserId = $_SESSION['UserId'];
                            $no = 1;
                            $transaksi = mysqli_query($koneksi, "SELECT * FROM tb_penjualan
                                INNER JOIN tb_pelanggan ON tb_pelanggan.PelangganId = tb_penjualan.PelangganId
                                INNER JOIN tb_user ON tb_user.UserId = tb_penjualan.UserId 
                            ");
                            foreach ($transaksi as $item) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td><?= $item['TanggalPenjualan']; ?></td>
                                    <td><?= $item['NamaPelanggan']; ?></td>
                                    <td><?= $item['username']; ?></td>
                                    <td><?= "Rp." . number_format($item['TotalHarga'], 0, ",", ".") ?></td>
                                    <td>
                                        <a href="transaksi_edit.php?NomorTransaksi=<?= $item['PenjualanId'] ?>" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                        <a href="transaksi_invoice_cetak.php?PenjualanId=<?= $item['PenjualanId'] ?>"
                                            class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-print"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include '../layout/footer.php';
?>