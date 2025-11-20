<?php
define('PAGE_ID', 'dashboard');
$title = "Dashboard Kasir MarKets Shop";

include "../layout/header.php";
?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><span class="text-info">M</span>ar<span class="text-info">K</span>ets Shop</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Data Pelanggan</h4>
                        </div>
                        <div class="card-body">
                            <?php
                            $pelanggan = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan");
                            echo mysqli_num_rows($pelanggan);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger text-white h4">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Data Produk</h4>
                        </div>
                        <div class="card-body">
                            <?php
                            $produk = mysqli_query($koneksi, "SELECT * FROM tb_produk");
                            echo mysqli_num_rows($produk);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning text-white h4">
                        <i class="fa-solid fa-database"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Data Transaksi</h4>
                        </div>
                        <div class="card-body">
                            <?php
                            $penjualan = mysqli_query($koneksi, "SELECT * FROM tb_penjualan");
                            echo mysqli_num_rows($penjualan);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success text-white h4">
                        <i class="fa-solid fa-money-bill-1-wave"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Transaksi</h4>
                        </div>
                        <div class="card-body">
                            <?php
                            $totalTransaksi = mysqli_query($koneksi, "SELECT SUM(TotalHarga) AS jml_total FROM tb_penjualan");
                            while ($total = mysqli_fetch_array($totalTransaksi)) { ?>
                            <?php  
                                $totalnya =+ $total['jml_total'];
                                ?>
                            <?php
                                echo "Rp. " . number_format($totalnya, 0, ',', '.');
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<?php
include "../layout/footer.php";
?>