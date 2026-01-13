<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

// 🔐 dosen only
$user = roleGuard("dosen");

$id_dosen = $user['ref_id']; // ref_id → id_dosen

$sql = "
SELECT 
    mhs.id_mahasiswa,
    mhs.nim,
    mhs.nama_mahasiswa,
    mk.kode_mk,
    mk.nama_mk
FROM mengajar mg
JOIN matakuliah mk ON mg.id_matakuliah = mk.id_matakuliah
JOIN krs k ON k.id_matakuliah = mk.id_matakuliah
JOIN mahasiswa mhs ON mhs.id_mahasiswa = k.id_mahasiswa
WHERE mg.id_dosen = ?
ORDER BY mk.nama_mk, mhs.nama_mahasiswa
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_dosen);
$stmt->execute();

$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

response(true, "Daftar mahasiswa yang diajar", $data);
