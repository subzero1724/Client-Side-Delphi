<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

// 🔐 admin only
$user = roleGuard("admin");

$data = json_decode(file_get_contents("php://input"), true);

$kode_mk  = $data['kode_mk']  ?? null;
$nama_mk  = $data['nama_mk']  ?? null;
$sks      = $data['sks']      ?? null;
$id_dosen = $data['id_dosen'] ?? null;

if (!$kode_mk || !$nama_mk || !$sks || !$id_dosen) {
    response(false, "Semua field wajib diisi");
}

/**
 * =========================
 * CEK DOSEN
 * =========================
 */
$stmt = $conn->prepare("SELECT id_dosen FROM dosen WHERE id_dosen = ?");
$stmt->bind_param("i", $id_dosen);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    response(false, "Dosen tidak ditemukan");
}

/**
 * =========================
 * INSERT MATA KULIAH
 * =========================
 */
$stmt = $conn->prepare(
    "INSERT INTO matakuliah (kode_mk, nama_mk, sks, id_dosen)
     VALUES (?, ?, ?, ?)"
);
$stmt->bind_param("ssii", $kode_mk, $nama_mk, $sks, $id_dosen);
$stmt->execute();

response(true, "Mata kuliah berhasil dibuat");
