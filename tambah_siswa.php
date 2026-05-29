<?php
session_start();
include "koneksi.php";
$prodi = mysqli_query($koneksi, "SELECT * FROM prodi");
$error = "";

if (isset($_POST['simpan'])){
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $tahun_ajaran = $_POST['tahun_ajaran'];
    $kd_prodi = $_POST['kd_prodi'];
    $jk = $_POST['jk'];

    if(empty($nis) || empty($nama)){
        $error = "Data Wajib diisi!";
    }else{
        mysqli_query($koneksi, "INSERT INTO siswa (nis, nama, kelas, tahun_ajaran, kd_prodi, jenis_kelamin) VALUES ('$nis', '$nama', '$kelas', '$tahun_ajaran', '$kd_prodi', '$jk')");
        header("location: siswa.php");
        exit();
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
        <div><?php echo htmlspecialchars($error); ?></div>
        <br>
    <form method="POST">
    <table>
        <tr>
            <td>NIS</td>
            <td>
                <input type="text" name="nis" required>
            </td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>
                <input type="text" name="nama" required>
            </td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>
                <input type="text" name="kelas">
            </td>
        </tr>
        <tr>
            <td>Tahun Ajaran</td>
            <td>
                <input type="text" name="tahun_ajaran">
            </td>
        </tr>
        <tr>
            <td>Program Studi</td>
            <td>
                <select name="kd_prodi" required>
                    <?php while($p = mysqli_fetch_assoc($prodi)){ ?>
                        <option value="<?php echo $p['kd_prodi']; ?>">
                            <?php echo $p['nama_prodi']; ?>
                        </option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>
                <input type="radio" name="jk" value="L"> Laki-Laki
                <input type="radio" name="jk" value="P"> Perempuan
            </td>
        </tr>
        <tr>
            <td><button type="submit" name="simpan" class="submit">SUBMIT</button></td>
            <td>
                <a href="siswa.php" class="cancel" style="float: right;">BATAL</a>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
