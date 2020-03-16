<!-- desain UI masih dapat berubah-ubah sebelum masuk production -->
<?php
$data["title"]        = "DuniaSiber";
$data["frameworkCss"] = "bootstrap";
$this->load->view("layout/header", $data);
?>

<div class="container">
  <div class="row justify-content-md-center">
    <?php
    if(isset($pesan)) {
    ?>
    <div class="col-md-8 my-5">
    <?php
    }else {
    ?>
    <div class="col-md-6 my-5">
    <?php
    }
    ?>
      <div class="card bg-light my-5">
        <div class="card-body">
          <?php
          if(isset($pesan)) {
            if($pesan == "Token telah kadaluarsa") {
          ?>
              <div class="alert alert-danger" role="alert"> <?= $pesan ?> </div>
          <?php
            }else if( strpos($pesan, "Password telah diubah") !== FALSE ) {
          ?>
              <div class="alert alert-success" role="alert"> <?= $pesan ?> </div>
          <?php
            }else {
          ?>
              <div class="alert alert-secondary" role="alert"> <?= $pesan ?> </div>
          <?php
            }
          }else{
          ?>
            <h4 class="card-title mb-4 text-center"> Reset Password </h4>
          <?php
            if( isset($_SESSION['statusResetPass']) ) {
          ?>

              <form id="aturUlangPassBaruForm" action="http://127.0.0.1/duniasiber/index.php/Autentikasi/lupaPassword" method="post">
              <!-- ( mode form: atur ulang password baru ) -->
                <div class="form-group" id="password-input">
                  <label> Masukkan password baru </label>
                  <input type="password" class="form-control" id="passwordId" name="passwordTxt">
                  <input type="password" class="form-control mt-2" id="ulangipasswordId" name="ulangipasswordTxt" placeholder="Ketik Ulang Password">
                </div>
                <hr>
                <div class="form-group text-center">
                  <input type="submit" class="btn btn-info btn-lg" value="Kirim">
                </div>
              </form>

          <?php
            }else {
          ?>

              <form id="requestUbahPasswordForm" action="http://127.0.0.1/duniasiber/index.php/Autentikasi/lupaPassword" method="post">
              <!-- ( mode form: request ubah password ) -->
                <div class="form-group" id="email-input">
                  <label> Masukkan email yang didaftarkan </label>
                  <input type="text" class="form-control" id="emailId" name="emailTxt">
                </div>
                <hr>
                <div class="form-group text-center">
                  <input type="submit" class="btn btn-info btn-lg" value="Kirim">
                </div>
              </form>

          <?php
            }
          }
          ?>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {

var inputValid = false;

$("body").attr("class", "bg-dark");

$("#requestUbahPasswordForm").on("submit", function(event) {                    // ( validasi untuk, mode form: request ubah password )
  if(!inputValid) {
    event.preventDefault();
  }else {
    return;
  }

  var _email = $("#emailId").val();

  $.ajax({
    type     : "POST",
    url      : "http://127.0.0.1/duniasiber/index.php/Autentikasi/validasiRequestUbahPassword",
    dataType : "json",
    data     : { email : _email },
    success  : function(data) {
                  if(data.error) {
                    segarkanHalaman();
                    validasi_requestUbahPassword(data);
                  }else {
                    segarkanHalaman();
                    inputValid = true;
                    $("#requestUbahPasswordForm").submit();
                  }
               }
  });
});

$("#aturUlangPassBaruForm").on("submit", function(event) {                      // ( validasi untuk, mode form: atur ulang password baru )
  if(!inputValid) {
    event.preventDefault();
  }else {
    return;
  }

  var _password       = $("#passwordId").val();
  var _ulangipassword = $("#ulangipasswordId").val();

  $.ajax({
    type     : "POST",
    url      : "http://127.0.0.1/duniasiber/index.php/Autentikasi/validasiAturUlangPassBaru",
    dataType : "json",
    data     : {
                password       : _password,
                ulangipassword : _ulangipassword
               },
    success  : function(data) {
                  if(data.error) {
                    segarkanHalaman();
                    validasi_aturUlangPassBaru(data);
                  }else {
                    segarkanHalaman();
                    inputValid = true;
                    $("#aturUlangPassBaruForm").submit();
                  }
               }
  });
});

function segarkanHalaman() {
  $("#emailId").removeClass("is-invalid");
  $("#passwordId").removeClass("is-invalid");
  $("#ulangipasswordId").removeClass("is-invalid");

  $("#email-pesan").remove();
  $("#password-pesan").remove();
}

function validasi_requestUbahPassword(data) {
  if(data.errEmail == "kosong") {
    $("#emailId").addClass("is-invalid");
    $("#email-input").append("<div class='invalid-feedback' id='email-pesan'> Input email masih kosong ! </div>");
  }else if(data.errEmail == "regex") {
    $("#emailId").addClass("is-invalid");
    $("#email-input").append("<div class='invalid-feedback' id='email-pesan'> Format email tidak sesuai ! </div>");
  }
}

function validasi_aturUlangPassBaru(data) {
  if(data.errPassword == "kosong") {
    $("#passwordId").addClass("is-invalid");
    $("#ulangipasswordId").addClass("is-invalid");
    $("#password-input").append("<div class='invalid-feedback' id='password-pesan'> Input password masih ada yang kosong ! </div>");
  }else if(data.errPassword == "tidakSama") {
    $("#passwordId").addClass("is-invalid");
    $("#ulangipasswordId").addClass("is-invalid");
    $("#password-input").append("<div class='invalid-feedback' id='password-pesan'> Input password tidak sama ! </div>");
  }
}

});
</script>

<?php
$this->load->view("layout/footer");
?>
