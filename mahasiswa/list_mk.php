<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

try {
    // 🔐 hanya mahasiswa
    $user = roleGuard("mahasiswa");

    /**
     * =========================
     * QUERY LIST MATA KULIAH
     * =========================
     */
    $sql = "
        SELECT 
            mk.id_matakuliah,
            mk.kode_mk,
            mk.nama_mk,
            mk.sks,
            d.id_dosen,
            d.nama AS nama_dosen
        FROM matakuliah mk
        LEFT JOIN dosen d ON d.id_dosen = mk.id_dosen
        ORDER BY mk.nama_mk ASC
    ";

    $result = $conn->query($sql);

    if (!$result) {
        response(false, "Query gagal", [
            "mysql_error" => $conn->error,
            "sql" => $sql
        ]);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    response(true, "Daftar mata kuliah", $data);

} catch (Throwable $e) {
    // 🔥 DEBUG ERROR 500
    response(false, "Internal Server Error", [
        "error_message" => $e->getMessage(),
        "error_file"    => $e->getFile(),
        "error_line"    => $e->getLine()
    ]);
}
