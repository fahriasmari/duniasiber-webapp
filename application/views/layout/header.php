<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <title> <?= $title ?> </title>                                                <!-- judul halaman -->
  <?php
  if($frameworkCss == "adminlte") {                                             // dependency yang dipakai dalam template adminlte
  ?>

  <meta charset="utf-8">                                                                            <!-- -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">                                             <!-- meta tag -->
  <meta name="viewport" content="width=device-width, initial-scale=1">                              <!-- -->

  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="http://127.0.0.1/duniasiber/assets/vendor/adminlte-302/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- adminlte css -->
  <link rel="stylesheet" href="http://127.0.0.1/duniasiber/assets/vendor/adminlte-302/dist/css/adminlte.min.css">
  <!-- google font: source sans pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- jquery -->
  <script src="http://127.0.0.1/duniasiber/assets/vendor/jquery/jquery-341.js"> </script>
  <!-- bootstrap Js -->
  <script src="http://127.0.0.1/duniasiber/assets/vendor/adminlte-302/plugins/bootstrap/js/bootstrap.bundle.min.js"> </script>
  <!-- adminlte Js -->
  <script src="http://127.0.0.1/duniasiber/assets/vendor/adminlte-302/dist/js/adminlte.min.js"> </script>
  <!-- font awesome ("conflict detection" aktif !, non-aktifkan setelah masuk tahap production) -->
  <script src="https://kit.fontawesome.com/265f0f514f.js" crossorigin="anonymous"> </script>

  <?php
  }else if($frameworkCss == "bootstrap") {                                      // depedency yang dipakai dalam framework css: bootstrap4
  ?>

  <meta charset="utf-8">                                                                                              <!-- meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">                              <!--  tag -->

  <link rel="stylesheet" href="http://127.0.0.1/duniasiber/assets/vendor/bootstrap-441/dist/css/bootstrap.min.css">   <!-- bootstrap 4 -->

  <!-- pertama jquery, kemudian popper.js, lalu bootstrap.js -->
  <script src="http://127.0.0.1/duniasiber/assets/vendor/jquery/jquery-341.js"> </script>                             <!-- jquery -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">      
  </script>                                                                                                           <!-- popper.js -->
  <script src="http://127.0.0.1/duniasiber/assets/vendor/bootstrap-441/dist/js/bootstrap.min.js"> </script>           <!-- bootstrap.js -->
  <!-- font awesome ("conflict detection" aktif !, non-aktifkan setelah masuk tahap production) -->
  <script src="https://kit.fontawesome.com/265f0f514f.js" crossorigin="anonymous"> </script>

  <?php
  }
  ?>
</head>
<body class="">
