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
    die("Koneksi Gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $kecamatan = $_POST['kecamatan'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];
    $luas = $_POST['luas'];
    $jumlah_penduduk = $_POST['jumlah_penduduk'];

    $sql = "UPDATE data_kecamatan SET kecamatan=?, longitude=?, latitude=?, luas=?, jumlah_penduduk=? WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $kecamatan, $longitude, $latitude, $luas, $jumlah_penduduk, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM data_kecamatan WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Kecamatan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Data Kecamatan</h2>
        <form action="edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="mb-3">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?php echo $row['kecamatan']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude" value="<?php echo $row['longitude']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" value="<?php echo $row['latitude']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="luas" class="form-label">Luas (km²)</label>
                <input type="number" step="0.01" class="form-control" id="luas" name="luas" value="<?php echo $row['luas']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="jumlah_penduduk" class="form-label">Jumlah Penduduk</label>
                <input type="number" class="form-control" id="jumlah_penduduk" name="jumlah_penduduk" value="<?php echo $row['jumlah_penduduk']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>