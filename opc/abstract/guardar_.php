<?php
session_start();

if(!$_SESSION["abstract"]["paso1"]){
	header("Location: index.php");
	die();
}

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

	require("../init.php");
	require("class/DB.class.php");
	require("class/core.php");
	require("class/abstract.php");
	require("../class/class.smtp.php");
	require("../class/phpmailer.class.php");
	$db = \DB::getInstance();
	require("datos.post.php");
	require("lang/".$_SESSION["abstract"]["lang"].".php");
	$ignore_fields = array("t", "palabra_clave4", "palabra_clave5", 'archivo_tl_viejo', 'tematica_tl1', 'tematica_tl2', 'tematica_tl3', 'area_tl', 'linea_transversal', 'resumen_tl', 'resumen_tl2', 'resumen_tl3', 'es_admin', 'words_total', "reglamento", "conflicto_descripcion");
	
    foreach($_POST as $name => $post){
        if(!is_array($post)) {
            if (empty(trim($post)) && !in_array($name,$ignore_fields) && !startsWith($name,"apellido_") && !startsWith($name,"pasaporte_") && !startsWith($name,"rol_") && !startsWith($name,"profesion-txt_") && !startsWith($name,"institucion-txt_")) {
				\Redirect::to('index.php?error=empty&name='.$name);
				die();
            }
			
			if(startsWith($name,"apellido_")){
				$getIndex = explode("_", $name);
				if(empty(trim($_POST["apellido_".$getIndex[1]]))){
					var_dump("redirect2");die();
					\Redirect::to('index.php?error=emptyp');
					die();
				}
			}
			
        }
    }
		
    foreach($_SESSION['abstract'] as $name => $session) {
        if(!is_array($session))
            $_SESSION['abstract'][$name] = trim($session);
    }
	
	$core = new core();
	$trabajos = new abstracts();
	$mailOBJ = new phpmailer();
    $getConfig = $core->getConfig();
    $result = $trabajos->todoTL();//var_dump('aca');die();
