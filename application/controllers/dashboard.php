<?php

class Dashboard extends CI_Controller
{
	public function index()
	{
		//load db setelah itu cek dir models(model_paket)
		$data["paket"] = $this->model_paket->tampil_data()->result();

		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('dashboard', $data);
		$this->load->view('templates/footer');

	}

	public function pembayaran()
	{
		$this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('pembayaran');
		$this->load->view('templates/footer');
	}

	public function proses_pesanan()
	{
		//menambahkan variable agar data yg diproses akan dikirim ke invoice admin
		$is_processed = $this->model_invoice->index();
		if($is_processed)
		{
			$this->load->view('templates/header');
			$this->load->view('templates/sidebar');
			$this->load->view('proses_pesanan');
			$this->load->view('templates/footer');
		}
		else
		{
			echo "Maaf pesanan anda gagal di proses!";
		}
		
	}
}