<?php
session_start();
$data = $_SESSION['original_data'] ?? $_SESSION['data'] ?? [];

function kMeans($data, $k, $iter = 100) {
    $centroids = array_slice($data, 0, $k);
    $clusters = [];

    for ($n = 0; $n < $iter; $n++) {
        // Assign data ke klaster terdekat
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

        // Update centroid
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

    // Hitung SSE
    $sse = 0;
    foreach ($data as $i => $point) {
        $c = $centroids[$clusters[$i]];
        $sse += pow($point['fitur1'] - $c['fitur1'], 2) + pow($point['fitur2'] - $c['fitur2'], 2);
    }

    return $sse;
}

$sseData = [];
for ($i = 1; $i <= 10; $i++) {
    $sseData[] = kMeans($data, $i);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Elbow Method</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-4">
    <h2>Elbow Method</h2>
    <p>Grafik berikut menunjukkan hubungan antara nilai K dan SSE (Sum of Squared Error).</p>
    <canvas id="elbowChart" height="100"></canvas>
</div>

<script>
const ctx = document.getElementById('elbowChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: [...Array(10).keys()].map(i => i + 1),
        datasets: [{
            label: 'SSE vs K',
            data: <?= json_encode($sseData) ?>,
            borderColor: 'blue',
            fill: false,
            tension: 0.2
        }]
    },
    options: {
        scales: {
            x: { title: { display: true, text: 'Jumlah Klaster (K)' }},
            y: { title: { display: true, text: 'SSE' }}
        }
    }
});
</script>
</body>
</html>
