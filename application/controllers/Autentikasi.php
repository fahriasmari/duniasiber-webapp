<?php
class Autentikasi extends CI_Controller {        // penamaan controller, dan model harus kapital, saya rekomendasikan menggunakan format pernamaan: "pascal case"
  public function __construct() {
    parent::__construct();                       // menjalankan method __construct() dari class (parent): "CI_Controller"

    $this->load->model("AkunModel");             // load Model: AkunModel

    $emailConfig = array(                        // konfigurasi email server
                        "protocol"  => "smtp",
                        "smtp_host" => "smtp.mailtrap.io",
                        "smtp_port" => "2525",
                        "smtp_user" => "f63429fe7364d3",
                        "smtp_pass" => "d0b545d4b694f8",
                        "crlf"      => "\r\n",
                        "newline"   => "\r\n"
                      );
    /*
    disini saya menggunakan dummy email server dari mailtrap.io,
    karena belum mendapatkan email server yang gratis.
    silahkan ubah konfigurasi nya menggunakan akun mailtrap masing2
    */
    $this->email->initialize($emailConfig);      // inisialisasi konfigurasi email
  }

  public function daftarAkun() {                 // untuk penamaan method dan variabel, saya rekomendasikan menggunankan format penamaan: "camel case"
    if($this->input->post()) {                                                                      // jika ada input method POST ($_POST)
      $this->AkunModel->buatBaru($this->input->post());                                             // jalankan method "buatBaru" di class AkunModel (Model)
      $this->loginAkun($this->input->post("usernameTxt"), $this->input->post("passwordTxt"));       // setelah membuat akun, langsung diarahkan untuk login
    }

    $this->load->view("otentikasi/daftar");                                                         // load view dari: application/views/otentikasi/daftar
  }

  public function validasiUsername() {
    $_errUsername = "";                                                         // ( nilai untuk menampung jenis error yang ditemukan )

    $_username    = $this->input->post("username");

    if(empty($_username)) {
      $_errUsername = "kosong";
    }else if($data = $this->AkunModel->cekUsername($_username)) {
      if(!empty($data)) {
        $_errUsername = "sudahDipakai";
      }
    }else if(!preg_match( "/^[a-z0-9_-]*$/", $_username )) {                    // ( jika variabel tidak sesuai dengan format regex )
      $_errUsername = "regex";
    }

    echo json_encode([ "errUsername" => $_errUsername ]);
  }

  public function validasiDaftar() {
    $_error          = FALSE;                                                   // ( nilai parameter jika ada error yang ditemukan )
    $_errNama        = "";                                                      //
    $_errEmail       = "";                                                      // ( nilai untuk menampung jenis error yang ditemukan )
    $_errUsername    = "";                                                      //
    $_errPassword    = "";                                                      //

    $_nama           = $this->input->post("nama");
    $_email          = $this->input->post("email");
    $_username       = $this->input->post("username");
    $_password       = $this->input->post("password");
    $_ulangipassword = $this->input->post("ulangipassword");

    if(empty($_nama)) {
      $_error   = TRUE;
      $_errNama = "kosong";
    }else if(!preg_match( "/^[a-zA-Z ]*$/", $_nama )) {
      $_error   = TRUE;
      $_errNama = "regex";
    }

    if(empty($_email)) {
      $_error    = TRUE;
      $_errEmail = "kosong";
    }else if($data = $this->AkunModel->cekEmail($_email)) {
      if(!empty($data)) {
        $_error    = TRUE;
        $_errEmail = "sudahDipakai";
      }
    }else if(!filter_var($_email, FILTER_VALIDATE_EMAIL)) {
      $_error    = TRUE;
      $_errEmail = "regex";
    }

    if(empty($_username)) {
      $_error    = TRUE;
      $_errUsername = "kosong";
    }else if($data = $this->AkunModel->cekUsername($_username)) {
      if(!empty($data)) {
        $_error       = TRUE;
        $_errUsername = "sudahDipakai";
      }
    }else if(!preg_match( "/^[a-z0-9_-]*$/", $_username )) {
      $_error       = TRUE;
      $_errUsername = "regex";
    }

    if(empty($_password) || empty($_ulangipassword)) {
      $_error       = TRUE;
      $_errPassword = "kosong";
    }else if( strcmp($_password, $_ulangipassword) != 0 ) {
      $_error       = TRUE;
      $_errPassword = "tidakSama";
    }

    if($_error) {                                                               // ( jika $_error == TRUE )
      echo json_encode([
                        "error"       => $_error,
                        "errNama"     => $_errNama,
                        "errEmail"    => $_errEmail,
                        "errUsername" => $_errUsername,
                        "errPassword" => $_errPassword
                      ]);
    }else {
      echo json_encode([ "error" => $_error ]);
    }
  }

