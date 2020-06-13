<?php
require_once("Umum.php");

class Profil extends Umum {                                                     // controller ini dipakai oleh 2 role akun : ADMIN dan PELANGGAN
  public function lihatProfil() {
    if($this->session->statusLogin) {
      if($this->session->baseProfil) {                                          // pembatasan akses ketika session baseProfil belum di inisialisasi
        $dataAkun = $this->AkunModel->ambilDataAkun($this->session->akunId);
        $dataFoto = $this->AkunModel->ambilDataFoto($dataAkun->foto_indeks);

        $dataProfil = array(
                            "nama"     => $dataAkun->nama,
                            "email"    => $dataAkun->email,
                            "username" => $dataAkun->username,
                            "foto"     => $dataFoto->nilai
                           );

        if($this->session->instrukturId) {
          $dataInstruktur        = $this->InstrukturModel->ambilDataInstruktur($this->session->akunId);
          $dataProfil["profesi"] = $dataInstruktur->profesi;
          $dataProfil["tentang"] = $dataInstruktur->tentang;

          $dataRekeningBank         = json_decode($dataInstruktur->rekening_bank);
          $dataProfil["noRekening"] = $dataRekeningBank->nomor_rekening;
          $dataProfil["namaBank"]   = $dataRekeningBank->nama_bank;
          $dataProfil["atasNama"]   = $dataRekeningBank->atas_nama;
        }

        $view = $this->load->view("profil/halprofil", $dataProfil, TRUE);       // parsing view halaman profil
        $this->session->set_userdata("viewProfil", $view);

        if($this->session->baseProfil == "ADMIN") {
          redirect( base_url("Admin/profil") );
        }else if($this->session->baseProfil == "PELANGGAN") {
          redirect( base_url("Pelanggan/profil") );
        }else if($this->session->baseProfil == "INSTRUKTUR") {
          redirect( base_url("Instruktur/profil") );
        }
      }else {
        echo "<script>
              alert('akses dibatasi !');
              window.location = '". base_url("Pelanggan"). "';
              </script>";
      }
    }else {                                                                     // jika akun tidak sedang login
      echo "<script>
            alert('sesi telah kadaluwarsa, login kembali untuk melanjutkan !');
            window.location = '". base_url("Autentikasi/loginAkun"). "';
            </script>";
    }
  }

  public function suntingProfil() {
    if($this->input->post()) {
      $this->AkunModel->updateProfilAkun($this->session->akunId, $this->input->post());
      $this->session->set_userdata("alert", "Profil berhasil di sunting");        // pesan alert
      $this->session->set_userdata("akunNama", $this->input->post("namaTxt"));    // reset variabel session akunNama
      redirect( base_url("Profil/lihatProfil") );
    }else {
      redirect( base_url("Pelanggan") );
    }
  }

  public function validasiUsername() {
    if($this->input->post()) {
      $_errUsername = "";

      $_username    = $this->input->post("username");

      if(empty($_username)) {
        $_errUsername = "kosong";
      }else if($data = $this->AkunModel->cekUsername($_username)) {
        if(!empty($data)) {
          if($data->akun_id != $this->session->akunId) {
            $_errUsername = "sudahDipakai";
          }else {
            $_errUsername = "saatIni";
          }
        }
      }else if(!preg_match( "/^[a-z0-9_-]*$/", $_username )) {
        $_errUsername = "regex";
      }

      echo json_encode([ "errUsername" => $_errUsername ]);
    }else {
      redirect( base_url("Pelanggan") );
    }
  }

  public function validasiSuntingProfil() {
    if($this->input->post()) {
      $_error       = FALSE;
      $_errNama     = "";
      $_errUsername = "";

      $_nama        = $this->input->post("nama");
      $_username    = $this->input->post("username");

      if(empty($_nama)) {
        $_error   = TRUE;
        $_errNama = "kosong";
      }else if(!preg_match( "/^[a-zA-Z ]*$/", $_nama )) {
        $_error   = TRUE;
        $_errNama = "regex";
      }

      if(empty($_username)) {
        $_error       = TRUE;
        $_errUsername = "kosong";
      }else if($data = $this->AkunModel->cekUsername($_username)) {
        if(!empty($data)) {
          if($data->akun_id != $this->session->akunId) {
            $_error       = TRUE;
            $_errUsername = "sudahDipakai";
          }else {
            $_errUsername = "saatIni";
          }
        }
      }else if(!preg_match( "/^[a-z0-9_-]*$/", $_username )) {
        $_error       = TRUE;
        $_errUsername = "regex";
      }

      if($_error) {
        echo json_encode([
                          "error"       => $_error,
                          "errNama"     => $_errNama,
                          "errUsername" => $_errUsername
                        ]);
      }else {
        echo json_encode([ "error" => $_error ]);
      }
    }else {
      redirect( base_url("Pelanggan") );
    }
  }

