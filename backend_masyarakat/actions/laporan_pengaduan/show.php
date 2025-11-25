<?php
    if(!isset($_GET['id'])){
        echo "
            <script>
                alert('Tidak bisa memilih ID ini');
                window.location.href = '../../pages/laporan_pengaduan/index.php';
            </script>
        ";
    }

    $id = $_GET['id'];

    $qSelect = "SELECT * FROM pengaduan WHERE id = '$id'";
    $result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));

    $laporan_pengaduan = $result->fetch_object();
    if(!$laporan_pengaduan){
        echo "Data Tidak Ditemukan";
    }
?>