  public function loginAkun($username=null, $password=null) {              // parameter default dari suatu method, username dan password = NULL
    if(isset($username) && isset($password)) {
      $akun = $this->AkunModel->lakukanLogin($username, $password);
    }else if($this->input->post()) {
      $akun = $this->AkunModel->lakukanLogin($this->input->post("userTxt"), $this->input->post("passwordTxt"));
      /*
      method "loginAkun" bisa dipakai melalui input method POST atau dipanggil melalui method controller
      */
    }

    if(isset($akun)) {
      if($akun == "loginGagal") {                                          // (login gagal)
        $data["alert"] = "Login Gagal !";
      }else {
        if( empty($akun->diaktivasi_pada) ) {
          $this->verifikasiEmail($akun->akun_id, $akun->email);            // jika akun belum di aktivasi/memverifikasi email
        }else {
          $this->session->set_userdata("statuslogin", "sedangLogin");      //
          $this->session->set_userdata("nama", $akun->nama);               // inisialisasi session ketika proses login
          $this->session->set_userdata("peran", $akun->peran);             //

          if($akun->peran == "ADMIN") {
            redirect("http://127.0.0.1/duniasiber/index.php/Admin");       // jika peran adalah "ADMIN" arahkan ke controller: Admin
          }else if($akun->peran == "PELANGGAN") {
            redirect("http://127.0.0.1/duniasiber/index.php/Pelanggan");   // jika peran adalah "PELANGGAN" arahkan ke controller: Pelanggan
          }

        }
      }
    }

    $this->load->view("otentikasi/login", @$data);
  }

  public function validasiLogin() {
    $_error       = FALSE;
    $_errUser     = "";
    $_errPassword = "";

    $_user     = $this->input->post("user");
    $_password = $this->input->post("password");

    if(empty($_user)) {
      $_error   = TRUE;
      $_errUser = "kosong";
    }

    if(empty($_password)) {
      $_error       = TRUE;
      $_errPassword = "kosong";
    }

    if($_error) {
      echo json_encode([
                        "error"       => $_error,
                        "errUser"     => $_errUser,
                        "errPassword" => $_errPassword
                      ]);
    }else {
      echo json_encode([ "error" => $_error ]);
    }
  }

  public function verifikasiEmail($id=null, $email=null) {                      // (id dan email akun)
    if( isset($id) ) {
      $token = $this->AkunModel->inisialisasiToken($id);
      $this->kirimEmail($token, $email, "VERIFIKASI");                                      // method yang digunakan untuk mengirim email
      $this->session->set_userdata("sinyalVerifikasi", TRUE);                               // setel session sinyalVerifikasi ( $_SESSION["sinyalVerifikasi"] )
      redirect("http://127.0.0.1/duniasiber/index.php/Autentikasi/verifikasiEmail");
    }else if($this->session->sinyalVerifikasi) {                                            // ( pemberitahuan ketika email sudah dikirim )
      $data["pesan"] = "Permintaan aktivasi akun telah dikirim ke email, silahkan buka email untuk melakukan proses aktivasi.
                        email aktivasi akan kadaluarsa dalam 10 menit! <a href='#' class='alert-link'> Kirim ulang email ? </a>";
                        // (fitur "kirim ulang email" dalam proses maintenance)

      $this->session->unset_userdata("sinyalVerifikasi");                                   // hapus variabel $_SESSION["sinyalVerifikasi"]
    }else if($this->input->get("t")) {                                          // jika ada input token ( $_GET["t"] )
      $akun = $this->AkunModel->cekToken($this->input->get("t"));

      if(!empty($akun)) {
        if( $akun->tgl_kadaluarsa_token > date("Y-m-d H:i:s") ) {               // jika tanggal kadaluarsa token melebihi tanggal sekarang
          $this->AkunModel->aktivasiAkun($akun->akun_id);
          $data["pesan"] = "Aktivasi akun berhasil,
                            <a href='http://127.0.0.1/duniasiber/index.php/Autentikasi/loginAkun' class='alert-link'> klik disini </a> untuk login kembali";
        }else {
          $data["pesan"] = "Token telah kadaluarsa";
        }
      }else {
        $data["pesan"] = "Token telah kadaluarsa";
      }
    }

    $this->load->view("otentikasi/verifikasi", @$data);
  }

