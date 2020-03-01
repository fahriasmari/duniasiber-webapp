<?php
class Autentikasi extends CI_Controller {
  public function __construct() {
    parent::__construct();                  // menjalankan method __construct() dari class CI_Controller

    $this->load->model("AkunModel");        // load Model: AkunModel

    $config = array(                        // konfigurasi email server
                  'protocol'  => 'smtp',
                  'smtp_host' => 'smtp.mailtrap.io',
                  'smtp_port' => '2525',
                  'smtp_user' => 'f63429fe7364d3',
                  'smtp_pass' => 'd0b545d4b694f8',
                  'crlf'      => "\r\n",
                  'newline'   => "\r\n"
              );
    /*
    disini saya menggunakan dummy email server dari mailtrap.io,
    karena belum mendapatkan email server yang gratis.
    silahkan ubah konfigurasi nya menggunakan akun mailtrap masing2
    */
    $this->email->initialize($config);
  }

  public function daftarAkun() {
    if($this->input->post()) {                                                                      // jika ada method POST
      if(strcmp($this->input->post("passwordTxt"), $this->input->post("ulangipasswordTxt")) != 0) {
        $data['pesanErr'] = "~password tidak sama!";
        /*
        verifikasi kesamaan password (hanya untuk sementara),
        untuk pengembangan selanjutnya validasi akan menggunakan ajax.
        */
      }else {
        $this->AkunModel->buatBaru($this->input->post());                                           // jalankan method "buatBaru" di class "AkunModel"
        $this->loginAkun($this->input->post("usernameTxt"), $this->input->post("passwordTxt"));
      }
    }

    $this->load->view("otentikasi/daftar", @$data);                                                 // load view dari: application/views/otentikasi/login
  }

  public function loginAkun($username=null, $password=null) {              // parameter default dari suatu method, username dan password = NULL
    if(isset($username) && isset($password)) {
      $akun = $this->AkunModel->lakukanLogin($username, $password);
    }else if($this->input->post()) {
      $akun = $this->AkunModel->lakukanLogin($this->input->post("userTxt"), $this->input->post("passwordTxt"));
      /*
      method "loginAkun" bisa dipakai melalui method POST atau dipanggil melalui controller
      */
    }

    if(isset($akun)) {
      if($akun == "loginGagal") {                                          // (login gagal)
        $data['pesanErr'] = "~login gagal!";
      }else {
        if( empty($akun->diaktivasi_pada) ) {
          $this->verifikasiEmail($akun->akun_id, $akun->email);            // jika akun belum di verifikasi/aktivasi
        }else {
          $this->session->set_userdata('statuslogin', TRUE);               //
          $this->session->set_userdata('nama', $akun->nama);               // inisialisasi session ketika proses login
          $this->session->set_userdata('peran', $akun->peran);             //

          if($akun->peran == "ADMIN") {
            redirect("http://127.0.0.1/duniasiber/index.php/Admin");       // jika peran adalah "ADMIN" arahkan ke controller: Admin
          }else if($akun->peran == "PELANGGAN") {
            redirect("http://127.0.0.1/duniasiber/index.php/Pelanggan");   // jika peran adalah "PELANGGAN" arahkan ke controller: Pelanggan (hanya untuk sementara)
          }

        }
      }
    }

    $this->load->view("otentikasi/login", @$data);
  }

