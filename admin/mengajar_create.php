<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

// 🔐 admin only
$user = roleGuard("admin");

$data = json_decode(file_get_contents("php://input"), true);

$id_dosen      = $data['id_dosen'] ?? null;
$id_matakuliah = $data['id_matakuliah'] ?? null;

if (!$id_dosen || !$id_matakuliah) {
    response(false, "id_dosen dan id_matakuliah wajib diisi");
}

$stmt = $conn->prepare(
    "INSERT INTO mengajar (id_dosen, id_matakuliah)
     VALUES (?, ?)"
);
$stmt->bind_param("ii", $id_dosen, $id_matakuliah);
$stmt->execute();

response(true, "Dosen berhasil di-assign ke matakuliah");
