<!-- file ini merupakan template halaman profil -->
<div class="container my-5">

  <?php
  if($this->session->alert) {                                                   // ( alert )
    if( $this->session->alert == "Error upload foto") {
  ?>
  <div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <strong> <?= $this->session->alert ?> : </strong> <?= $this->session->errorMsg ?>
  </div>
  <?php
      $this->session->unset_userdata("errorMsg");
    }else {
  ?>
  <div class="alert alert-success" role="alert">
    <strong> <?= $this->session->alert ?> </strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <?php
    }
    $this->session->unset_userdata("alert");
  }
  ?>

  <div class="row justify-content-md-center">
    <div class="col-md-3">
      <div class="card my-2">
        <div class="card-body">

          <!-- panel foto profil & tombol -->
          <div class="text-center">
            <img class="img-thumbnail" src="<?= base_url("assets/img/AKUN/$foto") ?>" width="200">
          </div>

          <button type="button" class="btn btn-info btn-block mt-2" data-toggle="modal" data-target="#ubahFotoModal">
            <i class="fas fa-camera"> </i> Ubah foto
          </button>

          <button type="button" class="btn btn-warning btn-block mt-2" data-toggle="modal" data-target="#suntingProfilModal">
            <i class="fas fa-edit"> </i> Sunting profil
          </button>

          <button type="button" class="btn btn-danger btn-block mt-2" data-toggle="modal" data-target="#ubahPasswordModal">
            <i class="fas fa-key"> </i> Ubah password
          </button>

          <?php
          if($this->session->instrukturId) {
          ?>
          <button type="button" class="btn btn-warning btn-block mt-2" data-toggle="modal" data-target="#suntingInstrukturModal">
            <i class="fas fa-edit"> </i> Sunting profil instruktur
          </button>
          <?php
          }
          ?>
        </div>
      </div>
    </div>

    <!-- modal -->
    <div class="modal fade" id="ubahFotoModal" tabindex="-1" role="dialog" aria-labelledby="ubahFotoModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ubahFotoModalLabel"> Ubah Foto </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>
          <form id="ubahFotoForm" action="<?= base_url("Profil/gantiFotoProfil") ?>" method="post" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="custom-file" id="fotoprofil-input">
                <input type="file" class="custom-file-input form-control" id="fotoprofilId" name="fotoprofilFile">     <!-- input file foto (ubah foto) -->
                <label class="custom-file-label"> Pilih file </label>
              </div>
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-primary" value="Simpan">
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="suntingProfilModal" tabindex="-1" role="dialog" aria-labelledby="suntingProfilModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="suntingProfilModalLabel"> Sunting Profil </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>
          <form id="suntingProfilForm" action="<?= base_url("Profil/suntingProfil") ?>" method="post">
            <div class="modal-body">
              <div class="form-group" id="nama-input">
                <label> Nama </label>
                <input type="text" class="form-control" id="namaId" name="namaTxt" value="<?= $nama ?>">               <!-- input nama (sunting profil) -->
              </div>
              <div class="form-group">
                <label> Username </label>
                <div class="input-group" id="username-input">
                  <input type="text" class="form-control" id="usernameId" name="usernameTxt" value="<?= $username ?>"> <!-- input username (sunting profil) -->
                  <div class="input-group-append">
                    <button type="button" class="btn btn-info" id="cekUsername"> <i class="fas fa-search"></i> Periksa </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-primary" value="Simpan">
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="ubahPasswordModal" tabindex="-1" role="dialog" aria-labelledby="ubahPasswordModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ubahPasswordModalLabel"> Ubah Password </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>
          <form id="ubahPasswordForm" action="<?= base_url("Profil/gantiPassword") ?>" method="post">
            <div class="modal-body">
              <div class="form-group" id="passwordlama-input">
                <label> Masukkan password lama </label>
                <input type="password" class="form-control" id="passwordlamaId" name="passwordlamaTxt">           <!-- input password lama (ubah password) -->
              </div>
              <div class="form-group" id="password-input">
                <label> Masukkan password baru </label>
                <input type="password" class="form-control" id="passwordId" name="passwordTxt">                   <!-- input password baru (ubah password) -->
                <input type="password" class="form-control mt-2" id="ulangipasswordId" name="ulangipasswordTxt" placeholder="Ketik Ulang Password">
              </div>
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-primary" value="Simpan">
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php
    if($this->session->instrukturId) {
    ?>
    <div class="modal fade" id="suntingInstrukturModal" tabindex="-1" role="dialog" aria-labelledby="suntingInstrukturModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="suntingInstrukturModalLabel"> Sunting Profil Instruktur </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>
          <form id="suntingInstrukturForm" action="<?= base_url("Profil/suntingInstruktur") ?>" method="post">
            <div class="modal-body">
              <div class="form-group" id="profesi-input">
                <label> Profesi </label>
                <input type="text" class="form-control" id="profesiId" name="profesiTxt" value="<?= $profesi ?>"> <!-- input profesi (sunting instruktur) -->
              </div>
              <div class="form-group" id="tentang-input">
                <label> Tentang </label>
                <textarea class="form-control" id="tentangId" name="tentangTxt" rows="4"><?=$tentang?></textarea> <!-- input tentang (sunting instruktur) -->
              </div>
              <div class="form-group">
                <label> Rekening Bank </label>                                                                    <!-- input rekening bank (sunting instruktur) -->
                <div id="norekening-input">
                  <input type="text" class="form-control" id="norekeningId" name="norekeningTxt" placeholder="Nomor rekening" value="<?= $noRekening ?>">
                </div>
                <div id="namabank-input">
                  <input type="text" class="form-control mt-2" id="namabankId" name="namabankTxt" placeholder="Nama bank" value="<?= $namaBank ?>">
                </div>
                <div id="atasnama-input">
                  <input type="text" class="form-control mt-2" id="atasnamaId" name="atasnamaTxt" placeholder="Atas nama" value="<?= $atasNama ?>">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-primary" value="Simpan">
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php
    }
    ?>

    <div class="modal fade" id="ubahEmailModal" tabindex="-1" role="dialog" aria-labelledby="ubahEmailModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ubahEmailModalLabel"> Ubah Email </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"> &times; </span>
            </button>
          </div>
          <form id="ubahEmailForm" action="<?= base_url("Profil/gantiEmail") ?>" method="post">
            <div class="modal-body">
              <div class="form-group" id="email-input">
                <label> Email </label>
                <input type="text" class="form-control" id="emailId" name="emailTxt">                             <!-- input email (ubah email) -->
              </div>
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-primary" value="Simpan">
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- panel data profil -->
    <div class="col-md-9">
      <div class="card my-2">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-center mb-4"> Profil </h5>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <b> Nama </b>
            </div>
            <div class="col">
              <p> <?= $nama ?> </p>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <b> Username </b>
            </div>
            <div class="col">
              <p> <?= $username ?> </p>
            </div>
          </div>
            <hr>
          <div class="row">
            <div class="col">
              <h5 class="card-title text-center mb-4"> Kontak </h5>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <b> Email </b>
            </div>
            <div class="col">
              <p>
                <?= $email ?> <span class="badge badge-success"> Terverifikasi </span>
                <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#ubahEmailModal"> Ubah </button>
              </p>
            </div>
          </div>
          <?php
          if($this->session->instrukturId) {
          ?>
            <hr>
          <div class="row">
            <div class="col">
              <h5 class="card-title text-center mb-4"> Profil Instruktur </h5>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <b> Profesi </b>
            </div>
            <div class="col">
              <p> <?= $profesi ?> </p>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <b> Tentang </b>
            </div>
            <div class="col">
              <p> <?= $tentang ?> </p>
            </div>
          </div>
            <hr>
          <div class="row">
            <div class="col">
              <h5 class="card-title text-center mb-4"> Rekening Bank </h5>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <b> Nomor Rekening </b>
            </div>
            <div class="col">
              <p> <?= $noRekening ?> </p>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <b> Nama Bank </b>
            </div>
            <div class="col">
              <p> <?= $namaBank ?> </p>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <b> Atas Nama </b>
            </div>
            <div class="col">
              <p> <?= $atasNama ?> </p>
            </div>
          </div>
          <?php
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

$(".custom-file-input").on("change", function() {                               // untuk memunculkan nama file pada label input file, fitur "ubah foto"
  var filename = $("#fotoprofilId").val().replace(/C:\\fakepath\\/i, '');
  $(".custom-file-label").text(filename);
});

$("#cekUsername").click(function() {                                            // #cekUsername dari fitur sunting profil
  var _username = $("#usernameId").val();

  $.ajax({
    type     : "POST",
    url      : "<?= base_url("Profil/validasiUsername") ?>",
    dataType : "json",
    data     : { username : _username },
    success  : function(data) {
                  segarkan_username();
                  validasi_username(data.errUsername);
              }
  });
});

$("#suntingProfilForm").on("submit", function(event) {
  if(!inputValid) {
    event.preventDefault();
  }else {
    return;
  }

  var _nama     = $("#namaId").val();
  var _username = $("#usernameId").val();

  $.ajax({
    type     : "POST",
    url      : "<?= base_url("Profil/validasiSuntingProfil") ?>",
    dataType : "json",
    data     : {
                nama     : _nama,
                username : _username
               },
    success  : function(data) {
                  if(data.error) {
                    segarkan_suntingProfil();
                    validasi_suntingProfil(data);
                  }else {
                    segarkan_suntingProfil();
                    inputValid = true;
                    $("#suntingProfilForm").submit();
                  }
               }
  });
});

$("#ubahPasswordForm").on("submit", function(event) {
  if(!inputValid) {
    event.preventDefault();
  }else {
    return;
  }

  var _passwordlama   = $("#passwordlamaId").val();
  var _password       = $("#passwordId").val();
  var _ulangipassword = $("#ulangipasswordId").val();

  $.ajax({
    type     : "POST",
    url      : "<?= base_url("Profil/validasiGantiPassword") ?>",
    dataType : "json",
    data     : {
                passwordlama   : _passwordlama,
                password       : _password,
                ulangipassword : _ulangipassword
               },
    success  : function(data) {
                  if(data.error) {
                    segarkan_gantiPassword();
                    validasi_gantiPassword(data);
                  }else {
                    segarkan_gantiPassword();
                    inputValid = true;
                    $("#ubahPasswordForm").submit();
                  }
               }
  });
});

$("#suntingInstrukturForm").on("submit", function(event) {
  if(!inputValid) {
    event.preventDefault();
  }else {
    return;
  }

  var _profesi    = $("#profesiId").val();
  var _tentang    = $("#tentangId").val();
  var _norekening = $("#norekeningId").val();
  var _namabank   = $("#namabankId").val();
  var _atasnama   = $("#atasnamaId").val();

  $.ajax({
    type     : "POST",
    url      : "<?= base_url("Profil/validasiSuntingInstruktur") ?>",
    dataType : "json",
    data     : {
                profesi    : _profesi,
                tentang    : _tentang,
                norekening : _norekening,
                namabank   : _namabank,
                atasnama   : _atasnama
               },
    success  : function(data) {
                  if(data.error) {
                    segarkan_suntingInstruktur();
                    validasi_suntingInstruktur(data);
                  }else {
                    segarkan_suntingInstruktur();
                    inputValid = true;
                    $("#suntingInstrukturForm").submit();
                  }
               }
  });
});

$("#ubahEmailForm").on("submit", function(event) {
  if(!inputValid) {
    event.preventDefault();
  }else {
    return;
  }

  var _email = $("#emailId").val();

  $.ajax({
    type     : "POST",
    url      : "<?= base_url("Profil/validasiGantiEmail") ?>",
    dataType : "json",
    data     : { email : _email },
    success  : function(data) {
                  if(data.error) {
                    segarkan_gantiEmail();
                    validasi_gantiEmail(data.errEmail);
                  }else {
                    segarkan_gantiEmail();
                    inputValid = true;
                    $("#ubahEmailForm").submit();
                  }
               }
  });
});

$("#ubahFotoForm").on("submit", function(event) {
  if(!inputValid) {
    event.preventDefault();
  }else {
    return;
  }

  var _fotoprofil = $("#fotoprofilId").val().replace(/C:\\fakepath\\/i, '');

  $.ajax({
    type     : "POST",
    url      : "<?= base_url("Profil/validasiGantiFotoProfil") ?>",
    dataType : "json",
    data     : { fotoprofil : _fotoprofil },
    success  : function(data) {
                  if(data.error) {
                    segarkan_gantiFotoProfil();
                    validasi_gantiFotoProfil(data.errFotoProfil);
                  }else {
                    segarkan_gantiFotoProfil();
                    inputValid = true;
                    $("#ubahFotoForm").submit();
                  }
               }
  });
});

function segarkan_username() {
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
  }else if(username == "saatIni") {
    $("#usernameId").addClass("is-valid");
    $("#username-input").append("<div class='valid-feedback' id='username-pesan'> Username saat ini </div>");
  }else if(username == "") {
    $("#usernameId").addClass("is-valid");
    $("#username-input").append("<div class='valid-feedback' id='username-pesan'> Username tersedia </div>");
  }
}

