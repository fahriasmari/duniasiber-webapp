<?php
require_once("Umum.php");                      // include controller Umum (general) untuk inheritance pada class Autentikasi

class Autentikasi extends Umum {               // penamaan controller dan model harus kapital, saya rekomendasikan menggunakan format pernamaan: "pascal case"

  public function daftarAkun() {               // untuk penamaan method dan variabel, saya rekomendasikan menggunankan format penamaan: "camel case"
    if(!$this->session->statusLogin) {         // pembatasan akses jika akun sudah login
      if($this->input->post()) {                                                                   // jika ada input method POST ($_POST)
        $this->AkunModel->buatBaru($this->input->post());                                          // jalankan method "buatBaru" di class AkunModel (Model)
        $this->loginAkun($this->input->post("usernameTxt"), $this->input->post("passwordTxt"));    // setelah membuat akun, langsung diarahkan untuk login
      }

      $this->load->view("otentikasi/daftar");                                                      // load view dari: application/views/otentikasi/daftar
    }else {
      echo "<script>
            alert('sesi login akun masih berlangsung !');
           ";
      if($this->session->akunPeran == "ADMIN") {
        echo "window.location = '". base_url("Admin"). "';";
      }else if($this->session->akunPeran == "PELANGGAN") {
        echo "window.location = '". base_url("Pelanggan"). "';";
      }
      echo "</script>";
    }
  }

  public function validasiUsername() {
    if($this->input->post()) {                                                  // bertujuan untuk mencegah method "validasi" di akses langsung oleh URL
      $_errUsername = "";                                                       // nilai untuk menampung jenis error yang ditemukan

      $_username    = $this->input->post("username");

      if(empty($_username)) {
        $_errUsername = "kosong";
      }else if($data = $this->AkunModel->cekUsername($_username)) {
        if(!empty($data)) {
          $_errUsername = "sudahDipakai";
        }
      }else if(!preg_match( "/^[a-z0-9_-]*$/", $_username )) {                  // jika variabel tidak sesuai dengan format regex
        $_errUsername = "regex";
      }

      echo json_encode([ "errUsername" => $_errUsername ]);
    }else {
      redirect( base_url("Pelanggan") );
    }
  }

