<?php
  session_start();
  include "koneksi.php";
  $error = "";
  $success = "";

  if (isset($_POST['simpan'])) {
    $kd_prodi = $_POST['kd_prodi'];
    $nama_prodi = $_POST['nama_prodi'];

    $cek = mysqli_query($koneksi, "SELECT * FROM prodi WHERE kd_prodi='$kd_prodi'");
    if (empty($kd_prodi) || empty($nama_prodi)) {
      $error = "Semua field harus diisi!";
    } elseif (mysqli_num_rows($cek) > 0) {
      $error = "Kode Prodi sudah digunakan!";
    } else {
      mysqli_query($koneksi, "INSERT INTO prodi VALUES (NULL, '$kd_prodi', '$nama_prodi')");
      header("Location: prodi.php");
      exit();
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Tambah Prodi</title>
</head>
<body>
  <div class="container">
    <h2>Tambah Prodi</h2>
     <div><?php echo htmlspecialchars($error); ?></div>
     <br>
    <form method="POST">
      <div class="form-group">
        <label>Kode Prodi :</label>
        <input type="text" name="kd_prodi" required>
      </div>
      <div class="form-group">
        <label>Nama Prodi :</label>
        <input type="text" name="nama_prodi" required>
      </div>
      <br>
      <div class="btn-group">
        <input type="submit" name="simpan" class="submit" value="Simpan">
        <a href="prodi.php" class="cancel">Batal</a>
      </div>
    </form>
  </div>
</body>
</html>