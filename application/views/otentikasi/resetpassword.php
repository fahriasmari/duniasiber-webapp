<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title> ~ </title>
</head>
<body>
  <h3> reset password </h3>
  <?php
  if(isset($pesan)) {
  ?>
    <b> <?= $pesan ?> </b>
  <?php
  }else if(isset($pesanErr)) {
  ?>
    <h4 style="color: red;"> <?= $pesanErr ?> </h4>
  <?php
  }

  if( isset($_SESSION['statusResetPass']) ) {
  ?>
    <form action="http://127.0.0.1/duniasiber/index.php/Autentikasi/lupaPassword" method="post">
      <label> masukkan password baru </label>
        <input type="text" name="passwordTxt">
        <input type="text" name="ulangipasswordTxt">
      <input type="submit" value="kirim">
    </form>
  <?php
  }else {
  ?>
    <form action="http://127.0.0.1/duniasiber/index.php/Autentikasi/lupaPassword" method="post">
      <label> masukkan email </label>
        <input type="text" name="emailTxt"> <br>
      <input type="submit" value="kirim">
    </form>
  <?php
  }
  ?>
</body>
</html>
