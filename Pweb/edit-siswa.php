<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Siswa</title>
</head>
<body>
    <h2>Edit Data Siswa</h2>
    <?php
    require 'config.php';

    // Pastikan ID tersedia di URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Ambil data siswa berdasarkan ID
        $sql = "SELECT * FROM calon_siswa WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Cek jika data ditemukan
        if ($data = mysqli_fetch_assoc($result)) {
            // Ambil daftar pegawai untuk dropdown
            $pegawaiQuery = "SELECT id, nama FROM pegawai";
            $pegawaiResult = mysqli_query($conn, $pegawaiQuery);
        } else {
            echo "Data tidak ditemukan!";
            exit;
        }
    } else {
        echo "ID tidak diberikan!";
        exit;
    }
    ?>

    <form action="proses-edit.php" method="POST">
        <!-- Hidden input untuk ID -->
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <label for="nama">Nama:</label><br>
        <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($data['nama']) ?>"><br><br>

        <label for="alamat">Alamat:</label><br>
        <input type="text" name="alamat" id="alamat" value="<?= htmlspecialchars($data['alamat']) ?>"><br><br>

        <label for="jenis_kelamin">Jenis Kelamin:</label><br>
        <select name="jenis_kelamin" id="jenis_kelamin">
            <option value="Laki-laki" <?= $data['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
            <option value="Perempuan" <?= $data['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
        </select><br><br>

        <label for="agama">Agama:</label><br>
        <input type="text" name="agama" id="agama" value="<?= htmlspecialchars($data['agama']) ?>"><br><br>

        <label for="sekolah_asal">Sekolah Asal:</label><br>
        <input type="text" name="sekolah_asal" id="sekolah_asal" value="<?= htmlspecialchars($data['sekolah_asal']) ?>"><br><br>

        <label for="pegawai_id">Pilih Pegawai:</label><br>
        <select name="pegawai_id" id="pegawai_id">
            <?php
            while ($pegawai = mysqli_fetch_assoc($pegawaiResult)) {
                $selected = $pegawai['id'] == $data['pegawai_id'] ? 'selected' : '';
                echo "<option value='" . $pegawai['id'] . "' $selected>" . htmlspecialchars($pegawai['nama']) . "</option>";
            }
            ?>
        </select><br><br>

        <input type="submit" value="Simpan Perubahan">
    </form>
</body>
</html>
