<?php
class Admin extends CI_Controller {
  public function __construct() {
    parent::__construct();

    if($this->session->statusLogin) {                                           // if($_SESSION["statusLogin"] == TRUE)
      if($this->session->akunPeran != "ADMIN") {                                // pembatasan akses
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
  }

  public function index() {
    $this->load->view("admin/dasbor");
  }

  public function profil() {
    $this->session->set_userdata("baseProfil", "ADMIN");

    if(!$this->session->viewProfil) {
      redirect( base_url("Profil/lihatProfil") );
    }

    $this->load->view("admin/profil");
  }

  public function daftarInstruktur() {
    $this->session->set_userdata("baseDaftarInstruktur", "ADMIN");

    if(!$this->session->viewDaftarInstruktur) {
      redirect( base_url("Instruktur/daftarInstruktur") );
    }

    $this->load->view("admin/daftarinstruktur");
  }

  public function kelolaKursus() {
    $this->session->set_userdata("baseKursus", "ADMIN");

    if(!$this->session->viewKursus) {
      redirect( base_url("kelolaKursus/listKursus") );
    }

    $this->load->view("admin/kursus");
  }

  public function buatKursus() {
    $data["tujuan"] = "BUATKURSUS";

    $this->session->set_userdata("baseTambahKursus", "ADMIN");

    if(!$this->session->viewTambahKursus) {
      redirect( base_url("KelolaKursus/tambahKursus") );
    }

    $this->load->view("admin/formkursus", $data);
  }
}
?>
