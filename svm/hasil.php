<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Klasifikasi Diabetes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #eef2f3, #8e9eab);
            min-height: 100vh;
        }

        .result-card {
            background-color: #fff;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="result-card">
                <h2 class="text-center mb-4">📊 Hasil Klasifikasi Diabetes</h2>
                <p class="text-center text-muted">Berikut adalah data hasil klasifikasi dengan metode SVM</p>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
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
                            if ($q->num_rows > 0) {
                                while ($r = $q->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$r['usia']}</td>
                                            <td>{$r['bmi']}</td>
                                            <td>{$r['riwayat']}</td>
                                            <td>{$r['aktivitas']}</td>
                                            <td><strong>{$r['hasil']}</strong></td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center text-muted'>Belum ada data klasifikasi.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-grid mt-4">
                    <a href="index.php" class="btn btn-primary btn-lg">← Kembali ke Form Klasifikasi</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
