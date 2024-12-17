<?php
require 'config.php';
require_once 'tcpdf/tcpdf.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil detail siswa dengan JOIN ke tabel pegawai
    $sql = "
        SELECT calon_siswa.*, pegawai.nama AS nama_pegawai 
        FROM calon_siswa 
        LEFT JOIN pegawai ON calon_siswa.pegawai_id = pegawai.id 
        WHERE calon_siswa.id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Inisialisasi PDF
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        // Judul
        $pdf->Cell(0, 10, 'Detail Siswa', 0, 1, 'C');
        $pdf->Ln(5);

        // Isi Data
        $pdf->Cell(50, 10, 'ID:', 0);
        $pdf->Cell(0, 10, $row['id'], 0, 1);
        $pdf->Cell(50, 10, 'Nama:', 0);
        $pdf->Cell(0, 10, $row['nama'], 0, 1);
        $pdf->Cell(50, 10, 'Alamat:', 0);
        $pdf->Cell(0, 10, $row['alamat'], 0, 1);
        $pdf->Cell(50, 10, 'Jenis Kelamin:', 0);
        $pdf->Cell(0, 10, $row['jenis_kelamin'], 0, 1);
        $pdf->Cell(50, 10, 'Agama:', 0);
        $pdf->Cell(0, 10, $row['agama'], 0, 1);
        $pdf->Cell(50, 10, 'Sekolah Asal:', 0);
        $pdf->Cell(0, 10, $row['sekolah_asal'], 0, 1);
        
        // Tambahkan Nama Pegawai
        $pdf->Cell(50, 10, 'Pegawai:', 0);
        $namaPegawai = $row['nama_pegawai'] ?? 'Belum Dipilih'; // Cek jika NULL
        $pdf->Cell(0, 10, $namaPegawai, 0, 1);

        // Tampilkan Foto jika ada
        if ($row['photo']) {
            $pdf->Ln(10);
            $pdf->Image($row['photo'], '', '', 40, 40);
        }

        // Output PDF
        $pdf->Output('detail_siswa.pdf', 'D');
    } else {
        echo "Data tidak ditemukan!";
    }
} else {
    echo "ID tidak ditemukan!";
}
?>
