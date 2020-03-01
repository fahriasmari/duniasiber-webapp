<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title> ~ </title>
</head>
<body>
  <h3> daftar pengguna </h3>
  <?php
  if(isset($pesanErr)) {
  ?>
    <h4 style="color: red;"> <?= $pesanErr ?> </h4>
  <?php
  }
  ?>
  <form action="http://127.0.0.1/duniasiber/index.php/Autentikasi/daftarAkun" method="post">
    <label> nama </label>
      <input type="text" name="namaTxt"> <br>
    <label> email </label>
      <input type="text" name="emailTxt"> <br>
    <label> username </label>
      <input type="text" name="usernameTxt"> <br>
    <label> password </label>
      <input type="text" name="passwordTxt">
      <input type="text" name="ulangipasswordTxt" placeholder="ulangi password"> <br>
    <input type="submit" value="Daftar">
  </form>
</body>
</html>
