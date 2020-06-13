<?php
class Umum extends CI_Controller {                                              // controller umum yang dipakai oleh seluruh pengguna
  public function __construct() {
    parent::__construct();                                                      // menjalankan method __construct() dari class parent: "CI_Controller"

    $this->load->model("AkunModel");                                            // load Model: AkunModel
    $this->load->model("InstrukturModel");
  }

  protected function kirimEmail($token, $email, $tujuan) {                      // method yang digunakan untuk mengirim email
    $this->email->set_mailtype("html");                                                     // setel mailtype: html
    $this->email->from("itsupport-duniasiber@email.com", "IT Support-duniasiber");          // (hanya untuk sementara)
    $this->email->to($email);                                                               // email pemilik akun

    $data["email"] = $email;
    $data["tujuan"] = $tujuan;

    if($tujuan == "VERIFIKASI") {                                                           // pengiriman email untuk tujuan verifikasi email
      $this->email->subject("Verifikasi Email - DuniaSiber");
      $data["token"] = base_url("Autentikasi/verifikasiEmail"). "?t=". $token;
    }else if($tujuan == "RESETPASSWORD") {                                                  // pengiriman email untuk tujuan reset password
      $this->email->subject("Reset Password - DuniaSiber");
      $data["token"] = base_url("Autentikasi/lupaPassword"). "?t=". $token;
    }else if($tujuan == "UBAHEMAIL") {                                                      // pengiriman email untuk tujuan ubah email
      $this->email->subject("Verifikasi Perubahan Email - DuniaSiber");
      $data["token"] = base_url("Profil/gantiEmail"). "?t=". $token;
    }

    $dataEmail = $this->load->view("layout/email", $data, TRUE);
    $this->email->message($dataEmail);

    $this->email->send();
  }

  public function kirimUlangEmail() {                                                       // fitur kirim ulang email
    if($this->session->waktuKadaluwarsa > date("Y-m-d H:i:s")) {
      if($this->session->tujuan == "VERIFIKASI") {
        $token = $this->AkunModel->inisialisasiToken($this->session->akunTokenIndeks, $this->session->tujuan);
        $this->kirimEmail($token, $this->session->akunEmail, $this->session->tujuan);
        $this->session->set_userdata("waktuKadaluwarsa", date( "Y-m-d H:i:s", strtotime("+3 minutes", strtotime(date("Y-m-d H:i:s"))) ));
        /*
        nilai waktuKadaluwarsa di reset
        */

        $this->session->set_userdata("sinyalVerifikasi", TRUE);
        redirect( base_url("Autentikasi/verifikasiEmail") );
      }else if($this->session->tujuan == "RESETPASSWORD") {
        $token = $this->AkunModel->inisialisasiToken($this->session->akunTokenIndeks, $this->session->tujuan);
        $this->kirimEmail($token, $this->session->akunEmail, $this->session->tujuan);
        $this->session->set_userdata("waktuKadaluwarsa", date( "Y-m-d H:i:s", strtotime("+3 minutes", strtotime(date("Y-m-d H:i:s"))) ));

        $this->session->set_userdata("sinyalVerifikasi", TRUE);
        redirect( base_url("Autentikasi/lupaPassword") );
      }else if($this->session->tujuan == "UBAHEMAIL") {
        $this->AkunModel->inisialisasiToken($this->session->akunTokenIndeks, $this->session->tujuan, $this->session->token);
        $this->kirimEmail($this->session->token, $this->session->akunEmail, $this->session->tujuan);
        $this->session->set_userdata("waktuKadaluwarsa", date( "Y-m-d H:i:s", strtotime("+3 minutes", strtotime(date("Y-m-d H:i:s"))) ));

        $this->session->set_userdata("sinyalVerifikasi", TRUE);
        redirect( base_url("Profil/gantiEmail") );
      }
    }else {
      $this->session->unset_userdata("akunTokenIndeks");
      $this->session->unset_userdata("akunEmail");
      $this->session->unset_userdata("token");                                  // session "token" dipakai pada fitur "ubah email"
      $this->session->unset_userdata("tujuan");
      $this->session->unset_userdata("waktuKadaluwarsa");
    }

    if(!$this->session->waktuKadaluwarsa) {
      echo "<script>
            alert('sesi telah kadaluwarsa !');
            window.location = '". base_url("Pelanggan"). "';
            </script>";
    }
  }
}
?>
