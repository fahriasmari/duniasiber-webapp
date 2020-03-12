<?php

class Dashboard_admin extends CI_COntroller
{
	Public function index()
	{
		//melakukan load view
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/dashboard');
		$this->load->view('templates_admin/footer');
	}
}