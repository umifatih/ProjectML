<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Klasifikasi Naive Bayes</title>

    <!-- Bootstrap & DataTables -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: linear-gradient(to right, #eef2f3, #8e9eab);
            min-height: 100vh;
        }

        .content-card {
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 2rem;
            margin-top: 3rem;
        }

        canvas {
            margin: 20px auto;
            max-width: 600px;
        }

        h4.chart-title {
            margin-top: 2rem;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="content-card">
        <h2 class="text-center mb-4">📊 Hasil Klasifikasi Naive Bayes</h2>

        <!-- Tabel Hasil -->
        <div class="table-responsive mb-5">
            <table id="tabelHasil" class="table table-striped table-bordered">
                <thead class="table-dark text-center">
                <tr>
                    <th>Penghasilan</th>
                    <th>Tanggungan</th>
                    <th>Pekerjaan</th>
                    <th>Kepemilikan</th>
                    <th>Hasil</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM data_uji");
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>
                        <td>{$row['penghasilan']}</td>
                        <td>{$row['tanggungan']}</td>
                        <td>{$row['pekerjaan']}</td>
                        <td>{$row['kepemilikan']}</td>
                        <td><strong>{$row['hasil']}</strong></td>
                    </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

        <!-- Chart Distribusi Hasil -->
        <?php
        $layak = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM data_uji WHERE hasil='Layak'"))['jml'];
        $tidak = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM data_uji WHERE hasil='Tidak Layak'"))['jml'];
        ?>
        <h4 class="chart-title">📈 Distribusi Hasil Klasifikasi</h4>
        <div class="d-flex justify-content-center">
            <canvas id="chartDistribusi" height="200"></canvas>
        </div>

        <hr class="my-5">

        <!-- Chart Penghasilan -->
        <?php
        $dataPenghasilan = mysqli_query($conn, "SELECT penghasilan, COUNT(*) as jumlah FROM data_uji GROUP BY penghasilan");
        $labels = $jumlah = [];
        while ($row = mysqli_fetch_assoc($dataPenghasilan)) {
            $labels[] = $row['penghasilan'];
            $jumlah[] = $row['jumlah'];
        }
        ?>
        <h4 class="chart-title">📊 Distribusi Berdasarkan Penghasilan</h4>
        <div class="d-flex justify-content-center">
            <canvas id="chartPenghasilan" height="200"></canvas>
        </div>

        <hr class="my-5">

        <!-- Navigasi -->
        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <a href="./index.php" class="btn btn-success">🔄 Input Baru</a>
            <a href="../index.php" class="btn btn-light text-dark">🏠 Kembali ke Beranda</a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tabelHasil').DataTable();
    });

    const ctx = document.getElementById('chartDistribusi').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Layak', 'Tidak Layak'],
            datasets: [{
                label: 'Jumlah Data',
                data: [<?= $layak ?>, <?= $tidak ?>],
                backgroundColor: ['#4CAF50', '#F44336']
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });

    const ctx2 = document.getElementById('chartPenghasilan').getContext('2d');
    new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Jumlah',
                data: <?= json_encode($jumlah) ?>,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#8BC34A', '#9C27B0']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>

</body>
</html>
