<?php
// File: proses/ambil_data.php
// Skrip untuk mengambil semua data laporan dari database dan mengirimkannya sebagai JSON

// Memanggil file konfigurasi database
require_once '../config.php';

// Set header response sebagai JSON
header('Content-Type: application/json');

// Query untuk mengambil semua data dari tabel 'laporan', diurutkan dari yang terbaru
$query = "SELECT * FROM laporan ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);

$data = [];
if ($result) {
    // Mengambil setiap baris data dan memasukkannya ke dalam array $data
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

// Meng-encode array $data menjadi format JSON dan menampilkannya
echo json_encode($data);
?>
