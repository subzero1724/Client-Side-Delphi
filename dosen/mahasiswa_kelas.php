<?php
include "../config/database.php";

$id_dosen = $_GET['id_dosen'];

$sql = "
SELECT
    k.id_krs,
    m.nim,
    m.nama AS nama_mahasiswa,
    mk.nama_mk
FROM krs k
JOIN mahasiswa m ON k.id_mahasiswa = m.id_mahasiswa
JOIN mengajar mg ON k.id_mengajar = mg.id_mengajar
JOIN matakuliah mk ON mg.id_matakuliah = mk.id_matakuliah
WHERE mg.id_dosen = $id_dosen
";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
