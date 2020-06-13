<?php
$dataHeader["title"]        = "DuniaSiber";
$dataHeader["frameworkCss"] = "adminlte";
$this->load->view("layout/header", $dataHeader);
$dataMenu["menuAktif"]      = "formkursus";
$this->load->view("layout/instrukturheader", $dataMenu);
?>

<!-- judul -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <?php
        if($tujuan == "BUATKURSUS") {
        ?>
        <h1 class="m-0 text-dark"> Tambah Kursus </h1>
        <?php
        }
        ?>

      </div>
    </div>
  </div>
</div>

<!-- konten utama -->
<section class="content">
  <div class="container-fluid">

  <?php
  if($tujuan == "BUATKURSUS") {
    echo $this->session->viewTambahKursus;
    $this->session->unset_userdata("viewTambahKursus");
  }
  ?>

  </div>
</section>

<?php
$this->load->view("layout/adminfooter");
$this->load->view("layout/footer");
?>
