<?php
include "../config/database.php";

$id_mahasiswa = $_GET['id_mahasiswa'];

$sql = "
SELECT
    mk.kode_mk,
    mk.nama_mk,
    d.nama AS nama_dosen,
    n.tugas,
    n.kuis,
    n.uts,
    n.uas,
    n.nilai_akhir,
    n.grade
FROM nilai n
JOIN krs k ON n.id_krs = k.id_krs
JOIN mengajar mg ON k.id_mengajar = mg.id_mengajar
JOIN dosen d ON mg.id_dosen = d.id_dosen
JOIN matakuliah mk ON mg.id_matakuliah = mk.id_matakuliah
WHERE k.id_mahasiswa = $id_mahasiswa
";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
