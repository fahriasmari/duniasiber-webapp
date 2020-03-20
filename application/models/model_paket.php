<?php

class Model_paket extends CI_Model
{
	public function tampil_data()
	{
		return $this->db->get("db_paket");
	}


	public function tambah_paket($data, $table)
	{
		$this->db->insert($table, $data);
	}

	public function edit_paket($where, $table)
	{
		//query menjalanakan data yang akan diedit berdasarkan id
		return $this->db->get_where($table,$where);
		//setelah di edit maka langkah selanjutnya di update, balik lagi ke controller data_paket
	}

	public function update_data($where, $data, $table)
	{
		$this->db->where($where);
		$this->db->update($table, $data);
	}

	public function hapus_data($where, $table)
	{
		$this->db->where($where);
		$this->db->delete($table);
	}

}

