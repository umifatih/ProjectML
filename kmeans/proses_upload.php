<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csv_file"])) {
    $file = $_FILES["csv_file"]["tmp_name"];
    if (($handle = fopen($file, "r")) !== FALSE) {
        fgetcsv($handle); // lewati header
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $fitur1 = floatval($data[0]);
            $fitur2 = floatval($data[1]);
            $stmt = $conn->prepare("INSERT INTO data_unlabeled (fitur1, fitur2) VALUES (?, ?)");
            $stmt->bind_param("dd", $fitur1, $fitur2);
            $stmt->execute();
            $stmt->close();
        }
        fclose($handle);
        header("Location: data.php?msg=upload_sukses");
    } else {
        echo "Gagal membuka file.";
    }
}
?>
