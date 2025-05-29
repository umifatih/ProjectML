<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Hasil Klasifikasi</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
  <h2 class="mb-4">Hasil Klasifikasi</h2>
  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>Usia</th>
        <th>BMI</th>
        <th>Riwayat</th>
        <th>Aktivitas</th>
        <th>Hasil</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $q = $conn->query("SELECT * FROM data_uji_svm ORDER BY id DESC");
        while ($r = $q->fetch_assoc()) {
          echo "<tr>
                  <td>{$r['usia']}</td>
                  <td>{$r['bmi']}</td>
                  <td>{$r['riwayat']}</td>
                  <td>{$r['aktivitas']}</td>
                  <td>{$r['hasil']}</td>
                </tr>";
        }
      ?>
    </tbody>
  </table>
  <a href="index.php" class="btn btn-primary mt-3">← Kembali ke Form</a>
</body>
</html>
