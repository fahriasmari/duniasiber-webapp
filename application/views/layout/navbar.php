<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= base_url("Pelanggan") ?>">                <!-- link ke controller: Pelanggan, method: index() -->
      <img src="<?= base_url("assets/img/brand-logo.png") ?>" width="145">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"> </span>
    </button>

    <div class="collapse navbar-collapse" id="navbarToggle">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="#"> -#- </a>                                <!-- ( hanya untuk sementara ) -->
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <?php
        if($this->session->statusLogin) {                                       // jika akun telah login
        ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= $this->session->akunNama ?>
          </a>
          
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="<?= base_url("Pelanggan/profil") ?>"> Profil </a>
            <div class="dropdown-divider"> </div>

          <?php
          if($this->session->akunPeran == "ADMIN") {                            // "panel admin" untuk akun ADMIN
          ?>
            <a class="dropdown-item text-info" href="<?= base_url("Admin") ?>"> <i class="fas fa-user-cog"> </i> Panel Admin </a>
          <?php
          }

          if($this->session->instrukturId) {
            if($this->session->akunPeran == "PELANGGAN") {                      // "panel instruktur" hanya untuk instruktur dengan role PELANGGAN
          ?>
            <a class="dropdown-item text-info" href="<?= base_url("Instruktur/dasbor") ?>"> <i class="fas fa-user-cog"> </i> Panel Instruktur </a>
          <?php
            }
          }else {                                                               // jika $_SESSION["instrukturId"] == FALSE
          ?>
            <a class="dropdown-item text-info" href="<?= base_url("Pelanggan/promosiInstruktur") ?>"> <i class="fas fa-chalkboard-teacher"> </i> Mengajar di DuniaSiber </a>
          <?php
          }
          ?>
            <a class="dropdown-item text-danger" href="<?= base_url("Autentikasi/logoutAkun") ?>"> <i class="fas fa-sign-out-alt"> </i> Keluar </a>
          </div>
        </li>
        <?php
        }else {
        ?>
        <li class="nav-item">
          <a href="<?= base_url("Autentikasi/loginAkun") ?>" class="btn btn-link text-white" style="width: 100px;"> <i class="fas fa-sign-in-alt"> </i> Masuk </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url("Autentikasi/daftarAkun") ?>" class="btn btn-outline-light" style="width: 100px;"> Daftar </a>
        </li>
        <?php
        }
        ?>
      </ul>
    </div>
  </div>
</nav>
