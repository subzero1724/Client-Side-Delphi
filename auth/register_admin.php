<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../config/database.php";
require_once "../utils/response.php";


// Cek apakah admin sudah ada
$check = $conn->query("SELECT id_user FROM users WHERE role = 'admin' LIMIT 1");

if ($check->num_rows > 0) {
    response(false, "Admin sudah ada. Endpoint ini dinonaktifkan.");
    exit;
}

// Ambil input
$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'] ?? null;
$password = $data['password'] ?? null;

if (!$username || !$password) {
    response(false, "Username dan password wajib diisi");
    exit;
}

// Hash password
$hash = password_hash($password, PASSWORD_DEFAULT);

// Insert admin
$stmt = $conn->prepare(
    "INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')"
);
$stmt->bind_param("ss", $username, $hash);

if ($stmt->execute()) {
    response(true, "Admin berhasil dibuat. Endpoint ini hanya bisa dipakai sekali.");
} else {
    response(false, "Gagal membuat admin");
}
