<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Data Kecamatan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff;
            /* AliceBlue for a light, bright background */
        }

        .navbar {
            background-color: #007bff;
            /* Bright blue for navbar */
        }

        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
        }

        .container {
            margin-top: 2rem;
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table {
            margin-top: 1.5rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3">Data Wilayah Kecamatan</h1>
            <a href='input/index.html' class="btn btn-primary">Input Data Baru</a>
        </div>

        <?php
        // Koneksi ke database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pgweb8";

        // membuat koneksi
        $conn = new mysqli($servername, $username, $password, $dbname);

        // cek koneksi
        if ($conn->connect_error) {
            die("<div class='alert alert-danger'>Koneksi Gagal: " . $conn->connect_error . "</div>");
        }

        $sql = "SELECT * FROM data_kecamatan";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<div class='table-responsive'>";
            echo "<table class='table table-striped table-hover'>
                    <thead class='table-primary'>
                        <tr>
                            <th>Kecamatan</th>
                            <th>Longitude</th>
                            <th>Latitude</th>
                            <th>Luas (km²)</th>
                            <th>Jumlah Penduduk</th>
                        </tr>
                    </thead>
                    <tbody>";

            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["kecamatan"]) . "</td>
                        <td>" . htmlspecialchars($row["longitude"]) . "</td>
                        <td>" . htmlspecialchars($row["latitude"]) . "</td>
                        <td>" . htmlspecialchars($row["luas"]) . "</td>
                        <td class='text-end'>" . number_format($row["jumlah_penduduk"]) . "</td>
                    </tr>";
            }
            echo "</tbody></table></div>";
        } else {
            echo "<div class='alert alert-info'>Tidak ada data untuk ditampilkan. Silakan input data baru.</div>";
        }
        $conn->close();
        ?>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Praktikum PGWEB-8 | M. Ivan Firmansyah</p>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>