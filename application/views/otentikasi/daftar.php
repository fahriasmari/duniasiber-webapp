<?php
$data["title"]        = "DuniaSiber";
$data["frameworkCss"] = "bootstrap";
$this->load->view("layout/header", $data);
?>

<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-md-6">
      <div class="card bg-light my-5">
        <div class="card-body">
          <h4 class="card-title mb-4 text-center"> Daftar Akun Baru </h4>
          <form id="formId" action="<?= base_url("Autentikasi/daftarAkun") ?>" method="post">
            <div class="form-group" id="nama-input">
              <label> Nama </label>
              <input type="text" class="form-control" id="namaId" name="namaTxt">                                             <!-- input nama -->
            </div>
            <div class="form-group" id="email-input">
              <label> Email </label>
              <input type="text" class="form-control" id="emailId" name="emailTxt">                                           <!-- input email -->
            </div>
            <div class="form-group">
              <label> Username </label>
              <div class="input-group" id="username-input">
                <input type="text" class="form-control" id="usernameId" name="usernameTxt">                                   <!-- input username -->
                <div class="input-group-append">
                  <button type="button" class="btn btn-info" id="cekUsername"> <i class="fas fa-search"></i> Periksa </button>
                </div>
              </div>
            </div>
            <div class="form-group" id="password-input">                                                                      <!-- input password -->
              <label> Password </label>
              <input type="password" class="form-control" id="passwordId" name="passwordTxt">
              <input type="password" class="form-control mt-2" id="ulangipasswordId" name="ulangipasswordTxt" placeholder="Ketik Ulang Password">
            </div>
            <hr>
            <div class="form-group text-center">
              <input type="submit" class="btn btn-primary btn-lg" value="Daftar">
            </div>
            <div class="form-group text-center">
              <a href="<?= base_url("Autentikasi/loginAkun") ?>" class="text-secondary"> Sudah punya akun? </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {                                                  // ( jika dokumen html file ini telah dimuat... )

var inputValid = false;                                                         // parameter validasi form

$("body").attr("class", "bg-dark");                                             // modifikasi class body

$("#cekUsername").click(function() {                                            // jika ada event: tombol periksa( #cekUsername ) di klik
  var _username = $("#usernameId").val();

  $.ajax({
    type     : "POST",
    url      : "<?= base_url("Autentikasi/validasiUsername") ?>",
    dataType : "json",
    data     : { username : _username },
    success  : function(data) {
                  segarkanInputUsername();
                  validasi_username(data.errUsername);
               }
  });
});

$("#formId").on("submit", function(event) {                                     // jika ada event: form( form id="formId" ) di submit
  if(!inputValid) {
    event.preventDefault();
  }else {
    return;                                                                     // mencegah function ini dijalankan berulang
  }

  var _nama           = $("#namaId").val();
  var _email          = $("#emailId").val();
  var _username       = $("#usernameId").val();
  var _password       = $("#passwordId").val();
  var _ulangipassword = $("#ulangipasswordId").val();

  $.ajax({
    type     : "POST",
    url      : "<?= base_url("Autentikasi/validasiDaftar") ?>",
    dataType : "json",
    data     : {
                nama           : _nama,
                email          : _email,
                username       : _username,
                password       : _password,
                ulangipassword : _ulangipassword
               },
    success  : function(data) {
                  if(data.error) {
                    segarkanHalaman();
                    validasi_daftar(data);
                  }else {
                    segarkanHalaman();
                    inputValid = true;                                          // merubah nilai parameter
                    $("#formId").submit();
                  }
               }
  });
});

function segarkanInputUsername() {
  $("#usernameId").removeClass("is-invalid");
  $("#usernameId").removeClass("is-valid");

  $("#username-pesan").remove();
}

function validasi_username(username) {
  if(username == "kosong") {
    $("#usernameId").addClass("is-invalid");
    $("#username-input").append("<div class='invalid-feedback' id='username-pesan'> Input username masih kosong ! </div>");
  }else if(username == "sudahDipakai") {
    $("#usernameId").addClass("is-invalid");
    $("#username-input").append("<div class='invalid-feedback' id='username-pesan'> Username telah dipakai ! </div>");
  }else if(username == "regex") {
    $("#usernameId").addClass("is-invalid");
    $("#username-input").append("<div class='invalid-feedback' id='username-pesan'> Karakter yang diperbolehkan hanya alfabet(LowerCase), numerik, simbol: garis bawah, dan strip ! </div>");
  }else if(username == "") {
    $("#usernameId").addClass("is-valid");
    $("#username-input").append("<div class='valid-feedback' id='username-pesan'> Username tersedia </div>");
  }
}

function segarkanHalaman() {
  $("#namaId").removeClass("is-invalid");
  $("#emailId").removeClass("is-invalid");
  $("#emailId").removeClass("is-valid");
  $("#usernameId").removeClass("is-invalid");
  $("#usernameId").removeClass("is-valid");
  $("#passwordId").removeClass("is-invalid");
  $("#ulangipasswordId").removeClass("is-invalid");

  $("#nama-pesan").remove();
  $("#email-pesan").remove();
  $("#username-pesan").remove();
  $("#password-pesan").remove();
}

function validasi_daftar(data) {                                                // parameter berupa object
  if(data.errNama == "kosong") {
    $("#namaId").addClass("is-invalid");
    $("#nama-input").append("<div class='invalid-feedback' id='nama-pesan'> Input nama masih kosong ! </div>");
  }else if(data.errNama == "regex") {
    $("#namaId").addClass("is-invalid");
    $("#nama-input").append("<div class='invalid-feedback' id='nama-pesan'> Karakter yang diperbolehkan hanya alfabet, dan spasi ! </div>");
  }

  if(data.errEmail == "kosong") {
    $("#emailId").addClass("is-invalid");
    $("#email-input").append("<div class='invalid-feedback' id='email-pesan'> Input email masih kosong ! </div>");
  }else if(data.errEmail == "sudahDipakai") {
    $("#emailId").addClass("is-invalid");
    $("#email-input").append("<div class='invalid-feedback' id='email-pesan'> Email telah dipakai ! </div>");
  }else if(data.errEmail == "regex") {
    $("#emailId").addClass("is-invalid");
    $("#email-input").append("<div class='invalid-feedback' id='email-pesan'> Format email tidak sesuai ! </div>");
  }else if(data.errEmail == "") {
    $("#emailId").addClass("is-valid");
    $("#email-input").append("<div class='valid-feedback' id='email-pesan'> Email tersedia </div>");
  }

  if(data.errUsername == "kosong") {
    $("#usernameId").addClass("is-invalid");
    $("#username-input").append("<div class='invalid-feedback' id='username-pesan'> Input username masih kosong ! </div>");
  }else if(data.errUsername == "sudahDipakai") {
    $("#usernameId").addClass("is-invalid");
    $("#username-input").append("<div class='invalid-feedback' id='username-pesan'> Username telah dipakai ! </div>");
  }else if(data.errUsername == "regex") {
    $("#usernameId").addClass("is-invalid");
    $("#username-input").append("<div class='invalid-feedback' id='username-pesan'> Karakter yang diperbolehkan hanya alfabet(LowerCase), numerik, dan simbol: garis bawah, dan strip ! </div>");
  }else if(data.errUsername == "") {
    $("#usernameId").addClass("is-valid");
    $("#username-input").append("<div class='valid-feedback' id='username-pesan'> Username tersedia </div>");
  }

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
