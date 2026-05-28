<?php 
  session_start();
  $_SESSION['login'] = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>PANEL LOGIN</h2>
    <hr>
    <form action="cek_login.php" method="post">
      <div class="form-group">
        <label>Username :</label>
        <input type="text" name="username" placeholder="Masukkan username">
      </div>
      <div class="form-group">
        <label>Password :</label>
        <input type="password" name="pass" placeholder="Masukkan password">
      </div>
      <div class="btn-group">
        <button type="submit" class="submit">LOGIN</button>
      </div>
    </form>
  </div>
</body>
</html>