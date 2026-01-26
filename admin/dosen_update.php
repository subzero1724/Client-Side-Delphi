<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

roleGuard("admin");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['nidn'], $data['nama'])) {
    response(false, "Data tidak lengkap");
}

$stmt = $conn->prepare(
    "UPDATE dosen SET nama=? WHERE nidn=?"
);
$stmt->bind_param("ss", $data['nama'], $data['nidn']);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    response(true, "Dosen berhasil diupdate");
} else {
    response(false, "Data tidak berubah / NIDN tidak ditemukan");
}
