<?php
session_start();

function requireRole($role) {
    if (!isset($_SESSION['user'])) {
        http_response_code(401);
        echo json_encode([
            "status" => false,
            "message" => "Unauthorized"
        ]);
        exit;
    }

    if ($_SESSION['user']['role'] !== $role) {
        http_response_code(403);
        echo json_encode([
            "status" => false,
            "message" => "Forbidden - akses ditolak"
        ]);
        exit;
    }
}
