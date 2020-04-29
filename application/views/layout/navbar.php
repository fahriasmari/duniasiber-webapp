<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= base_url("Pelanggan") ?>">
      <img src="<?= base_url("assets/img/brand-logo.png") ?>" width="145">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarToggle">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="#"> Kursus </a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a href="<?= base_url("Autentikasi/loginAkun") ?>" class="btn btn-link text-white" style="width: 100px;"> <i class="fas fa-sign-in-alt"></i> Masuk </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url("Autentikasi/daftarAkun") ?>" class="btn btn-outline-light" style="width: 100px;"> Daftar </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
