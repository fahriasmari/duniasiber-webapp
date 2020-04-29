<!-- desain UI masih dapat berubah-ubah sebelum masuk production -->
<?php
$data["title"]        = "DuniaSiber";
$data["frameworkCss"] = "bootstrap";
$this->load->view("layout/header", $data);
?>

~ ADMIN
<?php
// ( hanya untuk sementara )
if(isset($_SESSION["statusLogin"]) == "sedangLogin") {
  echo @$_SESSION['statusLogin']. "<br>";
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
