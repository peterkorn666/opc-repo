<?php
session_start();
if($_SESSION["pasos"]!=1){
	header("Location: login.php");
	die();
}
$_SESSION["pasos"]=2;

include('../../init.php');
include('clases/evaluadores.class.php');
$evaluadores = new Evaluadores();

$usuario_evaluador = trim($_POST["txtUsuario"]);
$password_evaluador = trim($_POST["txtPassword"]);
$row = $evaluadores->getEvaluador($usuario_evaluador, $password_evaluador);

if (count($row) > 0){
    $_SESSION['corrector']["registrado"] = true;
    $_SESSION['corrector']["idEvaluador"] = $row["id"];
    $_SESSION['corrector']["mailEvaluador"] = $row["mail"];
    $_SESSION['corrector']["claveEvaluador"] = $row["clave"];
    $_SESSION['corrector']["nombreEvaluador"] = $row["nombre"];
    $_SESSION['corrector']["permisos"] = $row["permisos"];
    $_SESSION['corrector']["nivel"] = $row["nivel"];
    $_SESSION['corrector']["Login"] = "Logueado";
    if($row["nivel"] == 1){
        header("Location: admin.php");
    }else
        header("Location: personal.php");
} else {
    header ("Location: login.php?error=true");
}
die();
?>