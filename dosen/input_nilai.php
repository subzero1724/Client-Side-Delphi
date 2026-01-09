<?php
include "../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$id_krs = $data['id_krs'];
$tugas  = $data['tugas'];
$kuis   = $data['kuis'];
$uts    = $data['uts'];
$uas    = $data['uas'];

$nilai_akhir =
    ($tugas * 0.1) +
    ($kuis * 0.1) +
    ($uts * 0.3) +
    ($uas * 0.5);

if ($nilai_akhir >= 85) {
    $grade = 'A';
} elseif ($nilai_akhir >= 75) {
    $grade = 'B';
} elseif ($nilai_akhir >= 65) {
    $grade = 'C';
} elseif ($nilai_akhir >= 50) {
    $grade = 'D';
} else {
    $grade = 'E';
}

$sql = "
INSERT INTO nilai (id_krs, tugas, kuis, uts, uas, nilai_akhir, grade)
VALUES ($id_krs, $tugas, $kuis, $uts, $uas, $nilai_akhir, '$grade')
";

if ($conn->query($sql)) {
    echo json_encode([
        "status" => true,
        "message" => "Nilai berhasil disimpan",
        "nilai_akhir" => $nilai_akhir,
        "grade" => $grade
    ]);
} else {
    echo json_encode([
        "status" => false,
        "message" => "Gagal menyimpan nilai"
    ]);
}
