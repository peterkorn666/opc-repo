<?php
/**
 * User: Hansz
 * Date: 10/4/2016
 * Time: 23:14
 */
if($_POST['usuario'] && $_POST['clave']){
	$core->bind('usuario', $_POST['usuario']);
	$core->bind('clave', $_POST['clave']);
	$result = $core->query("SELECT * FROM claves WHERE usuario=:usuario AND clave=:clave");
	$row = $result[0];
	session_start();
	$_SESSION["admin"] = false;
	if($row['ID_clave'] && $row['eliminado'] === 0)
	{
		$config = $core->getConfig();
		$_SESSION["registrado"] = true;
		$_SESSION["usuario"] = $row['usuario'];
		$_SESSION["tipoUsu"] = $row["tipoUsuario"];
		$_SESSION["canEdit"] = $row["edit"];
		$_SESSION["canDel"] = $row["del"];
		if($_SESSION["tipoUsu"]=="1")
			$_SESSION["admin"] = true;

		$headers = "From:gegamultimedios@gmail.com\nReply-To:gegamultimedios@gmail.com\n";
		$headers .= "X-Mailer:PHP/".phpversion()."\n";
		$headers .= "Mime-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "Return-Path:gegamultimedios@gmail.com\r\n";


		mail("gegamultimedios@gmail.com", "{$config["nombre_congreso"]} [".$_SESSION["usuario"]."] [".date("G:i - d/m/y")."]",  "", $headers);

		header('Location: ../');
	}else
		header('Location: ../?loign=0');
}