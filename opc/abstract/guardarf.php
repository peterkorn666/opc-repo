<?php
session_start();

if(!$_SESSION["abstract"]["paso1"]){
	header("Location: index.php");
	die();
}

	require("conexion.php");
	require("class/core.php");
	require("../configs/config.php");
	require("class/abstract.php");
	require("../class/phpmailer.class.php");
	require("datos.post.php");
	
	require("lang/".$_SESSION["abstract"]["lang"].".php");
	
	$core = new core();
	$trabajos = new abstracts();
	$mailOBJ = new phpmailer();
	
	$palabras_claves = "";
	if($_SESSION["abstract"]["palabra_clave1"]!="")
		$palabras_claves .= $_SESSION["abstract"]["palabra_clave1"];
		
	if($_SESSION["abstract"]["palabra_clave2"]!="")
		$palabras_claves .= ", ".$_SESSION["abstract"]["palabra_clave2"];
	
	if($_SESSION["abstract"]["palabra_clave3"]!="")
		$palabras_claves .= ", ".$_SESSION["abstract"]["palabra_clave3"];
	
	if($_SESSION["abstract"]["palabra_clave4"]!="")
		$palabras_claves .= ", ".$_SESSION["abstract"]["palabra_clave4"];
		
	if($_SESSION["abstract"]["palabra_clave5"]!="")
		$palabras_claves .= ", ".$_SESSION["abstract"]["palabra_clave5"];

	$insert_tl = array(
		"titulo_tl"=>$_SESSION["abstract"]["titulo_tl"],
		"tipo_trabajo"=>$_SESSION["abstract"]["tipo_trabajo"],
		//"categoria"=>$_SESSION["abstract"]["categoria"],
		"tipo_tl"=>$_SESSION["abstract"]["tipo_tl"],
		"area_tl"=>$_SESSION["abstract"]["area_tl"],
		"idioma"=>$_SESSION["abstract"]["idioma_tl"],
		"palabrasClave"=>$palabras_claves,
		"resumen"=>$_SESSION["abstract"]["resumen_tl"],
	/*	"resumen2"=>$_SESSION["abstract"]["resumen_tl2"],
		"resumen3"=>$_SESSION["abstract"]["resumen_tl3"],*/
		"contacto_mail"=>$_SESSION["abstract"]["contacto_mail"],
		"contacto_nombre"=>$_SESSION["abstract"]["contacto_nombre"],
		"contacto_apellido"=>$_SESSION["abstract"]["contacto_apellido"],
		"contacto_pais"=>$_SESSION["abstract"]["contacto_pais"],
		"contacto_institucion"=>$_SESSION["abstract"]["contacto_institucion"],
		"contacto_ciudad"=>$_SESSION["abstract"]["contacto_ciudad"],
		"contacto_telefono"=>$_SESSION["abstract"]["contacto_telefono"],
		"lang"=>$_SESSION["abstract"]["lang"],
		"fecha_creado"=>date("Y-m-d")
		/*"Hora_inicio"=>$_SESSION["abstract"]["hora1"],
		"Hora_fin"=>$_SESSION["abstract"]["hora2"],*/
	);
	
	
	
	if($_SESSION["abstract"]["id_tl"]==""){
		if($_SESSION["abstract"]["numero_tl"]==""){
			$numero_de_trabajo = $trabajos->getLastNumTL();
			$insert_tl["numero_tl"] = $numero_de_trabajo;
		}else{
			$insert_tl["numero_tl"] = $_SESSION["abstract"]["numero_tl"];
			$numero_de_trabajo = $_SESSION["abstract"]["numero_tl"];
		}
		
		$archivo_tl = $_FILES["archivo_tls"];
		$nombre_archivo = "";
		if($archivo_tl["tmp_name"]!=""){
			$autores = array("numero_tl"=>$numero_de_trabajo,"nombre"=>$_SESSION["abstract"]["nombre_0"],"apellido"=>$_SESSION["abstract"]["apellido_0"]);
			$nombre_archivo = $trabajos->guardarArchivoTL($archivo_tl,$autores);
		}
		
		if($nombre_archivo!=""){
			$insert_tl["archivo_tl"] = $nombre_archivo;
		}
		
		
		$password = $trabajos->generarClave(5);
		$insert_tl["clave"] = $password;
		$result_tl = $core->insertarBd("trabajos_libres",$insert_tl);
	}else{
		
		$archivo_tl = $_FILES["archivo_tls"];
		$nombre_archivo = "";
		if($archivo_tl["tmp_name"]!=""){
			$autores = array("numero_tl"=>$_SESSION["abstract"]["numero_tl"],"nombre"=>$trabajos->limpiar($_SESSION["abstract"]["nombre_0"]),"apellido"=>$trabajos->limpiar($_SESSION["abstract"]["apellido_0"]));
			$nombre_archivo = $trabajos->guardarArchivoTL($archivo_tl,$autores);
		}
		
		if($nombre_archivo!=""){
			$insert_tl["archivo_tl"] = $nombre_archivo;
		}
				
		
		$result_tl = $core->modificarBd("trabajos_libres","id_trabajo='".$_SESSION["abstract"]["id_tl"]."'",$insert_tl);
		$result_tl["lastID"] = $_SESSION["abstract"]["id_tl"];
		$password = $_SESSION["abstract"]["password"];
		$numero_de_trabajo = $_SESSION["abstract"]["numero_tl"];
	}
	
