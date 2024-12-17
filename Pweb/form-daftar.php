<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Daftar</title>
</head>
<body>
    <h1>Form Pendaftaran</h1>
    <?php
    // Hubungkan ke database untuk mendapatkan daftar pegawai
    require 'config.php';

    $pegawaiQuery = "SELECT id, nama FROM pegawai";
    $pegawaiResult = mysqli_query($conn, $pegawaiQuery);
    ?>

    <form action="proses-pendaftaran.php" method="POST">
        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" required><br>

        <label for="alamat">Alamat:</label>
        <textarea name="alamat" id="alamat" required></textarea><br>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select name="jenis_kelamin" id="jenis_kelamin" required>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select><br>

        <label for="agama">Agama:</label>
        <input type="text" name="agama" id="agama" required><br>

        <label for="sekolah_asal">Sekolah Asal:</label>
        <input type="text" name="sekolah_asal" id="sekolah_asal" required><br>

        <label for="pegawai_id">Pilih Pegawai:</label>
        <select name="pegawai_id" id="pegawai_id" required>
            <option value="" disabled selected>Pilih Pegawai</option>
            <?php
            while ($pegawai = mysqli_fetch_assoc($pegawaiResult)) {
                echo "<option value='" . $pegawai['id'] . "'>" . htmlspecialchars($pegawai['nama']) . "</option>";
            }
            ?>
        </select><br>

        <button type="submit">Daftar</button>
    </form>
</body>
</html>
