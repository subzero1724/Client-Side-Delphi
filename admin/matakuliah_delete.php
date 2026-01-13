<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

// 🔐 admin only
roleGuard("admin");

$id_matakuliah = $_GET['id_matakuliah'] ?? null;

if (!$id_matakuliah) {
    response(false, "ID matakuliah tidak ditemukan");
}

$conn->begin_transaction();

try {
    // hapus nilai lewat krs
    $stmt = $conn->prepare(
        "DELETE n FROM nilai n
         JOIN krs k ON k.id_krs = n.id_krs
         WHERE k.id_matakuliah = ?"
    );
    $stmt->bind_param("i", $id_matakuliah);
    $stmt->execute();

    // hapus krs
    $stmt = $conn->prepare(
        "DELETE FROM krs WHERE id_matakuliah = ?"
    );
    $stmt->bind_param("i", $id_matakuliah);
    $stmt->execute();

    // hapus matakuliah
    $stmt = $conn->prepare(
        "DELETE FROM matakuliah WHERE id_matakuliah = ?"
    );
    $stmt->bind_param("i", $id_matakuliah);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        $conn->rollback();
        response(false, "Matakuliah tidak ditemukan");
    }

    $conn->commit();
    response(true, "Matakuliah berhasil dihapus");

} catch (Exception $e) {
    $conn->rollback();
    response(false, "Gagal hapus matakuliah", [
        "error" => $e->getMessage()
    ]);
}
