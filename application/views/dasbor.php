<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title> ~ </title>
</head>
<body>
  <?php
  echo "statuslogin :"; var_dump($_SESSION['statuslogin']); echo "<br>";
  echo $_SESSION['nama']. "<br>";
  echo $_SESSION['peran']. "<br>";

  unset($_SESSION['statusLogin']);
  unset($_SESSION['nama']);
  unset($_SESSION['peran']);
  ?>
</body>
</html>
