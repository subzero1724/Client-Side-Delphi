<?php
require_once "../config/database.php";
require_once "../utils/response.php";

$data = json_decode(file_get_contents("php://input"), true);

$nim      = $data['nim'];
$nama     = $data['nama'];
$kelas    = $data['kelas'];
$jurusan  = $data['jurusan'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);

// mulai transaksi
$conn->begin_transaction();

try {
    // insert mahasiswa (DITAMBAH jurusan)
    $stmt = $conn->prepare(
        "INSERT INTO mahasiswa (nim, nama, kelas, jurusan) VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("ssss", $nim, $nama, $kelas, $jurusan);
    $stmt->execute();

    $id_mahasiswa = $conn->insert_id;

    // insert user
    $stmt = $conn->prepare(
        "INSERT INTO users (username, password, role, ref_id)
         VALUES (?, ?, 'mahasiswa', ?)"
    );
    $stmt->bind_param("ssi", $nim, $password, $id_mahasiswa);
    $stmt->execute();

    $conn->commit();
    response(true, "Mahasiswa & akun berhasil dibuat");

} catch (Exception $e) {
    $conn->rollback();
    response(false, "Gagal membuat mahasiswa");
}
