<?php
$dataHeader["title"]        = "DuniaSiber";
$dataHeader["frameworkCss"] = "adminlte";
$this->load->view("layout/header", $dataHeader);
$dataMenu["menuAktif"]      = "daftarinstruktur";
$this->load->view("layout/adminheader", $dataMenu);
?>

<!-- judul -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0 text-dark"> Daftar Instruktur </h1>
      </div>
    </div>
  </div>
</div>

<!-- konten utama -->
<section class="content">
  <div class="container-fluid">
    <?php
    echo $this->session->viewDaftarInstruktur;
    $this->session->unset_userdata("viewDaftarInstruktur");
    ?>
  </div>
</section>

<?php
$this->load->view("layout/adminfooter");
$this->load->view("layout/footer");
?>