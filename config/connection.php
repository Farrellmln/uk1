<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbName = "pengaduan_masyarakat";

    // membuat koneksi ke database
    $connect = mysqli_connect($host, $username, $password, $dbName);

    // cek apakah koneksi berhasil
    if(!$connect){
        echo "Data Base Gagal Tersambung";

}
?>