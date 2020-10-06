<?php
require("../init.php");
if(is_array($_POST["input_selected_trabajo"]) && count($_POST["input_selected_trabajo"]) > 0 && $_SESSION['cliente']['id_cliente']){
	$db = \DB::getInstance();
	$tl = $db->query("SELECT id_trabajo FROM trabajos_libres WHERE numero_tl = 47")->results();
	var_dump($tl);die;
	foreach($_POST["input_selected_trabajo"] as $trabajo_numero){
		$tl = $db->query("SELECT id_trabajo FROM trabajos_libres WHERE numero_tl = ?", array($trabajo_numero))->results();
		var_dump($tl, $trabajo_numero);die;
		if(count($tl) > 0){
			$db->insert("trabajos_favoritos", array("cuenta_id" => $_SESSION['cliente']['id_cliente'], "trabajo_id" => $tl["id_trabajo"]));
			die;
		}
	}
	header("Location: " . $_POST["redirect"]);
}
?>