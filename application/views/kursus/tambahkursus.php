<div class="row justify-content-md-center">
  <div class="col-md-8">
    <div class="card card-outline card-primary">
      <form id="formId" action="<?= base_url("KelolaKursus/tambahKursus") ?>" method="post" enctype="multipart/form-data" role="form">
        <div class="card-body">
          <div class="form-group" id="nama-input">
            <label> Nama Kursus </label>
            <input type="text" class="form-control" id="namaId" name="namaTxt">                                           <!-- input nama kursus -->
          </div>
          <div class="form-group" id="deskripsi-input">
            <label> Deskripsi </label>
            <textarea class="form-control" id="deskripsiId" name="deskripsiTxt" rows="4"></textarea>                      <!-- input deskripsi -->
          </div>
          <div class="form-group">
            <label> Foto Thumbnail Kursus </label>
            <div class="custom-file" id="fotothumbnail-input">
              <input type="file" class="custom-file-input form-control" id="fotothumbnailId" name="fotothumbnailFile">    <!-- input file foto (thumbnail) -->
              <label class="custom-file-label"> Pilih file </label>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <input type="submit" class="btn btn-primary" value="Buat">
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {

var inputValid = false;

$(".custom-file-input").on("change", function() {
  var filename = $("#fotothumbnailId").val().replace(/C:\\fakepath\\/i, '');
  $(".custom-file-label").text(filename);
});

$("#formId").on("submit", function(event) {
  if(!inputValid) {
    event.preventDefault();
  }else {
    return;
  }

  var _nama          = $("#namaId").val();
  var _deskripsi     = $("#deskripsiId").val();
  var _fotothumbnail = $("#fotothumbnailId").val().replace(/C:\\fakepath\\/i, '');

  $.ajax({
    type     : "POST",
    url      : "<?= base_url("KelolaKursus/validasiKursus") ?>",
    dataType : "json",
    data     : {
                nama          : _nama,
                deskripsi     : _deskripsi,
                fotothumbnail : _fotothumbnail
               },
    success  : function(data) {
                  if(data.error) {
                    segarkanHalaman();
                    validasi_kursus(data);
                  }else {
                    segarkanHalaman();
                    inputValid = true;
                    $("#formId").submit();
                  }
               }
  });
});

function segarkanHalaman() {
  $("#namaId").removeClass("is-invalid");
  $("#deskripsiId").removeClass("is-invalid");
  $("#fotothumbnailId").removeClass("is-invalid");

  $("#nama-pesan").remove();
  $("#deskripsi-pesan").remove();
  $("#fotothumbnail-pesan").remove();
}

function validasi_kursus(data) {
  if(data.errNama == "kosong") {
    $("#namaId").addClass("is-invalid");
    $("#nama-input").append("<div class='invalid-feedback' id='nama-pesan'> Input nama kursus masih kosong ! </div>");
  }

  if(data.errDeskripsi == "kosong") {
    $("#deskripsiId").addClass("is-invalid");
    $("#deskripsi-input").append("<div class='invalid-feedback' id='deskripsi-pesan'> Input deskripsi kursus masih kosong ! </div>");
  }

  if(data.errFotoThumbnail == "kosong") {
    $("#fotothumbnailId").addClass("is-invalid");
    $("#fotothumbnail-input").append("<div class='invalid-feedback' id='fotothumbnail-pesan'> Input file masih kosong ! </div>");
  }else if(data.errFotoThumbnail == "format") {
    $("#fotothumbnailId").addClass("is-invalid");
    $("#fotothumbnail-input").append("<div class='invalid-feedback' id='fotothumbnail-pesan'> Format yang diperbolehkan hanya .jpg, dan .png ! </div>");
  }
}

});
</script>
