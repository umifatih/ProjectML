<?php
include 'koneksi.php';
include 'naive_bayes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = [
        'penghasilan' => $_POST['penghasilan'],
        'tanggungan' => $_POST['tanggungan'],
        'pekerjaan' => $_POST['pekerjaan'],
        'kepemilikan' => $_POST['kepemilikan'],
    ];

    $hasil = klasifikasi($conn, $input);

    $query = "INSERT INTO data_uji (penghasilan, tanggungan, pekerjaan, kepemilikan, hasil)
              VALUES (
                  '{$input['penghasilan']}',
                  '{$input['tanggungan']}',
                  '{$input['pekerjaan']}',
                  '{$input['kepemilikan']}',
                  '$hasil'
              )";

    mysqli_query($conn, $query);

    header("Location: hasil.php");
    exit;
}
?>
