<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Prediksi Diabetes (SVM)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #eef2f3, #8e9eab);
            min-height: 100vh;
        }

        .form-card {
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 2rem;
        }

        select:invalid {
            color: #6c757d;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="form-card">
                <h2 class="text-center mb-3">🧬 Prediksi Diabetes dengan SVM</h2>
                <p class="text-center text-muted">Masukkan data uji untuk memprediksi risiko diabetes</p>

                <form method="POST" action="simpan_uji.php">
                    <div class="mb-3">
                        <label class="form-label">Usia:</label>
                        <select name="usia" class="form-select" required>
                            <option disabled selected value="">-- Pilih Usia --</option>
                            <option value="<30">&lt;30</option>
                            <option value="30-50">30-50</option>
                            <option value=">50">&gt;50</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">BMI:</label>
                        <select name="bmi" class="form-select" required>
                            <option disabled selected value="">-- Pilih BMI --</option>
                            <option value="Normal">Normal</option>
                            <option value="Pre-Obesitas">Pre-Obesitas</option>
                            <option value="Obesitas">Obesitas</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Riwayat Keluarga:</label>
                        <select name="riwayat" class="form-select" required>
                            <option disabled selected value="">-- Pilih Jawaban --</option>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Aktivitas:</label>
                        <select name="aktivitas" class="form-select" required>
                            <option disabled selected value="">-- Pilih Aktivitas --</option>
                            <option value="Tinggi">Tinggi</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Rendah">Rendah</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">🧪 Klasifikasi</button>
                    </div>
                </form>

                <hr class="my-4">

                <div class="d-grid gap-2">
                    <a href="hasil.php" class="btn btn-warning">📋 Lihat Hasil Prediksi</a>
                    <a href="../index.php" class="btn btn-light text-dark">🏠 Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