function segarkan_suntingProfil() {
  $("#namaId").removeClass("is-invalid");
  $("#usernameId").removeClass("is-invalid");
  $("#usernameId").removeClass("is-valid");

  $("#nama-pesan").remove();
  $("#username-pesan").remove();
}

function validasi_suntingProfil(data) {
  if(data.errNama == "kosong") {
    $("#namaId").addClass("is-invalid");
    $("#nama-input").append("<div class='invalid-feedback' id='nama-pesan'> Input nama masih kosong ! </div>");
  }else if(data.errNama == "regex") {
    $("#namaId").addClass("is-invalid");
    $("#nama-input").append("<div class='invalid-feedback' id='nama-pesan'> Karakter yang diperbolehkan hanya alfabet, dan spasi ! </div>");
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
  }else if(data.errUsername == "saatIni") {
    $("#usernameId").addClass("is-valid");
    $("#username-input").append("<div class='valid-feedback' id='username-pesan'> Username saat ini </div>");
  }else if(data.errUsername == "") {
    $("#usernameId").addClass("is-valid");
    $("#username-input").append("<div class='valid-feedback' id='username-pesan'> Username tersedia </div>");
  }
}

function segarkan_gantiPassword() {
  $("#passwordlamaId").removeClass("is-invalid");
  $("#passwordId").removeClass("is-invalid");
  $("#ulangipasswordId").removeClass("is-invalid");

  $("#passwordlama-pesan").remove();
  $("#password-pesan").remove();
}

