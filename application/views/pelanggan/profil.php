<?php
$data["title"]        = "DuniaSiber";
$data["frameworkCss"] = "bootstrap";
$this->load->view("layout/header", $data);
$this->load->view("layout/navbar");

echo $this->session->viewProfil;
$this->session->unset_userdata("viewProfil");                                   // menghapus session viewProfil, dengan tujuan mereset kembali session tersebut

$this->load->view("layout/footer");
?>
