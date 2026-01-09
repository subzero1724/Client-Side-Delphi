-- ===============================
-- DATABASE
-- ===============================
CREATE DATABASE IF NOT EXISTS akademik_api;
USE akademik_api;

-- ===============================
-- USERS (LOGIN)
-- ===============================
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'dosen', 'mahasiswa') NOT NULL,
    ref_id INT NULL
);

-- ===============================
-- ADMIN
-- ===============================
CREATE TABLE admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL
);

-- ===============================
-- DOSEN
-- ===============================
CREATE TABLE dosen (
    id_dosen INT AUTO_INCREMENT PRIMARY KEY,
    nidn VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL
);

-- ===============================
-- MAHASISWA
-- ===============================
CREATE TABLE mahasiswa (
    id_mahasiswa INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    kelas VARCHAR(10)
);

-- ===============================
-- MATA KULIAH
-- ===============================
CREATE TABLE matakuliah (
    id_matakuliah INT AUTO_INCREMENT PRIMARY KEY,
    kode_mk VARCHAR(10) UNIQUE,
    nama_mk VARCHAR(100),
    sks INT
);

-- ===============================
-- MENGAJAR (DOSEN - MK)
-- ===============================
CREATE TABLE mengajar (
    id_mengajar INT AUTO_INCREMENT PRIMARY KEY,
    id_dosen INT,
    id_matakuliah INT
);

-- ===============================
-- KRS
-- ===============================
CREATE TABLE krs (
    id_krs INT AUTO_INCREMENT PRIMARY KEY,
    id_mahasiswa INT,
    id_matakuliah INT
);

-- ===============================
-- NILAI
-- ===============================
CREATE TABLE nilai (
    id_nilai INT AUTO_INCREMENT PRIMARY KEY,
    id_mahasiswa INT,
    id_matakuliah INT,
    nilai_angka INT,
    grade CHAR(2)
);
