<?php
class AkunModel extends CI_Model {                              // "AkunModel" berisi query builder yang berhubungan dengan akun
  private $tabel = "akun";

  public function cekEmail($email) {                            // method ini dipakai pada fitur "daftar akun" dan "ubah email"
    $this->db->select("akun_id");
    $this->db->where("email", $email);

    $data = $this->db->get($this->tabel)->row();
    return $data;
  }

  public function cekUsername($username) {                      // method ini dipakai pada fitur "daftar akun" dan "edit profil"
    $this->db->select("akun_id");
    $this->db->where("username", $username);

    $data = $this->db->get($this->tabel)->row();
    return $data;
  }

  public function buatBaru($data) {
    $kodeUnik0 = bin2hex(random_bytes(8));                      // generate kode unik untuk nilai indeks
    $kodeUnik1 = bin2hex(random_bytes(8));

    $dataFoto = array(
                    "nilai"       => "standar.png",             // nilai default foto profil akun
                    "foto_indeks" => "AKUN-". $kodeUnik0
                  );

    $dataToken = array(
                    "token_indeks" => "AKUN-". $kodeUnik1
                  );
    /*
    kode indeks pada setiap tabel direkam dengan format: [4 huruf kode]-[kodeunik]
    contoh : ABCD-1a2b3c
    */

    $dataAkun = array(
                    "nama"         => $data["namaTxt"],
                    "email"        => $data["emailTxt"],
                    "username"     => $data["usernameTxt"],
                    "password"     => sha1( base64_encode($data["passwordTxt"]) ),                // pertama encode dulu dengan base64 lalu di hash sha1
                    "peran"        => "PELANGGAN",
                    "foto_indeks"  => "AKUN-". $kodeUnik0,
                    "token_indeks" => "AKUN-". $kodeUnik1
                  );

    $this->db->insert("foto", $dataFoto);
    $this->db->insert("token", $dataToken);
    /*
    masukkan data foto dan data token terlebih dahulu ke database sebagai nilai referensi data akun
    */
    $this->db->insert($this->tabel, $dataAkun);
  }

  public function lakukanLogin($user, $password) {
    $password = sha1( base64_encode($password) );
    $sql      = "SELECT `akun_id`, `nama`, `email`, `peran`, `foto_indeks`, `diaktivasi_pada`
                 FROM $this->tabel WHERE (`username`=? OR `email`=?) AND `password`=?";           // "prepared statement query"
    $dataAkun = $this->db->query( $sql, array($user, $user, $password) )->row();                  // jalankan query, bind parameter, dan ambil 1 record

    if(empty($dataAkun)) {                                                                        // jika akun tidak ada/login gagal
      $dataAkun = FALSE;
    }

    return $dataAkun;                                                           // data yang di "return" berupa bentuk object bukan array associative
  }

  public function ambilNilaiIndeks($user) {                                     // method untuk mengetahui nilai indeks dari suatu akun
    /*
    paramater yang digunakan method "ambilNilaiIndeks" menggunakan akun_id atau email
    */
    $this->db->select("foto_indeks");
    $this->db->select("token_indeks");
    $this->db->where("akun_id", $user);
    $this->db->or_where("email", $user);

    $data = $this->db->get($this->tabel)->row();
    return $data;
  }

  public function inisialisasiToken($indeks, $tujuan, $token=null) {            // $token di inisialisasi pada fitur "ubah email"
    if(is_null($token)) {
      $token = bin2hex(random_bytes(16));
    }

    $tgl = date("Y-m-d H:i:s");

    $dataToken = array(
                        "nilai"           => $token,
                        "tgl_kadaluwarsa" => date( "Y-m-d H:i:s", strtotime("+10 minutes", strtotime($tgl)) ),    // waktu sekarang di tambah 10 menit
                        "tujuan"          => $tujuan
                      );

    $this->db->where("token_indeks", $indeks);
    $this->db->update("token", $dataToken);

    return $token;
  }

  public function cekToken($token) {
    $this->db->select("akun.akun_id");
    $this->db->select("akun.token_indeks");
    $this->db->select("token.tgl_kadaluwarsa");
    $this->db->select("token.tujuan");

    $this->db->from("akun");
    $this->db->join("token", "akun.token_indeks = token.token_indeks");

    $this->db->where("token.nilai", $token);

    $data = $this->db->get()->row();
    return $data;
  }

  public function aktivasiAkun($id, $indeks) {
    $dataAkun  = array(
                        "diaktivasi_pada" => date("Y-m-d H:i:s")
                      );

    $dataToken = array(                                                         // untuk mereset token
                        "nilai"           => null,
                        "tgl_kadaluwarsa" => null,
                        "tujuan"          => null
                      );

    $this->db->where("akun_id", $id);
    $this->db->update($this->tabel, $dataAkun);

    $this->db->where("token_indeks", $indeks);
    $this->db->update("token", $dataToken);
  }

  public function ubahPassword($id, $password, $indeks=null) {                  // parameter $indeks dipakai pada fitur "lupa password"
    $dataAkun = array(
                      "password" => sha1( base64_encode($password) )
                    );

    $this->db->where("akun_id", $id);
    $this->db->update($this->tabel, $dataAkun);

    if(isset($indeks)) {
      $dataToken = array(
                          "nilai"           => null,
                          "tgl_kadaluwarsa" => null,
                          "tujuan"          => null
                        );

      $this->db->where("token_indeks", $indeks);
      $this->db->update("token", $dataToken);
    }
  }

  public function ambilDataAkun($id) {
    $this->db->where("akun_id", $id);

    $data = $this->db->get($this->tabel)->row();
    return $data;
  }

  public function ambilDataFoto($indeks) {
    $this->db->select("nilai");
    $this->db->where("foto_indeks", $indeks);

    $data = $this->db->get("foto")->row();
    return $data;
  }

  public function updateProfilAkun($id, $data) {
    $dataAkun = array(
                    "nama"     => $data["namaTxt"],
                    "username" => $data["usernameTxt"]
                  );

    $this->db->where("akun_id", $id);
    $this->db->update($this->tabel, $dataAkun);
  }

  public function ubahEmailAkun($id, $email, $indeks) {
    $dataAkun  = array(
                        "email" => $email
                      );

    $dataToken = array(
                        "nilai"           => null,
                        "tgl_kadaluwarsa" => null,
                        "tujuan"          => null
                      );

    $this->db->where("akun_id", $id);
    $this->db->update($this->tabel, $dataAkun);

    $this->db->where("token_indeks", $indeks);
    $this->db->update("token", $dataToken);
  }

  public function ubahFotoAkun($foto, $indeks) {
    $data = array(
                  "nilai" => $foto
                );

    $this->db->where("foto_indeks", $indeks);
    $this->db->update("foto", $data);
  }
}
?>