  public function gantiPassword() {
    if($this->input->post()) {
      $this->AkunModel->ubahPassword($this->session->akunId, $this->input->post("passwordTxt"));
      $this->session->set_userdata("alert", "Password berhasil di ubah");
      redirect( base_url("Profil/lihatProfil") );
    }else {
      redirect( base_url("Pelanggan") );
    }
  }

  public function validasiGantiPassword() {
    if($this->input->post()) {
      $_error           = FALSE;
      $_errPasswordLama = "";
      $_errPassword     = "";

      $_passwordlama    = $this->input->post("passwordlama");
      $_password        = $this->input->post("password");
      $_ulangipassword  = $this->input->post("ulangipassword");

      $dataAkun = $this->AkunModel->ambilDataAkun($this->session->akunId);

      if(empty($_passwordlama)) {
        $_error           = TRUE;
        $_errPasswordLama = "kosong";
      }else if( strcmp( sha1(base64_encode($_passwordlama)), $dataAkun->password ) != 0 ) {
        $_error           = TRUE;
        $_errPasswordLama = "tidakSesuai";
      }

      if(empty($_password) || empty($_ulangipassword)) {
        $_error       = TRUE;
        $_errPassword = "kosong";
      }else if( strcmp($_password, $_ulangipassword) != 0 ) {
        $_error       = TRUE;
        $_errPassword = "tidakSama";
      }

      if($_error) {
        echo json_encode([
                          "error"           => $_error,
                          "errPasswordLama" => $_errPasswordLama,
                          "errPassword"     => $_errPassword
                        ]);
      }else {
        echo json_encode([ "error" => $_error ]);
      }
    }else {
      redirect( base_url("Pelanggan") );
    }
  }

  public function suntingInstruktur() {
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
                                "profesiInstruktur"      => $this->input->post("profesiTxt"),
                                "tentangInstruktur"      => $this->input->post("tentangTxt"),
                                "rekeningBankInstruktur" => $dataRekeningBank
                               );

