<?php
// Pastikan file koneksi dan konfigurasi di-include terlebih dahulu
include '../../app.php';

// Cek apakah sesi sudah dimulai. Jika belum, mulai sesi.
// Ini adalah cara aman untuk menghindari Notice: session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Periksa status login
if (!isset($_SESSION['username'])) {
    // Jika belum login, redirect
    echo "
        <script>
            alert('anda harus login dahulu');
            window.location.href = '../auth/login.php';
        </script>
    "; 
    exit; // PENTING: Hentikan eksekusi script setelah redirect
}

// Pastikan variabel $_SESSION['role'] sudah disetel saat login berhasil.
// Jika belum disetel, Anda mungkin perlu mengambilnya dari database atau memastikan 
// file login Anda menyimpannya: $_SESSION['role'] = $user['role']; 
?>

<style>
  .sidebar-item.active > a.sidebar-link {
    background-color: #2c7be5 !important;
    color: #fff !important;
    border-radius: 8px;
  }

  .sidebar-item.active > a.sidebar-link i {
    color: #fff !important;
  }
</style>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pelaporan Masyarakat</title>
  <link rel="shortcut icon" type="image/png" href="../../../storages/header/pelaporan.png" />
  <link rel="stylesheet" href="../../template-admin/src/assets/css/styles.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>