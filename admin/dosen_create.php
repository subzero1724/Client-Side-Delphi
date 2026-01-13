<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

// 🔐 hanya admin
$user = roleGuard("admin");

$data = json_decode(file_get_contents("php://input"), true);

$nidn     = $data['nidn'] ?? null;
$nama     = $data['nama'] ?? null;
$password = $data['password'] ?? null;

if (!$nidn || !$nama || !$password) {
    response(false, "NIDN, nama, dan password wajib diisi");
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$conn->begin_transaction();

try {
    // 1️⃣ insert dosen
    $stmt = $conn->prepare(
        "INSERT INTO dosen (nidn, nama) VALUES (?, ?)"
    );
    $stmt->bind_param("ss", $nidn, $nama);
    $stmt->execute();

    $id_dosen = $conn->insert_id;

    // 2️⃣ insert user dosen
    $stmt = $conn->prepare(
        "INSERT INTO users (username, password, role, ref_id)
         VALUES (?, ?, 'dosen', ?)"
    );
    $stmt->bind_param("ssi", $nidn, $passwordHash, $id_dosen);
    $stmt->execute();

    $conn->commit();
    response(true, "Dosen & akun berhasil dibuat");

} catch (Exception $e) {
    $conn->rollback();
    response(false, "Gagal membuat dosen");
}
