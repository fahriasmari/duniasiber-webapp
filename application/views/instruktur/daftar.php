<!-- file ini merupakan template daftar instruktur -->
<div class="container my-5">
  <div class="row justify-content-md-center">
    <div class="col-md-8">
      <h4 class="mb-4"> Silakan masukkan data terkait dengan instruktur </h4>
      <form id="formId" action="<?= base_url("Instruktur/daftarInstruktur") ?>" method="post">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label"> Profesi </label>
          <div class="col-sm-10">
            <div id="profesi-input">
              <input type="text" class="form-control" id="profesiId" name="profesiTxt">                   <!-- input profesi -->
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label"> Tentang </label>
          <div class="col-sm-10">
            <div id="tentang-input">
              <textarea class="form-control" id="tentangId" name="tentangTxt" rows="4"></textarea>        <!-- input tentang -->
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label"> Rekening Bank </label>
          <div class="col-sm-10">                                                                         <!-- input rekening bank -->
            <div id="norekening-input">
              <input type="text" class="form-control" id="norekeningId" name="norekeningTxt" placeholder="Nomor Rekening">
            </div>
            <div id="namabank-input">
              <input type="text" class="form-control mt-2" id="namabankId" name="namabankTxt" placeholder="Nama Bank">
            </div>
            <div id="atasnama-input">
              <input type="text" class="form-control mt-2" id="atasnamaId" name="atasnamaTxt" placeholder="Atas Nama, contoh : qwerty">
            </div>
          </div>
        </div>
        <hr>
        <div class="form-group row text-center">
          <div class="col-sm-12">
            <input type="submit" class="btn btn-primary btn-lg" value="Daftar">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {

var inputValid = false;

$("#formId").on("submit", function(event) {
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
    url      : "<?= base_url("Instruktur/validasiDaftarInstruktur") ?>",
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
                    segarkan_daftarInstrukturr();
                    validasi_daftarInstruktur(data);
                  }else {
                    segarkan_daftarInstrukturr();
                    inputValid = true;
                    $("#formId").submit();
                  }
               }
  });
});

function segarkan_daftarInstrukturr() {
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

function validasi_daftarInstruktur(data) {
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

});
</script>
