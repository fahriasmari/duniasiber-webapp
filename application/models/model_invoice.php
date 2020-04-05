<?php

class Model_invoice extends CI_Model
{
	public function index()
	{
		date_default_timezone_set('Asia/Jakarta');
		$nama = $this->input->post('nama');
		$email = $this->input->post('email');
		
		$invoice = array(
			'nama' 			=> $nama,
			'email'			=> $alamat,
			'tgl_pesan'		=> date('Y-m-d H:i:s'),
			'batas_bayar'	=> date('Y-m-d H:i:s', mktime(date('H'),date('i'),date('s'), date('m'), date('d') + 1, date('Y'))),
			//date +1 artinya batas pembayaran diwaktu seharian
		);
		$this->db->insert('db_invoice', $invoice);
		$id_invoice = $this->db->insert_id();
		//still
		//buat table pesanan
	}

	public function tampil_data()
	{
		$result = $this->db->get('db_invoice');
		if($result->num_rows() > 0)
		{
			return $result->result();
		}
		else
		{
			return false;
		}
	}
}