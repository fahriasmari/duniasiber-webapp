<?php
$dataHeader["title"]        = "DuniaSiber";
$dataHeader["frameworkCss"] = "adminlte";
$this->load->view("layout/header", $dataHeader);
$dataMenu["menuAktif"]      = "dasbor";                                         // parameter active pada panel menu
$this->load->view("layout/adminheader", $dataMenu);
?>

<!-- judul -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0 text-dark"> Dasbor </h1>
      </div>
    </div>
  </div>
</div>

<!-- konten utama -->
<section class="content">
  <div class="container-fluid">

    <?php
    if($this->session->alert) {                                                 // alert pada saat sukses mendaftarkan instruktur
    ?>
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h5> <i class="icon fas fa-check"></i> <?= $this->session->alert ?> </h5>
    </div>
    <?php
      $this->session->unset_userdata("alert");
    }
    ?>

  </div>
</section>

<?php
$this->load->view("layout/adminfooter");
$this->load->view("layout/footer");
?>