$ses = date("dmhis"). session_id();	
if($result_tl["result"]){
	
	if($_SESSION["abstract"]["id_tl"]!=""){
		//Elimino los autores que ya no esten en el trabajo modificado
		$revisarAutores = $trabajos->getAutoresIDtl($_SESSION["abstract"]["id_tl"]);
		while($rowAut = $revisarAutores->fetch()){
			//if(!in_array($rowAut["ID_participante"],$_SESSION["abstract"]["id_autor"])){
				 $trabajos->eliminarAutorDeltrabajoID($_SESSION["abstract"]["id_tl"],$rowAut["ID_participante"]);
			//}
			
		}
	}
	
	
	for($i=0;$i<$_SESSION["abstract"]["total_autores"];$i++){
		
		$institucion_autor = $trabajos->validarInstitucionAutores($_SESSION["abstract"]["institucion_".$i]);
		
		$insert_autores = array(
			"Nombre"=>$_SESSION["abstract"]["nombre_".$i],
			"Apellidos"=>$_SESSION["abstract"]["apellido_".$i],
			"Pais"=>$_SESSION["abstract"]["pais_".$i],
			"Institucion"=>$institucion_autor,
			"Mail"=>$_SESSION["abstract"]["email_".$i],
			"ciudad"=>$_SESSION["abstract"]["ciudad_".$i],
			"session"=>$ses
		);
		//if(($_SESSION["abstract"]["id_autor"][$i]=="")){
			$result_autores = $core->insertarBd("personas_trabajos_libres",$insert_autores);
			$autores_last = $result_autores["lastID"];
		/*}else if($_SESSION["abstract"]["id_autor"][$i]!=""){
			$result_autores = $core->modificarBd("personas_trabajos_libres","ID_Personas='".$_SESSION["abstract"]["id_autor"][$i]."'",$insert_autores);
			$autores_last = $_SESSION["abstract"]["id_autor"][$i];
		}*/
		
		if($result_autores["result"]){
			$insert_autores_con = array(
				"ID_trabajos_libres"=>$result_tl["lastID"],
				"lee"=>$_SESSION["abstract"]["lee_".$i]
			);

			$insert_autores_con["ID_participante"] = $autores_last;

			
//			var_dump($insert_autores_con);
			//if($_SESSION["abstract"]["id_autor"][$i]==""){
				//echo "<br>";
				//var_dump($insert_autores_con);
				$result = $core->insertarBd("trabajos_libres_participantes",$insert_autores_con);
				//var_dump($r);
			/*}else{
//				echo "modifica";
				$result = $core->modificarBd("trabajos_libres_participantes","ID='$autores_last'",$insert_autores_con);
			}*/
		}		
	}
	
	//Asignar trabajos a todos los evaluadores
	$tle = $core->asignarTrabajos($numero_de_trabajo);
	
$area_tl = $core->getAreasIdTL($_SESSION["abstract"]["area_tl"]);
	$cuerpo = '
	<table width="850px" align="center" cellpadding="0px" cellspacing="0" bgcolor="#FBF6F0">
		<tr><td align="center"><br>
		<table width="800px" border="0" cellspacing="1" cellpadding="0" style="font:Geneva, Arial, Helvetica, sans-serif; font-size:13px; text-decoration:none">
			  <tr>
				   <td bgcolor="#FFFFFF" align="center"><img src="'.$getConfig["banner_congreso"].'" alt="'.$getConfig["nombre_congreso"].'" width="900" ></td>
			  </tr>
			  <tr>
				<td bgcolor="#FFFFFF" align="center">
				<span class="letrasMenu">
				<br>
				<strong>'.$getConfig["nombre_congreso"].'<br><br>
				'.$lang["PRESENTACION_RESUMEN"].'<br>
				<br>
				N&ordm;: <span style="font-size:28;color:red">'.$numero_de_trabajo.'</span></strong></span><br /><br />
				<table width="95%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>'.$lang["EJES_TEMATICOS"].': <strong>'.$area_tl.'</strong></td>
			</tr>
	
		  <tr>
		    <td align="left" class="letrasMenu">'.$lang["MODALIDAD"].': <strong>'.$core->getTipoTLID($_SESSION["abstract"]["tipo_tl"]).'</strong></td>
		    </tr>
		  <tr>
			<td align="center" class="letrasMenu"><br />
			 <strong> '.$_SESSION["abstract"]["titulo_tl"].'</strong></td>
			</tr>';
		if($_SESSION["abstract"]["autores"])
		{
			$cuerpo .='
		  <tr>
			<td align="center">'.$_SESSION["abstract"]["autores"].'</td>
		  </tr>
		  <tr>';
		}
		/*$cuerpo .='
			<td style="text-align:justify"><br>
			<div style="border-bottom:1px dashed; padding-bottom:10px; margin-bottom:10px">	
			  <p><strong>'.$lang["RESUMEN"].'</strong><br />
				'.$_SESSION["abstract"]["resumen_tl"].'
				</p>
               <p>'.$lang["PALABRAS_CLAVES"].': '.$_SESION["palabras_claves"].'</p>
			</div></td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			</tr>
		</table>
				<br />';*/
		if($_SESSION["abstract"]["autores"])
		{				
$cuerpo .='				<table style="font-size:13px">
				<tr>
					<td height="45" colspan="2" align="center" style="font-size:15px; font-family:\'Trebuchet MS\', Arial, Helvetica, sans-serif; color:#333"><strong><span class="translate" data-rel="Contact details*RESPONSABLE DEL TRABAJO QUE SE EST&Aacute; PRESENTANDO">'.$lang["DATOS_CONTACTO"].'</span></strong></td>
					</tr>
				  <tr>
					<td width="142" >'.$lang["NOMBRES"].':</td>
					<td width="407" valign="top" ><strong>'.$_SESSION["abstract"]["contacto_nombre"].'</strong></td>
					</tr>
				  <tr>
					<td >'.$lang["APELLIDOS"].':</td>
					<td valign="top" ><strong>'.$_SESSION["abstract"]["contacto_apellido"].'</strong></td>
					</tr>
				  <tr>
					<td >E-mail:</td>
					<td valign="top" ><strong>'.$_SESSION["abstract"]["contacto_mail"].'</strong></td>
					</tr>
				  <tr>
					<td>'.$lang["PAIS"].'</td>
					<td valign="top" ><strong>'.$core->getPaisID($_SESSION["abstract"]["contacto_pais"]).'</strong></td>
					</tr>
				  <tr>
					<td>'.$lang["INSTITUCION"].'</td>
					<td valign="top" ><strong>'.$_SESSION["abstract"]["contacto_institucion"].'</strong></td>
					</tr>
				  <tr>
					<td>'.$lang["TELEFONO"].':</td>
					<td valign="top" ><strong>'.$_SESSION["abstract"]["contacto_telefono"].'</strong></td>
					</tr>
				  <tr>
					<td>'.$lang["CIUDAD"].'</td>
					<td valign="top" ><strong>'.$_SESSION["abstract"]["contacto_ciudad"].'</strong></td>
					</tr>
				  </table>
				<br>
				
				'.$lang['TXT_CLAVES'].'<br>
				<br>
				<table width="50%" border="0" align="center" cellpadding="2" cellspacing="0"  style="font-size:12px; text-align:center">
				  <tr>
					<td width="50%">'.$lang["CODIGO"].': <strong>'.$numero_de_trabajo.'</strong></td>
					  <td width="50%">'.$lang["CLAVE"].': <strong>'.$password.'</strong></td>
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
		 }
		 if($nombre_archivo!="" or $_SESSION["abstract"]["archivo_tl"]!=""){
			$cuerpo .='<center>
			<a href="'.$getConfig["url_opc"].'tlc/'.($nombre_archivo!=""?$nombre_archivo:$_SESSION["abstract"]["archivo_tl"]).'" style="font-size:13px;"> '.$lang["DESCARGAR_ARCHIVO"].'</a><br></center>';
		 }
		 
		 
		$cuerpo .='
		</td>
			  </tr>
			</table>
		<br></td></tr>
		</table>';

//$asunto = utf8_decode($nombre_congreso);
$asunto = "";
if($_SESSION["abstract"]["id_tl"]==""){
	$asunto .= " Recepción de Resumen [ID: $numero_de_trabajo]";
}else{
	$asunto .= " Recepcion de archivo de PAPER [ID: $numero_de_trabajo]";
}
unset($mails_congreso);
if(!$_SESSION["abstract"]["is_admin"]){
	if(!empty($_SESSION["abstract"]["contacto_mail"]))
		$mails_congreso[] = $_SESSION["abstract"]["contacto_mail"];
}


$mails_congreso[] = "clatpu2016@gmail.com";	
//$mails_congreso[] = "trabajoscientificos@sup.org.uy";
//$mails_congreso[] = "trabajocientifico@irsolucionesempresariales.com.uy";
/*$mails_congreso[] = "gegamultimedios@gmail.com";*/
//$mails_congreso[] = "gegamultimedios@gmail.com";

foreach($mails_congreso as $cualMail){
	$mailOBJ->CharSet = "utf-8";
	$mailOBJ->From    = "secretariaclatpu2016@grupoelis.com.uy";
	$mailOBJ->FromName = "CLATPU 2016";
	$mailOBJ->IsHTML(true);
	
	$mailOBJ->Timeout=120;
	$mailOBJ->ClearAddresses();
	$mailOBJ->AddAddress($cualMail);
	
	/*switch($cualMail)
	{
		/*case "comitepediatria@sup.org.uy":
		case "comiteadolescencia@sup.org.uy":*/
		/*case "santarepara@gmail.com":
		case "carlos@ciganda.com":
		//case "carlos@ciganda.com":
			$mailOBJ->Body = cuerpoMail(false);
			$mailOBJ->Subject = $asunto;
		break;
		default:*/
			
		//break;
	//}
	
	
	$mailOBJ->Body = $cuerpo;
	$mailOBJ->Subject = $asunto." [".$_SESSION["abstract"]["nombre_0"]." " . $_SESSION["abstract"]["apellido_0"] . "]".($_SESSION["abstract"]["is_admin"]?"[ADMIN]":"");
	
	if(!$mailOBJ->Send()){
		echo "<script>alert('Ocurrio un error al enviar el abstract');</script>";
	}
}	
	unset($_SESSION["abstract"]);
	header("Location: message.php?status=".$result["result"]."&key=".base64_encode($numero_de_trabajo));
	
	
	
}
?>