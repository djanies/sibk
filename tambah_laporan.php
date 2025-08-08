<?php
// File: proses/tambah_laporan.php
// Skrip untuk memproses penambahan data laporan ke database

// Memanggil file konfigurasi database
require_once '../config.php';

// Cek apakah data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Mengambil dan membersihkan data dari form
    $namaSiswa = mysqli_real_escape_string($koneksi, $_POST['namaSiswa']);
    $kelasSiswa = mysqli_real_escape_string($koneksi, $_POST['kelasSiswa']);
    $tanggalKejadian = mysqli_real_escape_string($koneksi, $_POST['tanggalKejadian']);
    $laporanKejadian = mysqli_real_escape_string($koneksi, $_POST['laporanKejadian']);
    $namaGuru = mysqli_real_escape_string($koneksi, $_POST['namaGuru']);

    // Query untuk memasukkan data ke tabel 'laporan'
    $query = "INSERT INTO laporan (nama_siswa, kelas, tanggal_kejadian, deskripsi, nama_guru) 
              VALUES ('$namaSiswa', '$kelasSiswa', '$tanggalKejadian', '$laporanKejadian', '$namaGuru')";
    
    // Menjalankan query
    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, kirim response sukses
        echo json_encode(['status' => 'success', 'message' => 'Laporan berhasil ditambahkan.']);
    } else {
        // Jika gagal, kirim response error
        echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan laporan: ' . mysqli_error($koneksi)]);
    }

} else {
    // Jika file diakses langsung tanpa metode POST
    header("Location: ../index.php");
    exit();
}
?>
