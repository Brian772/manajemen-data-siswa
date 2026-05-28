<?php
  session_start();
  include "koneksi.php";
  $id_prodi = $_GET['id_prodi'];
  $query = mysqli_query($koneksi, "SELECT * FROM prodi WHERE id_prodi='$id_prodi'");
  $data = mysqli_fetch_assoc($query);

  $error="";
  if(isset($_POST['update'])) {
    $kd_prodi = $_POST['kd_prodi'];
    $nama_prodi = $_POST['nama_prodi'];

    mysqli_query($koneksi, "UPDATE prodi SET kd_prodi='$kd_prodi', nama_prodi='$nama_prodi' WHERE id_prodi='$id_prodi'");
    header("Location: prodi.php");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Edit Prodi</title>
</head>
<body>
  <div class="container">
    <h2>Edit Prodi</h2>
    <form method="POST">
      <div class="form-group">
        <label>Kode Prodi :</label>
        <input type="text" name="kd_prodi" value="<?php echo $data['kd_prodi']; ?>" required>
      </div>
      <div class="form-group">
        <label>Nama Prodi :</label>
        <input type="text" name="nama_prodi" value="<?php echo $data['nama_prodi']; ?>" required>
      </div>
      <br>
      <div class="btn-group">
        <input type="submit" name="update" class="submit" value="Update">
        <a href="prodi.php" class="cancel">Batal</a>
      </div>
    </form>
  </div>
</body>
</html>