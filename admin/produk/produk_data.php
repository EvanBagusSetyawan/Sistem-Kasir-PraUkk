<?php

define('PAGE_ID', 'produk');

$title = "Data Produk MarKets Shop";

include "../layout/header.php";
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header flex justify-content-between">
            <h1>Data Produk</h1>
            <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#TambahModal"><i class="far fa-plus"></i> Tambah</button>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Basic DataTables</h4>
                    </div>
                    <div class="row">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                #
                                            </th>
                                            <th>Nama Produk</th>
                                            <th>Alamat</th>
                                            <th>NoHp</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $produk = mysqli_query($koneksi, "SELECT * FROM tb_produk");
                                        foreach ($produk as $item) {
                                        ?>
                                            <tr>
                                                <td class="text-center">
                                                    <?= $no++; ?>
                                                </td>
                                                <td><?= $item['NamaProduk']; ?></td>
                                                <td><?= $item['Harga']; ?></td>
                                                <td><?= $item['Stok']; ?></td>
                                                <td>
                                                    <button class="btn btn-success" data-toggle="modal" data-target="#EditModal<?= $item['ProdukId'] ?>"><i class="fas fa-edit"></i></button>
                                                    <form action="produk_hapus.php" method="POST" style="display: inline-block;">
                                                        <input type="hidden" name="ProdukId" value="<?= $item['ProdukId'] ?>">
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<!-- Modal Tambah produk -->
<div class="modal fade" id="TambahModal" tabindex="-1" role="dialog" aria-labelledby="TambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="produk_tambah.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" class="form-control" name="NamaProduk" required>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" class="form-control" name="Harga" required>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" class="form-control" name="Stok" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
foreach ($produk as $item) {
?>
    <!-- Modal Edit produk -->
    <div class="modal fade" id="EditModal<?= $item['ProdukId'] ?>" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel<?= $item['ProdukId'] ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel<?= $item['ProdukId'] ?>">Edit Data Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="produk_update.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="ProdukId" value="<?= $item['ProdukId'] ?>">
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" name="NamaProduk" value="<?= $item['NamaProduk'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" class="form-control" name="Harga" value="<?= $item['Harga'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" class="form-control" name="Stok" value="<?= $item['Stok'] ?>" required>
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
include "../layout/footer.php";
?>