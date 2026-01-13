<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

// 🔐 admin only
roleGuard("admin");

$data = json_decode(file_get_contents("php://input"), true);

$id_matakuliah = $data['id_matakuliah'] ?? null;
$kode_mk       = $data['kode_mk'] ?? null;
$nama_mk       = $data['nama_mk'] ?? null;
$sks           = $data['sks'] ?? null;
$id_dosen      = $data['id_dosen'] ?? null;

if (!$id_matakuliah || !$kode_mk || !$nama_mk || !$sks) {
    response(false, "Field wajib tidak lengkap");
}

try {
    $stmt = $conn->prepare(
        "UPDATE matakuliah
         SET kode_mk = ?, nama_mk = ?, sks = ?, id_dosen = ?
         WHERE id_matakuliah = ?"
    );

    $stmt->bind_param(
        "ssiii",
        $kode_mk,
        $nama_mk,
        $sks,
        $id_dosen,
        $id_matakuliah
    );

    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        response(false, "Data tidak berubah atau MK tidak ditemukan");
    }

    response(true, "Matakuliah berhasil diupdate");
} catch (Exception $e) {
    response(false, "Gagal update matakuliah", [
        "error" => $e->getMessage()
    ]);
}
