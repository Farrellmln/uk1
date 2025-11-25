<?php
include '../../app.php';

if (!isset($_GET['id'])) {
    echo "
        <script>
            alert('ID tidak ditemukan');
            window.location.href = '../../pages/laporan_pengaduan/index.php';
        </script>
    ";
    exit;
}

$id = intval($_GET['id']);

// Ambil data pengaduan untuk hapus fotonya
$query = "SELECT * FROM pengaduan WHERE id_pengaduan = $id LIMIT 1";
$result = mysqli_query($connect, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "
        <script>
            alert('Data pengaduan tidak ditemukan');
            window.location.href = '../../pages/laporan_pengaduan/index.php';
        </script>
    ";
    exit;
}

$item = mysqli_fetch_object($result);

// Hapus file foto jika ada
if (!empty($item->foto)) {
    $fotoPath = "../../../storages/laporan_pengaduan/" . $item->foto;
    if (file_exists($fotoPath)) {
        unlink($fotoPath);
    }
}

// Hapus data dari database
$qDelete = "DELETE FROM pengaduan WHERE id_pengaduan = $id";
$deleteResult = mysqli_query($connect, $qDelete);

if ($deleteResult) {
    echo "
        <script>
            alert('Data pengaduan berhasil dihapus');
            window.location.href = '../../pages/laporan_pengaduan/index.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Gagal menghapus data pengaduan');
            window.location.href = '../../pages/laporan_pengaduan/index.php';
        </script>
    ";
}
?>
