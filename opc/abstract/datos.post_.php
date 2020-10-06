<?php
    /*if($_POST['step'] == '0'){
        session_start();
        if(empty($_POST['reglamento'])){
            header("Location: reglamento.php?error=empty");die();
        } else {
            $_SESSION["abstract"]["reglamento"] = $_POST["reglamento"];
            if($_SESSION["abstract"]["reglamento"] == '2' && empty($_POST["conflicto_descripcion"])){
                header("Location: reglamento.php?error=empty");die();
            } else if($_SESSION["abstract"]["reglamento"] == '2'){
                $_SESSION["abstract"]["conflicto_descripcion"] = $_POST["conflicto_descripcion"];
            } else {
                $_SESSION["abstract"]["conflicto_descripcion"] = NULL;
            }
        }
        if(empty($_POST['modalidad'])){
            header("Location: reglamento.php?error=empty");die();
        } else {
            $_SESSION["abstract"]["modalidad"] = $_POST["modalidad"];
        }
        header("Location: index.php");
        die();
    }*/
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
	$arrayAutoresNuevo = array();
	for($i=0;$i<$_SESSION["abstract"]["total_autores"];$i++){
		
		$_SESSION["abstract"]["nuevo_".$i] = ($_POST["nuevo_".$i]==""?0:$_POST["nuevo_".$i]);
		$_SESSION["abstract"]["profesion_".$i] = $_POST["profesion_".$i];
        $_SESSION["abstract"]["profesion-txt_".$i] = $_POST["profesion-txt_".$i];
		$_SESSION["abstract"]["nombre_".$i] = $_POST["nombre_".$i];
		$_SESSION["abstract"]["apellido_".$i] = $_POST["apellido_".$i];
		$_SESSION["abstract"]["pasaporte_".$i] = $_POST["pasaporte_".$i];
		$_SESSION["abstract"]["rol_".$i] = $_POST["rol_".$i];
		//$_SESSION["abstract"]["apellido2_".$i] = $_POST["apellido2_".$i];
		$_SESSION["abstract"]["pertenencia_".$i] = $_POST["pertenencia_".$i];
		$_SESSION["abstract"]["institucion_".$i] = $_POST["institucion_".$i];
        $_SESSION["abstract"]["institucion-txt_".$i] = $_POST["institucion-txt_".$i];
		$_SESSION["abstract"]["email_".$i] = $_POST["email_".$i];
		$_SESSION["abstract"]["pais_".$i] = $_POST["pais_".$i];
		$_SESSION["abstract"]["lee_".$i] = ($_POST["lee_".$i]?"1":"0");
		$arrayAutoresNuevo[] = array(
									"profesion" => $_SESSION["abstract"]["profesion_".$i],
                                    "profesion_otro" => $_SESSION["abstract"]["profesion-txt_".$i],
									"nombre" => $_SESSION["abstract"]["nombre_".$i],
									"apellido" => $_SESSION["abstract"]["apellido_".$i],
									"pasaporte" => $_SESSION["abstract"]["pasaporte_".$i],
									"rol" => $_SESSION["abstract"]["rol_".$i],
									"pertenencia" => $_SESSION["abstract"]["pertenencia_".$i],
									"institucion" => $_SESSION["abstract"]["institucion_".$i],
                                    "institucion_otro" => $_SESSION["abstract"]["institucion-txt_".$i],
									"email" => $_SESSION["abstract"]["email_".$i],
									"pais" => $_SESSION["abstract"]["pais_".$i],
									"lee" => $_SESSION["abstract"]["lee_".$i],
							   );
		
		array_push($arrayPersonas, array(
			"institucion"=>$_SESSION["abstract"]["institucion_".$i],
            "institucion_otro"=>$_SESSION["abstract"]["institucion-txt_".$i],
            "apellido"=>$_SESSION["abstract"]["apellido_".$i],
			//"apellido2"=>$_SESSION["abstract"]["apellido2_".$i],
			"nombre"=>$_SESSION["abstract"]["nombre_".$i],
			"lee"=>$_SESSION["abstract"]["lee_".$i],
			"profesion" => $_SESSION["abstract"]["profesion_".$i],
            "profesion_otro" => $_SESSION["abstract"]["profesion-txt_".$i]));
		if($_SESSION["abstract"]["institucion_".$i] == 'Otra'){
            array_push($arrayInstituciones , $_SESSION["abstract"]["institucion-txt_".$i]);
        } else {
            array_push($arrayInstituciones , $_SESSION["abstract"]["institucion_".$i]);
        }
	}
	$_SESSION["abstract"]["autoresNuevo"] = $arrayAutoresNuevo;
	
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
		    if($arrayPersonas[$i]["institucion"] == 'Otra'){
                $claveIns = (array_search($arrayPersonas[$i]["institucion_otro"] ,$arrayInstitucionesUnicas))+1;
            } else {
                $claveIns = (array_search($arrayPersonas[$i]["institucion"] ,$arrayInstitucionesUnicas))+1;
            }
		}else{
			$claveIns = "";
		}
		if($arrayPersonas[$i]["lee"]==1){
			$gestionAutores .= "<u>";
		}
		if($arrayPersonas[$i]["profesion"] == "Otro" || $arrayPersonas[$i]["profesion"] == "Outros"){
		    $profesion = $arrayPersonas[$i]["profesion_otro"];
        } else {
            $profesion = $arrayPersonas[$i]["profesion"];
        }
		$gestionAutores .= "<b>".$profesion." ".$arrayPersonas[$i]["nombre"]." ".$arrayPersonas[$i]["apellido"] . " " . $arrayPersonas[$i]["apellido2"] . "</b>";
		if($arrayPersonas[$i]["lee"]==1){
			$gestionAutores .= "</u>";
			$autorPresentador = $profesion." ".$arrayPersonas[$i]["nombre"]." ".$arrayPersonas[$i]["apellido"] . " " . $arrayPersonas[$i]["apellido2"];
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
	$_SESSION["abstract"]["modalidad"] = $_POST["modalidad"];
	$_SESSION["abstract"]["linea_transversal"] = $_POST["linea_transversal"];
	$_SESSION["abstract"]["apoyo_audiovisual"] = $_POST["apoyo_audiovisual"];
	$_SESSION["abstract"]["area_tl"] = $_POST["area_tl"];
	$_SESSION["abstract"]["tipo_tl"] = $_POST["tipo_tl"];
	$_SESSION["abstract"]["tematica_tl1"] = $_POST["tematica_tl1"];
	$_SESSION["abstract"]["tematica_tl2"] = $_POST["tematica_tl2"];
	$_SESSION["abstract"]["tematica_tl3"] = $_POST["tematica_tl3"];
	if($_SESSION["abstract"]["tematica_tl1"])
		$_SESSION["abstract"]["tematica_tl"] = $_SESSION["abstract"]["tematica_tl1"];
	elseif($_SESSION["abstract"]["tematica_tl2"])
		$_SESSION["abstract"]["tematica_tl"] = $_SESSION["abstract"]["tematica_tl2"];
	elseif($_SESSION["abstract"]["tematica_tl3"])
		$_SESSION["abstract"]["tematica_tl"] = $_SESSION["abstract"]["tematica_tl3"];
	$_SESSION["abstract"]["tematica_tl"] = (int)$_SESSION["abstract"]["tematica_tl"];
		
	$_SESSION["abstract"]["duracion_prevista"] = $_POST["duracion_prevista"];
	
	$_SESSION["abstract"]["words_total"] = $_POST["words_total"];

	$_SESSION["abstract"]["palabra_clave1"] = $_POST["palabra_clave1"];
	$_SESSION["abstract"]["palabra_clave2"] = $_POST["palabra_clave2"];
	$_SESSION["abstract"]["palabra_clave3"] = $_POST["palabra_clave3"];
	$_SESSION["abstract"]["palabra_clave4"] = $_POST["palabra_clave4"];
	$_SESSION["abstract"]["palabra_clave5"] = $_POST["palabra_clave5"];
	
	$palabras_claves = "";
	for($i=1;$i<=5;$i++){
		if($_SESSION["abstract"]["palabra_clave".$i])
			$palabras_claves .= $_SESSION["abstract"]["palabra_clave".$i].", ";
	}
	$_SESSION["abstract"]["palabras_claves"] = trim($palabras_claves, ", ");
		
	$_SESSION["abstract"]["resumen_tl"] = $_POST["resumen_tl"];//htmLawed($_POST["resumen_tl"],$config);
	$_SESSION["abstract"]["resumen_tl2"] = htmLawed($_POST["resumen_tl2"],$config);
	$_SESSION["abstract"]["resumen_tl3"] = htmLawed($_POST["resumen_tl3"],$config);
	
	$_SESSION["abstract"]["resumen_tl"] = preg_replace("/\r?\n|\r/"," ",$_SESSION["abstract"]["resumen_tl"]);
	$_SESSION["abstract"]["resumen_tl"] = preg_replace('/(\s)+/', ' ',$_SESSION["abstract"]["resumen_tl"]);
	
	$_SESSION["abstract"]["resumen_tl2"] = preg_replace ("/\r?\n|\r/"," ",$_SESSION["abstract"]["resumen_tl2"]);
	$_SESSION["abstract"]["resumen_tl2"] = preg_replace('/(\s)+/', ' ',$_SESSION["abstract"]["resumen_tl2"]);
	
	$_SESSION["abstract"]["resumen_tl3"] = preg_replace ("/\r?\n|\r/"," ",$_SESSION["abstract"]["resumen_tl3"]);
	$_SESSION["abstract"]["resumen_tl3"] = preg_replace('/(\s)+/', ' ',$_SESSION["abstract"]["resumen_tl3"]);
	
	$_SESSION["abstract"]["resumen_tl"] = str_replace("<br>"," ",$_SESSION["abstract"]["resumen_tl"]);	
	$_SESSION["abstract"]["resumen_tl2"] = str_replace("<br>"," ",$_SESSION["abstract"]["resumen_tl2"]);	
	$_SESSION["abstract"]["resumen_tl3"] = str_replace("<br>"," ",$_SESSION["abstract"]["resumen_tl3"]);
	
	//Contacto
	$_SESSION["abstract"]["contacto_mail"] = $_POST["contacto_mail"];
	$_SESSION["abstract"]["contacto_mail2"] = $_POST["contacto_mail2"];
	$_SESSION["abstract"]["contacto_nombre"] = $_POST["contacto_nombre"];
	$_SESSION["abstract"]["contacto_apellido"] = $_POST["contacto_apellido"];
	$_SESSION["abstract"]["contacto_pais"] = $_POST["contacto_pais"];
	$_SESSION["abstract"]["contacto_institucion"] = $_POST["contacto_institucion"];
	$_SESSION["abstract"]["contacto_ciudad"] = $_POST["contacto_ciudad"];
	$_SESSION["abstract"]["contacto_telefono"] = $_POST["contacto_telefono"];