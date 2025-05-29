<?php
include 'koneksi.php';
include 'model.php';

// Ambil data dari form
$usia = $_POST['usia'];
$bmi = $_POST['bmi'];
$riwayat = $_POST['riwayat'];
$aktivitas = $_POST['aktivitas'];

// Validasi input sederhana
$valid_usia = ['<30', '30-50', '>50'];
$valid_bmi = ['Normal', 'Pre-Obesitas', 'Obesitas'];
$valid_riwayat = ['Ya', 'Tidak'];
$valid_aktivitas = ['Tinggi', 'Sedang', 'Rendah'];

if (
    !in_array($usia, $valid_usia) ||
    !in_array($bmi, $valid_bmi) ||
    !in_array($riwayat, $valid_riwayat) ||
    !in_array($aktivitas, $valid_aktivitas)
) {
    echo "Input tidak valid.";
    exit;
}

// Proses klasifikasi
$hasil = klasifikasiSVM($usia, $bmi, $riwayat, $aktivitas);

// Simpan ke tabel data_uji_svm
$sql = "INSERT INTO data_uji_svm (usia, bmi, riwayat, aktivitas, hasil) 
        VALUES ('$usia', '$bmi', '$riwayat', '$aktivitas', '$hasil')";

if ($conn->query($sql) === TRUE) {
    header("Location: hasil.php");
    exit;
} else {
    echo "Gagal menyimpan data: " . $conn->error;
}
?>
