<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
  header("Location: index.php?p=Silahkan login terlebih dahulu!");
  exit();
}
include "koneksi.php";
$keyword = "";
if (isset($_GET['cari'])) {
  $keyword = $_GET['cari'];
  $data = mysqli_query($koneksi, "SELECT * FROM prodi WHERE kd_prodi LIKE '%$keyword%' OR nama_prodi LIKE '%$keyword%' ORDER BY id_prodi DESC");
} else {
  $data = mysqli_query($koneksi, "SELECT * FROM prodi ORDER BY id_prodi DESC");
}
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
    <div class="container container-main">
      <h2>Data Prodi</h2>
      <hr>

      <?php
      if (isset($_GET['success'])) {
        if ($_GET['success'] == 'tambah') {
      ?>
          <p class="success"> Data berhasil di tambahkan!</p>
        <?php
        }

        if ($_GET['success'] == 'edit') {
        ?>
          <p class="success">Data berhasil diubah!</p>
        <?php
        }

        if ($_GET['success'] == 'hapus') {
        ?>
          <p class="success">Data berhasil dihapus!</p>
      <?php
        }
      }
      ?>
      <script>
        setTimeout(function() {
          var successMessage = document.querySelector(".success");
          if (successMessage) {
            successMessage.style.display = "none";
            window.history.replaceState({}, document.title, "prodi.php");
          }
        }, 3000);
      </script>

      <div class="header-action">
        <a href="tambah_prodi.php" class="tambah">Tambah Data Prodi</a>
        <form method="GET" action="prodi.php" class="form-cari">
          <input type="text" name="cari" placeholder="Cari Kode atau Nama Prodi..." value="<?php echo htmlspecialchars($keyword); ?>">
          <button type="submit" class="btn-cari"><i class="fas fa-search"></i> Cari</button>
          <?php if ($keyword != "") { ?>
            <a href="prodi.php" class="btn-reset">Reset</a>
          <?php } ?>
        </form>
      </div>
      <br><br>
      <div class="tabel-responsif">
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
  </div>
</body>

</html>