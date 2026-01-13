<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

try {
    // 🔐 hanya mahasiswa
    $user = roleGuard("mahasiswa");

    $id_mahasiswa = $user['ref_id'];

    /**
     * =========================
     * AMBIL SEMUA KRS MAHASISWA
     * =========================
     */
    $sql = "
        SELECT
            k.id_krs,
            mk.id_matakuliah,
            mk.kode_mk,
            mk.nama_mk,
            mk.sks,
            d.id_dosen,
            d.nama AS nama_dosen
        FROM krs k
        JOIN matakuliah mk ON mk.id_matakuliah = k.id_matakuliah
        LEFT JOIN dosen d ON d.id_dosen = mk.id_dosen
        WHERE k.id_mahasiswa = ?
        ORDER BY mk.nama_mk ASC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_mahasiswa);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    response(true, "Daftar KRS saya", $data);

} catch (Throwable $e) {
    response(false, "Internal Server Error", [
        "error_message" => $e->getMessage(),
        "error_file"    => $e->getFile(),
        "error_line"    => $e->getLine()
    ]);
}
