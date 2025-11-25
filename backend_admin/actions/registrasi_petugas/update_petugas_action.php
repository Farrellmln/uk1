<?php
include '../../app.php';
global $connect;

$id_petugas = $_POST['id_petugas'];
$nama_petugas = $_POST['nama_petugas'];
$username = $_POST['username'];
$password = $_POST['password'];
$telp = $_POST['telp'];
$level = $_POST['level'];

// Jika password tidak diisi, jangan ubah kolom password
if (empty($password)) {
  $query = "UPDATE petugas 
            SET nama_petugas='$nama_petugas', username='$username', telp='$telp', level='$level' 
            WHERE id_petugas='$id_petugas'";
} else {
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $query = "UPDATE petugas 
            SET nama_petugas='$nama_petugas', username='$username', password='$hashed_password', telp='$telp', level='$level' 
            WHERE id_petugas='$id_petugas'";
}

$result = mysqli_query($connect, $query);

if ($result) {
  echo "
    <script>
      alert('Data petugas berhasil diperbarui!');
      window.location.href = '../../pages/registrasi_petugas/index.php';
    </script>
  ";
} else {
  echo "
    <script>
      alert('Gagal memperbarui data petugas!');
      window.history.back();
    </script>
  ";
}
