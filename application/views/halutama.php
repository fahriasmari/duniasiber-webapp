<!-- desain UI masih dapat berubah-ubah sebelum masuk production -->
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
// ( hanya untuk sementara )
if(isset($_SESSION["statuslogin"]) == "sedangLogin") {
  echo @$_SESSION["nama"]. "<br>";
  echo @$_SESSION["peran"]. "<br>";

  unset($_SESSION["statusLogin"]);
  unset($_SESSION["nama"]);
  unset($_SESSION["peran"]);
}
?>

<?php
$this->load->view("layout/footer");
?>
