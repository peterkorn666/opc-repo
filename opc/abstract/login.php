<?php
	session_start();
	if($_GET["id"]==""){
		if($_POST["codigo"]=="" && $_POST["clave"]==""){
			//header("Location: index.php");
			header("Location: modificar_trabajo.php?error=camposVacios");
			die();
		}
	}else{
		require("../class/util.class.php");
		$util = new Util;
		/*if(empty($_SESSION["cliente"]["id_cliente"]))
			$util->isLogged();*/
	}
	require("../init.php");
	require("class/DB.class.php");
	require("class/login.php");
	require("class/abstract.php");
	$login = new login();
	$trabajos = new abstracts();
	unset($_SESSION["abstract"]);
	$_SESSION["abstract"] = array();
	$_SESSION["abstract"]["is_admin"] = false;
	if($_GET["id"]=="")
		$result = $login->validar($_POST["codigo"],$_POST["clave"]);
	else{
		$result = $login->validarID($_GET["id"]);
		if($_SESSION["admin"]) {
			$_SESSION["abstract"]["is_admin"] = true;
		}
	}
	$numero_tl = $result["numero_tl"];
	if($numero_tl!=""){	
		$_SESSION["abstract"]["id_tl"] = $result["id_trabajo"];
		$_SESSION["abstract"]["numero_tl"] = $numero_tl;
		$_SESSION["abstract"]["password"] = $result["clave"];
		
		//DATOS
		$tl = $trabajos->getTrabajoID($_SESSION["abstract"]["id_tl"]);
		$_SESSION["abstract"]["tipo_tl"] = $tl["tipo_tl"];
		$_SESSION["abstract"]["titulo_tl"] = $tl["titulo_tl"];
		$_SESSION["abstract"]["area"] = $tl["area_tl"];
		$_SESSION["abstract"]["area_tl"] = $tl["area_tl"];
		$_SESSION["abstract"]["tipo_tl"] = $tl["tipo_tl"];
		$_SESSION["abstract"]["tematica_tl"] = $tl["tematica_tl"];
		$_SESSION["abstract"]["linea_transversal"] = $tl["linea_transversal"];
		$_SESSION["abstract"]["apoyo_audiovisual"] = $tl["apoyo_audiovisual"];
		//abstracts se usa para separar contenidos en el index del abstract --> ponencias, mesas redondas, libros, videos, fotografias, etc
		$_SESSION["abstracts"]['tipo_tl'] = $tl["tipo_tl"];
		
		$_SESSION["abstract"]["duracion_prevista"] = $tl["duracion_prevista"];
		$_SESSION["abstract"]["modalidad"] = $tl["modalidad"];
        $_SESSION["abstract"]["tipo_conversatorio"] = $tl["tipo_conversatorio"];
		$_SESSION["abstract"]["lang"] = $tl["lang"];
		$_SESSION["abstract"]["idioma"] = $tl["idioma"];
		$_SESSION["abstract"]["idioma_tl"] = $tl["idioma_tl"];
		$_SESSION["abstract"]["resumen_tl"] = $tl["resumen"];
		$_SESSION["abstract"]["resumen_tl2"] = $tl["resumen2"];
		$_SESSION["abstract"]["resumen_tl3"] = $tl["resumen3"];
		$_SESSION["abstract"]["resumen_tl4"] = $tl["resumen4"];
		$_SESSION["abstract"]["resumen_tl5"] = $tl["resumen5"];
		$_SESSION["abstract"]["contacto_mail"] = $tl["contacto_mail"];
		$_SESSION["abstract"]["contacto_mail2"] = $tl["contacto_mail2"];
		$_SESSION["abstract"]["contacto_nombre"] = $tl["contacto_nombre"];
		$_SESSION["abstract"]["contacto_apellido"] = $tl["contacto_apellido"];
		$_SESSION["abstract"]["contacto_pais"] = $tl["contacto_pais"];
		//$_SESSION["abstract"]["contacto_institucion"] = $tl["contacto_institucion"];
		$_SESSION["abstract"]["contacto_institucion"] = $trabajos->getInstitucionID($tl["contacto_institucion"]);
		$_SESSION["abstract"]["contacto_ciudad"] = $tl["contacto_ciudad"];
		$_SESSION["abstract"]["contacto_telefono"] = $tl["contacto_telefono"];
		$_SESSION["abstract"]["hora1"] = $tl["Hora_inicio"];
		$_SESSION["abstract"]["hora2"] = $tl["Hora_fin"];
		//$_SESSION["abstract"]["archivo_concurso_fotografia"] = $tl["archivo_concurso_fotografia"];
		$_SESSION["abstract"]["archivo_tl"] = $tl["archivo_tl"];
		$_SESSION["abstract"]["archivo_cv"] = $tl["archivo_cv"];
		$_SESSION["abstract"]["palabras_claves"] = $tl["palabrasClave"];
		if($_SESSION["abstract"]["palabras_claves"])
		{
			$palabras_claves = explode(", ", $_SESSION["abstract"]["palabras_claves"]);
			$h = 1;
			foreach($palabras_claves as $p){
				$_SESSION["abstract"]["palabra_clave".$h] = $p;
				$h++;
			}
		}

		$tl_autor = $trabajos->getAutoresIDtl($_SESSION["abstract"]["id_tl"]);
		$p = 0;
		$_SESSION["abstract"]["total_autores"] = count($tl_autor);
		foreach($tl_autor as $row_autor){
			$_SESSION["abstract"]["lee_".$p] = $row_autor["lee"];
			$_SESSION["abstract"]["id_autor_".$p] = $row_autor["ID_Personas"];
			$_SESSION["abstract"]["profesion_".$p] = $row_autor["Profesion"];
            $_SESSION["abstract"]["profesion-txt_".$p] = $row_autor["Profesion_otro"];
			$_SESSION["abstract"]["nombre_".$p] = $row_autor["Nombre"];
			$_SESSION["abstract"]["nombre2_".$p] = $row_autor["Nombre2"];
			$_SESSION["abstract"]["apellido_".$p] = $row_autor["Apellidos"];
			$_SESSION["abstract"]["pasaporte_".$p] = $row_autor["pasaporte"];
			$_SESSION["abstract"]["rol_".$p] = $row_autor["rol_crono"];
			//$_SESSION["abstract"]["apellido2_".$p] = $row_autor["Apellidos2"];
			$_SESSION["abstract"]["pais_".$p] = $row_autor["Pais"];
			$_SESSION["abstract"]["pertenencia_".$p] = $row_autor["pertenencia"];
			if($row_autor["Institucion"] == 'Otra'){
                $_SESSION["abstract"]["institucion_".$p] = $row_autor["Institucion"];
                $_SESSION["abstract"]["institucion-txt_".$p] = $trabajos->getInstitucionID($row_autor["Institucion_otro"]);
            } else {
                $_SESSION["abstract"]["institucion_".$p] = $trabajos->getInstitucionID($row_autor["Institucion"]);
                $_SESSION["abstract"]["institucion-txt_".$p] = $row_autor["Institucion_otro"];
            }
			$_SESSION["abstract"]["email_".$p] = $row_autor["Mail"];
			$_SESSION["abstract"]["ciudad_".$p] = $row_autor["ciudad"];
			$_SESSION["abstract"]["inscripto_".$p] = $row_autor["inscripto"];
			$p++;
		}
		//-- DATOS
		if(!$_SESSION["abstract"]["is_admin"])
			header("Location: index.php");
		else
			header("Location: index.php");
		die();
	}
	//header("Location: index.php?login=error");
	header("Location: modificar_trabajo.php?error=login");
	die();
?>