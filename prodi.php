<?php
  session_start();
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  if(!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: index.php?p=Silahkan login terlebih dahulu!");
    exit();
  }
  include "koneksi.php";
  $data = mysqli_query($koneksi, "SELECT * FROM prodi");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="script.js"></script>
  <title>Data Prodi</title>
</head>
<body>
  <?php include "navigasi.php"; ?>
  <div id="main">
    <?php if ($_GET['status'] === 'success') echo 'Data berhasil disimpan!'; ?>
    <div class="container">
      <h2>Data Prodi</h2>
      <hr>
      <a href="tambah_prodi.php" class="tambah">Tambah Data Prodi</a>
      <br><br>
      <table>
        <tr>
          <th>Kode Prodi</th>
          <th>Nama Prodi</th>
          <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($data)) { ?>
        <tr>
          <td><?php echo $row['kd_prodi']; ?></td>
          <td><?php echo $row['nama_prodi']; ?></td>
          <td>
            <div class="btn-group">
              <a href="edit_prodi.php?id_prodi=<?php echo $row['id_prodi']; ?>" class="edit-btn"><i class="fa-solid fa-pen-to-square"></i>Edit</a>
              <a href="hapus_prodi.php?id_prodi=<?php echo $row['id_prodi']; ?>" class="hapus-btn" onclick="return confirm('Yakin ingin hapus?')"><i class="fa-solid fa-trash-alt"></i>Hapus</a>
            </div>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>
  </div>
</body>
</html>