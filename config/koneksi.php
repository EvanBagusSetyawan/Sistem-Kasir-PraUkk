<?php

$koneksi = mysqli_connect('localhost', 'root', '', 'sistem-kasir-praukk');

if (mysqli_connect_error()) {
    echo "Koneksi Gagal: " . mysqli_connect_error();
}

?>