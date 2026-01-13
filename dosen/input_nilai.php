<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";
require_once "../utils/nilai_helper.php";

// 🔐 dosen only
$user = roleGuard("dosen");

$data = json_decode(file_get_contents("php://input"), true);

$id_krs = $data['id_krs'] ?? null;
$tugas  = $data['tugas'] ?? null;
$kuis   = $data['kuis'] ?? null;
$uts    = $data['uts'] ?? null;
$uas    = $data['uas'] ?? null;

if (!$id_krs || $tugas === null || $kuis === null || $uts === null || $uas === null) {
    response(false, "Semua field nilai wajib diisi");
}

// hitung
$nilai_akhir = hitungNilaiAkhir($tugas, $kuis, $uts, $uas);
$grade = hitungGrade($nilai_akhir);

// cek apakah nilai sudah ada
$cek = $conn->prepare("SELECT id_nilai FROM nilai WHERE id_krs = ?");
$cek->bind_param("i", $id_krs);
$cek->execute();
$res = $cek->get_result();

if ($res->num_rows > 0) {
    // update
    $stmt = $conn->prepare("
        UPDATE nilai 
        SET tugas=?, kuis=?, uts=?, uas=?, nilai_akhir=?, grade=?
        WHERE id_krs=?
    ");
    $stmt->bind_param(
        "iiiidsi",
        $tugas, $kuis, $uts, $uas, $nilai_akhir, $grade, $id_krs
    );
    $stmt->execute();

    response(true, "Nilai berhasil diperbarui");
} else {
    // insert
    $stmt = $conn->prepare("
        INSERT INTO nilai (id_krs, tugas, kuis, uts, uas, nilai_akhir, grade)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "iiiiids",
        $id_krs, $tugas, $kuis, $uts, $uas, $nilai_akhir, $grade
    );
    $stmt->execute();

    response(true, "Nilai berhasil disimpan");
}

function hitungNilaiAkhir($tugas, $kuis, $uts, $uas) {
    return ($tugas * 0.20)
         + ($kuis * 0.20)
         + ($uts   * 0.25)
         + ($uas   * 0.35);
}

function hitungGrade($nilai) {
    if ($nilai >= 85) return "A";
    if ($nilai >= 75) return "B";
    if ($nilai >= 65) return "C";
    if ($nilai >= 50) return "D";
    return "E";
}

