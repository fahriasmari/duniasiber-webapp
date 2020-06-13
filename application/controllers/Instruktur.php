<?php
class Instruktur extends CI_Controller {                                        // controller ini dipakai oleh 2 role akun : ADMIN dan PELANGGAN
  public function __construct() {
    parent::__construct();

    if(!$this->session->statusLogin) {
      echo "<script>
            alert('sesi telah kadaluwarsa, login kembali untuk melanjutkan !');
            window.location = '". base_url("Autentikasi/loginAkun"). "';
            </script>";
    }

    $this->load->model("InstrukturModel");
  }

  public function daftarInstruktur() {
    if($this->session->baseDaftarInstruktur) {
      if(!$this->session->instrukturId) {
        if($this->input->post()) {
          $noRekening = $this->input->post("norekeningTxt");
          $namaBank   = $this->input->post("namabankTxt");
          $atasNama   = $this->input->post("atasnamaTxt");

          $dataRekeningBank = '{
                                "nomor_rekening" : "'. $noRekening. '",
                                "nama_bank"      : "'. $namaBank. '",
                                "atas_nama"      : "'. $atasNama. '"
                              }';

          $dataInstruktur   = array(
                                    "akunId"                 => $this->session->akunId,
                                    "profesiInstruktur"      => $this->input->post("profesiTxt"),
                                    "tentangInstruktur"      => $this->input->post("tentangTxt"),
                                    "rekeningBankInstruktur" => $dataRekeningBank
                                  );

          $this->InstrukturModel->daftarkanInstruktur($dataInstruktur);

          $dataInstruktur = $this->InstrukturModel->ambilDataInstruktur($this->session->akunId);
          $this->session->set_userdata("instrukturId", $dataInstruktur->instruktur_id);             // inisialisasi id instruktur pada session

          $this->session->set_userdata("alert", "Berhasil daftar instruktur !");                    // alert

          if($this->session->akunPeran == "ADMIN") {
            redirect( base_url("Admin") );
          }else if($this->session->akunPeran == "PELANGGAN") {
            redirect( base_url("Instruktur/dasbor") );
          }
        }else {
          $view = $this->load->view("instruktur/daftar", "", TRUE);                                 // parsing view halaman daftar instruktur
          $this->session->set_userdata("viewDaftarInstruktur", $view);

          if($this->session->baseDaftarInstruktur == "ADMIN") {
            redirect( base_url("Admin/daftarInstruktur") );
          }else if($this->session->baseDaftarInstruktur == "PELANGGAN") {
            redirect( base_url("Pelanggan/daftarInstruktur") );
          }
        }
      }else {
        echo "<script>
              alert('akun telah terdaftar sebagai instruktur !');
             ";
        if($this->session->akunPeran == "ADMIN") {
          echo "window.location = '". base_url("Admin"). "';";
        }else if($this->session->akunPeran == "PELANGGAN") {
          echo "window.location = '". base_url("Instruktur/dasbor"). "';";
        }
        echo "</script>";
      }
    }else {
      echo "<script>
            alert('akses dibatasi !');
            window.location = '". base_url("Pelanggan"). "';
            </script>";
    }
  }

  public function validasiDaftarInstruktur() {
    if($this->input->post()) {
      $_error         = FALSE;
      $_errProfesi    = "";
      $_errTentang    = "";
      $_errNoRekening = "";
      $_errNamaBank   = "";
      $_errAtasNama   = "";

      $_profesi    = $this->input->post("profesi");
      $_tentang    = $this->input->post("tentang");
      $_norekening = $this->input->post("norekening");
      $_namabank   = $this->input->post("namabank");
      $_atasnama   = $this->input->post("atasnama");

      if(empty($_profesi)) {
        $_error      = TRUE;
        $_errProfesi = "kosong";
      }

      if(empty($_tentang)) {
        $_error      = TRUE;
        $_errTentang = "kosong";
      }

      if(empty($_norekening)) {
        $_error         = TRUE;
        $_errNoRekening = "kosong";
      }else if(!preg_match( "/^[0-9]*$/", $_norekening )) {
        $_error         = TRUE;
        $_errNoRekening = "regex";
      }

      if(empty($_namabank)) {
        $_error       = TRUE;
        $_errNamaBank = "kosong";
      }

      if(empty($_atasnama)) {
        $_error       = TRUE;
        $_errAtasNama = "kosong";
      }

      if($_error) {
        echo json_encode([
                          "error"         => $_error,
                          "errProfesi"    => $_errProfesi,
                          "errTentang"    => $_errTentang,
                          "errNoRekening" => $_errNoRekening,
                          "errNamaBank"   => $_errNamaBank,
                          "errAtasNama"   => $_errAtasNama
                        ]);
      }else {
        echo json_encode([ "error" => $_error ]);
      }
    }else {
      redirect( base_url("Pelanggan") );
    }
  }

  public function dasbor() {                                                    // method ini dipakai oleh akun dengan role : PELANGGAN
    if(!$this->session->instrukturId) {                                         // validasi panel instruktur
      echo "<script>
            alert('akses dibatasi !');
            window.location = '". base_url("Pelanggan"). "';
            </script>";
    }else {
      if($this->session->akunPeran != "PELANGGAN") {
        echo "<script>
              alert('akses dibatasi !');
              window.location = '". base_url("Pelanggan"). "';
              </script>";
      }else {
        $this->load->view("instruktur/dasbor");
      }
    }
  }

  public function profil() {
    if(!$this->session->instrukturId) {
      echo "<script>
            alert('akses dibatasi !');
            window.location = '". base_url("Pelanggan"). "';
            </script>";
    }else {
      if($this->session->akunPeran != "PELANGGAN") {
        echo "<script>
              alert('akses dibatasi !');
              window.location = '". base_url("Pelanggan"). "';
              </script>";
      }else {
        $this->session->set_userdata("baseProfil", "INSTRUKTUR");

        if(!$this->session->viewProfil) {
          redirect( base_url("Profil/lihatProfil") );
        }

        $this->load->view("instruktur/profil");
      }
    }
  }

  public function kelolaKursus() {
    if(!$this->session->instrukturId) {
      echo "<script>
            alert('akses dibatasi !');
            window.location = '". base_url("Pelanggan"). "';
            </script>";
    }else {
      if($this->session->akunPeran != "PELANGGAN") {
        echo "<script>
              alert('akses dibatasi !');
              window.location = '". base_url("Pelanggan"). "';
              </script>";
      }else {
        $this->session->set_userdata("baseKursus", "INSTRUKTUR");

        if(!$this->session->viewKursus) {
          redirect( base_url("kelolaKursus/listKursus") );
        }

        $this->load->view("instruktur/kursus");
      }
    }
  }

  public function buatKursus() {
    if(!$this->session->instrukturId) {
      echo "<script>
            alert('akses dibatasi !');
            window.location = '". base_url("Pelanggan"). "';
            </script>";
    }else {
      if($this->session->akunPeran != "PELANGGAN") {
        echo "<script>
              alert('akses dibatasi !');
              window.location = '". base_url("Pelanggan"). "';
              </script>";
      }else {
        $data["tujuan"] = "BUATKURSUS";

        $this->session->set_userdata("baseTambahKursus", "INSTRUKTUR");

        if(!$this->session->viewTambahKursus) {
          redirect( base_url("KelolaKursus/tambahKursus") );
        }

        $this->load->view("instruktur/formkursus", $data);
      }
    }
  }
}
?>
