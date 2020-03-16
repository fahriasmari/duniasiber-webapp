<!-- desain UI masih dapat berubah-ubah sebelum masuk production -->
<?php
$data["title"]        = "DuniaSiber";
$data["frameworkCss"] = "bootstrap";
$this->load->view("layout/header", $data);
?>

<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-md-8 my-5">
      <div class="card bg-light my-5">
        <div class="card-body">
          <!-- pesan -->
          <?php
          if(isset($pesan)) {
            if($pesan == "Token telah kadaluarsa") {
          ?>
              <div class="alert alert-danger" role="alert"> <?= $pesan ?> </div>
          <?php
            }else if( strpos($pesan, "Aktivasi akun berhasil") !== FALSE ) {
          ?>
              <div class="alert alert-success" role="alert"> <?= $pesan ?> </div>
          <?php
            }else {
          ?>
              <div class="alert alert-secondary" role="alert"> <?= $pesan ?> </div>
          <?php
            }
          }else {
            redirect("http://127.0.0.1/duniasiber/index.php/Autentikasi/loginAkun");
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {

$("body").attr("class", "bg-dark");

});
</script>

<?php
$this->load->view("layout/footer");
?>
