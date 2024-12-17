<?php
require 'config.php';

if (isset($_POST['upload'])) {
    $id = $_POST['id'];
    $target_dir = "uploads/"; // Direktori penyimpanan foto
    $file_name = basename($_FILES["photo"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name; // Unik dengan timestamp
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi file adalah gambar
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check === false) {
        echo "File bukan gambar.";
        $upload_ok = 0;
    }

    // Batasi tipe file gambar
    if (!in_array($image_file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "Hanya file JPG, JPEG, PNG, dan GIF yang diizinkan.";
        $upload_ok = 0;
    }

    // Upload file jika valid
    if ($upload_ok == 1) {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // Update database
            $sql = "UPDATE calon_siswa SET photo = '$target_file' WHERE id = $id";
            mysqli_query($conn, $sql);
            header("Location: index.php");
        } else {
            echo "Terjadi kesalahan saat upload.";
        }
    }
}
?>
