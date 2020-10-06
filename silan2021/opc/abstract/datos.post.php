<?php
	if(!$_SESSION["abstract"]["paso1"]){
		die();
	}
	
	require_once("class/htmLawed.php");
	$config_titulo = array(
		'safe'=>1, // Dangerous elements and attributes thus not allowed
		'elements'=>'strong, b, i, em, sup, sub, -span, -u',
		'deny_attribute'=>'class, id, style, lang', // None of the allowed elements can have these attributes
		'cdata'=>1,
		'comment'=>1
	);
	$config = array(
		'safe'=>1, // Dangerous elements and attributes thus not allowed
		'elements'=>'strong, b, u, i, em, sup, sub, -span',
		'deny_attribute'=>'class, id, style, lang', // None of the allowed elements can have these attributes
		'cdata'=>1,
		'comment'=>1
	);
	
	//header('Content-Type: text/html; charset=iso-8859-1');
	$_SESSION["abstract"]["total_autores"] = $_POST["total_autores"];
	$_SESSION["abstract"]["id_autor"] = $_POST["id_autor"];
	//$_SESSION["abstract"]["numero_tl"] = $_POST["numero_tl"];
	
	$_SESSION["abstract"]["hora1"] = $_POST["hora1"];
	$_SESSION["abstract"]["hora2"] = $_POST["hora2"];
	
