<?php
if($_POST["id_save"]=="")
{
	header("Location: ".$config["url_opc"]."?page=personasTL&status=error");
	die();
}
$autores = array();
foreach($_POST["id_autor"] as $id){
	if($id!=$_POST["id_save"]){
		//obtener datos autores para log
		$autor = $core->getAutor($id);
		$autores[] = $autor;
		$core->bind("id", $id);
		$core->query("DELETE FROM personas_trabajos_libres WHERE ID_Personas=:id");
		$core->bind("id", $id);
		$core->bind("id_save", $_POST["id_save"]);
		$core->query("UPDATE trabajos_libres_participantes SET ID_Participante=:id_save WHERE ID_Participante=:id");
	}
}
$core->bind("id_save", $_POST["id_save"]);
$core->bind("autores", json_encode($autores));
$core->bind("by", $_SESSION["usuario"]);
$core->query("INSERT INTO log_unificar_autores (id_save, autores, por) VALUES (:id_save, :autores, :by)");
header("Location: ".$config["url_opc"]."?page=personasTL&status=ok");
?>