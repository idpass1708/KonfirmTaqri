<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nomor_wa = $_POST['nomor_wa'];

    // Cek apakah nomor WA sudah terdaftar
    $cek_query = "SELECT * FROM peserta WHERE nomor_wa = '$nomor_wa'";
    $result = $conn->query($cek_query);

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Nomor WhatsApp sudah terdaftar!"]);
    } else {
        // Tentukan juz
        $last_juz_query = "SELECT juz FROM peserta ORDER BY id DESC LIMIT 1";
        $last_juz_result = $conn->query($last_juz_query);
        $juzTerakhir = ($last_juz_result->num_rows > 0) ? ($last_juz_result->fetch_assoc()["juz"] % 30) + 1 : 1;

        // Simpan ke database
        $insert_query = "INSERT INTO peserta (nama, nomor_wa, juz) VALUES ('$nama', '$nomor_wa', '$juzTerakhir')";
        if ($conn->query($insert_query)) {
            // Kirim ke WhatsApp
            $wa_link = "https://wa.me/6289656433788?text=Konfirmasi%20kehadiran%3A%20$nama%20telah%20terdaftar%20untuk%20membaca%20Juz%20$juzTerakhir.";
            echo json_encode(["status" => "success", "message" => "Kehadiran berhasil disimpan!", "juz" => $juzTerakhir, "wa_link" => $wa_link]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal menyimpan data!"]);
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
    $password = $_POST['password'];
    if ($password === "taqri123") {
        $conn->query("TRUNCATE TABLE peserta");
        echo json_encode(["status" => "success", "message" => "Daftar peserta berhasil direset!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Password salah!"]);
    }
}
?>
