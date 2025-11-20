<?php

include '../../config/koneksi.php';

$UserId = $_POST['UserId'];
$username = $_POST['username'];
$email = $_POST['email'];

mysqli_query($koneksi, "UPDATE tb_user SET username = '$username', email = '$email' Where UserId = '$UserId' ");

header("Location: kasir_data.php");
exit;