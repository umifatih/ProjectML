<?php
include 'koneksi.php';

function prior($data, $label) {
    $query = "SELECT COUNT(*) as total FROM data_training WHERE label='$label'";
    $result = mysqli_fetch_assoc(mysqli_query($data, $query));
    return $result['total'];
}

function conditional($data, $atribut, $nilai, $label) {
    $query = "SELECT COUNT(*) as total FROM data_training 
              WHERE $atribut='$nilai' AND label='$label'";
    $result = mysqli_fetch_assoc(mysqli_query($data, $query));
    return $result['total'];
}

function klasifikasi($data, $input) {
    $labels = ['Layak', 'Tidak Layak'];
    $atribut = ['penghasilan', 'tanggungan', 'pekerjaan', 'kepemilikan'];

    $total_data = mysqli_fetch_assoc(mysqli_query($data, "SELECT COUNT(*) as total FROM data_training"))['total'];

    if ($total_data == 0) {
        die("Error: Data training kosong. Tambahkan data terlebih dahulu.");
    }

    $hasil = [];
    foreach ($labels as $label) {
        $prior_label = prior($data, $label);
        if ($prior_label == 0) {
            continue;
        }

        $probabilitas = $prior_label / $total_data;

        foreach ($atribut as $a) {
            $numerator = conditional($data, $a, $input[$a], $label);
            $denominator = $prior_label;
            $probabilitas *= ($numerator + 1) / ($denominator + count($labels)); // Laplace smoothing
        }

        $hasil[$label] = $probabilitas;
    }

    if (empty($hasil)) {
        return "Tidak dapat diklasifikasikan";
    }

    arsort($hasil);
    return key($hasil);
}
?>
