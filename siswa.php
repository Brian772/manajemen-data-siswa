<?php
session_start();
header("Cache-control: no-cache, must-revalidate, max-age=0");
if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
  header("location: index.php?p=Silahkan login terlebih dahulu");
  exit();
}
include "koneksi.php";
$keyword = "";
if (isset($_GET['cari'])) {
  $keyword = $_GET['cari'];
  $data = mysqli_query($koneksi, "SELECT s.*, p.nama_prodi FROM siswa s JOIN prodi p ON s.kd_prodi=p.kd_prodi WHERE s.nama LIKE '%$keyword%' OR s.nis LIKE '%$keyword%' ORDER BY s.id DESC");
} else {
  // Jika tidak mencari, tampilkan semua
  $data = mysqli_query($koneksi, "SELECT s.*, p.nama_prodi FROM siswa s JOIN prodi p ON s.kd_prodi=p.kd_prodi ORDER BY s.id DESC");
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
</head>

<body>
  <?php include "navigasi.php"; ?>
  <div id="main">
    <div class="container container-siswa">
      <h2>Data Siswa</h2>
      <hr>
      <div class="header-action">
        <a href="tambah_siswa.php" class="tambah">Tambah Data Siswa</a>

        <form method="GET" action="siswa.php" class="form-cari">
          <input type="text" name="cari" placeholder="Cari NIS atau Nama..." value="<?php echo htmlspecialchars($keyword); ?>">
          <button type="submit" class="btn-cari"><i class="fas fa-search"></i> Cari</button>
          <?php if ($keyword != "") { ?>
            <a href="siswa.php" class="btn-reset">Reset</a>
          <?php } ?>
        </form>
      </div>
      <br><br>
      <div class="tabel-responsif">
        <table class="tabel-siswa">
          <tr>
            <th>Foto</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Tahun Ajaran</th>
            <th>Prodi</th>
            <th>Jenis Kelamin</th>
            <th>Actions</th>
          </tr>
          <?php while ($row = mysqli_fetch_assoc($data)) { ?>
            <tr>
              <td>
                <?php if (!empty($row['foto'])) { ?>
                  <img src="img/<?php echo $row['foto']; ?>" class="foto-profil" alt="Foto">
                <?php } else { ?>
                  <span style="font-size: 12px; color: #888;">Tidak ada foto</span>
                <?php } ?>
              </td>
              <td><?php echo $row['nis']; ?></td>
              <td><?php echo $row['nama']; ?></td>
              <td><?php echo $row['kelas']; ?></td>
              <td><?php echo $row['tahun_ajaran']; ?></td>
              <td><?php echo $row['nama_prodi']; ?></td>
              <td><?php echo $row['jenis_kelamin']; ?></td>
              <td>
                <div class="btn-group">
                  <a href="edit_siswa.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                  <a href="hapus_siswa.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin hapus?')" class="hapus-btn">Delete</a>
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