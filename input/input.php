<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Input Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
        }
        .container {
            margin-top: 2rem;
            max-width: 600px;
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .footer {
            text-align: center;
            padding: 1rem 0;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                Portal Data Statistik Kecamatan
            </a>
        </div>
    </nav>

    <div class="container">
        <?php
        $kecamatan = $_POST['kecamatan'];
        $longitude = $_POST['longitude'];
        $latitude = $_POST['latitude'];
        $luas = $_POST['luas'];
        $jumlah_penduduk = $_POST['jumlah_penduduk'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pgweb8";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("<div class='alert alert-danger'><h4>Koneksi Gagal</h4><p>" . $conn->connect_error . "</p></div>");
        }

        // Menggunakan prepared statement untuk keamanan
        $stmt = $conn->prepare("INSERT INTO data_kecamatan (kecamatan, longitude, latitude, luas, jumlah_penduduk) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssddi", $kecamatan, $longitude, $latitude, $luas, $jumlah_penduduk);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'><h4>Data Berhasil Disimpan!</h4><p>Informasi kecamatan telah berhasil ditambahkan ke database.</p></div>";
        } else {
            echo "<div class='alert alert-danger'><h4>Terjadi Kesalahan</h4><p>Error: " . $stmt->error . "</p></div>";
        }

        $stmt->close();
        $conn->close();
        ?>
        <div class="mt-4">
            <a href="index.html" class="btn btn-primary">Tambah Data Lagi</a>
            <a href="../index.php" class="btn btn-secondary">Lihat Semua Data</a>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Instansi XYZ. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>