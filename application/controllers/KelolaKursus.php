<?php
class KelolaKursus extends CI_Controller {                                      // controller ini dipakai oleh 2 role akun : ADMIN dan PELANGGAN
  public function __construct() {
    parent::__construct();

    if($this->session->statusLogin) {
      if(!$this->session->instrukturId) {
        echo "<script>
              alert('akses dibatasi !');
              window.location = '". base_url("Pelanggan"). "';
              </script>";
      }
    }else {
      echo "<script>
            alert('sesi telah kadaluwarsa, login kembali untuk melanjutkan !');
            window.location = '". base_url("Autentikasi/loginAkun"). "';
            </script>";
    }

    $this->load->model("KursusModel");
  }

  public function listKursus() {
    if($this->session->baseKursus) {
      $dataKursus["dataKursus"] = $this->KursusModel->tampilKursusBerdasarkanInstruktur($this->session->instrukturId);
      
      foreach ($dataKursus["dataKursus"] as $dK) {
        $dataFoto = $this->KursusModel->ambilDataFotoKursus($dK->foto_indeks);
        $dK->fotoKursus = $dataFoto->nilai;
      }

      $view = $this->load->view("kursus/listkursus", $dataKursus, TRUE);
      $this->session->set_userdata("viewKursus", $view);

      if($this->session->baseKursus == "ADMIN") {
        redirect( base_url("Admin/kelolaKursus") );
      }else if($this->session->baseKursus == "INSTRUKTUR") {
        redirect( base_url("Instruktur/kelolaKursus") );
      }
    }else {
      echo "<script>
            alert('akses dibatasi !');";
      if($this->session->akunPeran == "ADMIN") {
        echo "window.location = '". base_url("Admin"). "';";
      }else if($this->session->akunPeran == "PELANGGAN") {
        echo "window.location = '". base_url("Instruktur/dasbor"). "';";
      }
      echo "</script>";
    }
  }

  public function tambahKursus() {
    if($this->session->baseTambahKursus) {
      if($this->input->post()) {
        $filename     = bin2hex(random_bytes(8));

        $configUpload = array(
                               "upload_path"      => "./assets/img/KRSS",       // KRSS, singkatan dari kursus
                               "allowed_types"    => "jpg|png",
                               "max_size"         => 5120,
                               "max_width"        => 1080,
                               "max_height"       => 1080,
                               "file_name"        => $filename,
                               "file_ext_tolower" => TRUE
                             );

        $this->upload->initialize($configUpload);

        if($this->upload->do_upload("fotothumbnailFile")) {
          $filename   = $this->upload->data("file_name");

          $dataKursus = array(
                              "namaKursus"      => $this->input->post("namaTxt"),
                              "fotoThumbnail"   => $filename,
                              "deskripsiKursus" => $this->input->post("deskripsiTxt"),
                              "instrukturId"    => $this->session->instrukturId
                            );

          $this->KursusModel->buatKursus($dataKursus);

          $this->session->set_userdata("alert", "Kursus berhasil di buat");

          if($this->session->akunPeran == "ADMIN") {
            redirect( base_url("Admin/kelolaKursus") );
          }else if($this->session->akunPeran == "PELANGGAN") {
            redirect( base_url("Instruktur/kelolaKursus") );
          }
        }else {
          $this->session->set_userdata("alert", "Error upload foto");
          $this->session->set_userdata("errorMsg", "size atau resolusi foto terlalu besar !");

          if($this->session->akunPeran == "ADMIN") {
            redirect( base_url("Admin/kelolaKursus") );
          }else if($this->session->akunPeran == "PELANGGAN") {
            redirect( base_url("Instruktur/kelolaKursus") );
          }
        }
      }else {
        $view = $this->load->view("kursus/tambahkursus", "", TRUE);
        $this->session->set_userdata("viewTambahKursus", $view);

        if($this->session->baseTambahKursus == "ADMIN") {
          redirect( base_url("Admin/buatKursus") );
        }else if($this->session->baseTambahKursus == "INSTRUKTUR") {
          redirect( base_url("Instruktur/buatKursus") );
        }
      }
    }else {
      echo "<script>
            alert('akses dibatasi !');";
      if($this->session->akunPeran == "ADMIN") {
        echo "window.location = '". base_url("Admin/kelolaKursus"). "';";
      }else if($this->session->akunPeran == "PELANGGAN") {
        echo "window.location = '". base_url("Instruktur/kelolaKursus"). "';";
      }
      echo "</script>";
    }
  }

  public function validasiKursus() {
    if($this->input->post()) {
      $_error            = FALSE;
      $_errNama          = "";
      $_errDeskripsi     = "";
      $_errFotoThumbnail = "";

      $_nama          = $this->input->post("nama");
      $_deskripsi     = $this->input->post("deskripsi");

      $_fotothumbnail = strtolower($this->input->post("fotothumbnail"));
      $_fotothumbnail = explode(".", $_fotothumbnail);
      $_fotothumbnail = end($_fotothumbnail);

      if(empty($_nama)) {
        $_error   = TRUE;
        $_errNama = "kosong";
      }

      if(empty($_deskripsi)) {
        $_error        = TRUE;
        $_errDeskripsi = "kosong";
      }

      if(empty($_fotothumbnail)) {
        $_error            = TRUE;
        $_errFotoThumbnail = "kosong";
      }else if( !($_fotothumbnail == "jpg" || $_fotothumbnail == "png") ) {
        $_error            = TRUE;
        $_errFotoThumbnail = "format";
      }

      if($_error) {
        echo json_encode([
                          "error"            => $_error,
                          "errNama"          => $_errNama,
                          "errDeskripsi"     => $_errDeskripsi,
                          "errFotoThumbnail" => $_errFotoThumbnail
                        ]);
      }else {
        echo json_encode([ "error" => $_error ]);
      }
    }else {
      redirect( base_url("Pelanggan") );
    }
  }
}
?>
