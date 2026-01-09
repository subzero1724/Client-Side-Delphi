<?php
include "../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$id_dosen      = $data['id_dosen'];
$id_matakuliah = $data['id_matakuliah'];

$sql = "INSERT INTO mengajar (id_dosen, id_matakuliah)
        VALUES ($id_dosen, $id_matakuliah)";

if ($conn->query($sql)) {
    echo json_encode([
        "status" => true,
        "message" => "Dosen berhasil ditugaskan mengajar"
    ]);
} else {
    echo json_encode([
        "status" => false,
        "message" => "Gagal mengatur dosen mengajar"
    ]);
}
