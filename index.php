<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Data Kecamatan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
    <style>
        :root{
            --primary:#007bff;
            --accent:#00a2ff;
            --muted:#6c757d;
            --table-header-grad: linear-gradient(90deg,#00a2ff,#007bff);
        }

        body{
            background: linear-gradient(180deg,#f6fbff,#ffffff);
            font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color:#222;
        }

        .navbar{
            background: var(--primary);
            box-shadow: 0 4px 14px rgba(0,123,255,0.15);
        }

        .navbar-brand{ color:#fff !important; font-weight:700; letter-spacing:0.2px }

        .container{
            margin-top:1.75rem;
            background: #fff;
            padding:1.5rem;
            border-radius:10px;
            box-shadow: 0 6px 30px rgba(3, 19, 63, 0.06);
        }

        #map {
            height: 400px;
            margin-bottom: 1.5rem;
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
        <div class="text-center mb-3">
            <h1 class="h3">Data Wilayah Kecamatan</h1>
        </div>
        <div class="d-flex justify-content-end mb-3">
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
                            <th colspan='2'>Aksi</th>
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
                        <td><a href=hapus.php?id=" . $row["id"] . " class='btn btn-danger'>Hapus</a></td>
                        <td><a href=edit.php?id=" . $row["id"] . " class='btn btn-warning'>Edit</a></td>
                    </tr>";
            }
            echo "</tbody></table></div>";
        } else {
            echo "<div class='alert alert-info'>Tidak ada data untuk ditampilkan. Silakan input data baru.</div>";
        }
        $conn->close();
        ?>

        <h1 class="h3 mt-5">Peta Wilayah Kecamatan</h1>
        <div id="map"></div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Praktikum PGWEB-8 | M. Ivan Firmansyah</p>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    var map = L.map('map').setView([-7.7956, 110.3695], 10); // Center map on Yogyakarta

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    const blueIcon = L.icon({
        iconUrl: `data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='32' height='32'%3E%3Cpath fill='%23007bff' d='M12 0C7.589 0 4 3.589 4 8c0 4.411 8 16 8 16s8-11.589 8-16c0-4.411-3.589-8-8-8zm0 12c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z'/%3E%3C/svg%3E`,
        iconSize: [32, 32],
        iconAnchor: [16, 32],
        popupAnchor: [0, -32]
    });

    fetch('get_data.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(function(row) {
                if (row.latitude && row.longitude) {
                    var marker = L.marker([row.latitude, row.longitude], {icon: blueIcon}).addTo(map);
                    marker.bindPopup(
                        `<b>Kecamatan:</b> ${row.kecamatan}<br>` +
                        `<b>Luas:</b> ${row.luas} km²<br>` +
                        `<b>Jumlah Penduduk:</b> ${Number(row.jumlah_penduduk).toLocaleString()}`
                    );
                    marker.bindTooltip(row.kecamatan);
                }
            });
        });
    </script>
</body>

</html>