<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $sekolah_asal = $_POST['sekolah_asal'];
    $pegawai_id = $_POST['pegawai_id'];

    // Validasi apakah semua input terisi
    if (empty($nama) || empty($alamat) || empty($jenis_kelamin) || empty($agama) || empty($sekolah_asal) || empty($pegawai_id)) {
        die("Semua field wajib diisi!");
    }

    // Query untuk update data siswa
    $sql = "UPDATE calon_siswa SET 
                nama = ?, 
                alamat = ?, 
                jenis_kelamin = ?, 
                agama = ?, 
                sekolah_asal = ?, 
                pegawai_id = ? 
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssi", $nama, $alamat, $jenis_kelamin, $agama, $sekolah_asal, $pegawai_id, $id);

    // Eksekusi query
    if (mysqli_stmt_execute($stmt)) {
        header('Location: list-siswa.php');
        exit();
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($conn);
    }
}
?>
