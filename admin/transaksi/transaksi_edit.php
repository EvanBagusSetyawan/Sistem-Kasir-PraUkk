<?php
include '../layout/header.php';

$NomorTransaksiUrl = $_GET['NomorTransaksi'] ?? null;
if (!$NomorTransaksiUrl) {
    die("Nomor transaksi tidak ditemukan.");
}

// Ambil data penjualan
$PenjualanQuery = mysqli_query($koneksi, "SELECT * FROM tb_penjualan WHERE PenjualanId = '$NomorTransaksiUrl'");
$PenjualanData = mysqli_fetch_array($PenjualanQuery);

// Ambil total harga
$totalHarga = 0;
$BarangQuery = mysqli_query($koneksi, "SELECT * FROM tb_detail_penjualan 
    INNER JOIN tb_produk ON tb_produk.ProdukId = tb_detail_penjualan.ProdukId
    WHERE PenjualanId = '$NomorTransaksiUrl'");
foreach ($BarangQuery as $b) {
    $totalHarga += $b['SubTotal'];
}

// Ambil data user
$UserID = $PenjualanData['UserId'];
$dataUser = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE UserId = '$UserID'");
$user = mysqli_fetch_assoc($dataUser);
?>

<div class="main-content">
    <section class="section">
        <div class="section-header d-flex justify-content-between gap-3">
            <h1>Edit Transaksi: <?= $NomorTransaksiUrl ?></h1>
            <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#TambahModal"><i class="far fa-plus"></i> Tambah Barang</button>
        </div>

        <div class="row align-items-stretch" style="min-height: 100vh;">
            <!-- Daftar Barang -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Barang</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Sub Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($BarangQuery) > 0) {
                                    $no = 1;
                                    foreach ($BarangQuery as $item) {
                                ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $item['NamaProduk'] ?></td>
                                            <td><?= $item['JumlahProduk'] ?></td>
                                            <td>Rp. <?= number_format($item['SubTotal']) ?></td>
                                            <td>
                                                <a href="#" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                                <form action="transaksi_barang_hapus.php" method="POST" style="display:inline;">
                                                    <input type="hidden" name="DetailId" value="<?= $item['DetailId'] ?>">
                                                    <input type="hidden" name="ProdukId" value="<?= $item['ProdukId'] ?>">
                                                    <input type="hidden" name="PenjualanId" value="<?= $item['PenjualanId'] ?>">
                                                    <input type="hidden" name="edit" value="edit">
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>Belum ada barang.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Form info transaksi -->
            <form action="transaksi_barang_proses.php" method="post" class="col-md-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h4>Info Transaksi</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <label>Total:</label>
                            <input type="text" class="form-control input-transparent text-right" value="Rp. <?= number_format($totalHarga, 0, ",", ".") ?>" readonly>
                            <input type="hidden" name="total" value="<?= $totalHarga ?>">
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <label>Tanggal:</label>
                            <input type="date" name="Tanggal" class="form-control input-transparent" value="<?= $PenjualanData['TanggalPenjualan'] ?>" readonly>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <label>Nomor Transaksi:</label>
                            <input type="text" class="form-control input-transparent" name="nomorTransaksi" value="<?= $NomorTransaksiUrl ?>" readonly>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <label>Pelayanan:</label>
                            <input type="text" class="form-control input-transparent text-primary" value="<?= $user['username'] ?>" readonly>
                            <input type="hidden" name="UserId" value="<?= $user['UserId'] ?>">
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <label>Pelanggan:</label>
                            <select name="pelanggan" class="form-control input-transparent">
                                <option value="">Pilih Pelanggan</option>
                                <?php
                                $pelanggans = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan");
                                while ($pelanggan = mysqli_fetch_assoc($pelanggans)) {
                                    $selected = ($PenjualanData['PelangganId'] == $pelanggan['PelangganId']) ? 'selected' : '';
                                    echo "<option value='{$pelanggan['PelangganId']}' $selected>{$pelanggan['NamaPelanggan']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">Update Transaksi</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<!-- Modal Tambah Barang -->
<div class="modal fade" id="TambahModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="transaksi_barang_tambah.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Barang Baru</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="NomorTransaksi" value="<?= $NomorTransaksiUrl ?>">
                    <input type="hidden" name="edit" value="edit">
                    <div class="form-group">
                        <label>Pilih Produk</label>
                        <select name="produk" class="form-control" required>
                            <option value="">Pilih Produk</option>
                            <?php
                            $produk = mysqli_query($koneksi, "SELECT * FROM tb_produk");
                            foreach ($produk as $p) {
                                echo "<option value='{$p['ProdukId']}'>{$p['NamaProduk']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="Jumlah" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Barang</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .input-transparent {
        background-color: transparent !important;
        border: none;
        font-weight: bold;
        color: #000;
    }
</style>

<?php include '../layout/footer.php'; ?>