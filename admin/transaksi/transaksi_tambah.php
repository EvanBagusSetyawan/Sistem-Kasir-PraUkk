<?php
define('PAGE_ID', 'transaksi tambah');

$title = "Tambah Transaksi MarKets Shop";

include '../layout/header.php';

// Ambil ID penjualan terakhir
$dt_pelanggan = mysqli_query($koneksi, "SELECT MAX(PenjualanId) AS PenjualanId FROM tb_penjualan");
$penjualan = mysqli_fetch_array($dt_pelanggan);

// Buat ID transaksi baru
if ($penjualan && $penjualan['PenjualanId'] != null) {
    $urutan = (int) substr($penjualan['PenjualanId'], -4, 4);
} else {
    $urutan = 0;
}
$urutan++;
$huruf = date('ymd');
$kodeBarang = $huruf . sprintf("%04s", $urutan);

$totalHarga = 0;
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header d-flex justify-content-between gap-3">
            <h1>Lakukan Transaksi</h1>
            <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#TambahModal">
                <i class="far fa-plus"></i> Tambah Barang
            </button>
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
                                // Ambil daftar barang berdasarkan kode transaksi baru
                                $Barang = mysqli_query($koneksi, "SELECT * FROM tb_detail_penjualan 
                                    INNER JOIN tb_produk ON tb_produk.ProdukId = tb_detail_penjualan.ProdukId
                                    WHERE PenjualanId = '$kodeBarang'");

                                $no = 1;
                                foreach ($Barang as $key) {
                                    $totalHarga += $key['SubTotal'];
                                }

                                if (mysqli_num_rows($Barang) > 0) {
                                    mysqli_data_seek($Barang, 0); // reset pointer hasil query
                                    foreach ($Barang as $item) {
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
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center'>Belum ada barang ditambahkan.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Transaksi -->
            <form action="transaksi_barang_proses.php" method="post" class="col-md-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h4>Total Semua Barang</h4>
                    </div>
                    <div class="card-body text-Secondary">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="total" class="mb-0">Total:</label>
                            <input type="hidden" name="total" value="<?= $totalHarga ?>">
                            <input type="text" class="form-control input-transparent w-auto text-right" value="Rp. <?= number_format($totalHarga, 0, ",", ".") ?>" readonly>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <label for="tanggal" class="mb-0">Tanggal:</label>
                            <input type="date" name="tanggal" class="form-control input-transparent text-right" value="<?= date('Y-m-d') ?>" readonly>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <label for="nomorTransaksi" class="mb-0 text-nowrap">Nomor Transaksi:</label>
                            <input type="text" name="nomorTransaksi" class="form-control input-transparent text-right" value="<?= $kodeBarang ?>" readonly>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <label for="pelayanan" class="mb-0 text-nowrap">Pelayanan:</label>
                            <?php
                            $UserID = $_SESSION['UserId'];
                            $dataUser = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE UserId = '$UserID'");
                            $user = mysqli_fetch_array($dataUser);
                            ?>
                            <input type="hidden" name="UserId" value="<?= $user['UserId']; ?>">
                            <input type="text" class="form-control input-transparent text-right text-primary" value="<?= $user['username']; ?>" readonly>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <label for="pelanggan" class="mb-0 text-nowrap">Nama Pelanggan:</label>
                            <select name="pelanggan" id="pelanggan" class="form-control input-transparent text-right" required>
                                <option value="">Pilih Pelanggan</option>
                                <?php
                                $pelanggans = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan");
                                while ($pelanggan = mysqli_fetch_assoc($pelanggans)) {
                                    echo "<option value='{$pelanggan['PelangganId']}'>{$pelanggan['NamaPelanggan']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3">Simpan Transaksi</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<!-- Modal Tambah Barang -->
<div class="modal fade" id="TambahModal" tabindex="-1" role="dialog" aria-labelledby="TambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="transaksi_barang_tambah.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nomor Transaksi</label>
                        <input type="text" name="NomorTransaksi" class="form-control" value="<?= $kodeBarang ?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label>Pilih Produk</label>
                        <select name="produk" id="produk" class="form-control" required>
                            <option value="">Pilih Produk</option>
                            <?php
                            $produk = mysqli_query($koneksi, "SELECT * FROM tb_produk");
                            foreach ($produk as $item) {
                                echo "<option value='{$item['ProdukId']}'  data-stok='{$item['Stok']}'>{$item['NamaProduk']} ({$item['Stok']})</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" id="jumlah" name="Jumlah" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .input-transparent {
        background-color: transparent !important;
        border: none;
        color: #000;
        font-weight: bold;
        box-shadow: none;
        cursor: default;
    }
</style>

<script>
document.getElementById("produk").addEventListener("change", function () {
    let stok = parseInt(this.options[this.selectedIndex].getAttribute("data-stok"));
    let jumlahInput = document.getElementById("jumlah");

    jumlahInput.max = stok;
    jumlahInput.value = "";
});

document.getElementById("jumlah").addEventListener("input", function () {
    let max = parseInt(this.max);
    let val = parseInt(this.value);

    // Jika lebih besar dari stok → set otomatis ke stok
    if (val > max) {
        this.value = max;
    }

    // Jika kurang dari 1 → set ke 1
    if (val < 1) {
        this.value = 1;
    }
});
</script>



<?php include '../layout/footer.php'; ?>