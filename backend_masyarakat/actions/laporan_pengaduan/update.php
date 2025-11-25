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

$id = $_GET['id'];

// Ambil data dari form
$tgl_pengaduan = escapeString($_POST['tgl_pengaduan']);
$nik = escapeString($_POST['nik']);
$isi_laporan = escapeString($_POST['isi_laporan']);
$tingkat = escapeString($_POST['tingkat']); // 🟢 Tambahan: ambil tingkat dari form

// Ambil data lama
$result = mysqli_query($connect, "SELECT * FROM pengaduan WHERE id_pengaduan = '$id'");
$oldData = mysqli_fetch_object($result);

$fotoBaru = $oldData->foto;
$storages = "../../../storages/laporan_pengaduan/";

// Proses upload foto baru (jika ada)
if (!empty($_FILES['foto']['tmp_name'])) {
    // Hapus foto lama jika ada
    if (!empty($oldData->foto) && file_exists($storages . $oldData->foto)) {
        unlink($storages . $oldData->foto);
    }

    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $fotoBaru = time() . "-laporan." . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], $storages . $fotoBaru);
}

// Update database
$qUpdate = "UPDATE pengaduan SET 
    tgl_pengaduan = '$tgl_pengaduan',
    nik = '$nik',
    isi_laporan = '$isi_laporan',
    tingkat = '$tingkat',  -- 🟠 Tambahan field tingkat
    foto = '$fotoBaru'
    WHERE id_pengaduan = '$id'";

mysqli_query($connect, $qUpdate) or die(mysqli_error($connect));

echo "
    <script>
        alert('Laporan berhasil diperbarui!');
        window.location.href = '../../pages/laporan_pengaduan/index.php';
    </script>
";
?>
