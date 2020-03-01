<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title> ~ </title>
</head>
<body>
  <h3> verifikasi password </h3>
<?php
if(isset($pesan) && isset($kirimUlangEmail)) {
  echo $pesan;
  echo $kirimUlangEmail;
}

if(isset($statusVerifikasi)) {
  echo $statusVerifikasi;
}
?>
</body>
</html>
