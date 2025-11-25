<?php
include '../../app.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status']; // 'proses' atau 'selesai'

    // Update status
    $query = "UPDATE pengaduan SET status='$status' WHERE id_pengaduan='$id'";
    $result = mysqli_query($connect, $query);

    if ($result) {
        header("Location: ../../pages/verifikasi_validasi/index.php");
        exit;
    } else {
        echo "Gagal memperbarui status: " . mysqli_error($connect);
    }
} else {
    echo "Parameter tidak valid.";
}
?>
