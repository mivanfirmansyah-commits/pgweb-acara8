<?php
header('Content-Type: application/json');

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgweb8";

// membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// cek koneksi
if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}

$sql = "SELECT id, kecamatan, longitude, latitude, luas, jumlah_penduduk FROM data_kecamatan";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

echo json_encode($data);
?>