<?php
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>K-Means Clustering</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #eef2f3, #8e9eab);
            min-height: 100vh;
        }

        .tab-btn {
            width: 150px;
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
        }

        .form-card {
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 2rem;
        }

        .tab-btn.active {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="form-card">
                <h2 class="text-center mb-3">🧠 Sistem K-Means Clustering</h2>
                <p class="text-center text-muted">Silakan pilih metode input data untuk dilakukan clustering</p>

                <!-- Tombol tab -->
                <div class="d-flex justify-content-center my-4">
                    <button class="btn btn-outline-primary mx-2 tab-btn active" id="btnManual" onclick="showForm('manual')">Input Manual</button>
                    <button class="btn btn-outline-success mx-2 tab-btn" id="btnUpload" onclick="showForm('upload')">Upload CSV</button>
                </div>

                <!-- Form Input Manual -->
                <div id="form-manual" class="form-section active">
                    <form method="POST" action="proses_kmeans.php">
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Fitur 1:</label>
                                <input type="number" step="any" name="fitur1" class="form-control" required>
                            </div>
                            <div class="col">
                                <label class="form-label">Fitur 2:</label>
                                <input type="number" step="any" name="fitur2" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nilai K (jumlah klaster):</label>
                            <input type="number" name="k" class="form-control" required min="1">
                        </div>
                        <button type="submit" name="submit_manual" class="btn btn-primary w-100">🔍 Proses Manual</button>
                    </form>
                </div>

                <!-- Form Upload CSV -->
                <div id="form-upload" class="form-section">
                    <form method="POST" action="proses_kmeans.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Upload file CSV:</label>
                            <input type="file" name="file_csv" class="form-control" accept=".csv" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nilai K (jumlah klaster):</label>
                            <input type="number" name="k" class="form-control" required min="1">
                        </div>
                        <button type="submit" name="submit_csv" class="btn btn-success w-100">📤 Proses dari CSV</button>
                    </form>
                </div>

               <hr class="my-4">
                <div class="d-grid gap-2">
                    <a href="data.php" class="btn btn-warning">📋 Lihat & Kelola Data</a>
                    <a href="/semester4/Kecerdasan Buatan/Program ML/index.php" class="btn btn-light text-dark">🏠 Kembali ke Beranda</a>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function showForm(type) {
        // Nonaktifkan semua form
        document.getElementById('form-manual').classList.remove('active');
        document.getElementById('form-upload').classList.remove('active');

        // Nonaktifkan semua tombol
        document.getElementById('btnManual').classList.remove('active');
        document.getElementById('btnUpload').classList.remove('active');

        // Tampilkan form yang dipilih dan aktifkan tombolnya
        if (type === 'manual') {
            document.getElementById('form-manual').classList.add('active');
            document.getElementById('btnManual').classList.add('active');
        } else {
            document.getElementById('form-upload').classList.add('active');
            document.getElementById('btnUpload').classList.add('active');
        }
    }
</script>

</body>
</html>
