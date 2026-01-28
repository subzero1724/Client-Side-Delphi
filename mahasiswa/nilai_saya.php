<?php
include "../config/database.php";

// Ambil semua data dari tabel nilai
$sql = "
SELECT
    id_nilai,
    id_krs,
    tugas,
    kuis,
    uts,
    uas,
    grade
FROM nilai
ORDER BY id_nilai ASC
";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
