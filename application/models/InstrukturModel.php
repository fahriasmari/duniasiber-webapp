<?php
class InstrukturModel extends CI_Model {
  private $tabel = "instruktur";

  public function ambilDataInstruktur($id) {
    $this->db->where("akun_id", $id);

    $data = $this->db->get($this->tabel)->row();
    return $data;
  }

  public function daftarkanInstruktur($data) {
    $dataInstruktur = array(
                            "akun_id"       => $data["akunId"],
                            "profesi"       => $data["profesiInstruktur"],
                            "tentang"       => $data["tentangInstruktur"],
                            "rekening_bank" => $data["rekeningBankInstruktur"]
                          );

    $this->db->insert($this->tabel, $dataInstruktur);
  }

  public function updateDataInstruktur($id, $data) {
    $dataInstruktur = array(
                            "profesi"       => $data["profesiInstruktur"],
                            "tentang"       => $data["tentangInstruktur"],
                            "rekening_bank" => $data["rekeningBankInstruktur"]
                          );

    $this->db->where("akun_id", $id);
    $this->db->update($this->tabel, $dataInstruktur);
  }
}
?>
