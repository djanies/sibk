<?php
// File: config.php
// Konfigurasi untuk koneksi ke database

// Informasi koneksi database
$db_host = 'localhost';    // Biasanya 'localhost'
$db_user = 'root';         // User default XAMPP
$db_pass = '';             // Password default XAMPP kosong
$db_name = 'sibk'; // Nama database yang Anda buat

// Membuat koneksi ke database
$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if (!$koneksi) {
    // Jika koneksi gagal, hentikan skrip dan tampilkan pesan error
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Mengatur zona waktu default
date_default_timezone_set('Asia/Jakarta');
?>
