<?php
$data["title"]        = "DuniaSiber";
$data["frameworkCss"] = "bootstrap";
$this->load->view("layout/header", $data);
/*
bertujuan untuk mencegah konflik framework bootstrap dengan template adminlte ( bootstrap yang sudah di kustomisasi )
*/
$this->load->view("layout/navbar");                                             // navbar
?>

<?php
$this->load->view("layout/footer");
?>
