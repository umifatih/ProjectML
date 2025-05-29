<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Prediksi Diabetes</title>
  <script src="assets/bootstrap.min.js"></script>
</head>
<body>
  <h2>Form Data Uji</h2>
  <form method="POST" action="simpan_uji.php">
    <label>Usia</label>
    <select name="usia" required>
      <option value="<30"><30</option>
      <option value="30-50">30-50</option>
      <option value=">50">>50</option>
    </select><br>

    <label>BMI</label>
    <select name="bmi" required>
      <option value="Normal">Normal</option>
      <option value="Pre-Obesitas">Pre-Obesitas</option>
      <option value="Obesitas">Obesitas</option>
    </select><br>

    <label>Riwayat Keluarga</label>
    <select name="riwayat" required>
      <option value="Ya">Ya</option>
      <option value="Tidak">Tidak</option>
    </select><br>

    <label>Aktivitas</label>
    <select name="aktivitas" required>
      <option value="Tinggi">Tinggi</option>
      <option value="Sedang">Sedang</option>
      <option value="Rendah">Rendah</option>
    </select><br>

    <button type="submit">Klasifikasi</button>
  </form>
</body>
</html>