  public function validasiDaftar() {
    if($this->input->post()) {
      $_error          = FALSE;                                                 // nilai parameter jika ada error yang ditemukan
      $_errNama        = "";                                                    // nilai untuk menampung jenis error yang ditemukan
      $_errEmail       = "";
      $_errUsername    = "";
      $_errPassword    = "";

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
        $_error       = TRUE;
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

      if($_error) {                                                             // jika $_error == TRUE
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
    }else {
      redirect( base_url("Pelanggan") );
    }
  }

  public function loginAkun($username=null, $password=null) {                   // parameter default dari suatu method, username dan password = NULL
    if(!$this->session->statusLogin) {
      if(isset($username) && isset($password)) {
        $dataAkun = $this->AkunModel->lakukanLogin($username, $password);
      }else if($this->input->post()) {
        $dataAkun = $this->AkunModel->lakukanLogin($this->input->post("userTxt"), $this->input->post("passwordTxt"));
      }
      /*
      method "loginAkun" dipakai melalui input method POST atau dipanggil melalui method controller
      */

      if(isset($dataAkun)) {
        if($dataAkun == FALSE) {                                                // login gagal
          $data["alert"] = "Login Gagal !";
        }else {
          if( empty($dataAkun->diaktivasi_pada) ) {
            $this->verifikasiEmail($dataAkun->akun_id, $dataAkun->email);       // jika akun belum memverifikasi email
          }else {
            $this->session->set_userdata("statusLogin", TRUE);                  // inisialisasi session ketika proses login
            $this->session->set_userdata("akunId", $dataAkun->akun_id);
            $this->session->set_userdata("akunNama", $dataAkun->nama);
            $this->session->set_userdata("akunPeran", $dataAkun->peran);

            $dataFoto = $this->AkunModel->ambilDataFoto($dataAkun->foto_indeks);
            $this->session->set_userdata("fotoAkun", $dataFoto->nilai);         // foto profil di inisialisasi pada session ketika login

            $dataInstruktur = $this->InstrukturModel->ambilDataInstruktur($dataAkun->akun_id);
            if(!empty($dataInstruktur)) {                                       // id instruktur di inisialisasi pada session ketika login
              $this->session->set_userdata("instrukturId", $dataInstruktur->instruktur_id);
            }else {
              $this->session->set_userdata("instrukturId", FALSE);
            }

            if($dataAkun->peran == "ADMIN") {
              redirect( base_url("Admin") );                                    // jika peran adalah "ADMIN" arahkan ke controller: Admin
            }else if($dataAkun->peran == "PELANGGAN") {
              redirect( base_url("Pelanggan") );                                // jika peran adalah "PELANGGAN" arahkan ke controller: Pelanggan
            }
          }
        }
      }

      $this->load->view("otentikasi/login", @$data);
    }else {
      echo "<script>
            alert('sesi login akun masih berlangsung !');
           ";
      if($this->session->akunPeran == "ADMIN") {
        echo "window.location = '". base_url("Admin"). "';";
      }else if($this->session->akunPeran == "PELANGGAN") {
        echo "window.location = '". base_url("Pelanggan"). "';";
      }
      echo "</script>";
    }
  }

  public function validasiLogin() {
    if($this->input->post()) {
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
    }else {
      redirect( base_url("Pelanggan") );
    }
  }

  public function verifikasiEmail($id=null, $email=null) {                      // id dan email akun
    if(!$this->session->statusLogin) {
      if( isset($id) && isset($email) ) {
        $tujuan = "VERIFIKASI";                                                 // $tujuan dipakai untuk pengkategorian token dan email

        $dataIndeks = $this->AkunModel->ambilNilaiIndeks($id);                                // proses untuk mengetahui nilai token_indeks suatu akun
        $token      = $this->AkunModel->inisialisasiToken($dataIndeks->token_indeks, $tujuan);// inisialisasi token
        $this->kirimEmail($token, $email, $tujuan);                                           // method ini terdapat pada class parent: Umum

        $this->session->set_userdata("akunTokenIndeks", $dataIndeks->token_indeks);           // parsing data penting akun dalam bentuk session
        $this->session->set_userdata("akunEmail", $email);
        $this->session->set_userdata("tujuan", $tujuan);
        $this->session->set_userdata("waktuKadaluwarsa", date( "Y-m-d H:i:s", strtotime("+3 minutes", strtotime(date("Y-m-d H:i:s"))) ));
        /*
        parameter waktu kadaluwarsa session, session akan kadaluwarsa dalam 3 menit
        */

        $this->session->set_userdata("sinyalVerifikasi", TRUE);                 // setel session sinyalVerifikasi ( $_SESSION["sinyalVerifikasi"] )
        redirect( base_url("Autentikasi/verifikasiEmail") );
      }else if($this->session->sinyalVerifikasi) {                              // pemberitahuan ketika email sudah dikirim
        $data["pesan"] = "<p>
                            Permintaan aktivasi akun telah dikirim ke email, silahkan buka email untuk melakukan proses aktivasi.
                            email aktivasi akan kadaluwarsa dalam 10 menit!
                          </p>
                          <p>
                            Email tidak terkirim ? <br>
                            <a href='#' class='btn btn-primary disabled' id='kirimUlang' style='margin-top: 10px;'>
                              Kirim ulang email dalam <span id='detikTimer'>60</span>
                            </a>
                          </p>";

        $this->session->unset_userdata("sinyalVerifikasi");                     // hapus variabel $_SESSION["sinyalVerifikasi"]
      }else if($this->input->get("t")) {                                        // jika ada input token ( $_GET["t"] )
        $dataToken = $this->AkunModel->cekToken($this->input->get("t"));

        if(!empty($dataToken)) {
          if( $dataToken->tgl_kadaluwarsa > date("Y-m-d H:i:s") ) {             // jika tanggal kadaluwarsa token melebihi tanggal sekarang
            if( $dataToken->tujuan == "VERIFIKASI" ) {
              $this->AkunModel->aktivasiAkun($dataToken->akun_id, $dataToken->token_indeks);
              $data["pesan"] = "<p>
                                  Aktivasi akun berhasil,
                                  <a href='". base_url("Autentikasi/loginAkun"). "' class='alert-link'> klik disini </a> untuk login kembali
                                </p>";
            }else {
              $data["pesan"] = "<p> Token telah kadaluwarsa </p>";
            }
          }else {
            $data["pesan"] = "<p> Token telah kadaluwarsa </p>";
          }
        }else {
          $data["pesan"] = "<p> Token telah kadaluwarsa </p>";
        }
      }

      $this->load->view("otentikasi/verifikasi", @$data);
    }else {
      echo "<script>
            alert('sesi login akun masih berlangsung !');
           ";
      if($this->session->akunPeran == "ADMIN") {
        echo "window.location = '". base_url("Admin"). "';";
      }else if($this->session->akunPeran == "PELANGGAN") {
        echo "window.location = '". base_url("Pelanggan"). "';";
      }
      echo "</script>";
    }
  }

  public function lupaPassword() {
    if(!$this->session->statusLogin) {
      if($this->input->post()) {
        if($this->session->statusResetPass) {
          $this->AkunModel->ubahPassword( $this->session->akunId, $this->input->post("passwordTxt"), $this->session->akunToken_Indeks );

          $this->session->unset_userdata("statusResetPass");
          $this->session->unset_userdata("akunToken_Indeks");
          $this->session->unset_userdata("akunId");

          $data["pesan"] = "<p>
                              Password telah diubah,
                              <a href='". base_url("Autentikasi/loginAkun"). "' class='alert-link'> klik disini </a> untuk login kembali
                            </p>";
        }else {
          $tujuan     = "RESETPASSWORD";

          $dataIndeks = $this->AkunModel->ambilNilaiIndeks($this->input->post("emailTxt"));
          $token      = $this->AkunModel->inisialisasiToken($dataIndeks->token_indeks, $tujuan);      // inisialisasi token untuk reset password
          $this->kirimEmail($token, $this->input->post("emailTxt"), $tujuan);

          $this->session->set_userdata("akunTokenIndeks", $dataIndeks->token_indeks);
          $this->session->set_userdata("akunEmail", $this->input->post("emailTxt"));
          $this->session->set_userdata("tujuan", $tujuan);
          $this->session->set_userdata("waktuKadaluwarsa", date( "Y-m-d H:i:s", strtotime("+3 minutes", strtotime(date("Y-m-d H:i:s"))) ));

          $this->session->set_userdata("sinyalVerifikasi", TRUE);
          redirect( base_url("Autentikasi/lupaPassword") );
        }
      }else if($this->session->sinyalVerifikasi) {
        $data["pesan"] = "<p>
                            Permintaan reset password telah dikirim ke email, silahkan buka email untuk melakukan proses reset password.
                            email reset password akan kadaluwarsa dalam 10 menit!
                          </p>
                          <p>
                            Email tidak terkirim ? <br>
                            <a href='#' class='btn btn-primary disabled' id='kirimUlang' style='margin-top: 10px;'>
                              Kirim ulang email dalam <span id='detikTimer'>60</span>
                            </a>
                          </p>";

        $this->session->unset_userdata("sinyalVerifikasi");
      }else if($this->input->get("t")) {
        $dataToken = $this->AkunModel->cekToken($this->input->get("t"));

        if(!empty($dataToken)) {
          if( $dataToken->tgl_kadaluwarsa > date("Y-m-d H:i:s") ) {
            if( $dataToken->tujuan == "RESETPASSWORD" ) {
              $this->session->set_userdata("statusResetPass", TRUE);                                  // mode form: atur ulang password baru = diaktifkan!
              $this->session->set_userdata("akunToken_Indeks", $dataToken->token_indeks);             // dibuat hanya untuk parsing data
              $this->session->set_userdata("akunId", $dataToken->akun_id);

              redirect( base_url("Autentikasi/lupaPassword") );
            }else {
              $data["pesan"] = "<p> Token telah kadaluwarsa </p>";
            }
          }else {
            $data["pesan"] = "<p> Token telah kadaluwarsa </p>";
          }
        }else {
          $data["pesan"] = "<p> Token telah kadaluwarsa </p>";
        }
      }

      $this->load->view("otentikasi/resetpassword" , @$data);
    }else {
      echo "<script>
            alert('sesi login akun masih berlangsung !');
           ";
      if($this->session->akunPeran == "ADMIN") {
        echo "window.location = '". base_url("Admin"). "';";
      }else if($this->session->akunPeran == "PELANGGAN") {
        echo "window.location = '". base_url("Pelanggan"). "';";
      }
      echo "</script>";
    }
  }

  public function validasiRequestUbahPassword() {
    if($this->input->post()) {
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
    }else {
      redirect( base_url("Pelanggan") );
    }
  }

  public function validasiAturUlangPassBaru() {
    if($this->input->post()) {
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
    }else {
      redirect( base_url("Pelanggan") );
    }
  }

  public function logoutAkun() {
    $this->session->unset_userdata("statusLogin");
    $this->session->unset_userdata("akunId");
    $this->session->unset_userdata("akunNama");
    $this->session->unset_userdata("akunPeran");
    $this->session->unset_userdata("fotoAkun");
    $this->session->unset_userdata("instrukturId");

    /*
    (area session yang digunakan sebagai container untuk view yang dinamis)
    */
    $this->session->unset_userdata("baseProfil");                      // session yang berfungsi sebagai container yang menampung halaman profil
    $this->session->unset_userdata("baseDaftarInstruktur");            // session yang berfungsi sebagai container yang menampung halaman daftar instruktur
    $this->session->unset_userdata("baseKursus");                      // dan seterus nya ...
    $this->session->unset_userdata("baseTambahKursus");

    redirect( base_url("Pelanggan") );
  }
}
?>
