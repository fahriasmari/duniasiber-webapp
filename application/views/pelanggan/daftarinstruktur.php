<?php
$data["title"]        = "DuniaSiber";
$data["frameworkCss"] = "bootstrap";
$this->load->view("layout/header", $data);
$this->load->view("layout/navbar");

echo $this->session->viewDaftarInstruktur;
$this->session->unset_userdata("viewDaftarInstruktur");

$this->load->view("layout/footer");
?>
