<?php
require_once "../config/database.php";
require_once "../utils/response.php";

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

$stmt = $conn->prepare("SELECT id_user, password, role, ref_id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    response(true, "Login berhasil", [
        "id_user" => $user['id_user'],
        "role" => $user['role'],
        "ref_id" => $user['ref_id']
    ]);
} else {
    response(false, "Login gagal");
}
