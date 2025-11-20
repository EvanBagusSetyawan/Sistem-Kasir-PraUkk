<?php
include "../../config/koneksi.php";

session_start();

// Cek role sebelum ada output HTML
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../dashboard/index.php");
    exit();
}

define('PAGE_ID', 'kasir');
$title = "Data Kasir MarKets Shop";
include "../layout/header.php";
?>


<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header flex justify-content-between">
            <h1>Data Kasir</h1>
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
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $kasir = mysqli_query($koneksi, "SELECT * FROM tb_user where Role = 'Petugas'");
                                        foreach ($kasir as $item) {
                                        ?>
                                            <tr>
                                                <td class="text-center">
                                                    <?= $no++; ?>
                                                </td>
                                                <td><?= $item['username']; ?></td>
                                                <td><?= $item['email']; ?></td>
                                                <td><?= $item['role']; ?></td>
                                                <td>
                                                    <button href="#" class="btn btn-success" data-toggle="modal" data-target="#EditModal<?= $item['UserId'] ?>"><i class="fas fa-edit"></i></button>
                                                    <form action="kasir_hapus.php" method="POST" style="display: inline-block;">
                                                        <input type="hidden" name="UserId" value="<?= $item['UserId'] ?>">
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

<!-- Modal Tambah user -->
<div class="modal fade" id="TambahModal" tabindex="-1" role="dialog" aria-labelledby="TambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="kasir_tambah.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
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
foreach ($kasir as $item) {
?>
    <!-- Modal Edit user -->
    <div class="modal fade" id="EditModal<?= $item['UserId'] ?>" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel<?= $item['UserId'] ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel<?= $item['UserId'] ?>">Edit Data user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="kasir_update.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="UserId" value="<?= $item['UserId'] ?>">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="<?= $item['email'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" value="<?= $item['username'] ?>" required>
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