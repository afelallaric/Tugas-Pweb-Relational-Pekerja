<?php
require 'config.php';

// Query untuk mengambil data calon_siswa beserta nama pegawai
$sql = "
    SELECT 
        calon_siswa.id AS calon_id,
        calon_siswa.nama AS calon_nama,
        calon_siswa.alamat,
        calon_siswa.jenis_kelamin,
        calon_siswa.agama,
        calon_siswa.sekolah_asal,
        calon_siswa.photo,
        pegawai.nama AS pegawai_nama
    FROM 
        calon_siswa
    LEFT JOIN 
        pegawai ON calon_siswa.pegawai_id = pegawai.id
";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Siswa</title>
</head>

<body>
    <h1>Daftar Siswa</h1>
    <a href="form-daftar.php">[+] Tambah Siswa Baru</a>
    <a href="edit-siswa.php">[+] Edit Data Siswa</a>
    <a href="export-all-pdf.php">[+] Ekspor Semua PDF</a> <!-- Tombol Ekspor Semua -->
    
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Jenis Kelamin</th>
                <th>Agama</th>
                <th>Sekolah Asal</th>
                <th>Nama Pegawai</th> <!-- Kolom baru -->
                <th>Photo</th>
                <th>Upload Photo</th>
                <th>Ekspor</th>
                <th>Hapus</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['calon_id'] ?></td>
                    <td><?= htmlspecialchars($row['calon_nama']) ?></td>
                    <td><?= htmlspecialchars($row['alamat']) ?></td>
                    <td><?= $row['jenis_kelamin'] ?></td>
                    <td><?= htmlspecialchars($row['agama']) ?></td>
                    <td><?= htmlspecialchars($row['sekolah_asal']) ?></td>
                    <td><?= $row['pegawai_nama'] ?: 'Tidak dipilih' ?></td> <!-- Nama Pegawai -->
                    <td>
                        <?php if ($row['photo']): ?>
                            <img src="<?= $row['photo'] ?>" alt="Photo" width="100">
                        <?php else: ?>
                            Belum ada foto
                        <?php endif; ?>
                    </td>
                    <td>
                        <form action="upload-photo.php" method="POST" enctype="multipart/form-data">
                            <input type="file" name="photo" required>
                            <input type="hidden" name="id" value="<?= $row['calon_id'] ?>">
                            <button type="submit" name="upload">Upload</button>
                        </form>
                    </td>
                    <td>
                        <a href="export-row-pdf.php?id=<?= $row['calon_id'] ?>">Ekspor PDF</a>
                    </td>
                    <td>
                        <a href="hapus.php?id=<?= $row['calon_id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                    </td>
                    <td>
                        <a href="edit-siswa.php?id=<?= $row['calon_id'] ?>">Edit</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>
