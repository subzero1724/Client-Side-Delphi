<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

roleGuard("admin");

$result = $conn->query("SELECT * FROM dosen ORDER BY nama ASC");

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

response(true, "Data dosen", $data);
