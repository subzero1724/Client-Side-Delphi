<?php
require_once "jwt.php";
require_once "response.php";

function authGuard() {
    $headers = getallheaders();

    if (!isset($headers['Authorization'])) {
        response(false, "Unauthorized");
    }

    $token = str_replace("Bearer ", "", $headers['Authorization']);

    $payload = verifyJWT($token);

    if (!$payload) {
        response(false, "Token tidak valid");
    }

    return $payload;
}

function roleGuard($role) {
    $user = authGuard();

    if ($user['role'] !== $role) {
        response(false, "Forbidden");
    }

    return $user;
}
