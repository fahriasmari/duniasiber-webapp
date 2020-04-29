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
            if( strpos($pesan, "Token telah kadaluwarsa") ) {                   // jika strpos() == TRUE
          ?>
              <div class="alert alert-danger" role="alert"> <?= $pesan ?> </div>
          <?php
            }else if( strpos($pesan, "Aktivasi akun berhasil") ) {
          ?>
              <div class="alert alert-success" role="alert"> <?= $pesan ?> </div>
          <?php
            }else {
          ?>
              <div class="alert alert-secondary" role="alert"> <?= $pesan ?> </div>
              <script>
              $(document).ready(function() {

                var timer = 60;

                var interval = setInterval(function() {                         // function ini akan dijalankan dalam interval 1 detik
                  timer--;
                  $("#detikTimer").text(timer);

                  if (timer == 0) {
                    $("#kirimUlang").attr("href", "<?= base_url("Autentikasi/kirimUlangEmail") ?>");
                    $("#kirimUlang").removeClass("disabled");
                    $("#detikTimer").remove();
                    $("#kirimUlang").text("Kirim ulang email");

                    clearInterval(interval);
                  }
                }, 1000);

              });
              </script>
          <?php
            }
          }else {
            redirect( base_url("Autentikasi/loginAkun") );
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
