<?php
include '../../app.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nik = trim($_POST['nik'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $telp = trim($_POST['telp'] ?? '');

    // Validasi sederhana
    if ($nik === '' || $nama === '' || $username === '' || $password === '' || $telp === '') {
        echo "<script>
                alert('Semua field wajib diisi!');
                window.location.href = '../../pages/auth/register.php';
              </script>";
        exit;
    }

    // Cek username sudah digunakan atau belum
    $check = $connect->prepare("SELECT username FROM masyarakat WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $checkResult = $check->get_result();

    if ($checkResult->num_rows > 0) {
        echo "<script>
                alert('Username sudah digunakan!');
                window.location.href = '../../pages/auth/register.php';
              </script>";
        exit;
    }
    $check->close();

    // ✅ Hash password aman dan kompatibel dengan password_verify()
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Simpan ke database
    $query = $connect->prepare("INSERT INTO masyarakat (nik, nama, username, password, telp) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("sssss", $nik, $nama, $username, $hashedPassword, $telp);

    if ($query->execute()) {
        echo "<script>
                alert('Registrasi berhasil! Silakan login.');
                window.location.href = '../../pages/auth/login.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Terjadi kesalahan saat registrasi: {$query->error}');
                window.location.href = '../../pages/auth/register.php';
              </script>";
        exit;
    }
}
?>
