<?php
include 'koneksi.php';
include 'naive_bayes.php';

$query = mysqli_query($conn, "SELECT * FROM data_uji");

while ($row = mysqli_fetch_assoc($query)) {
    $input = [
        'penghasilan' => $row['penghasilan'],
        'tanggungan' => $row['tanggungan'],
        'pekerjaan' => $row['pekerjaan'],
        'kepemilikan' => $row['kepemilikan']
    ];

    $hasil = klasifikasi($conn, $input);
    mysqli_query($conn, "UPDATE data_uji SET hasil='$hasil' WHERE id={$row['id']}");
}

echo "Klasifikasi selesai.";
?>
