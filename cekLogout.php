<?php
session_start(); // Mulai session agar bisa dihapus

// Hapus semua session
session_unset();
session_destroy();

// Arahkan balik ke halaman login
header("Location: index.php?pesan=logout");
exit;
?>
