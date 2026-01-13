<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

roleGuard("admin");

$id = $_GET['id_dosen'] ?? null;

if (!$id) response(false, "ID tidak ditemukan");

$conn->begin_transaction();

try {
    // hapus user
    $stmt = $conn->prepare("DELETE FROM users WHERE role='mahasiswa' AND ref_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // hapus mahasiswa
    $stmt = $conn->prepare("DELETE FROM mahasiswa WHERE id_mahasiswa=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $conn->commit();
    response(true, "Mahasiswa berhasil dihapus");
} catch (Exception $e) {
    $conn->rollback();
    response(false, "Gagal hapus mahasiswa");
}
