<?php

use Pdo\Mysql;

include "../../config/koneksi.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// membuat sebuah kondisi agar halaman ini tidak bisa diakses oleh user yang belum login
if (empty($_SESSION['username'])) {
    header("Location: ../../index.php?pesan=belum login");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= isset($title) ? $title : "Sistem Kasir"; ?></title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="../../Komponent/dist/assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="../../Komponent/dist/assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet" href="../../Komponent/dist/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="../../Komponent/dist/assets/modules/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="../../Komponent/dist/assets/modules/weather-icon/css/weather-icons.min.css">
    <link rel="stylesheet" href="../../Komponent/dist/assets/modules/weather-icon/css/weather-icons-wind.min.css">
    <link rel="stylesheet" href="../../Komponent/dist/assets/modules/summernote/summernote-bs4.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="../../Komponent/dist/assets/css/style.css">
    <link rel="stylesheet" href="../../Komponent/dist/assets/css/components.css">

</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <!-- navbar -->
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                    </ul>
                    <div class="search-element">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
                <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="../../Komponent/dist/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                        <div class="d-sm-none d-lg-inline-block">Hi,
                            <?php
                            $UserId = $_SESSION['UserId'];
                            $userLogin = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE UserId = '$UserId'");
                            while ($user = mysqli_fetch_array($userLogin)) { ?>
                            <?php
                                echo $user['username'];
                            }
                            ?>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="features-profile.html" class="dropdown-item has-icon">
                            <i class="far fa-user"></i> Profile
                        </a>

                        <form action="../../cekLogout.php" method="post">
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>

                        <!-- <a href="#" class="dropdown-item has-icon text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a> -->
                    </div>
                </li>
                </ul>
            </nav>

            <!-- Sidebar -->
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="index.html">MarKets</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="index.html">MK</a>
                    </div>
                    <ul id="menu-masterdata" class="sidebar-menu">
                        <li class="<?= defined('PAGE_ID') && PAGE_ID === 'dashboard' ? 'active' : '' ?>">
                            <a class="nav-link" href="../dashboard/index.php"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
                        </li>
                        <li class="menu-header">Data</li>
                        <li class="dropdown <?= defined('PAGE_ID') && in_array(PAGE_ID, ['pelanggan', 'produk', 'kasir']) ? 'active' : '' ?>">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa fa-chart-line"></i><span>Master Data</span></a>
                            <ul class="dropdown-menu">
                                <li class="<?= defined('PAGE_ID') && PAGE_ID === 'pelanggan' ? 'active' : '' ?>"><a class="nav-link" href="../pelanggan/pelanggan_data.php"><i class="fas fa-user"></i>Data Pelanggan</a></li>
                                <li class="<?= defined('PAGE_ID') && PAGE_ID === 'produk' ? 'active' : '' ?> "><a class="nav-link" href="../produk/produk_data.php"><i class="fas fa-shopping-cart"></i>Data Produk</a></li>
                                <?php
                                $UserId = $_SESSION['UserId'];
                                $userLogin = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE UserId = '$UserId'");
                                $user = mysqli_fetch_array($userLogin);

                                if ($user['role'] == 'Admin') {
                                ?>
                                    <li class="<?= defined('PAGE_ID') && PAGE_ID === 'kasir' ? 'active' : '' ?>"><a class="nav-link" href="../kasir/kasir_data.php"><i class="fas fa-user-tag"></i>Data Kasir</a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="dropdown <?= defined('PAGE_ID') && in_array(PAGE_ID , ['transaksi', 'transaksi tambah']) ? 'active' : '' ?>">
                            <a href="#" class="nav-link has-dropdown " data-toggle="dropdown"><i class="far fa-handshake"></i><span>Transaksi</span></a>
                            <ul class="dropdown-menu">
                                <li class="<?= defined('PAGE_ID') && PAGE_ID === 'transaksi' ? 'active' : '' ?>"><a class="nav-link" href="../transaksi/transaksi_data.php"><i class="fas fa-database"></i>Data Transaksi</a></li>
                                <li class="<?= defined('PAGE_ID') && PAGE_ID === 'transaksi tambah' ? 'active' : '' ?>"><a class="nav-link" href="../transaksi/transaksi_tambah.php"><i class="fas fa-cart-plus"></i>Tambah Transaksi</a></li>
                            </ul>
                        </li>
                        <li class="<?= defined('PAGE_ID') && PAGE_ID === 'laporan' ? 'active' : '' ?>"><a class="nav-link" href="../transaksi/transaksi_laporan.php"><i class="far fa-list-alt"></i><span>Laporan Transaksi</span></a></li>
                    </ul>
                    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                        <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                            <i class="fas fa-rocket"></i> Documentation
                        </a>
                    </div>
                </aside>
            </div>