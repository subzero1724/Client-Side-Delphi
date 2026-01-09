<?php
include "../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$id_mahasiswa = $data['id_mahasiswa'];
$id_mengajar  = $data['id_mengajar'];

$sql = "INSERT INTO krs (id_mahasiswa, id_mengajar)
        VALUES ($id_mahasiswa, $id_mengajar)";

if ($conn->query($sql)) {
    echo json_encode([
        "status" => true,
        "message" => "Matakuliah berhasil diambil"
    ]);
} else {
    echo json_encode([
        "status" => false,
        "message" => "Gagal mengambil matakuliah"
    ]);
}
