<?php
include "../config/database.php";

$result = $conn->query("
SELECT
    m.id_mahasiswa,
    m.nim,
    m.nama,
    m.jurusan,
    u.username
FROM mahasiswa m
LEFT JOIN users u ON m.id_user = u.id_user
");

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
