<?php
include '../../app.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        echo "<script>
                alert('Username dan password wajib diisi!');
                window.location.href = '../../pages/auth/login.php';
              </script>";
        exit;
    }

    // === 1️⃣ Cek di tabel masyarakat ===
    $stmt = $connect->prepare("SELECT nik, nama, username, password FROM masyarakat WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['nik'] = $user['nik'];
            $_SESSION['level'] = 'masyarakat';

            echo "<script>
                    alert('Login berhasil sebagai masyarakat!');
                    window.location.href = '../../../backend_masyarakat/pages/dashboard/index.php';
                  </script>";
            exit;
        }
    }

    // === 2️⃣ Cek di tabel petugas (admin & petugas) ===
    $stmt = $connect->prepare("SELECT id_petugas, nama_petugas, username, password, level 
                               FROM petugas WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama_petugas'] = $user['nama_petugas'];
            $_SESSION['id_petugas'] = $user['id_petugas'];
            $_SESSION['level'] = $user['level']; // admin / petugas

            // Arahkan berdasarkan level
            if ($user['level'] === 'admin') {
                echo "<script>
                        alert('Login berhasil sebagai admin!');
                        window.location.href = '../../../backend_admin/pages/dashboard/index.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Login berhasil sebagai petugas!');
                        window.location.href = '../../../backend_admin/pages/dashboard/index.php';
                      </script>";
            }
            exit;
        }
    }

    // === 3️⃣ Jika tidak ditemukan di kedua tabel ===
    echo "<script>
            alert('Username atau password salah!');
            window.location.href = '../../pages/auth/login.php';
          </script>";
    exit;
}
?>
