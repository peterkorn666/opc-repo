<?php
if(empty($_POST["numero_tl"]))
{
	echo json_encode(array("status"=>false));
	die();
}
require("../init.php");
$db = \DB::getInstance();


//verificar si el numero existe
$trabajo = $db->query("SELECT id_trabajo, id_cliente, numero_tl, titulo_tl FROM trabajos_libres WHERE numero_tl = ? AND (estado=2 OR estado=4)", [$_POST["numero_tl"]]);
if($trabajo->count()==1){
	$trabajo = $trabajo->first();
	//obtenemos los autores del trabajo
	$autores = $db->query("SELECT p.ID_Personas, p.Nombre, p.Apellidos, p.Mail, l.ID_participante, l.ID_trabajos_libres FROM trabajos_libres_participantes as l JOIN personas_trabajos_libres as p ON p.ID_Personas=l.ID_participante WHERE l.ID_trabajos_libres = ?", [$trabajo["id_trabajo"]])->results();
	
	$cuenta_trabajo = $db->query("SELECT * FROM cuentas WHERE id = ?", [$trabajo["id_cliente"]])->first();
	
	$match = array();
	$cuenta = array();
	foreach($autores as $autor){
		if(strtolower(trim($autor["Nombre"]))==strtolower(trim($_SESSION['cliente']['nombre'])) && strtolower(trim($autor["Apellidos"]))==strtolower(trim($_SESSION['cliente']['apellido'])) && strtolower(trim($autor["Mail"]))==strtolower(trim($_SESSION['cliente']['email']))){
			$match[] = $autor;
		}else if(strtolower(trim($autor["Apellidos"]))==strtolower(trim($_SESSION['cliente']['apellido'])) && strtolower(trim($autor["Mail"]))==strtolower(trim($_SESSION['cliente']['email']))){
			$match[] = $autor;
		}else if(strtolower(trim($autor["Nombre"]))==strtolower(trim($_SESSION['cliente']['nombre'])) && strtolower(trim($autor["Mail"]))==strtolower(trim($_SESSION['cliente']['email']))){
			$match[] = $autor;
		}else if(strtolower(trim($autor["Apellidos"]))==strtolower(trim($_SESSION['cliente']['apellido']))){
			$match[] = $autor;
		}
	}
	
	if($_SESSION["admin"]){
		$cuenta["id"] = $cuenta_trabajo["id"];
		$cuenta["email"] = $cuenta_trabajo['email'];
		$cuenta["nombre"] = $cuenta_trabajo['nombre'];
		$cuenta["apellido"] = $cuenta_trabajo['apellido'];
	}
	
	$found = 1;
	if(count($match)==0){
		$match = $autores;
		$found = 0;
	}
	
	echo json_encode(array("status"=>true, "trabajo"=>$trabajo, "found"=> $found,"autores"=>$match, "cuenta" => $cuenta));
	die();
}

echo json_encode(array("status"=>false));