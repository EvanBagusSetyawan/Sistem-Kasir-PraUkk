<?php
define('PAGE_ID', 'pelanggan');
$title = "Pelanggan MarKets Shop";
include '../layout/header.php';
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Data Pelanggan</h1>
            <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#exampleModal">
                <i class="far fa-plus"></i> Tambah
            </button>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Daftar Pelanggan</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Nama Pelanggan</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $pelanggan = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan");
                            foreach ($pelanggan as $item) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td><?= $item['NamaPelanggan']; ?></td>
                                    <td><?= $item['Alamat']; ?></td>
                                    <td><?= $item['NomerTelephone']; ?></td>
                                    <td>
                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#EditModal<?= $item['PelangganId'] ?>"><i class="fas fa-edit"></i></button>
                                        <a href="#" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                                        <form action="pelanggan_hapus.php" method="POST" style="display: inline-block;">
                                            <input type="hidden" name="PelangganId" value="<?= $item['PelangganId'] ?>">
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
                                        </form>
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

<!-- Modal Tambah -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="pelanggan_tambah.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Pelanggan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Pelanggan</label>
                        <input type="text" name="NamaPelanggan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" name="Alamat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>No HP</label>
                        <input type="text" name="NomerTelephone" class="form-control" required>
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


<?php
foreach ($pelanggan as $item) {
?>
    <!-- Modal Edit produk -->
    <div class="modal fade" id="EditModal<?= $item['PelangganId'] ?>" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel<?= $item['PelangganId'] ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel<?= $item['PelangganId'] ?>">Edit Data Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="pelanggan_update.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="PelangganId" value="<?= $item['PelangganId'] ?>">
                        <div class="form-group">
                            <label>Nama Pelanggan</label>
                            <input type="text" class="form-control" name="NamaPelanggan" value="<?= $item['NamaPelanggan'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" class="form-control" name="Alamat" value="<?= $item['Alamat'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>No Hp</label>
                            <input type="text" class="form-control" name="NomerTelephone" value="<?= $item['NomerTelephone'] ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" name="edit">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
}
?>

<?php
include '../layout/footer.php';
?>