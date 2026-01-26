<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

roleGuard("admin");

$data = json_decode(file_get_contents("php://input"), true);
$nidn = $data['nidn'] ?? null;

if (!$nidn) response(false, "NIDN tidak ditemukan");

$conn->begin_transaction();

try {
    // hapus user (FK via nidn)
    $stmt = $conn->prepare(
        "DELETE FROM users WHERE role='dosen' AND ref_id=?"
    );
    $stmt->bind_param("s", $nidn);
    $stmt->execute();

    // hapus dosen
    $stmt = $conn->prepare(
        "DELETE FROM dosen WHERE nidn=?"
    );
    $stmt->bind_param("s", $nidn);
    $stmt->execute();

    $conn->commit();
    response(true, "Dosen berhasil dihapus");
} catch (Exception $e) {
    $conn->rollback();
    response(false, "Gagal hapus dosen");
}
