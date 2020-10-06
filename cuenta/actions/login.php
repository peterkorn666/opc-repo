<?php
require("../../init.php");
require("../class/login.class.php");
$login = new Login();

if(empty($_GET['key'])) {
	if (empty($_POST["email"]) || empty($_POST["clave"])) {
		\Redirect::to('../login.php?error=1');
		die();
	}
}
unset($_SESSION['cliente']);
unset($_SESSION['inscripcion']);
unset($_SESSION['abstract']);
unset($_SESSION['abstracts']);
$login->validate(base64_decode($_GET['key']));