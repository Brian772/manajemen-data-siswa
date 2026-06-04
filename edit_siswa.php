<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "koneksi.php";

if (!isset($_SESSION['login'])) {
  header("location: index.php");
  exit();
}
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id='$id'");
$data = mysqli_fetch_assoc($query);
$prodi = mysqli_query($koneksi, "SELECT * FROM prodi");

if (isset($_POST['update'])) {
  $nis = $_POST['nis'];
  $nama = $_POST['nama'];
  $kelas = $_POST['kelas'];
  $tahun_ajaran = $_POST['tahun_ajaran'];
  $kd_prodi = $_POST['kd_prodi'];
  $jk = $_POST['jenis_kelamin'];

  $foto = $_FILES['foto']['name'];
  $tmp = $_FILES['foto']['tmp_name'];
  if (!empty($foto)) {
    $foto_baru = date('dmYHis') . '_' . $foto;
    move_uploaded_file($tmp, "img/" . $foto_baru);
    $foto = $foto_baru;
  } else {
    $foto = $data['foto'];
  }

  mysqli_query($koneksi, "UPDATE siswa SET 
    nis='$nis', 
    nama='$nama', 
    kelas='$kelas', 
    tahun_ajaran='$tahun_ajaran', 
    kd_prodi='$kd_prodi', 
    jenis_kelamin='$jk',
    foto='$foto'
    WHERE id='$id'");

  header("location: siswa.php?success=edit");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="script.js"></script>
  <title>Edit Data Siswa</title>
</head>

<body>
  <div class="main">
    <div class="container">
      <h2>Edit Data Siswa</h2>
      <hr>
      <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label>NIS</label>
          <input type="text" name="nis" value="<?php echo $data['nis']; ?>" required>
        </div>

        <div class="form-group">
          <label>Nama</label>
          <input type="text" name="nama" value="<?php echo $data['nama']; ?>" required>
        </div>

        <div class="form-group">
          <label>Kelas</label>
          <input type="text" name="kelas" value="<?php echo $data['kelas']; ?>" required>
        </div>

        <div class="form-group">
          <label>Tahun Ajaran</label>
          <input type="text" name="tahun_ajaran" value="<?php echo $data['tahun_ajaran']; ?>">
        </div>

        <div class="form-group">
          <label>Program Studi</label>
          <select name="kd_prodi" required>
            <option value="">-- Pilih Prodi --</option>
            <?php
            // Merapikan logika pilihan dropdown agar tidak terlalu banyak tag PHP yang terputus-putus
            while ($p = mysqli_fetch_assoc($prodi)) {
              $selected = ($p['kd_prodi'] == $data['kd_prodi']) ? "selected" : "";
            ?>
              <option value="<?php echo $p['kd_prodi']; ?>" <?php echo $selected; ?>>
                <?php echo $p['nama_prodi']; ?>
              </option>
            <?php
            }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label>Jenis Kelamin</label>
          <div class="radio-group">
            <label class="radio-label">
              <input type="radio" name="jenis_kelamin" value="L" <?php if ($data['jenis_kelamin'] == 'L') echo "checked"; ?>> Laki-Laki
            </label>
            <label class="radio-label">
              <input type="radio" name="jenis_kelamin" value="P" <?php if ($data['jenis_kelamin'] == 'P') echo "checked"; ?>> Perempuan
            </label>
          </div>
        </div>

        <div class="form-profil">
          <label>Foto (opsional)</label><br>
          <div class="profil">
            <?php if (!empty($data['foto'])) { ?>
              <img src="img/<?php echo $data['foto']; ?>" id="preview" class="foto-profil" alt="Foto">
            <?php } else { ?>
              <img src="" id="preview" class="foto-profil" style="display: none;" alt="Preview Foto">
            <?php } ?>
            <input type="file" name="foto" id="input-foto" accept="image/*" onchange="previewFoto()">
          </div>
          <script>
            function previewFoto() {
              const input = document.getElementById('input-foto');
              const preview = document.getElementById('preview');

              if (input.files && input.files[0]) {
                const fileURL = URL.createObjectURL(input.files[0]);
                preview.src = fileURL;
                preview.style.display = 'block';
              }
            }
          </script>
        </div>

        <br>

        <div class="btn-group">
          <button type="submit" name="update" class="submit">UPDATE</button>
          <a href="siswa.php" class="cancel">BATAL</a>
        </div>
      </form>
    </div>
  </div>
</body>

</html>