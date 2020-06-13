<?php
$data["title"]        = "DuniaSiber";
$data["frameworkCss"] = "bootstrap";
$this->load->view("layout/header", $data);
$this->load->view("layout/navbar");
?>

<div class="container-fluid bg-light text-dark py-5">
  <div class="row">
    <div class="col-md-4">
      <h1 class="text-center" style="font-size: 150px;"> <i class="fas fa-chalkboard-teacher"></i> </h1>
    </div>
    <div class="col-md-8">
      <h1 class="display-4"> Tingkatkan skill mengajar, berkontribusi pada dunia pendidikan, dan dapatkan uang </h1>
    </div>
  </div>
  <div class="row mt-5">
    <div class="col text-center">
      <a href="<?= base_url("Pelanggan/daftarInstruktur") ?>" class="btn btn-success btn-lg" > Daftar jadi instruktur sekarang ! </a>
    </div>
  </div>
</div>

<?php
$this->load->view("layout/footer");
?>
