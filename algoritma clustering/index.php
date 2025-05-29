<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>K-Means Clustering</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Penerapan Metode K-Means Clustering</h2>
    <form method="POST" action="proses_kmeans.php">
        <div class="mb-3">
            <label for="k" class="form-label">Masukkan Nilai K (Jumlah Klaster):</label>
            <input type="number" class="form-control" id="k" name="k" required min="1">
        </div>
        <button type="submit" class="btn btn-primary">Proses K-Means</button>
    </form>
<br>
    <a href="data.php"><button class="btn btn-warning">DATA</button></a>
</div>
</body>
</html>
