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

		public function edit($id)
		{
			$where = array('id_pkt' =>$id);
			$data['paket'] = $this->model_paket->edit_paket($where, 'db_paket')->result();

				//copy dari atas
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/sidebar');
			$this->load->view('admin/edit_paket', $data);
			//function edit_paket ada di models
			$this->load->view('templates_admin/footer');
		}

		public function update()
		{
			$id 		= $this->input->post('id_pkt');
			$nama_pkt 	= $this->input->post('nama_pkt');
			$keterangan = $this->input->post('keterangan');
			$kategori 	= $this->input->post('kategori');
			$harga 		= $this->input->post('harga');
			$stok 		= $this->input->post('stok');
			
			$data = array(
			'nama_pkt'		=> $nama_pkt,
			'keterangan'	=> $keterangan,
			'kategori'		=> $kategori,
			'harga'			=> $harga,
			'stok'			=> $stok,
			);

			$where = array(
				'id_pkt' => $id
			);

			$this->model_paket->update_data($where, $data, 'db_paket');
			redirect('admin/data_paket/index');

			//balk ke models dan buat update_data
		}

		public function hapus($id)
		{
			$where = array('id_pkt' => $id);
			$this->model_paket->hapus_data($where, 'db_paket');
			redirect('admin/data_paket/index');
		}
		
}