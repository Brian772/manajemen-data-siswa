<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("location: index.php?p=Silahkan login terlebih dahulu");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Halaman Home</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <?php include "navigasi.php"; ?>
    <div id="main">
        <div>
            <h2>APLIKASI MANAJEMEN DATA SISWA</H2>
            <hr>
            <p>Selamat datang di aplikasi Data Siswa SMK PGRI 3 Malang</p>
            <hr>
            <?php
                date_default_timezone_set('Asia/Jakarta');
                echo "Hari ini: " . date("l, d-m-Y");
            ?>
        </div>
    </div>
</body>
</html>