  public function lupaPassword() {
    if($this->input->post()) {
      if($this->session->statusResetPass) {
        $this->AkunModel->ubahPassword( $this->session->akunId, $this->input->post("passwordTxt") );

        $this->session->unset_userdata("statusResetPass");
        $this->session->unset_userdata("akunId");

        $data["pesan"] = "Password telah diubah,
                          <a href='http://127.0.0.1/duniasiber/index.php/Autentikasi/loginAkun' class='alert-link'> klik disini </a> untuk login kembali";
      }else {
        $token = $this->AkunModel->inisialisasiToken($this->input->post("emailTxt"));       // inisialisasi token untuk reset password
        $this->kirimEmail($token, $this->input->post("emailTxt"), "RESETPASSWORD");

        $data["pesan"] = "Permintaan reset password telah dikirim ke email, silahkan buka email untuk melakukan proses reset password.
                          email reset password akan kadaluarsa dalam 10 menit! <a href='#' class='alert-link'> Kirim ulang email ? </a>";
                          // (fitur "kirim ulang email" dalam proses maintenance)
      }
    }else if($this->input->get("t")) {
      $akun = $this->AkunModel->cekToken($this->input->get("t"));

      if(!empty($akun)) {
        if( $akun->tgl_kadaluarsa_token > date("Y-m-d H:i:s") ) {
          $this->session->set_userdata("statusResetPass", TRUE);                            // ( mode form: atur ulang password baru = diaktifkan! )
          $this->session->set_userdata("akunId", $akun->akun_id);                           // dibuat hanya untuk parsing data akun_id

          redirect("http://127.0.0.1/duniasiber/index.php/Autentikasi/lupaPassword");
        }else {
          $data["pesan"] = "Token telah kadaluarsa";
        }
      }else {
        $data["pesan"] = "Token telah kadaluarsa";
      }
    }

    $this->load->view("otentikasi/resetpassword" , @$data);
  }

  public function validasiRequestUbahPassword() {
    $_error    = FALSE;
    $_errEmail = "";

    $_email    = $this->input->post("email");

    if(empty($_email)) {
      $_error    = TRUE;
      $_errEmail = "kosong";
    }else if(!filter_var($_email, FILTER_VALIDATE_EMAIL)) {
      $_error    = TRUE;
      $_errEmail = "regex";
    }

    if($_error) {
      echo json_encode([
                        "error"    => $_error,
                        "errEmail" => $_errEmail
                      ]);
    }else {
      echo json_encode([ "error" => $_error ]);
    }
  }

  public function validasiAturUlangPassBaru() {
    $_error       = FALSE;
    $_errPassword = "";

    $_password       = $this->input->post("password");
    $_ulangipassword = $this->input->post("ulangipassword");

    if(empty($_password) || empty($_ulangipassword)) {
      $_error       = TRUE;
      $_errPassword = "kosong";
    }else if( strcmp($_password, $_ulangipassword) != 0 ) {
      $_error       = TRUE;
      $_errPassword = "tidakSama";
    }

    if($_error) {
      echo json_encode([
                        "error"       => $_error,
                        "errPassword" => $_errPassword
                      ]);
    }else {
      echo json_encode([ "error" => $_error ]);
    }
  }

  public function kirimEmail($token, $email, $tujuan) {
    $this->email->from("itsupport-duniasiber@email.com", "IT Support-duniasiber");          // (hanya untuk sementara)
    $this->email->to($email);                                                               // email pemilik akun

    if($tujuan == "VERIFIKASI") {                                                                            // pengiriman email untuk tujuan aktivasi akun
      $this->email->subject("Verifikasi Email");
      $this->email->message("http://127.0.0.1/duniasiber/index.php/Autentikasi/verifikasiEmail?t=". $token);
    }else if($tujuan == "RESETPASSWORD") {                                                                   // pengiriman email untuk tujuan reset password
      $this->email->subject("Reset Password");
      $this->email->message("http://127.0.0.1/duniasiber/index.php/Autentikasi/lupaPassword?t=". $token);
    }

    $this->email->send();
  }
}
?>
