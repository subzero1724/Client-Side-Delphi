<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

try {
    // 🔐 hanya mahasiswa
    $user = roleGuard("mahasiswa");

    $data = json_decode(file_get_contents("php://input"), true);

    $id_mahasiswa  = $user['ref_id'];
    $id_matakuliah = $data['id_matakuliah'] ?? null;

    if (!$id_matakuliah) {
        response(false, "id_matakuliah wajib diisi");
    }

    /**
     * =========================
     * CEK SUDAH AMBIL / BELUM
     * =========================
     */
    $cek = $conn->prepare("
        SELECT id_krs
        FROM krs
        WHERE id_mahasiswa = ? AND id_matakuliah = ?
    ");
    $cek->bind_param("ii", $id_mahasiswa, $id_matakuliah);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        response(false, "Mata kuliah sudah diambil");
    }

    /**
     * =========================
     * INSERT KRS
     * =========================
     */
    $stmt = $conn->prepare("
        INSERT INTO krs (id_mahasiswa, id_matakuliah)
        VALUES (?, ?)
    ");
    $stmt->bind_param("ii", $id_mahasiswa, $id_matakuliah);
    $stmt->execute();

    $id_krs = $conn->insert_id;

    /**
     * =========================
     * AMBIL DETAIL MATA KULIAH
     * =========================
     */
    $detail = $conn->prepare("
        SELECT
            mk.id_matakuliah,
            mk.kode_mk,
            mk.nama_mk,
            mk.sks,
            d.id_dosen,
            d.nama AS nama_dosen
        FROM matakuliah mk
        LEFT JOIN dosen d ON d.id_dosen = mk.id_dosen
        WHERE mk.id_matakuliah = ?
    ");
    $detail->bind_param("i", $id_matakuliah);
    $detail->execute();
    $result = $detail->get_result();
    $mk = $result->fetch_assoc();

    response(true, "Berhasil mengambil mata kuliah", [
        "id_krs" => $id_krs,
        "mata_kuliah" => $mk
    ]);

} catch (Throwable $e) {
    response(false, "Internal Server Error", [
        "error_message" => $e->getMessage(),
        "error_file"    => $e->getFile(),
        "error_line"    => $e->getLine()
    ]);
}
