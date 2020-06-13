<?php
if(empty($dataKursus)) {
?>

<div class="btn btn-block btn-danger btn-flat py-3 text-center">
  <h5> <i class="fas fa-exclamation-triangle"></i> Data kursus kosong ! </h5>
</div>

<?php
}else {
?>

<div class="row">
<?php
  foreach ($dataKursus as $data) {
?>
  <div class="col-md-4">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h3 class="card-title"> <?= $data->nama ?> </h3>
      </div>
      <div class="card-body">
        <img class="img-thumbnail" src="<?= base_url("assets/img/KRSS/$data->fotoKursus") ?>" width="200">
      </div>
      <div class="card-footer">
        <div class="btn-group">
          <a href="#" class="btn btn-warning"> <i class="fas fa-edit"></i> Edit </a>
          <a href="#" class="btn btn-danger"> <i class="fas fa-trash-alt"></i> Hapus </a>
        </div>
      </div>
    </div>
  </div>
<?php
  }
?>
</div>

<?php
}
?>
