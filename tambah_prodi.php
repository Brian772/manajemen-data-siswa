<?php
  session_start();
  include "koneksi.php";
  $error = "";
  $kd_prodi = $nama_prodi = "";
  $kd_prodiError = $nama_prodiError = "";

  if (isset($_POST['simpan'])) {
    $valid = true;

    if (empty($_POST['kd_prodi'])) {
      $kd_prodiError = "Kode Prodi tidak boleh kosong";
      $valid = false;
    } else {
      $kd_prodi = $_POST['kd_prodi'];
      $query = "SELECT * FROM prodi WHERE kd_prodi='$kd_prodi'";
      $result = mysqli_query($koneksi, $query);
      if (mysqli_num_rows($result) > 0) {
        $kd_prodiError = "Kode Prodi sudah ada";
        $valid = false;
      }
    }

    if (empty($_POST['nama_prodi'])) {
      $nama_prodiError = "Nama Prodi tidak boleh kosong";
      $valid = false;
    } else {
      $nama_prodi = $_POST['nama_prodi'];
    }

    if($valid) {
      $query = "INSERT INTO prodi (kd_prodi, nama_prodi) VALUES ('$kd_prodi', '$nama_prodi')";
      if (mysqli_query($koneksi, $query)) {
        header("location: prodi.php?success=tambah");
        exit();
      } else {
        $error = "Error: " . mysqli_error($koneksi);
      }
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
        <input type="text" name="kd_prodi" value="<?php echo htmlspecialchars($kd_prodi); ?>">
        <span class="error"><?php echo htmlspecialchars($kd_prodiError); ?></span>
      </div>
      <div class="form-group">
        <label>Nama Prodi :</label>
        <input type="text" name="nama_prodi" value="<?php echo htmlspecialchars($nama_prodi); ?>">
        <span class="error"><?php echo htmlspecialchars($nama_prodiError); ?></span>
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