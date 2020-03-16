<?php

class Data_paket extends CI_Controller
{
	public function index()
	{
		$data['paket'] = $this->model_paket->tampil_data()->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/data_paket', $data);
		$this->load->view('templates_admin/footer');
	}

	public function tambah_aksi(){
		$nama_pkt 	= $this->input->post('nama_pkt');
		$keterangan = $this->input->post('keterangan');
		$kategori 	= $this->input->post('kategori');
		$harga 		= $this->input->post('harga');
		$stok 		= $this->input->post('stok');
		$gambar = $_FILES['gambar']['name'];
		if ($gambar = '')
		{

		}
		else
		{
			$config ['upload_path'] = './uploads';
			$config ['allowed_types'] = 'jpg|jpeg|png|gif';

			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('gambar'))
			{
				echo "Gambar gagal diupload";
			}
			else
			{
				$gambar=$this->upload->data('file_name');
			}
		}

		$data = array(
			'nama_pkt'		=> $nama_pkt,
			'keterangan'	=> $keterangan,
			'kategori'		=> $kategori,
			'harga'			=> $harga,
			'stok'			=> $stok,
			'gambar'		=> $gambar
		);

		$this->model_paket->tambah_paket($data, 'db_paket');
		redirect('admin/data_paket/index');
	
	}
}