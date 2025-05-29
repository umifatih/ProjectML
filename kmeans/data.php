<?php
session_start();
include 'koneksi.php';

// Inisialisasi variabel
$fitur1 = $fitur2 = "";
$edit_mode = false;

// Tambah Data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {
    $fitur1 = $_POST['fitur1'];
    $fitur2 = $_POST['fitur2'];
    $stmt = $conn->prepare("INSERT INTO data_unlabeled (fitur1, fitur2) VALUES (?, ?)");
    $stmt->bind_param("dd", $fitur1, $fitur2);
    $stmt->execute();
    $stmt->close();
    $_SESSION['msg'] = "Data berhasil ditambahkan!";
    header("Location: data.php");
    exit();
}

// Hapus Data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $stmt = $conn->prepare("DELETE FROM data_unlabeled WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['msg'] = "Data berhasil dihapus!";
    header("Location: data.php");
    exit();
}

// Ambil Data untuk Edit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_mode = true;
    $stmt = $conn->prepare("SELECT * FROM data_unlabeled WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data_edit = $result->fetch_assoc();
    $fitur1 = $data_edit['fitur1'];
    $fitur2 = $data_edit['fitur2'];
    $stmt->close();
}

// Update Data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $fitur1 = $_POST['fitur1'];
    $fitur2 = $_POST['fitur2'];
    $stmt = $conn->prepare("UPDATE data_unlabeled SET fitur1 = ?, fitur2 = ? WHERE id = ?");
    $stmt->bind_param("ddi", $fitur1, $fitur2, $id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['msg'] = "Data berhasil diupdate!";
    header("Location: data.php");
    exit();
}

// Upload CSV
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload_csv'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $filename = $_FILES['csv_file']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if ($ext !== 'csv') {
            $_SESSION['msg'] = "❌ File harus berformat .csv!";
            header("Location: data.php");
            exit();
        }

        $file = fopen($_FILES['csv_file']['tmp_name'], 'r');
        fgetcsv($file); // skip header
        $rowCount = 0;
        $invalidCount = 0;

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 2 || !is_numeric($row[0]) || !is_numeric($row[1])) {
                $invalidCount++;
                continue;
            }
            $fitur1 = (float)$row[0];
            $fitur2 = (float)$row[1];
            $stmt = $conn->prepare("INSERT INTO data_unlabeled (fitur1, fitur2) VALUES (?, ?)");
            $stmt->bind_param("dd", $fitur1, $fitur2);
            $stmt->execute();
            $stmt->close();
            $rowCount++;
        }
        fclose($file);

        $_SESSION['msg'] = "✅ $rowCount baris berhasil diunggah. ❌ $invalidCount baris diabaikan karena format tidak valid.";
        header("Location: data.php");
        exit();
    }
}

// Ambil Semua Data
$result = $conn->query("SELECT * FROM data_unlabeled ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .table-container {
            overflow-x: auto;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="form-card">
        <h2 class="text-center mb-4">📋 Manajemen Data Unlabeled</h2>

        <?php if (isset($_SESSION['msg'])): ?>
            <div class="alert alert-info text-center"><?= $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
        <?php endif; ?>

        <!-- Tabel -->
        <div class="table-container mb-4">
            <table class="table table-striped table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Fitur 1</th>
                        <th>Fitur 2</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $dataChart = []; while ($row = $result->fetch_assoc()): $dataChart[] = ['x' => $row['fitur1'], 'y' => $row['fitur2']]; ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['fitur1'] ?></td>
                        <td><?= $row['fitur2'] ?></td>
                        <td>
                            <a href="data.php?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
                            <a href="data.php?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">🗑️</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Chart -->
        <canvas id="scatterChart" height="100"></canvas>
        <script>
        const ctx = document.getElementById('scatterChart').getContext('2d');
        new Chart(ctx, {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Data Unlabeled',
                    data: <?= json_encode($dataChart) ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: {
                scales: {
                    x: { title: { display: true, text: 'Fitur 1' }},
                    y: { title: { display: true, text: 'Fitur 2' }}
                }
            }
        });
        </script>

        <!-- Form Manual dan CSV -->
        <div class="row mt-4">
            <div class="col-md-6">
                <h5><?= $edit_mode ? '✏️ Edit Data' : '➕ Tambah Data' ?></h5>
                <form method="POST">
                    <div class="mb-3">
                        <input type="number" name="fitur1" step="any" class="form-control" placeholder="Fitur 1" value="<?= htmlspecialchars($fitur1) ?>" required>
                    </div>
                    <div class="mb-3">
                        <input type="number" name="fitur2" step="any" class="form-control" placeholder="Fitur 2" value="<?= htmlspecialchars($fitur2) ?>" required>
                    </div>
                    <div>
                        <?php if ($edit_mode): ?>
                            <input type="hidden" name="id" value="<?= $_GET['edit'] ?>">
                            <button name="update" class="btn btn-warning w-100">🔄 Update</button>
                            <a href="data.php" class="btn btn-secondary w-100 mt-2">❌ Batal</a>
                        <?php else: ?>
                            <button name="tambah" class="btn btn-primary w-100">➕ Tambah</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <h5>📤 Upload CSV</h5>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="file" name="csv_file" accept=".csv" class="form-control" required>
                    </div>
                    <button name="upload_csv" class="btn btn-success w-100">⬆️ Upload CSV</button>
                </form>
            </div>
        </div>

        <!-- Navigasi -->
        <div class="mt-4 text-center">
            <a href="index.php" class="btn btn-outline-success">🔍 Proses K-Means</a>
            <form method="POST" action="proses_kmeans.php" class="d-inline">
                <input type="hidden" name="k" value="3">
                <button class="btn btn-outline-info">🔁 Cluster Otomatis (K=3)</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
