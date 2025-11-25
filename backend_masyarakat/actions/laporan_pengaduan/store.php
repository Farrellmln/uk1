<?php
include '../../app.php';

if (isset($_POST['tombol'])) {
    $tgl_pengaduan = escapeString($_POST['tgl_pengaduan']);
    $nik = escapeString($_POST['nik']);
    $isi_laporan = escapeString($_POST['isi_laporan']);
    $status = '0'; // default: Baru
    $tingkat = escapeString($_POST['tingkat']); // 🔹 ambil dari dropdown

    // Folder penyimpanan foto
    $storage = "../../../storages/laporan_pengaduan/";

    // Upload foto (jika ada)
    $fotoName = "";
    if (!empty($_FILES['foto']['name'])) {
        $fotoTmp = $_FILES['foto']['tmp_name'];
        $fotoExt = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $fotoName = time() . "_pengaduan." . $fotoExt;

        move_uploaded_file($fotoTmp, $storage . $fotoName);
    }

    // 🔹 Query insert ke database (tambah kolom tingkat)
    $query = "INSERT INTO pengaduan (tgl_pengaduan, nik, isi_laporan, foto, status, tingkat)
              VALUES ('$tgl_pengaduan', '$nik', '$isi_laporan', '$fotoName', '$status', '$tingkat')";

    $insert = mysqli_query($connect, $query);

    if ($insert) {
        echo "
        <script>
            alert('Laporan berhasil ditambahkan!');
            window.location.href = '../../pages/laporan_pengaduan/index.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Gagal menambahkan laporan!');
            window.location.href = '../../pages/laporan_pengaduan/index.php';
        </script>";
    }
}
?>
