<?php
// backend_admin/partials/admin_only.php
session_start();

if (!isset($_SESSION['username'])) {
    echo "<script>
            alert('Silakan login terlebih dahulu!');
            window.location.href = '../../pages/auth/login.php';
          </script>";
    exit;
}

if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    echo "<script>
            alert('Akses ditolak! Halaman ini hanya untuk admin.');
            window.location.href = '../dashboard/index.php';
          </script>";
    exit;
}
?>
