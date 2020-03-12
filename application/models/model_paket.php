<?php

class Model_paket extends CI_Model
{
	public function tampil_data()
	{
		return $this->db->get("db_paket");
	}
}