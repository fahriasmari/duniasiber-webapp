<?php
class Pelanggan extends CI_Controller {
  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $this->load->view("halutama");                                // ( halaman utama )
  }
}
?>