function validasi_gantiPassword(data) {
  if(data.errPasswordLama == "kosong") {
    $("#passwordlamaId").addClass("is-invalid");
    $("#passwordlama-input").append("<div class='invalid-feedback' id='passwordlama-pesan'> Input password lama masih kosong ! </div>");
  }else if(data.errPasswordLama == "tidakSesuai") {
    $("#passwordlamaId").addClass("is-invalid");
    $("#passwordlama-input").append("<div class='invalid-feedback' id='passwordlama-pesan'> Input password tidak sesuai dengan password sebelumnya ! </div>");
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

function segarkan_suntingInstruktur() {
  $("#profesiId").removeClass("is-invalid");
  $("#tentangId").removeClass("is-invalid");
  $("#norekeningId").removeClass("is-invalid");
  $("#namabankId").removeClass("is-invalid");
  $("#atasnamaId").removeClass("is-invalid");

  $("#profesi-pesan").remove();
  $("#tentang-pesan").remove();
  $("#norekening-pesan").remove();
  $("#namabank-pesan").remove();
  $("#atasnama-pesan").remove();
}

function validasi_suntingInstruktur(data) {
  if(data.errProfesi == "kosong") {
    $("#profesiId").addClass("is-invalid");
    $("#profesi-input").append("<div class='invalid-feedback' id='profesi-pesan'> Input profesi masih kosong ! </div>");
  }

  if(data.errTentang == "kosong") {
    $("#tentangId").addClass("is-invalid");
    $("#tentang-input").append("<div class='invalid-feedback' id='tentang-pesan'> Input tentang instruktur masih kosong ! </div>");
  }

  if(data.errNoRekening == "kosong") {
    $("#norekeningId").addClass("is-invalid");
    $("#norekening-input").append("<div class='invalid-feedback' id='norekening-pesan'> Input nomor rekening masih kosong ! </div>");
  }else if(data.errNoRekening == "regex") {
    $("#norekeningId").addClass("is-invalid");
    $("#norekening-input").append("<div class='invalid-feedback' id='norekening-pesan'> Karakter yang diperbolehkan hanya numerik ! </div>");
  }

  if(data.errNamaBank == "kosong") {
    $("#namabankId").addClass("is-invalid");
    $("#namabank-input").append("<div class='invalid-feedback' id='namabank-pesan'> Input nama bank rekening masih kosong ! </div>");
  }

  if(data.errAtasNama == "kosong") {
    $("#atasnamaId").addClass("is-invalid");
    $("#atasnama-input").append("<div class='invalid-feedback' id='atasnama-pesan'> Input atas nama rekening masih kosong ! </div>");
  }
}

function segarkan_gantiEmail() {
  $("#emailId").removeClass("is-invalid");

  $("#email-pesan").remove();
}

function validasi_gantiEmail(email) {
  if(email == "kosong") {
    $("#emailId").addClass("is-invalid");
    $("#email-input").append("<div class='invalid-feedback' id='email-pesan'> Input email masih kosong ! </div>");
  }else if(email == "sudahDipakai") {
    $("#emailId").addClass("is-invalid");
    $("#email-input").append("<div class='invalid-feedback' id='email-pesan'> Email telah dipakai ! </div>");
  }else if(email == "regex") {
    $("#emailId").addClass("is-invalid");
    $("#email-input").append("<div class='invalid-feedback' id='email-pesan'> Format email tidak sesuai ! </div>");
  }else if(email == "saatIni") {
    $("#emailId").addClass("is-invalid");
    $("#email-input").append("<div class='invalid-feedback' id='email-pesan'> Email tidak diperbolehkan sama dengan yang sebelum nya ! </div>");
  }
}

function segarkan_gantiFotoProfil() {
  $("#fotoprofilId").removeClass("is-invalid");

  $("#fotoprofil-pesan").remove();
}

function validasi_gantiFotoProfil(fotoprofil) {
  if(fotoprofil == "kosong") {
    $("#fotoprofilId").addClass("is-invalid");
    $("#fotoprofil-input").append("<div class='invalid-feedback' id='fotoprofil-pesan'> Input file masih kosong ! </div>");
  }else if(fotoprofil == "format") {
    $("#fotoprofilId").addClass("is-invalid");
    $("#fotoprofil-input").append("<div class='invalid-feedback' id='fotoprofil-pesan'> Format yang diperbolehkan hanya .jpg, .png, dan .gif ! </div>");
  }
}

});
</script>
