<?php
$file = $_GET['file'] ?? '';
if (!file_exists($file)) die("File tidak ditemukan!");

$data = array_map('str_getcsv', file($file));
?>

<table border="1">
    <thead>
        <tr>
            <?php foreach ($data[0] as $header): ?>
                <th><?= htmlspecialchars($header) ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach (array_slice($data, 1) as $row): ?>
            <tr>
                <?php foreach ($row as $cell): ?>
                    <td><?= htmlspecialchars($cell) ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
