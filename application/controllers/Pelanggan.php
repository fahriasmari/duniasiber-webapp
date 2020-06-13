<?php
class Pelanggan extends CI_Controller {

  public function index() {
    $this->load->view("pelanggan/halutama");                                    // halaman utama
  }

  public function profil() {
    if(!$this->session->statusLogin) {                                          // jika akun tidak sedang login
      echo "<script>
            alert('sesi telah kadaluwarsa, login kembali untuk melanjutkan !');
            window.location = '". base_url("Autentikasi/loginAkun"). "';
            </script>";
    }else{
      $this->session->set_userdata("baseProfil", "PELANGGAN");                  // baseProfil = container/wadah yang berisi halaman profil

      if(!$this->session->viewProfil) {                                         // jika session telah dihapus, maka inisialisasi ulang session tersebut
        redirect( base_url("Profil/lihatProfil") );
      }

      $this->load->view("pelanggan/profil");                                    // halaman profil
    }
  }

  public function promosiInstruktur() {
    $this->load->view("pelanggan/promosiinstruktur");
  }

  public function daftarInstruktur() {
    if(!$this->session->statusLogin) {
      echo "<script>
            alert('sesi telah kadaluwarsa, login kembali untuk melanjutkan !');
            window.location = '". base_url("Autentikasi/loginAkun"). "';
            </script>";
    }else{
      $this->session->set_userdata("baseDaftarInstruktur", "PELANGGAN");        // baseDaftarInstruktur = container/wadah yang berisi halaman daftar instruktur

      if(!$this->session->viewDaftarInstruktur) {                               // jika session telah dihapus, maka inisialisasi ulang session tersebut
        redirect( base_url("Instruktur/daftarInstruktur") );
      }

      $this->load->view("pelanggan/daftarinstruktur");                          // halaman daftar instruktur untuk pelanggan
    }
  }
  
}
?>
