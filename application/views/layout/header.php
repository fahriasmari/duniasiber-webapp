<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <title> <?= $title ?> </title>                                                <!-- judul halaman -->
  <?php
  if($frameworkCss == "adminlte") {                                             // dependency yang dipakai dalam template adminlte
  ?>

  <!-- meta tag -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- adminlte.min.css -->
  <link rel="stylesheet" href="<?= base_url("assets/vendor/adminlte-302/dist/css/adminlte.min.css") ?>">
  <!-- font awesome -->
  <link rel="stylesheet" href="<?= base_url("assets/vendor/fontawesome-5130/css/all.css") ?>">
  <!-- ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- google font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- google font: Audiowide (signature brand font) -->
  <link href="https://fonts.googleapis.com/css?family=Audiowide" rel="stylesheet">

  <!-- jquery -->
  <script src="<?= base_url("assets/vendor/jquery/jquery-341.js") ?>"> </script>
  <!-- bootstrap 4 (adminlte) -->
  <script src="<?= base_url("assets/vendor/adminlte-302/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>"> </script>
  <!-- adminlte.js -->
  <script src="<?= base_url("assets/vendor/adminlte-302/dist/js/adminlte.js") ?>"> </script>
  <!-- demo.js (AdminLTE for demo purposes) -->
  <script src="<?= base_url("assets/vendor/adminlte-302/dist/js/demo.js") ?>"> </script>

  <?php
  }else if($frameworkCss == "bootstrap") {                                      // depedency yang dipakai dalam framework css: bootstrap4
  ?>

  <!-- meta tag -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- bootstrap.min.css -->
  <link rel="stylesheet" href="<?= base_url("assets/vendor/bootstrap-441/dist/css/bootstrap.min.css") ?>">
  <!-- font awesome -->
  <link rel="stylesheet" href="<?= base_url("assets/vendor/fontawesome-5130/css/all.css") ?>">

  <!-- pertama jquery, kemudian popper.js, lalu bootstrap.min.js -->
  <!-- jquery -->
  <script src="<?= base_url("assets/vendor/jquery/jquery-341.js") ?>"> </script>
  <!-- popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"> </script>
  <!-- bootstrap.min.js -->
  <script src="<?= base_url("assets/vendor/bootstrap-441/dist/js/bootstrap.min.js") ?>"> </script>

  <?php
  }
  ?>
</head>
<body class="">
