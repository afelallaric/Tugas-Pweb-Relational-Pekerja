<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = isset($_POST['nama']) ? $_POST['nama'] : null;
    $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : null;
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : null;
    $agama = isset($_POST['agama']) ? $_POST['agama'] : null;
    $sekolah_asal = isset($_POST['sekolah_asal']) ? $_POST['sekolah_asal'] : null;
    $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;

    // Validasi input
    if (empty($nama) || empty($alamat) || empty($jenis_kelamin) || empty($agama) || empty($sekolah_asal) || empty($pegawai_id)) {
        die("Semua field wajib diisi!");
    }

    // Query SQL untuk menyimpan data
    $sql = "INSERT INTO calon_siswa (nama, alamat, jenis_kelamin, agama, sekolah_asal, pegawai_id) 
            VALUES ('$nama', '$alamat', '$jenis_kelamin', '$agama', '$sekolah_asal', '$pegawai_id')";

    // Eksekusi query
    if (mysqli_query($conn, $sql)) {
        echo "Pendaftaran berhasil! <a href='index.php'>Kembali ke halaman utama</a>";
    } else {
        echo "Pendaftaran gagal: " . mysqli_error($conn);
    }

    // Tutup koneksi
    mysqli_close($conn);
}
?>
