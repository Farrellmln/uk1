<?php
include '../../app.php'; // koneksi ke database

// Pastikan ID dikirim
if (!isset($_GET['id'])) {
  echo "<script>alert('ID Petugas tidak ditemukan!'); window.location.href='../../pages/registrasi_petugas/index.php';</script>";
  exit;
}

$id = $_GET['id'];

// Cek apakah data petugas ada
$query = mysqli_query($connect, "SELECT * FROM petugas WHERE id_petugas = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
  echo "<script>alert('Data petugas tidak ditemukan!'); window.location.href='../../pages/registrasi_petugas/index.php';</script>";
  exit;
}

// Hapus data petugas
$delete = mysqli_query($connect, "DELETE FROM petugas WHERE id_petugas = '$id'");

if ($delete) {
  echo "<script>alert('Data petugas berhasil dihapus!'); window.location.href='../../pages/registrasi_petugas/index.php';</script>";
} else {
  echo "<script>alert('Gagal menghapus data petugas!'); window.location.href='../../pages/registrasi_petugas/index.php';</script>";
}
?>
