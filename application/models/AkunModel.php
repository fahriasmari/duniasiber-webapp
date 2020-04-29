<?php
class AkunModel extends CI_Model {                              // "AkunModel" berisi query builder yang berhubungan dengan akun
  private $tabel = "akun";

  public function cekEmail($email) {
    $this->db->select("email");
    $this->db->where("email", $email);

    $data = $this->db->get($this->tabel)->row();
    return $data;
  }

  public function cekUsername($username) {
    $this->db->select("username");                              // ( SELECT `username` )
    $this->db->where("username", $username);                    // ( WHERE `username` = $username )

    $data = $this->db->get($this->tabel)->row();                // ( FROM `akun` ), ambil 1 record
    return $data;
  }

  public function buatBaru($data) {
    $kodeunik = bin2hex(random_bytes(16));                      // generate kode unik untuk nilai foto_indeks

    $dataFoto = array(
                    "nilai"       => "fotoprofildefault.png",   // nilai default foto profil yang disingkronkan ke tabel akun
                    "foto_indeks" => "AKUN-". $kodeunik
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
                    "foto_indeks"  => "AKUN-". $kodeunik
                  );

    $this->db->insert("foto", $dataFoto);
    /*
    masukkan data foto terlebih dahulu ke database sebagai nilai referensi foto profil untuk data akun,
      karena tabel foto merupakan tabel parent dari tabel akun.
    pemisahan data foto dari tabel akun dilakukan untuk tujuan pengkategorian data bedasarkan tipe-nya.
    tabel foto juga bisa digunakan untuk menyimpan foto yang bersifat dinamis.
    */
    $this->db->insert($this->tabel, $dataAkun);
  }

  public function lakukanLogin($user, $password) {
    $password = sha1( base64_encode($password) );
    $sql      = "SELECT * FROM $this->tabel WHERE (`username`=? OR `email`=?) AND `password`=?";  // "prepared statement query"
    $akun     = $this->db->query( $sql, array($user, $user, $password) )->row();                  // jalankan query, bind parameter, dan ambil 1 record

    if(empty($akun)) {                                                                            // jika akun tidak ada/login gagal
      $akun = "loginGagal";
    }

    return $akun;                                                               // data yang di "return" berupa bentuk object bukan array associative
  }

  public function inisialisasiToken($user) {
    /*
    paramater yang digunakan method "inisialisasiToken" menggunakan akun_id atau email
    */
    $token = bin2hex(random_bytes(16));
    $tgl   = date("Y-m-d H:i:s");

    $data  = array(
                  "token"                => $token,
                  "tgl_kadaluarsa_token" => date( "Y-m-d H:i:s", strtotime("+10 minutes", strtotime($tgl)) )    // waktu sekarang di tambah 10 menit
                );

    $this->db->where("akun_id", $user);
    $this->db->or_where("email", $user);

    $this->db->update($this->tabel, $data);

    return $token;
  }

  public function cekToken($token) {
    $this->db->where("token", $token);

    $data = $this->db->get($this->tabel)->row();                                // ambil data akun, jika token dikenali

    return $data;
  }

  public function aktivasiAkun($id) {
    $data = array(
                "token"                => null,
                "tgl_kadaluarsa_token" => null,
                "diaktivasi_pada"      => date("Y-m-d H:i:s")
            );

    $this->db->where("akun_id", $id);

    $this->db->update($this->tabel, $data);
  }

  public function ubahPassword($id, $password) {
    $data = array(
                "password"             => sha1( base64_encode($password) ),
                "token"                => null,
                "tgl_kadaluarsa_token" => null
            );

    $this->db->where("akun_id", $id);

    $this->db->update($this->tabel, $data);
  }
}
?>
