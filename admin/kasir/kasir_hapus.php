<?php

include '../../config/koneksi.php';

$UserId = $_POST['UserId']; 

mysqli_query($koneksi, "DELETE FROM tb_user Where UserId = '$UserId'");

header("Location: kasir_data.php");
exit;
