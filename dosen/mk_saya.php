<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

try {
    // 🔐 hanya dosen
    $user = roleGuard("dosen");

    $id_dosen = $user['ref_id'];

    /**
     * =========================
     * AMBIL MATA KULIAH DOSEN
     * =========================
     */
    $sql = "
        SELECT
            mk.id_matakuliah,
            mk.kode_mk,
            mk.nama_mk,
            mk.sks
        FROM matakuliah mk
        WHERE mk.id_dosen = ?
        ORDER BY mk.nama_mk ASC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_dosen);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    response(true, "Daftar mata kuliah yang saya ajar", $data);

} catch (Throwable $e) {
    response(false, "Internal Server Error", [
        "error_message" => $e->getMessage(),
        "error_file"    => $e->getFile(),
        "error_line"    => $e->getLine()
    ]);
}
