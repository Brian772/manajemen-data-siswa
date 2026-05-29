<?php

  $host = "localhost";
  $username = "root";
  $password = "";
  $database = "db_penilaian";
  
  $koneksi = mysqli_connect($host, $username, $password, $database);
  
  if ($koneksi) {
    $pilih_db = mysqli_select_db($koneksi, $database);
    if ($pilih_db) {
      //echo "databases terpilih!";
    } 
  } else {
    echo "koneksi gagal, silahkan coba lagi";
  }

?>