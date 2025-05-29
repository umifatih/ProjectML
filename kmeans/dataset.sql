CREATE DATABASE IF NOT EXISTS db_kmeans;
USE db_kmeans;

CREATE TABLE IF NOT EXISTS data_unlabeled (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fitur1 FLOAT,
    fitur2 FLOAT
);

INSERT INTO data_unlabeled (fitur1, fitur2) VALUES
(5.1, 3.5),
(4.9, 3.0),
(6.2, 3.4),
(6.5, 3.0),
(5.7, 2.8),
(6.3, 3.3),
(5.0, 3.4),
(6.1, 2.8),
(5.8, 2.7),
(6.0, 3.0);

CREATE TABLE data_uji (
    id INT AUTO_INCREMENT PRIMARY KEY,
    penghasilan VARCHAR(20),
    tanggungan VARCHAR(20),
    pekerjaan VARCHAR(20),
    kepemilikan VARCHAR(20),
    hasil VARCHAR(20) -- diisi setelah klasifikasi
);

CREATE TABLE data_training (
    id INT AUTO_INCREMENT PRIMARY KEY,
    penghasilan VARCHAR(20),
    tanggungan VARCHAR(20),
    pekerjaan VARCHAR(20),
    kepemilikan VARCHAR(20),
    label VARCHAR(20) -- Layak atau Tidak Layak
);
SELECT COUNT(*) FROM data_training;

SELECT penghasilan, tanggungan, pekerjaan, kepemilikan, label, COUNT(*) as jumlah
FROM data_training
GROUP BY penghasilan, tanggungan, pekerjaan, kepemilikan, label;
