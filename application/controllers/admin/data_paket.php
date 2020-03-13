<?php

class Data_paket extends CI_Controller
{
	public function index()
	{
		//*load datapaket yg udah dibuat di view
		$data['paket'] = $this->model_paket->tampil_data()->result();


		//samadengan admin, karena penampilannya emang sama
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		//buat view data_paket di view admin
		$this->load->view('admin/data_paket', $data);
		$this->load->view('templates_admin/footer');
	}

	//ini menghubungkan view dari data_paket
	public function tambah_aksi()
	{
			//inputtttannnn
			$nama_pkt	= $this->input->post('nama_pkt');
			$keterangan	= $this->input->post('keterangan');
			$kategori	= $this->input->post('kategori');
			$harga		= $this->input->post('harga');
			$stok		= $this->input->post('stok');
			$gambar 	= $_FILES['gambar']['name'];

			if($gambar = '' ){}else{
				$config ['upload_path'] = './uploads';
				$config ['allowed_types'] = 'jpg|jpeg|png';
				
				
				$this->load->library('upload'. $config);
					if( !$this->upload->do_upload('gambar'))
				{
					echo "Gagal mengupload gambar, silahkan ulangi beberapa saat lagi...";
				}
				else
				{
					$gambar = $this->upload->data('file_name');
				}
			}
			
			//data dimasukan ke array
			$data = array(
				'nama_pkt'		=> $nama_pkt,
				'keterangan'	=> $keterangan,
				'kategori'		=> $kategori,
				'harga'			=> $harga,
				'stok'			=> $stok,
				'gambar'		=> $gambar

			);

			//input ke dlm table barang, di loas
			$this->model_paket->tambah_paket($data, 'db_paket');
			redirect('admin/data_paket/index');
			
			//fungsi tambah barang dijankan di model
	}
}