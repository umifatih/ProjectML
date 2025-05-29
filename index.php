<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kecerdasan Buatan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right,  #eef2f3, #8e9eab);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 90%;
        }

        img {
            width: 100px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        p {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .button-group {
            margin-top: 25px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .button-group a {
            background-color: #0C0950;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .button-group a:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        @media (max-width: 480px) {
            .card {
                padding: 20px;
            }

            h2 {
                font-size: 20px;
            }

            .button-group a {
                padding: 8px 14px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="card">
    <img src="logo.png" alt="Logo">
    <h2>Kecerdasan Buatan</h2>
    <p><strong>Nama:</strong> Umi Fatihaturrohmah</p>
    <p><strong>NIM:</strong> 234110601047</p>

    <div class="button-group">
        <a href="kmeans/index.php">🔶 K-Means</a>
        <a href="svm/index.php">⚙️ SVM</a>
        <a href="bayes/index.php">📊 Naive Bayes</a>
        <a href="#">🧠 ANN</a>
    </div>
</div>

</body>
</html>
