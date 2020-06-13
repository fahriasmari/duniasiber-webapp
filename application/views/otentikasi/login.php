<?php
$data["title"]        = "DuniaSiber";
$data['frameworkCss'] = "bootstrap";
$this->load->view("layout/header", $data);
?>

<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-md-4 my-5">
      <div class="card bg-light my-5">
        <div class="card-body">
          <h4 class="card-title mb-4 text-center"> Login Akun </h4>
          <?php
          if(isset($alert)) {
          ?>
          <div class="alert alert-danger" role="alert">                                                           <!-- ( alert ) -->
            <strong> <?= $alert ?> </strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <?php
          }
          ?>
          <form id="formId" action="<?= base_url("Autentikasi/loginAkun") ?>" method="post">
            <div class="form-group">
              <label> Username / Email </label>
              <div class="input-group" id="user-input">
                <input type="text" class="form-control" id="userId" name="userTxt">                               <!-- input username/email -->
                <div class="input-group-append">
                  <span class="input-group-text"> <i class="far fa-user"></i> </span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label> Password </label>
              <div class="input-group" id="password-input">
                <input type="password" class="form-control" id="passwordId" name="passwordTxt">                   <!-- input password -->
                <div class="input-group-append">
                  <span class="input-group-text"> <i class="fas fa-lock"></i> </span>
                </div>
              </div>
            </div>
            <hr>
            <div class="form-group text-center">
              <input type="submit" class="btn btn-success btn-lg" value="Login">
            </div>
            <div class="form-group text-center">
              <a href="<?= base_url("Autentikasi/lupaPassword") ?>" class="text-secondary"> Lupa Password? </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {

var inputValid = false;

$("body").attr("class", "bg-dark");                                             // background gelap ( body class="bg-dark" )

$("#formId").on("submit", function(event) {
  if(!inputValid) {
    event.preventDefault();
  }else {
    return;
  }

  var _user     = $("#userId").val();
  var _password = $("#passwordId").val();

  $.ajax({
    type     : "POST",
    url      : "<?= base_url("Autentikasi/validasiLogin") ?>",
    dataType : "json",
    data     : {
                user     : _user,
                password : _password
              },
    success  : function(data) {
                  if(data.error) {
                    segarkanHalaman();
                    validasi_login(data);
                  }else {
                    segarkanHalaman();
                    inputValid = true;
                    $("#formId").submit();
                  }
               }
  });
});

function segarkanHalaman() {
  $("#userId").removeClass("is-invalid");
  $("#passwordId").removeClass("is-invalid");

  $("#user-pesan").remove();
  $("#password-pesan").remove();
}

function validasi_login(data) {
  if(data.errUser == "kosong") {
    $("#userId").addClass("is-invalid");
    $("#user-input").append("<div class='invalid-feedback' id='user-pesan'> Input username/email masih kosong ! </div>");
  }

  if(data.errPassword == "kosong") {
    $("#passwordId").addClass("is-invalid");
    $("#password-input").append("<div class='invalid-feedback' id='password-pesan'> Input password masih kosong ! </div>");
  }
}

});
</script>

<?php
$this->load->view("layout/footer");
?>
