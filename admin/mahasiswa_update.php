<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

roleGuard("admin");

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id_mahasiswa'];
$nama = $data['nama'];
$kelas = $data['kelas'];
$jurusan = $data['jurusan'];

$stmt = $conn->prepare(
    "UPDATE mahasiswa SET nama=?, kelas=?, jurusan=? WHERE id_mahasiswa=?"
);
$stmt->bind_param("sssi", $nama, $kelas, $jurusan, $id);
$stmt->execute();

response(true, "Mahasiswa berhasil diupdate");
