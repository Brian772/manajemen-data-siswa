<?php
session_start();
include "koneksi.php";
$id = $_GET['id'];

$cek = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id='$id'");
$data = mysqli_fetch_assoc($cek);

if (!$data){
    header("location: siswa.php?p=data tidak ditemukan");
    exit();
}

$hapus = mysqli_query($koneksi, "DELETE FROM siswa WHERE id='$id'");
if ($hapus){
    header("location: siswa.php?success=hapus");
    exit();
}else{
    header("location: siswa.php?p=data gagal dihapus");
    exit();
}
