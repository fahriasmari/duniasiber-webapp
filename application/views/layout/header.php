<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <title> <?= $title ?> </title>                                                <!-- judul halaman -->
  <?php
  if($frameworkCss == "adminlte") {                                             // dependency yang dipakai dalam template adminlte
  ?>

  <!-- ( belum ada module adminlte yang di pakai di sini ! ) -->

  <?php
  }else if($frameworkCss == "bootstrap") {                                      // depedency yang dipakai dalam framework css: bootstrap4
  ?>

  <!-- meta tag -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- bootstrap.min.css -->
  <link rel="stylesheet" href="<?= base_url("assets/vendor/bootstrap-441/dist/css/bootstrap.min.css") ?>">

  <!-- pertama jquery, kemudian popper.js, lalu bootstrap.min.js -->
  <!-- jquery -->
  <script src="<?= base_url("assets/vendor/jquery/jquery-341.js") ?>"> </script>
  <!-- popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"> </script>
  <!-- bootstrap.min.js -->
  <script src="<?= base_url("assets/vendor/bootstrap-441/dist/js/bootstrap.min.js") ?>"> </script>
  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/265f0f514f.js" crossorigin="anonymous"> </script>

  <?php
  }
  ?>
</head>
<body class="">
