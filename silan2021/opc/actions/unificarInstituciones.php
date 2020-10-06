<?php
if($_POST["id_save"]=="")
{
	header("Location: ".$config["url_opc"]."?page=instituciones&status=error");
	die();
}
foreach($_POST["id_institucion"] as $id){
	if($id!=$_POST["id_save"]){
		$core->bind("id", $id);
		$core->query("DELETE FROM instituciones WHERE ID_Instituciones=:id");
		
		$core->bind("id", $id);
		$core->bind("id_save", $_POST["id_save"]);
		$core->query("UPDATE conferencistas SET institucion=:id_save WHERE institucion=:id");
		
		$core->bind("id", $id);
		$core->bind("id_save", $_POST["id_save"]);
		$core->query("UPDATE personas_trabajos_libres SET Institucion=:id_save WHERE Institucion=:id");
	}
}

header("Location: ".$config["url_opc"]."?page=instituciones&status=ok");
?>