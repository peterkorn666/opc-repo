<?php
if($_POST["j"]!=1 || empty(trim($_POST["search_author"]))){
	die();
}
header('Content-Type: application/json');
require("../../opc/codebase/config.php");
require("../../init.php");
require("../class/cuenta.class.php");
$cuenta = new Cuenta();
$sql = $res->prepare("SELECT * FROM trabajos_libres as t JOIN trabajos_libres_participantes as tp ON t.id_trabajo=tp.ID_trabajos_libres JOIN personas_trabajos_libres as p ON tp.ID_participante=p.ID_Personas WHERE (t.tipo_tl=2 AND tp.lee=1) AND p.Apellidos LIKE ?");
$sql->bindValue(1, "%".$_POST["search_author"]."%");
$sql->execute();
$html = array();
while($row = $sql->fetch()){
	$titulo_panelista = $cuenta->getTituloPanelista(array("id_trabajo"=>$row["id_trabajo"], "id_coordinador"=> $row["ID_Personas"]));
	$html[$row["ID_Personas"]] = array("id_trabajo"=>$row["id_trabajo"],"id_coordinador"=>$row["ID_Personas"],"nombre"=> $row["Nombre"], "apellido"=>$row["Apellidos"],"titulo"=>$titulo_panelista["titulo"]);
}
echo json_encode($html);