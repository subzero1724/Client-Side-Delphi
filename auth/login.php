<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/jwt.php";

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'] ?? null;
$password = $data['password'] ?? null;

if (!$username || !$password) {
    response(false, "Username dan password wajib diisi");
}

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if (!$user = $result->fetch_assoc()) {
    response(false, "User tidak ditemukan");
}

if (!password_verify($password, $user['password'])) {
    response(false, "Password salah");
}

$payload = [
    "id_user" => $user['id_user'],
    "username" => $user['username'],
    "role" => $user['role'],
    "ref_id" => $user['ref_id'],
    "iat" => time()
];

$token = generateJWT($payload);

response(true, "Login berhasil", [
    "id_user" => $user['id_user'],
    "username" => $user['username'],
    "role" => $user['role'],
    "token" => $token
]);
