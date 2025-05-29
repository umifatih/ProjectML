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
