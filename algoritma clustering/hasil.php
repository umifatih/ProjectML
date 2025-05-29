<?php
session_start();
$data = $_SESSION['data'] ?? [];
$centroids = $_SESSION['centroids'] ?? [];
$k = $_SESSION['k'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil K-Means Clustering</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Hasil K-Means Clustering (K = <?= $k ?>)</h2>
    <table class="table table-bordered mt-3">
        <thead>
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
                <td><?= $d['cluster'] + 1 ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <canvas id="chartKlaster" height="100"></canvas>
</div>

<script>
const ctx = document.getElementById('chartKlaster');
const dataPoints = <?= json_encode($data) ?>;
const colors = ['red', 'blue', 'green', 'orange', 'purple', 'cyan', 'magenta', 'yellow', 'black', 'gray'];

const datasets = [];
for (let i = 0; i < <?= $k ?>; i++) {
    const clusterData = dataPoints.filter(d => d.cluster === i);
    datasets.push({
        label: 'Klaster ' + (i + 1),
        data: clusterData.map(d => ({ x: d.fitur1, y: d.fitur2 })),
        backgroundColor: colors[i % colors.length]
    });
}

new Chart(ctx, {
    type: 'scatter',
    data: {
        datasets: datasets
    },
    options: {
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Fitur 1'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Fitur 2'
                }
            }
        }
    }
});
</script>
</body>
</html>