//var_dump($_SESSION["abstract"]["id_autor"]);

	$arrayPersonas = array();
	$arrayInstituciones = array();
	
	for($i=0;$i<$_SESSION["abstract"]["total_autores"];$i++){
		
		$_SESSION["abstract"]["nuevo_".$i] = ($_POST["nuevo_".$i]==""?0:$_POST["nuevo_".$i]);
		$_SESSION["abstract"]["nombre_".$i] = $_POST["nombre_".$i];
		$_SESSION["abstract"]["apellido_".$i] = $_POST["apellido_".$i];
		$_SESSION["abstract"]["institucion_".$i] = $_POST["institucion_".$i];
		$_SESSION["abstract"]["email_".$i] = $_POST["email_".$i];
		$_SESSION["abstract"]["pais_".$i] = $_POST["pais_".$i];
		$_SESSION["abstract"]["lee_".$i] = ($_POST["lee_".$i]?"1":"0");
		
		array_push($arrayPersonas, array(
			"institucion"=>$_SESSION["abstract"]["institucion_".$i], 
			"apellido"=>$_SESSION["abstract"]["apellido_".$i], 
			"apellido2"=>$_SESSION["abstract"]["apellido2_".$i],
			"nombre"=>$_SESSION["abstract"]["nombre_".$i],
			"lee"=>$_SESSION["abstract"]["lee_".$i]));
		array_push($arrayInstituciones , $_SESSION["abstract"]["institucion_".$i]);
	}
	
	//Unifcacion Instituciones
	$arrayInstitucionesUnicas =  array_values(array_unique($arrayInstituciones));

	$arrayInstitucionesUnicasNuevaClave = array();
	if(count($arrayInstitucionesUnicas)>0){
		foreach ($arrayInstitucionesUnicas as $u){
			if($u!=""){
				array_push($arrayInstitucionesUnicasNuevaClave, $u);
			}
		}
	}
	
	$autoreInscriptos = "";
	$gestionAutores = "";
	for ($i=0; $i < count($arrayPersonas); $i++){
		if($i>0){
			$gestionAutores .= "; ";
		}
		if($arrayPersonas[$i]["institucion"]!=""){
			$claveIns = (array_search($arrayPersonas[$i]["institucion"] ,$arrayInstitucionesUnicas))+1;
		}else{
			$claveIns = "";
		}
		if($arrayPersonas[$i]["lee"]==1){
			$gestionAutores .= "<u>";
		}
		$gestionAutores .= "<b>" . $arrayPersonas[$i]["nombre"]." ".$arrayPersonas[$i]["apellido"] .  "</b>";
		if($arrayPersonas[$i]["lee"]==1){
			$gestionAutores .= "</u>";
			$autorPresentador = $arrayPersonas[$i]["nombre"]." ".$arrayPersonas[$i]["apellido"];
		}
		$gestionAutores .= "<sup>" . $claveIns . "</sup>";
	}
	
	$gestionAutores .="<br>";
	for ($i=0; $i < count($arrayInstitucionesUnicasNuevaClave); $i++){
			
		$gestionAutores .= "<i>";
		$gestionAutores .=  ($i+1) . " - " . $arrayInstitucionesUnicas[$i] . ". ";
		$gestionAutores .= "</i>";
	}

	$_SESSION["abstract"]["autores"] = $gestionAutores;
	
	$_SESSION["abstract"]["tipo_trabajo"] = $_POST["tipo_trabajo"];
	$_SESSION["abstract"]["idioma"] = $_POST["idioma"];
	$_SESSION["abstract"]["titulo_tl"] = str_replace("<br>","",htmLawed($_POST["titulo_tl"],$config_titulo));
	$_SESSION["abstract"]["idioma_tl"] = $_POST["idioma_tl"];
	$_SESSION["abstract"]["area_tl"] = $_POST["area_tl"];
	$_SESSION["abstract"]["tipo_tl"] = $_POST["tipo_tl"];
	$_SESSION["abstract"]["premio"] = $_POST["premio"];
	$_SESSION["abstract"]["duracion_prevista"] = $_POST["duracion_prevista"];

	$_SESSION["abstract"]["palabra_clave1"] = $_POST["palabra_clave1"];
	$_SESSION["abstract"]["palabra_clave2"] = $_POST["palabra_clave2"];
	$_SESSION["abstract"]["palabra_clave3"] = $_POST["palabra_clave3"];
	$_SESSION["abstract"]["palabra_clave4"] = $_POST["palabra_clave4"];
	$_SESSION["abstract"]["palabra_clave5"] = $_POST["palabra_clave5"];
	
	$_SESSION["abstract"]["palabras_claves"] = "";
	if($_POST["palabra_clave1"])
		$_SESSION["abstract"]["palabras_claves"] = $_POST["palabra_clave1"].", ";
	if($_POST["palabra_clave2"])
		$_SESSION["abstract"]["palabras_claves"] .= $_POST["palabra_clave2"].", ";
	if($_POST["palabra_clave3"])
		$_SESSION["abstract"]["palabras_claves"] .= $_POST["palabra_clave3"].", ";
	if($_POST["palabra_clave4"])
		$_SESSION["abstract"]["palabras_claves"] .= $_POST["palabra_clave4"].", ";
	if($_POST["palabra_clave5"])
		$_SESSION["abstract"]["palabras_claves"] .= $_POST["palabra_clave5"].", ";
	$_SESSION["abstract"]["palabras_claves"] = trim($_SESSION["abstract"]["palabras_claves"],", ");
	
		
	$_SESSION["abstract"]["resumen_tl"] = htmLawed($_POST["resumen_tl"],$config);
	$_SESSION["abstract"]["resumen_tl2"] = htmLawed($_POST["resumen_tl2"],$config);
	$_SESSION["abstract"]["resumen_tl3"] = htmLawed($_POST["resumen_tl3"],$config);
	if($_SESSION["abstract"]["tipo_tl"] == "2"){ //Caso clínico
		$_SESSION["abstract"]["resumen_tl4"] = NULL;
	}else
		$_SESSION["abstract"]["resumen_tl4"] = $_POST["resumen_tl4"];
	$_SESSION["abstract"]["resumen_tl5"] = htmLawed($_POST["resumen_tl5"],$config);
	$_SESSION["abstract"]["resumen_tl6"] = htmLawed($_POST["resumen_tl6"],$config);
	
	$enters = array("<br>", "<br />", "<br/>");
	$enters_rem = array(" "," "," ");
	$_SESSION["abstract"]["resumen_tl"] = str_replace($enters, $enters_rem, $_SESSION["abstract"]["resumen_tl"]);	
	$_SESSION["abstract"]["resumen_tl2"] = str_replace($enters, $enters_rem, $_SESSION["abstract"]["resumen_tl2"]);	
	$_SESSION["abstract"]["resumen_tl3"] = str_replace($enters, $enters_rem, $_SESSION["abstract"]["resumen_tl3"]);
	$_SESSION["abstract"]["resumen_tl4"] = str_replace($enters, $enters_rem, $_SESSION["abstract"]["resumen_tl4"]);
	$_SESSION["abstract"]["resumen_tl5"] = str_replace($enters, $enters_rem, $_SESSION["abstract"]["resumen_tl5"]);
	
		
	$_SESSION["abstract"]["resumen_tl"] = preg_replace("/\r?\n|\r/"," ",$_SESSION["abstract"]["resumen_tl"]);
	$_SESSION["abstract"]["resumen_tl"] = preg_replace('/(\s)+/', ' ',$_SESSION["abstract"]["resumen_tl"]);
	
	$_SESSION["abstract"]["resumen_tl2"] = preg_replace ("/\r?\n|\r/"," ",$_SESSION["abstract"]["resumen_tl2"]);
	$_SESSION["abstract"]["resumen_tl2"] = preg_replace('/(\s)+/', ' ',$_SESSION["abstract"]["resumen_tl2"]);
	
	$_SESSION["abstract"]["resumen_tl3"] = preg_replace ("/\r?\n|\r/"," ",$_SESSION["abstract"]["resumen_tl3"]);
	$_SESSION["abstract"]["resumen_tl3"] = preg_replace('/(\s)+/', ' ',$_SESSION["abstract"]["resumen_tl3"]);
	
	$_SESSION["abstract"]["resumen_tl4"] = preg_replace ("/\r?\n|\r/"," ",$_SESSION["abstract"]["resumen_tl4"]);
	$_SESSION["abstract"]["resumen_tl4"] = preg_replace('/(\s)+/', ' ',$_SESSION["abstract"]["resumen_tl4"]);
	
	$_SESSION["abstract"]["resumen_tl5"] = preg_replace ("/\r?\n|\r/"," ",$_SESSION["abstract"]["resumen_tl5"]);
	$_SESSION["abstract"]["resumen_tl5"] = preg_replace('/(\s)+/', ' ',$_SESSION["abstract"]["resumen_tl5"]);
	
	$_SESSION["abstract"]["resumen_tl6"] = preg_replace ("/\r?\n|\r/"," ",$_SESSION["abstract"]["resumen_tl6"]);
	$_SESSION["abstract"]["resumen_tl6"] = preg_replace('/(\s)+/', ' ',$_SESSION["abstract"]["resumen_tl6"]);
	
	
	//$_SESSION["abstract"]["resumen_tl6"] = str_replace($enters, $enters_rem, $_SESSION["abstract"]["resumen_tl6"]);
	
	//Contacto
	$_SESSION["abstract"]["contacto_mail"] = $_POST["contacto_mail"];
	$_SESSION["abstract"]["contacto_mail2"] = $_POST["contacto_mail2"];
	$_SESSION["abstract"]["contacto_nombre"] = $_POST["contacto_nombre"];
	$_SESSION["abstract"]["contacto_apellido"] = $_POST["contacto_apellido"];
	$_SESSION["abstract"]["contacto_pais"] = $_POST["contacto_pais"];
	$_SESSION["abstract"]["contacto_institucion"] = $_POST["contacto_institucion"];
	$_SESSION["abstract"]["contacto_ciudad"] = $_POST["contacto_ciudad"];
	$_SESSION["abstract"]["contacto_telefono"] = $_POST["contacto_telefono"];