<?php
include "../config/database.php";

$q = $conn->query("
  SELECT kode_mk
  FROM matakuliah
  WHERE kode_mk LIKE 'IF%'
  ORDER BY kode_mk DESC
  LIMIT 1
");

if ($row = $q->fetch_assoc()) {
  echo json_encode([
    "status" => true,
    "data" => ["kode_mk" => $row['kode_mk']]
  ]);
} else {
  echo json_encode([
    "status" => false
  ]);
}
