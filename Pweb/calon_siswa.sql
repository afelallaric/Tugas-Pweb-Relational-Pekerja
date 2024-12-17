CREATE DATABASE IF NOT EXISTS pendaftaran_siswa;
USE pendaftaran_siswa;

-- Tabel pegawai
CREATE TABLE IF NOT EXISTS pegawai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(50) DEFAULT 'Staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel calon_siswa
CREATE TABLE IF NOT EXISTS calon_siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL,
    agama VARCHAR(50) NOT NULL,
    sekolah_asal VARCHAR(100) NOT NULL,
    photo VARCHAR(255) DEFAULT NULL,
    pegawai_id INT,
    FOREIGN KEY (pegawai_id) REFERENCES pegawai(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- Tambah data ke tabel pegawai
INSERT INTO pegawai (nama) VALUES 
('Kinan'),
('Kanaja'),
('Kaka');

