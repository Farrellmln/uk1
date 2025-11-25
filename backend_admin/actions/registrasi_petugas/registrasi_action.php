<?php
include '../../app.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_petugas = mysqli_real_escape_string($connect, $_POST['nama_petugas']);
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $telp = mysqli_real_escape_string($connect, $_POST['telp']);
    $level = mysqli_real_escape_string($connect, $_POST['level']);

    // Cek apakah username sudah digunakan
    $cek = mysqli_query($connect, "SELECT username FROM petugas WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah digunakan!'); window.location='../../pages/registrasi_petugas/create.php';</script>";
        exit;
    }

    // Simpan data
    $query = "INSERT INTO petugas (nama_petugas, username, password, telp, level)
              VALUES ('$nama_petugas', '$username', '$password', '$telp', '$level')";
    if (mysqli_query($connect, $query)) {
        echo "<script>alert('Data petugas berhasil disimpan!'); window.location='../../pages/registrasi_petugas/index.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data!'); window.location='../../pages/registrasi_petugas/create.php';</script>";
    }
}
?>
