<?php
require_once "../config/database.php";
require_once "../utils/response.php";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$role     = $_POST['role'] ?? '';
$ref_id   = $_POST['ref_id'] ?? null;

// validasi wajib
if ($username == '' || $password == '' || $role == '') {
    response(false, "Data tidak lengkap");
}

// validasi role
if (!in_array($role, ['admin','dosen','mahasiswa'])) {
    response(false, "Role tidak valid");
}

// role selain admin wajib punya ref_id
if ($role != 'admin' && empty($ref_id)) {
    response(false, "ref_id wajib untuk role $role");
}

// cek username
$cek = mysqli_query($conn,
    "SELECT id_user FROM users WHERE username='$username'"
);

if (mysqli_num_rows($cek) > 0) {
    response(false, "Username sudah digunakan");
}

// hash password
$hash = password_hash($password, PASSWORD_DEFAULT);

// insert user
mysqli_query($conn,"
    INSERT INTO users(username,password,role,ref_id)
    VALUES('$username','$hash','$role','$ref_id')
");

response(true, "Register berhasil");
