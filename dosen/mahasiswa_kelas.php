<?php
require_once "../config/database.php";
require_once "../utils/response.php";
require_once "../utils/auth.php";

try {
    // 🔐 hanya dosen
    $user = roleGuard("dosen");

    $id_dosen = $user['ref_id'];

    // ambil id_matakuliah dari query param
    $id_matakuliah = $_GET['id_matakuliah'] ?? null;

    if (!$id_matakuliah) {
        response(false, "id_matakuliah wajib diisi");
    }

    /**
     * =========================
     * VALIDASI MK MILIK DOSEN
     * =========================
     */
    $cek = $conn->prepare("
        SELECT id_matakuliah
        FROM matakuliah
        WHERE id_matakuliah = ? AND id_dosen = ?
    ");
    $cek->bind_param("ii", $id_matakuliah, $id_dosen);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows === 0) {
        response(false, "Mata kuliah bukan milik dosen ini");
    }

    /**
     * =========================
     * LIST MAHASISWA PER MK
     * =========================
     */
    $sql = "
        SELECT
            m.id_mahasiswa,
            m.nim,
            m.nama,
            m.kelas,
            m.jurusan
        FROM krs k
        JOIN mahasiswa m ON m.id_mahasiswa = k.id_mahasiswa
        WHERE k.id_matakuliah = ?
        ORDER BY m.nama ASC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_matakuliah);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    response(true, "Daftar mahasiswa per mata kuliah", $data);

} catch (Throwable $e) {
    response(false, "Internal Server Error", [
        "error_message" => $e->getMessage(),
        "error_file"    => $e->getFile(),
        "error_line"    => $e->getLine()
    ]);
}
