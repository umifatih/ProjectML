<?php
include 'koneksi.php';
include 'naive_bayes.php';

$penghasilan = ['Rendah', 'Sedang', 'Tinggi'];
$tanggungan = ['Sedikit', 'Sedang', 'Banyak'];
$pekerjaan = ['Tetap', 'Kontrak', 'Tidak Ada'];
$kepemilikan = ['Sewa', 'Kontrak', 'Milik Sendiri'];

foreach ($penghasilan as $p) {
    foreach ($tanggungan as $t) {
        foreach ($pekerjaan as $pe) {
            foreach ($kepemilikan as $k) {
                $input = [
                    'penghasilan' => $p,
                    'tanggungan' => $t,
                    'pekerjaan' => $pe,
                    'kepemilikan' => $k
                ];

                $hasil = klasifikasi($conn, $input);
                echo "<p><strong>Input:</strong> Penghasilan=$p, Tanggungan=$t, Pekerjaan=$pe, Kepemilikan=$k => <strong>Hasil:</strong> $hasil</p>";
            }
        }
    }
}
?>
