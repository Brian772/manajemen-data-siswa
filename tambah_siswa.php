<?php
session_start();
include "koneksi.php";
$prodi = mysqli_query($koneksi, "SELECT * FROM prodi");

$nis = $nama = $kelas = $tahun_ajaran = $kd_prodi = $jk = "";
$nisErr = $namaErr = $kelasErr = $tahun_ajaranErr = $kd_prodiErr = $jkErr = "";

if (isset($_POST['simpan'])) {
	$valid = true;

	if (empty($_POST['nis'])) {
		$nisErr = "NIS tidak boleh kosong";
		$valid = false;
	} else {
		$nis = $_POST['nis'];
		$query = "SELECT * FROM siswa WHERE nis='$nis'";
		$result = mysqli_query($koneksi, $query);
		if (mysqli_num_rows($result) > 0) {
			$nisErr = "NIS sudah ada";
			$valid = false;
		}
	}

	if (empty($_POST['nama'])) {
		$namaErr = "Nama tidak boleh kosong";
		$valid = false;
	} else {
		$nama = $_POST['nama'];
	}

	if (empty($_POST['kelas'])) {
		$kelasErr = "Kelas tidak boleh kosong";
		$valid = false;
	} else {
		$kelas = $_POST['kelas'];
	}

	if (empty($_POST['tahun_ajaran'])) {
		$tahun_ajaranErr = "Tahun Ajaran tidak boleh kosong";
		$valid = false;
	} else {
		$tahun_ajaran = $_POST['tahun_ajaran'];
	}

	if (empty($_POST['kd_prodi'])) {
		$kd_prodiErr = "Program Studi tidak boleh kosong";
		$valid = false;
	} else {
		$kd_prodi = $_POST['kd_prodi'];
	}

	if (empty($_POST['jk'])) {
		$jkErr = "Jenis Kelamin tidak boleh kosong";
		$valid = false;
	} else {
		$jk = $_POST['jk'];
	}

	$foto = "";
	$tmp = "";
	if (isset($_FILES['foto'])) {
		$foto = $_FILES['foto']['name'];
		$tmp = $_FILES['foto']['tmp_name'];
	}

	if ($valid) {
		if (!empty($foto)) {
			$foto_baru = date('YmdHis') . '_' . $foto;
			move_uploaded_file($tmp, "img/" . $foto_baru);
			$foto = $foto_baru;
		} else {
			$foto = "";
		}
		
		$query = "INSERT INTO siswa (nis, nama, kelas, tahun_ajaran, kd_prodi, jenis_kelamin, foto) VALUES ('$nis', '$nama', '$kelas', '$tahun_ajaran', '$kd_prodi', '$jk', '$foto')";
		if (mysqli_query($koneksi, $query)) {
			header("location: siswa.php?success=tambah");
        exit();
		} else {
			echo "Error: " . mysqli_error($koneksi);
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Tambah Data Siswa</title>
	<link rel="stylesheet" href="style.css">

</head>

<body>
	<div class="container">
		<h2>Tambah Data Siswa</h2>
		<br>
		<form method="POST" enctype="multipart/form-data">
			<form method="POST">
				<div class="form-group">
					<label>NIS</label>
					<input type="text" name="nis" value="<?php echo htmlspecialchars($nis); ?>">
					<span class="error"><?php echo htmlspecialchars($nisErr); ?></span>
				</div>

				<div class="form-group">
					<label>Nama</label>
					<input type="text" name="nama" value="<?php echo htmlspecialchars($nama); ?>">
					<span class="error"><?php echo htmlspecialchars($namaErr); ?></span>
				</div>

				<div class="form-group">
					<label>Kelas</label>
					<input type="text" name="kelas" value="<?php echo htmlspecialchars($kelas); ?>">
					<span class="error"><?php echo htmlspecialchars($kelasErr); ?></span>
				</div>

				<div class="form-group">
					<label>Tahun Ajaran</label>
					<input type="text" name="tahun_ajaran" value="<?php echo htmlspecialchars($tahun_ajaran); ?>">
					<span class="error"><?php echo htmlspecialchars($tahun_ajaranErr); ?></span>
				</div>

				<div class="form-group">
					<label>Program Studi</label>
					<select name="kd_prodi">
						<option value="">-- Pilih Prodi --</option>
						<?php
						mysqli_data_seek($prodi, 0);
						while ($p = mysqli_fetch_assoc($prodi)) {
							$selected = ($kd_prodi == $p['kd_prodi']) ? "selected" : "";
						?>
							<option value="<?php echo $p['kd_prodi']; ?>" <?php echo $selected; ?>>
								<?php echo $p['nama_prodi']; ?>
							</option>
						<?php } ?>
					</select>
					<span class="error"><?php echo htmlspecialchars($kd_prodiErr); ?></span>
				</div>

				<div class="form-group">
					<label>Jenis Kelamin</label>
					<div class="radio-group">
						<label class="radio-label">
							<input type="radio" name="jk" value="L" <?php if ($jk == "L") echo "checked"; ?>> Laki-Laki
						</label>
						<label class="radio-label">
							<input type="radio" name="jk" value="P" <?php if ($jk == "P") echo "checked"; ?>> Perempuan
						</label>
					</div>
					<span class="error"><?php echo htmlspecialchars($jkErr); ?></span>
				</div>

				<div class="form-group">
					<label>Foto (opsional)</label>
					<input type="file" name="foto" accept="image/*" style="margin: 12px 0 32px 0;">
				</div>
				<br>

				<div class="btn-group">
					<button type="submit" name="simpan" class="submit">SUBMIT</button>
					<a href="siswa.php" class="cancel">BATAL</a>
				</div>
			</form>
		</form>
</body>

</html>