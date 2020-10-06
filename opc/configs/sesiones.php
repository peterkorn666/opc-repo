<?php
	session_start();
	$_SESSION["registrado"] = true;
	$_SESSION["usuario"] = $_POST["usuario"];
	$_SESSION["tipoUsu"] = $validarUsuario["tipoUsuario"];
?>