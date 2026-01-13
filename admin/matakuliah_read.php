<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

roleGuard("admin");

$sql = "
SELECT mk.*, d.nama AS nama_dosen
FROM matakuliah mk
LEFT JOIN dosen d ON d.id_dosen = mk.id_dosen
ORDER BY mk.nama_mk
";

$result = $conn->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

response(true, "Data matakuliah", $data);
