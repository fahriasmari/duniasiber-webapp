<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title> ~ </title>
</head>
<body>
  <h3> login </h3>
  <?php
  if(isset($pesanErr)) {
  ?>
    <h4 style="color: red;"> <?= $pesanErr ?> </h4>
  <?php
  }
  ?>
  <form action="http://127.0.0.1/duniasiber/index.php/Autentikasi/loginAkun" method="post">
    <label> username/email </label>
      <input type="text" name="userTxt"> <br>
    <label> Password </label>
      <input type="text" name="passwordTxt"> <br>
    <a href="http://127.0.0.1/duniasiber/index.php/Autentikasi/daftarAkun"> Daftar </a> <br>
    <a href="http://127.0.0.1/duniasiber/index.php/Autentikasi/lupaPassword"> Lupa Password? </a> <br>
    <input type="submit" value="login">
  </form>
</body>
</html>
