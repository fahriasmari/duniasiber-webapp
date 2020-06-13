<?php
class KursusModel extends CI_Model {
  private $tabel = "kursus";

  public function tampilKursusBerdasarkanInstruktur($instrukturId) {
    $this->db->where("instruktur_id", $instrukturId);

    $data = $this->db->get($this->tabel)->result();
    return $data;
  }

  public function buatKursus($data) {
    $kodeUnik   = bin2hex(random_bytes(8));

    $dataFoto   = array(
                        "nilai"       => $data["fotoThumbnail"],
                        "foto_indeks" => "KRSS-". $kodeUnik
                      );

    $dataKursus = array(
                        "nama"            => $data["namaKursus"],
                        "foto_indeks"     => "KRSS-". $kodeUnik,
                        "peringkat"       => 0.0,
                        "deskripsi"       => $data["deskripsiKursus"],
                        "instruktur_id"   => $data["instrukturId"],
                        "di_review"       => "TIDAK",
                        "di_publikasikan" => "TIDAK"
                      );

    $this->db->insert("foto", $dataFoto);

    $this->db->insert($this->tabel, $dataKursus);
  }

  public function ambilDataFotoKursus($indeks) {
    $this->db->select("nilai");
    $this->db->where("foto_indeks", $indeks);

    $data = $this->db->get("foto")->row();
    return $data;
  }
}
?>
