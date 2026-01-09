<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth_guard.php";

requireRole("admin");

$data = json_decode(file_get_contents("php://input"), true);

$nidn = $data['nidn'];
$nama = $data['nama'];

mysqli_query($conn, "
    INSERT INTO dosen (nidn, nama)
    VALUES ('$nidn', '$nama')
");

$dosen_id = mysqli_insert_id($conn);

$username = $nidn;
$password = password_hash($nidn, PASSWORD_DEFAULT);

mysqli_query($conn, "
    INSERT INTO users (ref_id, role, username, password)
    VALUES ($dosen_id, 'dosen', '$username', '$password')
");

response(true, "Dosen & akun berhasil dibuat");
