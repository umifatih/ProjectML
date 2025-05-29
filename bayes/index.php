<?php
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Naive Bayes Classifier</title>
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
                <h2 class="text-center mb-3">🤖 Klasifikasi Naive Bayes</h2>
                <p class="text-center text-muted">Masukkan data uji untuk diklasifikasikan menggunakan metode Naive Bayes</p>

                <form action="simpan_uji.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Penghasilan:</label>
                        <select name="penghasilan" class="form-select" required>
                            <option disabled selected value="">-- Pilih Penghasilan --</option>
                            <option value="Rendah">Rendah</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Tinggi">Tinggi</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggungan:</label>
                        <select name="tanggungan" class="form-select" required>
                            <option disabled selected value="">-- Pilih Jumlah Tanggungan --</option>
                            <option value="Sedikit">Sedikit</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Banyak">Banyak</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pekerjaan:</label>
                        <select name="pekerjaan" class="form-select" required>
                            <option disabled selected value="">-- Pilih Status Pekerjaan --</option>
                            <option value="Tetap">Tetap</option>
                            <option value="Kontrak">Kontrak</option>
                            <option value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Kepemilikan Rumah:</label>
                        <select name="kepemilikan" class="form-select" required>
                            <option disabled selected value="">-- Pilih Status Kepemilikan --</option>
                            <option value="Sewa">Sewa</option>
                            <option value="Kontrak">Kontrak</option>
                            <option value="Milik Sendiri">Milik Sendiri</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">💾 Simpan dan Klasifikasikan</button>
                    </div>
                </form>

                <hr class="my-4">

                <div class="d-grid gap-2">
                    <a href="hasil.php" class="btn btn-warning">📋 Lihat Data Uji</a>
                    <a href="../index.php" class="btn btn-light text-dark">🏠 Kembali ke Beranda</a>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>
