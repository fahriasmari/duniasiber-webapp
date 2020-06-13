<?php
$dataHeader["title"]        = "DuniaSiber";
$dataHeader["frameworkCss"] = "adminlte";
$this->load->view("layout/header", $dataHeader);
$dataMenu["menuAktif"]      = "kursus";
$this->load->view("layout/adminheader", $dataMenu);
?>

<!-- judul -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0 text-dark"> Kelola Kursus </h1>
      </div>
    </div>
  </div>
</div>

<!-- konten utama -->
<section class="content">
  <div class="container-fluid">

    <?php
    if($this->session->alert) {                                                 // alert pada saat membuat kursus
      if($this->session->alert == "Error upload foto") {
    ?>
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h5> <i class="icon fas fa-ban"></i> <?= $this->session->alert ?> </h5>
      <?= $this->session->errorMsg ?>
    </div>
    <?php
        $this->session->unset_userdata("errorMsg");
      }else {
    ?>
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h5> <i class="icon fas fa-check"></i> <?= $this->session->alert ?> </h5>
    </div>
    <?php
      }
      $this->session->unset_userdata("alert");
    }
    ?>

    <div class="row mb-2 ml-1">
      <div class="float-left">
        <a href="<?= base_url("Admin/buatKursus") ?>" class="btn btn-primary btn-flat">
          <i class="fas fa-plus"></i> Tambah Kursus
        </a>
      </div>
    </div>

    <hr>

    <?php
    echo $this->session->viewKursus;
    $this->session->unset_userdata("viewKursus");
    ?>

  </div>
</section>

<?php
$this->load->view("layout/adminfooter");
$this->load->view("layout/footer");
?>
