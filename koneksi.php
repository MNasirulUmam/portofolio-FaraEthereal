<?php
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'portofolio';

    // membuat koneksi
    $koneksi = new mysqli($host, $user, $password, $database);
    // memerikasa koneksi
    if ($koneksi->connect_error) {
        die("Connection failed:" . $koneksi->connect_error);
    }
    // echo "Connected successfully.";
    // menutup koneksi
    // $koneksi->close();
?>