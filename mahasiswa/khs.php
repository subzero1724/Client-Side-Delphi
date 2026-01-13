<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

// 🔐 hanya mahasiswa
$user = roleGuard("mahasiswa");

$id_mahasiswa = $user['ref_id'];

$sql = "
SELECT
    mk.kode_mk,
    mk.nama_mk,
    mk.sks,
    d.nama_dosen,

    n.tugas,
    n.kuis,
    n.uts,
    n.uas,
    n.nilai_akhir,
    n.grade
FROM krs k
JOIN matakuliah mk ON mk.id_matakuliah = k.id_matakuliah
LEFT JOIN dosen d ON d.id_dosen = mk.id_dosen
LEFT JOIN nilai n ON n.id_krs = k.id_krs
WHERE k.id_mahasiswa = ?
ORDER BY mk.nama_mk ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_mahasiswa);
$stmt->execute();

$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

response(true, "KHS Mahasiswa", $data);
