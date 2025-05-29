<?php
session_start();
$data = $_SESSION['data'] ?? [];

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="hasil_klaster.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'Fitur 1', 'Fitur 2', 'Klaster']);

foreach ($data as $d) {
    fputcsv($output, [$d['id'], $d['fitur1'], $d['fitur2'], $d['cluster'] + 1]);
}
fclose($output);
exit;
