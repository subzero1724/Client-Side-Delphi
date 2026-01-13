<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

roleGuard("admin");

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $conn->prepare(
    "UPDATE dosen SET nama=?, nidn=? WHERE id_dosen=?"
);
$stmt->bind_param("ssi", $data['nama'], $data['nidn'], $data['id_dosen']);
$stmt->execute();

response(true, "Dosen berhasil diupdate");
