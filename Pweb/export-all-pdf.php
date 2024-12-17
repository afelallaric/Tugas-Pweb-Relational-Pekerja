<?php
require 'config.php';
require_once 'tcpdf/tcpdf.php';

// Query untuk mendapatkan data semua siswa dengan nama pegawai yang terkait
$sql = "
    SELECT calon_siswa.*, pegawai.nama AS nama_pegawai 
    FROM calon_siswa 
    LEFT JOIN pegawai ON calon_siswa.pegawai_id = pegawai.id
";
$result = mysqli_query($conn, $sql);

// Cek jika ada data
if (mysqli_num_rows($result) > 0) {
    // Inisialisasi PDF
    $pdf = new TCPDF();
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->SetFont('helvetica', '', 12);

    // Tambahkan halaman pertama
    $pdf->AddPage();

    // Judul PDF
    $pdf->Cell(0, 10, 'Daftar Semua Siswa', 0, 1, 'C');
    $pdf->Ln(10);

    // Loop data untuk ditampilkan di PDF
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(50, 10, 'ID:', 0);
        $pdf->Cell(0, 10, $row['id'], 0, 1);
        $pdf->Cell(50, 10, 'Nama:', 0);
        $pdf->Cell(0, 10, $row['nama'], 0, 1);
        $pdf->Cell(50, 10, 'Alamat:', 0);
        $pdf->MultiCell(0, 10, $row['alamat'], 0, 1);
        $pdf->Cell(50, 10, 'Jenis Kelamin:', 0);
        $pdf->Cell(0, 10, $row['jenis_kelamin'], 0, 1);
        $pdf->Cell(50, 10, 'Agama:', 0);
        $pdf->Cell(0, 10, $row['agama'], 0, 1);
        $pdf->Cell(50, 10, 'Sekolah Asal:', 0);
        $pdf->Cell(0, 10, $row['sekolah_asal'], 0, 1);
        $pdf->Cell(50, 10, 'Pegawai:', 0);
        $namaPegawai = $row['nama_pegawai'] ?? 'Belum Dipilih';
        $pdf->Cell(0, 10, $namaPegawai, 0, 1);

        // Tambahkan Foto jika ada
        if ($row['photo']) {
            $pdf->Ln(5);
            $pdf->Image($row['photo'], '', $pdf->GetY(), 40, 40); // Sesuaikan posisi dan ukuran
            $pdf->Ln(45); // Beri ruang setelah foto
        } else {
            $pdf->Ln(5);
        }

        // Garis pemisah antar siswa
        $pdf->Ln(10);
        $pdf->Cell(0, 0, '', 'T', 1, '', true); // Tambahkan garis horizontal
        $pdf->Ln(5);
    }

    // Output PDF ke browser
    $pdf->Output('daftar_semua_siswa.pdf', 'D');
} else {
    echo "Tidak ada data untuk diekspor!";
}
?>
