<?php
	require("init.php");

	$db = \DB::getInstance();
	
	$trabajos_contacto = $db->query("SELECT id_trabajo, contacto_nombre, contacto_apellido FROM trabajos_libres")->results();
	foreach($trabajos_contacto as $trabajo_contacto){
		$nombre_contacto = "";
		$nombres_contacto_explode = explode(" ", $trabajo_contacto["contacto_nombre"]);
		foreach($nombres_contacto_explode as $nombre_contacto_explode){
			$nombre_contacto .= mb_convert_case($nombre_contacto_explode, MB_CASE_TITLE, "UTF-8")." ";
		}
		$nombre_contacto = substr($nombre_contacto, 0, -1);
		
		$apellido_contacto = "";
		$apellidos_contacto_explode = explode(" ", $trabajo_contacto["contacto_apellido"]);
		foreach($apellidos_contacto_explode as $apellido_contacto_explode){
			$apellido_contacto .= mb_convert_case($apellido_contacto_explode, MB_CASE_TITLE, "UTF-8")." ";
		}
		$apellido_contacto = substr($apellido_contacto, 0, -1);
		
		$db->query("UPDATE trabajos_libres SET contacto_nombre=?, contacto_apellido=? WHERE id_trabajo=?", [$nombre_contacto, $apellido_contacto, $trabajo_contacto["id_trabajo"]]);
	}
	
	/*$autores = $db->query("SELECT ID_Personas, Nombre, Apellidos FROM personas_trabajos_libres")->results();
	foreach($autores as $autor){
		$nombre = "";
		$nombres_explode = explode(" ", $autor["Nombre"]);
		foreach($nombres_explode as $nombre_explode){
			$nombre .= mb_convert_case($nombre_explode, MB_CASE_TITLE, "UTF-8")." ";
		}
		$nombre = substr($nombre, 0, -1);
		
		$apellido = "";
		$apellidos_explode = explode(" ", $autor["Apellidos"]);
		foreach($apellidos_explode as $apellido_explode){
			$apellido .= mb_convert_case($apellido_explode, MB_CASE_TITLE, "UTF-8")." ";
		}
		$apellido = substr($apellido, 0, -1);
		
		$db->query("UPDATE personas_trabajos_libres SET Nombre=?, Apellidos=? WHERE ID_Personas=?", [$nombre, $apellido, $autor["ID_Personas"]]);
		
	}*/
	echo "Termino";
?>