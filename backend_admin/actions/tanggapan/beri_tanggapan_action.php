<?php
include '../../app.php';
session_start(); // wajib untuk ambil id_petugas

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Akses tidak valid');
}

// Ambil data dari form
$id_pengaduan = $_POST['id_pengaduan'] ?? '';
$tgl_tanggapan = $_POST['tgl_tanggapan'] ?? date('Y-m-d');
$tanggapan = $_POST['tanggapan'] ?? '';
$id_petugas = $_SESSION['id_petugas'] ?? null;

// Validasi input
if (empty($id_pengaduan) || empty($tanggapan)) {
    die('Data tanggapan tidak lengkap!');
}

if (!$id_petugas) {
    die('Session petugas tidak ditemukan. Silakan login ulang.');
}

// Simpan tanggapan
$qInsert = "
    INSERT INTO tanggapan (id_pengaduan, tgl_tanggapan, tanggapan, id_petugas)
    VALUES ('$id_pengaduan', '$tgl_tanggapan', '$tanggapan', '$id_petugas')
";
if (!mysqli_query($connect, $qInsert)) {
    die('Gagal menyimpan tanggapan: ' . mysqli_error($connect));
}

// Update status pengaduan jadi 'selesai'
$qUpdate = "UPDATE pengaduan SET status='selesai' WHERE id_pengaduan='$id_pengaduan'";
mysqli_query($connect, $qUpdate) or die('Gagal update status: ' . mysqli_error($connect));

// Redirect
header('Location: ../../pages/beri_tanggapan/index.php?success=1');
exit;
?>