if($result["success"]){
    $numero_de_trabajo = $result['numero_tl'];
	if(array_key_exists("archivo_name", $result)){
		$nombre_archivo = $result["archivo_name"];
	}else
		$nombre_archivo = "";
	/*if(array_key_exists("archivo_name", $result))
		$concursoArchivo = $result["archivo_name"];
	elseif($_SESSION['abstract']["archivo_tl"] && $_SESSION['abstract']["tipo_tl"] === '5'){
		$concursoArchivo = $_SESSION['abstract']["archivo_tl"];
	}*/
	
    //Agregar trabajos a evaluadores segun el area
    /*$evaluadores = array(
		12=>array(2, 3, 4, 5),
		13=>array(7, 8, 9),
		14=>array(11, 12, 13, 14),
		15=>array(16, 17, 18, 19),
		16=>array(21, 22, 23, 24),
		17=>array(26, 27, 28, 29),
		18=>array(31, 32, 33, 34),
		19=>array(36, 37, 38),
		20=>array(40, 41, 42, 43),
		21=>array(45, 46, 47),
		22=>array(49, 50, 51, 52),
		23=>array(54, 55, 56, 57),
		24=>array(59, 60, 61, 62),
		25=>array(64, 65, 66, 67),
		26=>array(69, 70, 71, 72),
		27=>array(74, 75, 76, 77),
		28=>array(79, 80, 81, 82),
		29=>array(84, 85, 86, 87),
		30=>array(89, 90, 91),
		31=>array(93, 94, 95),
		32=>array(97, 98, 99),
		33=>array(101, 102, 103),
		34=>array(105, 106, 107, 108),
		35=>array(110, 111, 112, 113),
		36=>array(115, 116, 117, 118),
		37=>array(120, 121, 122, 123)
	);
    if(is_array($evaluadores[$_SESSION["abstract"]["area_tl"]]) and $_SESSION["abstract"]["id_tl"]==""){
        foreach($evaluadores[$_SESSION["abstract"]["area_tl"]] as $evaid){
            $db->insert("evaluaciones",[
				"idEvaluador"=>$evaid,
                "numero_tl"=>$numero_de_trabajo,
                "fecha_asignado"=>date("Y-m-d")
			]);
        }
    }*/
	if($_SESSION["abstract"]["area_tl"] != "")
        $area_tl = $core->getAreasIdTL($_SESSION["abstract"]["area_tl"]);
    if(empty($_SESSION["abstract"]["linea_transversal"])){
        $linea_transversal = "";
    } else {
        $linea_transversal = $core->getLineaTransversalByID($_SESSION["abstract"]["linea_transversal"]);
    }
    if(!empty($_SESSION["abstract"]["modalidad"]))
        $modalidad = $core->getModalidadID($_SESSION["abstract"]["modalidad"]);
    else
        $modalidad = "";
	$tematica_tl = $core->getTematicaTLByID($_SESSION["abstract"]["tematica_tl"]);
	$tipo_tl = $core->getTipoTLID($_SESSION["abstract"]["tipo_tl"]);
	//$modalidad = $core->getModalidadID($_SESSION["abstract"]["modalidad"]);
	//$idioma_tl = $trabajos->getIdiomaTLID($_SESSION["abstract"]["idioma_tl"]);
	$cuerpo = '
	<table width="850px" align="center" cellpadding="0px" cellspacing="0" bgcolor="#FBF6F0">
		<tr><td align="center"><br>
		<table width="800px" border="0" cellspacing="1" cellpadding="0" style="font-size:13px; text-decoration:none">';

	$banner_impreso = '<tr>
				   <td bgcolor="#FFFFFF" align="center"><img src="'.$getConfig["banner_congreso"].'" alt="'.$getConfig["nombre_congreso"].'" width="600" ></td>
			  </tr>';

    $cuerpo .= $banner_impreso;
	$cuerpo .= '
			  <tr>
				<td bgcolor="#FFFFFF" align="center">
				<span class="letrasMenu">
				<br>
				<strong>'.$getConfig["nombre_congreso"].'</strong><br><br>
				'.$lang["PRESENTACION_RESUMEN"].'<br>';

                //Reglamento
                /*$cuerpo .= '<div style="border:1px solid gray;padding:10px;margin-bottom:20px">';
                if($_SESSION["abstract"]["reglamento"]=="1")
                    $cuerpo .= $lang["reglamento"];
                elseif($_SESSION["abstract"]["reglamento"]=="2"){
                    $cuerpo .= $lang["reglamento2"]."<br>";
                    if($_SESSION["abstract"]["conflicto_descripcion"])
                        $cuerpo .= "<br>".$_SESSION["abstract"]["conflicto_descripcion"]."<br><br>";
                }
                $cuerpo .= '</div>';*/
				
				//$cuerpo .= $lang["TIPO_TL"] . ': <strong>' . $tipo_tl . '</strong><br>';
                if(!empty($_SESSION["abstract"]["modalidad"]))
                    $cuerpo .= $lang["MODALIDAD"] . ': <strong>' . $modalidad . '</strong><br>';
				if($_SESSION["abstract"]["area_tl"] != "")
                    $cuerpo .= $lang["EJES_TEMATICOS_MAIL"] . ': <strong>' . $area_tl . '</strong><br>';
                if(!empty($_SESSION["abstract"]["linea_transversal"]))
                    $cuerpo .= $lang["LINEA_TRANSVERSAL"] . ': <strong>' . $linea_transversal["linea_transversal_".$_SESSION["abstract"]["lang"]] . '</strong><br>';
                $cuerpo .= $lang["TXT_APOYO_AUDIOVISUAL"];
                if(!empty($_SESSION["abstract"]["apoyo_audiovisual"]))
                    $cuerpo .= ' <strong>Si</strong><br>';
                else
                    $cuerpo .= ' <strong>No</strong><br>';
				//if($_SESSION["abstract"]["area_tl"] === '1' || $_SESSION["abstract"]["area_tl"] === '2' || $_SESSION["abstract"]["area_tl"] === '3')
					//$cuerpo .= $lang["TEMATICA"] . ': <strong>' . $tematica_tl . '</strong><br>';

                $cuerpo .='
				<br><br>
				
				'.$lang["TXT_TRABAJO"].': <span style="font-size:28;color:red">'.$numero_de_trabajo.'</span></span><br /><br />
				<table width="95%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="center" class="letrasMenu"><br />
			 <strong> '.$_SESSION["abstract"]["titulo_tl"].'</strong></td>
			</tr>
		  <tr>
			<td align="center">'.$_SESSION["abstract"]["autores"].'</td>
		  </tr>
		  <tr>
			<td style="text-align:justify"><br>
			<div style="border-bottom:1px dashed; padding-bottom:10px; margin-bottom:10px">';
			if($_SESSION["abstract"]["resumen_tl"]) {
				$cuerpo .='
				  <p><strong>'.$lang["RESUMEN"].'</strong><br />
					'.$_SESSION["abstract"]["resumen_tl"].'
					</p>';
			}
			if($_SESSION["abstract"]["resumen_tl2"]) {
				$cuerpo .='
				  <p><strong>'.$lang["RESUMEN2"].'</strong><br />
					'.$_SESSION["abstract"]["resumen_tl2"].'
					</p>';
			}
            if($_SESSION["abstract"]["resumen_tl3"]) {
                $cuerpo .='
                          <p><strong>'.$lang["RESUMEN3"].'</strong><br />
                            '.$_SESSION["abstract"]["resumen_tl3"].'
                            </p>';
            }
			if($_SESSION["abstract"]["palabras_claves"])
              $cuerpo .= '<p>'.$lang["PALABRAS_CLAVES"].': <strong>'.$_SESSION["abstract"]["palabras_claves"].'</strong></p><br>';
            /*$cuerpo .= '<p><strong>'.$lang["PALABRAS_CLAVES"].'</strong>:<br>';
            if($_SESSION["abstract"]["palabra_clave1"]){
                $palabra_clave1 = $core->getPalabraClaveByID($_SESSION["abstract"]["palabra_clave1"]);
                $cuerpo .= $palabra_clave1["nombre_palabra_clave_".$_SESSION["abstract"]["lang"]].', ';
            }
            if($_SESSION["abstract"]["palabra_clave2"]){
                $palabra_clave2 = $core->getPalabraClaveByID($_SESSION["abstract"]["palabra_clave2"]);
                $cuerpo .= $palabra_clave2["nombre_palabra_clave_".$_SESSION["abstract"]["lang"]].', ';
            }
            if($_SESSION["abstract"]["palabra_clave3"]){
                $palabra_clave3 = $core->getPalabraClaveByID($_SESSION["abstract"]["palabra_clave3"]);
                $cuerpo .= $palabra_clave3["nombre_palabra_clave_".$_SESSION["abstract"]["lang"]].', ';
            }
            if($_SESSION["abstract"]["palabra_clave4"]){
                $palabra_clave4 = $core->getPalabraClaveByID($_SESSION["abstract"]["palabra_clave4"]);
                $cuerpo .= $palabra_clave4["nombre_palabra_clave_".$_SESSION["abstract"]["lang"]].', ';
            }
            if($_SESSION["abstract"]["palabra_clave5"]){
                $palabra_clave5 = $core->getPalabraClaveByID($_SESSION["abstract"]["palabra_clave5"]);
                $cuerpo .= $palabra_clave5["nombre_palabra_clave_".$_SESSION["abstract"]["lang"]].', ';
            }
            $cuerpo = substr($cuerpo, 0, -2);
            $cuerpo .= "<br>";*/

			if($_SESSION["abstract"]["words_total"])
				$cuerpo .= '<p> '.$lang["CANTIDAD_PALABRAS"].': <strong>'.$_SESSION["abstract"]["words_total"].'</strong></p>';
    $cuerpo .='
			</div></td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			</tr>
		</table>
        
        <table width="95%" border="0" cellspacing="1" cellpadding="5">
          <tr>
		  	<!--<th align="left">'.$lang['PROFESION'].'</th>-->
            <th align="left">'.$lang["NOMBRES"].'</th>
            <th align="left">'.$lang["APELLIDOS"].'</th>
            <th align="left">'.$lang['PERTENENCIA'].'</th>
            <!--<th align="left">Pasaporte / CI</th>-->
		';
		$tiene_rol = false;
		for($i=0;$i<$_SESSION["abstract"]["total_autores"];$i++){
			if($_SESSION["abstract"]["rol_".$i]){
				$tiene_rol = true;
			}
		}
		if(($_SESSION["admin"] || $_SESSION["abstract"]["is_admin"]) && $tiene_rol){
			$cuerpo .= '<th align="left">Rol</th>';
		}else{
			$cuerpo .= '<th align="left"></th>';
		}
		$cuerpo .= '
            <th align="left">'.$lang["INSTITUCION"].'</th>
            <th align="left">'.$lang['EMAIL'].'</th>
            <th align="left">'.$lang["PAIS"].'</th>
            </tr>';
    foreach($_SESSION["abstract"]["autoresNuevo"] as $autor){
        $paisAutor = $core->getPaisID($autor['pais']);

        /*if($autor['profesion'] == 'Otro' || $autor['profesion'] == 'Outros'){
            $txt_prof = '<td>'.$autor['profesion_otro'].'</td>';
        } else {
            $txt_prof = '<td>'.$autor['profesion'].'</td>';
        }*/
        if($autor['institucion'] == 'Otra'){
            $txt_inst = '<td>'.$autor['institucion_otro'].'</td>';
        } else {
            $txt_inst = '<td>'.$autor['institucion'].'</td>';
        }

        if($autor['rol']){
            $rolAutor = $core->getRolConferencistaByID($autor['rol']);
            $txt_rol = '<td>'.$rolAutor['calidad'].'</td>';
        }else
            $txt_rol = "<td></td>";
        $cuerpo .= '
            <tr>
                <td>'.$autor['nombre'].'</td>
                <td>'.$autor['apellido'].'</td>
                <td>'.$lang['PERTENENCIA_OPCIONES'][$autor['pertenencia']].'</td>
                <!--<td>'.$autor['pasaporte'].'</td>-->
                '.$txt_rol.'
                '.$txt_inst.'
                <td>'.$autor['email'].'</td>
                <td>'.$paisAutor.'</td>
            </tr>
        ';
    }
    $cuerpo .='</table>
        <br />			
        <table style="font-size:13px">
            <tr>
                <td height="45" colspan="2" align="center" style="font-size:15px; font-family:\'Trebuchet MS\', Arial, Helvetica, sans-serif; color:#333"><strong>'.$lang["DATOS_CONTACTO"].'</strong></td>
            </tr>
            <tr>
                <td width="142" >'.$lang["NOMBRES"].':</td>
                <td width="407" valign="top" ><strong>'.$_SESSION["abstract"]["contacto_nombre"].'</strong></td>
            </tr>
            <tr>
                <td >'.$lang["APELLIDO"].':</td>
                <td valign="top" ><strong>'.$_SESSION["abstract"]["contacto_apellido"].'</strong></td>
                </tr>
            <tr>
                <td >'.$lang['EMAIL'].':</td>
                <td valign="top" ><strong>'.$_SESSION["abstract"]["contacto_mail"].'</strong></td>
            </tr>
            <tr>
                <td >'.$lang['EMAIL_ALTERNATIVO'].':</td>
                <td valign="top" ><strong>'.$_SESSION["abstract"]["contacto_mail2"].'</strong></td>
            </tr>
            <tr>
                <td>'.$lang["INSTITUCION"].'</td>
                <td valign="top" ><strong>'.$_SESSION["abstract"]["contacto_institucion"].'</strong></td>
            </tr>
        </table>
        <br>
        '.$lang['TXT_CLAVES'].'<br>
        <br>
        <table width="50%" border="0" align="center" cellpadding="2" cellspacing="0"  style="font-size:12px; text-align:center">
            <tr>
                <td width="50%">'.$lang["CODIGO"].': <strong>'.$numero_de_trabajo.'</strong></td>
                <td width="50%">'.$lang["CLAVE"].': <strong>'.$_SESSION["abstract"]["password"].'</strong></td>
            </tr>
            <tr>
                <td width="50%" colspan="2"><br><br>
                    <a href="'.$getConfig["url_opc"].'abstract">'.$getConfig["url_opc"].'abstract</a>
                </td>
            </tr>
        </table>
        <br>
        <br>
    ';

    if($_SESSION["abstract"]["archivo_tl"]!=""){
        $cuerpo .='<center>
        <a href="'.$getConfig["url_opc"].'tl/'.($nombre_archivo!=""?$nombre_archivo:$_SESSION["abstract"]["archivo_tl"]).'" style="font-size:13px;"> '.$lang["DESCARGAR_ARCHIVO"].'</a><br></center>';
    }

    if(count($_SESSION["abstract"]["archivo_cv"])>0){
        foreach ($_SESSION["abstract"]["archivo_cv"] as $archivos) {
            $cuerpo .= '<center>
            <a href="' . $getConfig["url_opc"] . 'uploads/cv/' . $archivos . '.pdf" style="font-size:13px;"> ' . $lang["DESCARGAR_CV"] . '</a><br></center>';
        }
    }


    $cuerpo .='
                        </td>
                    </tr>
                </table>
                <br>
            </td>
        </tr>
    </table>';
    //"Cuenta [".str_pad($_SESSION["cliente"]["id_cliente"],4,0,STR_PAD_LEFT)."]
    $asunto = " [".$_SESSION["abstract"]["nombre_0"]." ".$_SESSION["abstract"]["apellido_0"]."] ";

    //if($_SESSION["abstract"]["tipo_tl"]=='1') {
        if ($_SESSION["abstract"]["id_tl"] == "") {
            $asunto .= " ".$lang['PRESENTACION_RESUMEN']." [$numero_de_trabajo]";
        } else {
            $asunto .= " ".$lang['MODIFICACION_RESUMEN']." [$numero_de_trabajo]";
        }
        /*}else if($_SESSION["abstract"]["tipo_tl"]=='2'){
            if ($_SESSION["abstract"]["id_tl"] == "") {
                $asunto .= " MESA REDONDA [$numero_de_trabajo]";
            } else {
                $asunto .= " Modificación de MESA REDONDA [$numero_de_trabajo]";
            }
            }else {
            if ($_SESSION["abstract"]["id_tl"] == "") {
                $asunto .= " ".$tipo_tl." [$numero_de_trabajo]";
            } else {
                $asunto .= " Modificación de ".$tipo_tl." [$numero_de_trabajo]";
            }
        }*/
    unset($mails_congreso);
    unset($mails_congreso_admin);
    /* str_replace("http://", "", $getConfig["url_base"]) */
    $mails_congreso = array();
    $mails_congreso_admin = array();

    if($_SERVER["SERVER_NAME"] == "localhost"){

        $mails_congreso[] = "gegamultimedios@gmail.com";
    } else {

        if(!$_SESSION["abstract"]["is_admin"] && !$_SESSION["admin"]){
            if(!empty($_SESSION["abstract"]["contacto_mail"]))
                $mails_congreso[] = $_SESSION["abstract"]["contacto_mail"];
            //Agregamos al primer autor al envio del email
            $mails_congreso[] = $_SESSION["abstract"]["email_0"];
            //Email alternativo
            $mails_congreso[] = $_SESSION["abstract"]["contacto_mail2"];
        }
        $mails_congreso_admin[] = $getConfig['email_abstract'];
        $mails_congreso_admin[] = $getConfig['email_respaldo'];
    }



    $mails_congreso = array_unique($mails_congreso);
    $mails_congreso_admin = array_unique($mails_congreso_admin);

    $mailOBJ->Body = $cuerpo;
    $mailOBJ->Subject = $asunto.($_SESSION["abstract"]["is_admin"]?"[ADMIN]":"");
    $mailOBJ->CharSet = "utf-8";
    $mailOBJ->From    = $getConfig["email_username"];
    $mailOBJ->FromName = $getConfig["nombre_congreso"];
    $mailOBJ->IsHTML(true);
    $mailOBJ->Timeout=120;
    //

    $mailOBJ->IsSMTP();
    $mailOBJ->SMTPDebug  = false;
    $mailOBJ->SMTPAuth   = true;
    $mailOBJ->SMTPAutoTLS = false;

    $mailOBJ->Host       = $getConfig["email_host"];
    $mailOBJ->Username   = $getConfig["email_username"];
    $mailOBJ->Password   = $getConfig["email_password"];

    $mailOBJ->Port = 25;
    //$mailOBJ->From = "contacto@mail.alas2017.easyplanners.info";
    $mailOBJ->addReplyTo($getConfig['email_abstract'], 'Contacto - ' . $getConfig["nombre_congreso"]);


    //Envio a personas
    foreach($mails_congreso as $cualMail){

        $mailOBJ->ClearAddresses();
        $mailOBJ->AddAddress($cualMail);


        if(!$mailOBJ->Send()){
            echo "<script>alert('Ocurrio un error al enviar el abstract');</script>";
        }
    }

    //$nombre_archivo_word = "Trabajo ".$numero_de_trabajo." - ".$_SESSION["abstract"]["nombre_0"]." " . $_SESSION["abstract"]["apellido_0"]." ".$_SESSION["abstract"]["apellido2_0"].".doc";
    //$mailOBJ->AddStringAttachment(utf8_decode(str_replace($banner_impreso, "", $cuerpo)), $nombre_archivo_word);

    //Envio admin
    foreach($mails_congreso_admin as $cualMailAdmin){

        $mailOBJ->ClearAddresses();
        $mailOBJ->AddAddress($cualMailAdmin);


        if(!$mailOBJ->Send()){
            echo "<script>alert('Ocurrio un error al enviar el abstract');</script>";
        }
    }

    $lang = $_SESSION["abstract"]["lang"];
	unset($_SESSION["abstract"]);
	$numero_tl = "&key=".base64_encode($result["numero_tl"]);
} //end if result
header("Location: message.php?lang=".$lang."&status=".$result["success"].$numero_tl);