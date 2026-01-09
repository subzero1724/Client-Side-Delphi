<?php
include "../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$kode_mk = $data['kode_mk'];
$nama_mk = $data['nama_mk'];
$sks     = $data['sks'];

$sql = "INSERT INTO matakuliah (kode_mk, nama_mk, sks)
        VALUES ('$kode_mk', '$nama_mk', $sks)";

if ($conn->query($sql)) {
    echo json_encode([
        "status" => true,
        "message" => "Matakuliah berhasil ditambahkan"
    ]);
} else {
    echo json_encode([
        "status" => false,
        "message" => "Gagal menambahkan matakuliah"
    ]);
}
