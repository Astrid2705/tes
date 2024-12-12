<?php
// Koneksi ke database
$host = "localhost"; // Ganti dengan nama host Anda
$username = "root"; // Ganti dengan username MySQL Anda
$password = ""; // Ganti dengan password MySQL Anda
$database = "jejeweb2uas"; // Ganti dengan nama database Anda

// Buat koneksi
$koneksi = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