      $this->InstrukturModel->updateDataInstruktur($this->session->akunId, $dataInstruktur);
      $this->session->set_userdata("alert", "Profil instruktur berhasil di sunting");
      redirect( base_url("Profil/lihatProfil") );
    }else {
      redirect( base_url("Pelanggan") );
    }
  }

  public function validasiSuntingInstruktur() {
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

  public function gantiEmail() {
    if($this->input->post()) {
      $tujuan = "UBAHEMAIL";

      $ciphering      = "AES-128-CTR";                 // method cipher: AES
      $options        = 0;                             // openssl flag
      $encryption_iv  = "1234567891011121";            // (saya kesulitan untuk mejelaskan ini, tapi kalian bisa cari tahu tentang "cipher block chaining")
      $encryption_key = "DuniaSiber";                  // key enkripsi

      $token = openssl_encrypt($this->input->post("emailTxt"), $ciphering, $encryption_key, $options, $encryption_iv);
      /*
      token merupakan plain text email yang telah di enkripsi
      */

      $dataIndeks = $this->AkunModel->ambilNilaiIndeks($this->session->akunId);
      $this->AkunModel->inisialisasiToken($dataIndeks->token_indeks, $tujuan, $token);
      $this->kirimEmail($token, $this->input->post("emailTxt"), $tujuan);

      $this->session->set_userdata("akunTokenIndeks", $dataIndeks->token_indeks);
      $this->session->set_userdata("akunEmail", $this->input->post("emailTxt"));
      $this->session->set_userdata("token", $token);
      $this->session->set_userdata("tujuan", $tujuan);
      $this->session->set_userdata("waktuKadaluwarsa", date( "Y-m-d H:i:s", strtotime("+3 minutes", strtotime(date("Y-m-d H:i:s"))) ));

      $this->session->set_userdata("sinyalVerifikasi", TRUE);
      redirect( base_url("Profil/gantiEmail") );
    }else if($this->session->sinyalVerifikasi) {
      $data["pesan"] = "<p>
                          Permintaan perubahan email telah dikirim ke email yang dituju, email akan segera berubah setelah melakukan verifikasi. <br>
                          silahkan buka email untuk melakukan proses verifikasi, email verifikasi akan kadaluwarsa dalam 10 menit!
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
          if( $dataToken->tujuan == "UBAHEMAIL" ) {
            $ciphering      = "AES-128-CTR";
            $options        = 0;
            $decryption_iv  = "1234567891011121";
            $decryption_key = "DuniaSiber";

            $email = openssl_decrypt($this->input->get("t"), $ciphering, $decryption_key, $options, $decryption_iv);

            $this->AkunModel->ubahEmailAkun($dataToken->akun_id, $email, $dataToken->token_indeks);

            $data["pesan"] = "<p>
                                Email berhasil di ubah,
                                <a href='". base_url("Profil/lihatProfil"). "' class='alert-link'> klik disini </a> untuk melihat profil
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

    $this->load->view("profil/verifikasi", @$data);
  }

  public function validasiGantiEmail() {
    if($this->input->post()) {
      $_error    = FALSE;
      $_errEmail = "";

      $_email    = $this->input->post("email");

      if(empty($_email)) {
        $_error    = TRUE;
        $_errEmail = "kosong";
      }else if($data = $this->AkunModel->cekEmail($_email)) {
        if(!empty($data)) {
          if($data->akun_id != $this->session->akunId) {
            $_error    = TRUE;
            $_errEmail = "sudahDipakai";
          }else {
            $_error    = TRUE;
            $_errEmail = "saatIni";
          }
        }
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

  public function gantiFotoProfil() {
    if(isset($_FILES["fotoprofilFile"])) {
      $filename     = bin2hex(random_bytes(8));                                 // generate filename

      $configUpload = array(                                                    // konfigurasi file upload untuk foto profil akun
                            "upload_path"      => "./assets/img/AKUN",          // direktori dimulai pada root folder
                            "allowed_types"    => "gif|jpg|png",
                            "max_size"         => 5120,                         // 5 mb
                            "max_width"        => 1024,                         // 1024 px
                            "max_height"       => 1024,                         // 1024 px
                            "file_name"        => $filename,
                            "file_ext_tolower" => TRUE
                           );

      $this->upload->initialize($configUpload);

      if($this->upload->do_upload("fotoprofilFile")) {
        $dataIndeks = $this->AkunModel->ambilNilaiIndeks($this->session->akunId);
        $filename   = $this->upload->data("file_name");                         // filename foto yang telah di upload

        $this->AkunModel->ubahFotoAkun($filename, $dataIndeks->foto_indeks);

        $path = $_SERVER['DOCUMENT_ROOT']. "/duniasiber/assets/img/AKUN/". $this->session->fotoAkun;
        /*
        setting path file masih menggunakan cara manual
        */

        if($this->session->fotoAkun != "standar.png") {
          unlink($path);                                                        // hapus foto sebelumnya dengan tujuan meminimalisir penggunaan storage
        }

        $this->session->set_userdata("fotoAkun", $filename);                    // reset variabel session fotoAkun

        $this->session->set_userdata("alert", "Foto profil berhasil di ubah");
        redirect( base_url("Profil/lihatProfil") );
      }else {
        $this->session->set_userdata("alert", "Error upload foto");
        $this->session->set_userdata("errorMsg", "size atau resolusi foto terlalu besar !");        // pesan error
        redirect( base_url("Profil/lihatProfil") );
      }
    }else {
      redirect( base_url("Pelanggan") );
    }
  }

  public function validasiGantiFotoProfil() {
    if($this->input->post()) {
      $_error         = FALSE;
      $_errFotoProfil = "";

      $_fotoprofil = strtolower($this->input->post("fotoprofil"));
      $_fotoprofil = explode(".", $_fotoprofil);
      $_fotoprofil = end($_fotoprofil);                                         // hanya mengambil ekstensi dari file

      if(empty($_fotoprofil)) {
        $_error         = TRUE;
        $_errFotoProfil = "kosong";
      }else if( !($_fotoprofil == "jpg" || $_fotoprofil == "png" || $_fotoprofil == "gif") ) {
        $_error         = TRUE;
        $_errFotoProfil = "format";
      }

      if($_error) {
        echo json_encode([
                          "error"         => $_error,
                          "errFotoProfil" => $_errFotoProfil
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
