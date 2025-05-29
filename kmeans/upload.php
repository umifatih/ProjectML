<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload CSV</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>📤 Upload Data CSV</h3>
    <form method="POST" action="proses_upload.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="csv_file" class="form-label">Pilih File CSV:</label>
            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
        <a href="data.php" class="btn btn-secondary">Kembali ke Data Manual</a>
    </form>
</div>
</body>
</html>
