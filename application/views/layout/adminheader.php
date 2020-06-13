<!-- untuk animasi transisi -->
<script>
  $("body").attr("class", "hold-transition sidebar-mini layout-fixed");
</script>

<!-- ./wrapper -->
<div class="wrapper">

  <!-- navbar -->
  <nav class="main-header navbar navbar-expand navbar-light">
    <!-- navbar link : bagian kiri -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"> <i class="fas fa-bars"> </i> </a>
      </li>
    </ul>

    <!-- navbar link : bagian kanan -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> </a>
        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu dropdown-menu-right">
          <li>
            <a href="<?= base_url("Admin/profil") ?>" class="dropdown-item"> Profil </a>
          </li>
          <li class="dropdown-divider"></li>
          <li>
            <a href="<?= base_url("Pelanggan") ?>" class="dropdown-item text-info"> <i class="far fa-window-restore"> </i> Situs Web </a>
          </li>
          <li class="dropdown-divider"></li>
          <li>
            <a href="<?= base_url("Autentikasi/logoutAkun") ?>" class="dropdown-item text-danger"> <i class="fas fa-sign-out-alt"> </i> Keluar </a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- sidebar container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- brand logo -->
    <a href="#" class="brand-link">
      <img src="<?= base_url("assets/img/logo.png") ?>" class="brand-image elevation-3">
      <span class="brand-text font-weight-light" style="font-family: 'AudioWide'; font-size: 18px;"> DuniaSiber </span>
    </a>

    <!-- sidebar -->
    <div class="sidebar">
      <!-- panel akun -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= base_url("assets/img/AKUN/". $this->session->fotoAkun) ?>" class="elevation-2" style="border: 2px solid #ffffff;">
        </div>
        <div class="info">
          <a class="d-block"> <?= $this->session->akunNama ?> </a>
        </div>
      </div>

      <!-- sidebar menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
          <!-- untuk menambahkan icon pada link menu, tambahkan .nav-icon pada class icon -->
          <li class="nav-item">
            <?php
            if($menuAktif == "dasbor") {
            ?>
            <a href="<?= base_url("Admin") ?>" class="nav-link active">
            <?php
            }else {
            ?>
            <a href="<?= base_url("Admin") ?>" class="nav-link">
            <?php
            }
            ?>
              <i class="nav-icon fas fa-tachometer-alt"> </i>
              <p> Dasbor </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-clipboard-list"> </i>
              <p> Area Staging Kursus </p>
            </a>
          </li>
          <?php
          if($this->session->instrukturId) {
            if($menuAktif == "kursus" || $menuAktif == "formkursus") {
          ?>
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
          <?php
            }else {
          ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
          <?php
            }
          ?>
              <i class="nav-icon fas fa-chalkboard-teacher"> </i>
              <p>
                Instruktur
                <i class="right fas fa-angle-left"> </i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <?php
                if($menuAktif == "kursus" || $menuAktif == "formkursus") {
                ?>
                <a href="<?= base_url("Admin/kelolaKursus") ?>" class="nav-link active">
                <?php
                }else {
                ?>
                <a href="<?= base_url("Admin/kelolaKursus") ?>" class="nav-link">
                <?php
                }
                ?>
                  <i class="far fa-circle nav-icon"> </i>
                  <p> Kursus </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"> </i>
                  <p> Pesan </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"> </i>
                  <p> Performa </p>
                </a>
              </li>
            </ul>
          </li>
          <?php
          }else {                                                               // jika $_SESSION["instrukturId"] == FALSE
          ?>
          <li class="nav-item">
            <?php
            if($menuAktif == "daftarinstruktur") {
            ?>
            <a href="<?= base_url("Admin/daftarInstruktur") ?>" class="nav-link active">
            <?php
            }else {
            ?>
            <a href="<?= base_url("Admin/daftarInstruktur") ?>" class="nav-link">
            <?php
            }
            ?>
              <i class="nav-icon fas fa-chalkboard-teacher"> </i>
              <p> Mengajar di DuniaSiber </p>
            </a>
          </li>
          <?php
          }
          ?>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- content wrapper ( mengandung halaman konten ) -->
  <div class="content-wrapper" style="background-color: #ffffff;">
