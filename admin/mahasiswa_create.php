<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

// 🔐 hanya admin
$user = roleGuard("admin");

$data = json_decode(file_get_contents("php://input"), true);

$nim      = $data['nim'] ?? null;
$nama     = $data['nama'] ?? null;
$kelas    = $data['kelas'] ?? null;
$jurusan  = $data['jurusan'] ?? null;
$password = $data['password'] ?? null;

if (!$nim || !$nama || !$kelas || !$jurusan || !$password) {
    response(false, "Semua field wajib diisi");
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$conn->begin_transaction();

try {
    // 1️⃣ insert mahasiswa
    $stmt = $conn->prepare(
        "INSERT INTO mahasiswa (nim, nama, kelas, jurusan)
         VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("ssss", $nim, $nama, $kelas, $jurusan);
    $stmt->execute();

    $id_mahasiswa = $conn->insert_id;

    // 2️⃣ insert user mahasiswa
    $stmt = $conn->prepare(
        "INSERT INTO users (username, password, role, ref_id)
         VALUES (?, ?, 'mahasiswa', ?)"
    );
    $stmt->bind_param("ssi", $nim, $passwordHash, $id_mahasiswa);
    $stmt->execute();

    $conn->commit();
    response(true, "Mahasiswa & akun berhasil dibuat");

} catch (Exception $e) {
    $conn->rollback();
    response(false, "Gagal membuat mahasiswa");
}
