<?php
session_start();
$data = $_SESSION['original_data'] ?? $_SESSION['data'] ?? [];
$centroids = $_SESSION['centroids'] ?? [];
$k = $_SESSION['k'] ?? 0;

// Hitung SSE (Sum of Squared Error)
function calculateSSE($data, $centroids) {
    $sse = 0;
    foreach ($data as $d) {
        $c = $centroids[$d['cluster']];
        $distance = pow($d['fitur1'] - $c['fitur1'], 2) + pow($d['fitur2'] - $c['fitur2'], 2);
        $sse += $distance;
    }
    return $sse;
}
$sse = calculateSSE($data, $centroids);

// Elbow Method
function kMeans($data, $k, $iter = 100) {
    $centroids = array_slice($data, 0, $k);
    $clusters = [];

    for ($n = 0; $n < $iter; $n++) {
        foreach ($data as $i => $point) {
            $minDist = INF;
            $cluster = 0;
            foreach ($centroids as $j => $c) {
                $dist = pow($point['fitur1'] - $c['fitur1'], 2) + pow($point['fitur2'] - $c['fitur2'], 2);
                if ($dist < $minDist) {
                    $minDist = $dist;
                    $cluster = $j;
                }
            }
            $clusters[$i] = $cluster;
        }

        $sums = array_fill(0, $k, ['fitur1' => 0, 'fitur2' => 0, 'count' => 0]);
        foreach ($data as $i => $point) {
            $c = $clusters[$i];
            $sums[$c]['fitur1'] += $point['fitur1'];
            $sums[$c]['fitur2'] += $point['fitur2'];
            $sums[$c]['count'] += 1;
        }

        foreach ($sums as $j => $sum) {
            if ($sum['count'] > 0) {
                $centroids[$j]['fitur1'] = $sum['fitur1'] / $sum['count'];
                $centroids[$j]['fitur2'] = $sum['fitur2'] / $sum['count'];
            }
        }
    }

    $sse = 0;
    foreach ($data as $i => $point) {
        $c = $centroids[$clusters[$i]];
        $sse += pow($point['fitur1'] - $c['fitur1'], 2) + pow($point['fitur2'] - $c['fitur2'], 2);
    }

    return $sse;
}

$elbow_data = [];
for ($i = 1; $i <= 10; $i++) {
    $elbow_data[$i] = kMeans($data, $i);
}
$_SESSION['elbow'] = $elbow_data;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil K-Means</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #eef2f3, #8e9eab);
            min-height: 100vh;
        }
        .form-card {
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            background-color: #fff;
            padding: 2rem;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .btn:hover {
            transform: scale(1.02);
            transition: 0.2s ease;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-card">
                <h2 class="text-center mb-3">📊 Hasil K-Means Clustering</h2>
                <p class="text-center text-muted mb-4">Jumlah klaster digunakan: <strong>K = <?= $k ?></strong></p>

                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Fitur 1</th>
                                <th>Fitur 2</th>
                                <th>Klaster</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $d): ?>
                                <tr>
                                    <td><?= $d['id'] ?></td>
                                    <td><?= $d['fitur1'] ?></td>
                                    <td><?= $d['fitur2'] ?></td>
                                    <td><span class="badge bg-primary">Klaster <?= $d['cluster'] + 1 ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <h5 class="mt-4">Visualisasi Klaster</h5>
                <canvas id="chartKlaster" height="120"></canvas>

                <hr class="my-5">

                <h5 class="mt-4">📉 Elbow Method</h5>
                <p class="text-muted">Grafik berikut menunjukkan nilai SSE terhadap K, digunakan untuk menentukan jumlah klaster optimal.</p>
                <canvas id="elbowChart" height="100"></canvas>

                <div class="d-flex justify-content-center flex-wrap gap-2 my-4">
                    <a href="export.php" class="btn btn-outline-success px-4 py-2 d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-arrow-down"></i> Export CSV
                    </a>
                    <a href="index.php" class="btn btn-outline-secondary px-4 py-2 d-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left-circle"></i> Kembali
                    </a>
                    <a href="reset.php" class="btn btn-outline-danger px-4 py-2 d-flex align-items-center gap-2">
                        <i class="bi bi-trash3"></i> Reset Hasil
                    </a>
                </div>

                <p><strong>Total SSE:</strong> <?= number_format($sse, 4) ?></p>
            </div>
        </div>
    </div>
</div>

<script>
    const dataPoints = <?= json_encode($data) ?>;
    const centroids = <?= json_encode($centroids) ?>;
    const elbowData = <?= json_encode($elbow_data) ?>;
    const colors = ['#e6194b','#3cb44b','#ffe119','#4363d8','#f58231','#911eb4','#46f0f0','#f032e6','#bcf60c','#fabebe'];

    const ctxCluster = document.getElementById('chartKlaster').getContext('2d');
    const datasets = [];

    for (let i = 0; i < <?= $k ?>; i++) {
        const clusterData = dataPoints.filter(d => d.cluster === i);
        datasets.push({
            label: 'Klaster ' + (i + 1),
            data: clusterData.map(d => ({ x: d.fitur1, y: d.fitur2 })),
            backgroundColor: colors[i % colors.length],
            pointRadius: 5
        });
    }

    datasets.push({
        label: 'Centroid',
        data: centroids.map(c => ({ x: c.fitur1, y: c.fitur2 })),
        backgroundColor: 'black',
        pointStyle: 'triangle',
        pointRadius: 8
    });

    new Chart(ctxCluster, {
        type: 'scatter',
        data: { datasets },
        options: {
            plugins: { legend: { labels: { usePointStyle: true } } },
            scales: {
                x: { title: { display: true, text: 'Fitur 1' } },
                y: { title: { display: true, text: 'Fitur 2' } }
            }
        }
    });

    const elbowCtx = document.getElementById('elbowChart').getContext('2d');
    const labels = Object.keys(elbowData).map(k => 'K=' + k);
    const sseValues = Object.values(elbowData);

    new Chart(elbowCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'SSE vs K',
                data: sseValues,
                borderColor: 'blue',
                backgroundColor: 'rgba(0,123,255,0.1)',
                tension: 0.2,
                fill: true,
                pointRadius: 5
            }]
        },
        options: {
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: { title: { display: true, text: 'SSE' } },
                x: { title: { display: true, text: 'Jumlah Klaster (K)' } }
            }
        }
    });
</script>
</body>
</html>
