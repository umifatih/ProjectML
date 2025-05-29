<?php
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
    header("Location: data.php");
    exit();
}

// Ambil Semua Data
$result = $conn->query("SELECT * FROM data_unlabeled ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Data Unlabeled</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Manajemen Data Unlabeled</h2>

    <!-- Form Tambah / Edit -->
    <form method="POST" class="mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="fitur1" class="col-form-label">Fitur 1:</label>
            </div>
            <div class="col-auto">
                <input type="number" step="any" class="form-control" id="fitur1" name="fitur1" required value="<?= htmlspecialchars($fitur1) ?>">
            </div>
            <div class="col-auto">
                <label for="fitur2" class="col-form-label">Fitur 2:</label>
            </div>
            <div class="col-auto">
                <input type="number" step="any" class="form-control" id="fitur2" name="fitur2" required value="<?= htmlspecialchars($fitur2) ?>">
            </div>
            <div class="col-auto">
                <?php if ($edit_mode): ?>
                    <input type="hidden" name="id" value="<?= $_GET['edit'] ?>">
                    <button type="submit" name="update" class="btn btn-warning">Update</button>
                    <a href="data.php" class="btn btn-secondary">Batal</a>
                <?php else: ?>
                    <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <!-- Tabel Data -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fitur 1</th>
                <th>Fitur 2</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['fitur1'] ?></td>
                <td><?= $row['fitur2'] ?></td>
                <td>
                    <a href="data.php?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="data.php?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