  public function verifikasiEmail($id=null, $email=null) {
    if( isset($id) ) {
      $token = $this->AkunModel->inisialisasiToken($id);                                    // proses pembuatan token untuk verifikasi/aktivasi akun
      $this->kirimEmail($token, $email, "VERIFIKASI");                                      // method yang digunakan untuk mengirim email
      $this->session->set_userdata('sinyalVerifikasi', TRUE);
      redirect("http://127.0.0.1/duniasiber/index.php/Autentikasi/verifikasiEmail");
    }else if($this->session->sinyalVerifikasi) {                                            // pemberitahuan ketika email sudah dikirim
      $data['pesan'] = "~permintaan aktivasi akun telah dikirim ke email, silahkan buka email untuk melakukan proses aktivasi <br>
                        email aktivasi akan kadaluarsa dalam 10 menit!";
      $data['kirimUlangEmail'] = "<a href=\"#\"> kirim ulang email ? </a>";                 // (dalam proses maintenance)

      $this->session->unset_userdata("sinyalVerifikasi");                                   // hapus variabel $_SESSION['sinyalVerifikasi']
    }else if($this->input->get("t")) {
      $akun = $this->AkunModel->cekToken($this->input->get("t"));                           // cek token

      if(!empty($akun)) {
        if( $akun->tgl_kadaluarsa_token > date("Y-m-d H:i:s") ) {
          $this->AkunModel->aktivasiAkun($akun->akun_id);
          $data['statusVerifikasi'] = "~aktivasi akun berhasil";
        }else {
          $data['statusVerifikasi'] = "~token telah kadaluarsa";
        }
      }else {
        $data['statusVerifikasi'] = "~token telah kadaluarsa";
      }
    }

    $this->load->view("otentikasi/verifikasi", @$data);
  }

  public function lupaPassword() {
    if($this->input->post()) {
      if($this->session->statusResetPass) {
        if( strcmp($this->input->post("passwordTxt"), $this->input->post("ulangipasswordTxt")) != 0 ) {
          /*
          verifikasi kesamaan password (hanya untuk sementara),
          untuk pengembangan selanjutnya validasi akan menggunakan ajax.
          */
          $data['pesanErr'] = "~password tidak sama!";
        }else {
          $this->AkunModel->ubahPassword( $this->session->akunId, $this->input->post("passwordTxt") );

          $this->session->unset_userdata("statusResetPass");
          $this->session->unset_userdata("akunId");

          $data['pesan'] = "~password telah diubah";
        }
      }else {
        $token = $this->AkunModel->inisialisasiToken($this->input->post("emailTxt"));       // inisialisasi token untuk reset password
        $this->kirimEmail($token, $this->input->post("emailTxt"), "RESETPASSWORD");

        $data['pesan'] = "~permintaan reset password telah dikirim ke email, silahkan buka email untuk melakukan proses reset password <br>
                          email reset password akan kadaluarsa dalam 10 menit!";
      }
    }else if($this->input->get("t")) {
      $akun = $this->AkunModel->cekToken($this->input->get("t"));

      if(!empty($akun)) {
        if( $akun->tgl_kadaluarsa_token > date("Y-m-d H:i:s") ) {
          $this->session->set_userdata('statusResetPass', TRUE);
          $this->session->set_userdata('akunId', $akun->akun_id);                           // dibuat hanya untuk parsing data akun_id

          redirect("http://127.0.0.1/duniasiber/index.php/Autentikasi/lupaPassword");
        }else {
          $data['pesan'] = "~token telah kadaluarsa";
        }
      }else {
        $data['pesan'] = "~token telah kadaluarsa";
      }
    }

    $this->load->view("otentikasi/resetpassword" , @$data);
  }

  public function kirimEmail($token, $email, $tujuan) {
    $this->email->from('itsupport-duniasiber@email.com', 'IT Support-duniasiber');          // (hanya untuk sementara)
    $this->email->to($email);                                                               // email pemilik akun

    if($tujuan == "VERIFIKASI") {                                                                            // pengiriman email untuk tujuan aktivasi akun
      $this->email->subject('Verifikasi Email');
      $this->email->message("http://127.0.0.1/duniasiber/index.php/Autentikasi/verifikasiEmail?t=". $token);
    }else if($tujuan == "RESETPASSWORD") {                                                                   // pengiriman email untuk tujuan reset password
      $this->email->subject('Reset Password');
      $this->email->message("http://127.0.0.1/duniasiber/index.php/Autentikasi/lupaPassword?t=". $token);
    }

    $this->email->send();
  }
}
?>
