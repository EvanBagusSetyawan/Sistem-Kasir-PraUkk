<?php
define('PAGE_ID', 'laporan');

$title = "Laporan Transaksi MarKets Shop";

include '../layout/header.php';

$bulanSekarang = date('m'); // hasil: 01, 02, ..., 12


$tahunFilter = isset($_GET['tahun']) ? (int) $_GET['tahun'] : date('Y');
$bulanFilter = isset($_GET['bulan']) ? str_pad($_GET['bulan'], 2, '0', STR_PAD_LEFT) : date('m');
$tglAwalFilter = isset($_GET['tanggal_awal']) ? str_pad($_GET['tanggal_awal'], 2, '0', STR_PAD_LEFT) : '01';
$tglAkhirFilter = isset($_GET['tanggal_akhir']) ? str_pad($_GET['tanggal_akhir'], 2, '0', STR_PAD_LEFT) : '31';

?>

<style>
    /* Fokus tetap biru */
    .focusStyle:focus {
        border-color: #36A2EB !important;
        outline: none !important;
    }

    /* Atur ukuran input agar lebih nyaman */
    .form-control-lg {
        font-size: 16px !important;
        padding: 10px 14px;
        width: 225px;
        height: 40px !important;
        /* <- tambahkan ini */
    }

    /* Sedikit atur margin antar elemen dalam form */
    form label {
        margin-bottom: -3px !important;
        /* label lebih dekat ke input */
    }
</style>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header d-flex justify-content-between align-items-center">
            <h1>Laporan Transaksi</h1>
            <div class="d-flex justify-content-end mb-3">
                <button onclick="printDiv('printArea')" class="btn btn-primary">
                    <i class="fa fa-print"></i> Cetak Laporan
                </button>
            </div>

        </div>

        <div class="card">
            <div class="card-header d-flex flex-column align-items-start">
                <h4>Filter Data Transaksi</h4>
                <div>
                    <form action="" class="d-flex justify-content-between align-items-center flex-wrap" style="width: 100%; gap: 20px;">
                        <div class="d-flex flex-column align-items-start">
                            <label for="tahun" class="font-weight-bold">Tahun</label>
                            <input type="number" name="tahun" id="tahun"
                                class="form-control form-control-lg rounded border focusStyle"
                                value="<?= $tahunFilter ?>">
                        </div>
                        <div class="d-flex flex-column align-items-start">
                            <label for="bulan" class="font-weight-bold">Bulan</label>
                            <select name="bulan" id="bulan" class="form-control form-control-lg rounded border focusStyle">
                                <option value="01" <?= ($bulanFilter == '01') ? 'selected' : '' ?>>Januari</option>
                                <option value="02" <?= ($bulanFilter == '02') ? 'selected' : '' ?>>Februari</option>
                                <option value="03" <?= ($bulanFilter == '03') ? 'selected' : '' ?>>Maret</option>
                                <option value="04" <?= ($bulanFilter == '04') ? 'selected' : '' ?>>April</option>
                                <option value="05" <?= ($bulanFilter == '05') ? 'selected' : '' ?>>Mei</option>
                                <option value="06" <?= ($bulanFilter == '06') ? 'selected' : '' ?>>Juni</option>
                                <option value="07" <?= ($bulanFilter == '07') ? 'selected' : '' ?>>Juli</option>
                                <option value="08" <?= ($bulanFilter == '08') ? 'selected' : '' ?>>Agustus</option>
                                <option value="09" <?= ($bulanFilter == '09') ? 'selected' : '' ?>>September</option>
                                <option value="10" <?= ($bulanFilter == '10') ? 'selected' : '' ?>>Oktober</option>
                                <option value="11" <?= ($bulanFilter == '11') ? 'selected' : '' ?>>November</option>
                                <option value="12" <?= ($bulanFilter == '12') ? 'selected' : '' ?>>Desember</option>
                            </select>
                        </div>

                        <div class="d-flex flex-column align-items-start">
                            <label for="tanggal_awal" class="font-weight-bold">Tanggal Awal</label>
                            <select name="tanggal_awal" id="tanggal_awal" class="form-control form-control-lg rounded border focusStyle">
                                <?php
                                for ($i = 1; $i <= 31; $i++) {
                                    $val = str_pad($i, 2, "0", STR_PAD_LEFT);
                                    $selected = ($tglAwalFilter == $val) ? 'selected' : '';
                                    echo "<option value='$val' $selected>$i</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="d-flex flex-column align-items-start">
                            <label for="tanggal_akhir" class="font-weight-bold">Tanggal Akhir</label>
                            <select name="tanggal_akhir" id="tanggal_akhir" class="form-control form-control-lg rounded border focusStyle">
                                <?php
                                for ($i = 1; $i <= 31; $i++) {
                                    $val = str_pad($i, 2, "0", STR_PAD_LEFT);
                                    $selected = ($tglAkhirFilter == $val) ? 'selected' : '';
                                    echo "<option value='$val' $selected>$i</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Tombol Filter -->
                        <div class="d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-lg">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body" id="printArea">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col">Tanggal Transaksi</th>
                                <th scope="col">Nama Pelanggan</th>
                                <th scope="col">Pelayanan</th>
                                <th scope="col">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;

                            if (isset($_GET['tahun'])) {
                                $tahun = (int) $_GET['tahun'];
                                $bulan = (int) $_GET['bulan'];
                                $tanggal_awal = (int) $_GET['tanggal_awal'];
                                $tanggal_akhir = (int) $_GET['tanggal_akhir'];

                                $query = "
                        SELECT * FROM tb_penjualan 
                        INNER JOIN tb_pelanggan ON tb_pelanggan.PelangganId = tb_penjualan.PelangganId
                        INNER JOIN tb_user ON tb_user.UserId = tb_penjualan.UserId 
                        WHERE YEAR(TanggalPenjualan) = $tahun
                        AND MONTH(TanggalPenjualan) = $bulan
                        AND DAY(TanggalPenjualan) BETWEEN $tanggal_awal AND $tanggal_akhir
                    ";
                                $data = mysqli_query($koneksi, $query);
                            }

                            if (isset($data) && mysqli_num_rows($data) > 0) {
                                foreach ($data as $item) {
                            ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $item['TanggalPenjualan']; ?></td>
                                        <td><?= $item['NamaPelanggan']; ?></td>
                                        <td><?= $item['username']; ?></td>
                                        <td><?= "Rp." . number_format($item['TotalHarga'], 0, ",", ".") ?></td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="6" class="text-center">
                                        Tidak ada data transaksi pada periode yang dipilih.
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

<script>
    function printDiv(divId) {
        const printContents = document.getElementById(divId).innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload(); // agar tampilan kembali normal setelah print
    }
</script>

<?php
include '../layout/footer.php';
?>