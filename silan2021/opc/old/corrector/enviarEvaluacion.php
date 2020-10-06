<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
$opcion = $_POST["opcion"];
$nota1 = $_POST["nota1"];
$nota2 = $_POST["nota2"];
$nota3 = $_POST["nota3"];
$nota4 = $_POST["nota4"];
$nota5 = $_POST["nota5"];
$nota6 = $_POST["nota6"];
$nota7 = $_POST["nota7"];
$nota8 = $_POST["nota8"];
$nota9 = $_POST["nota9"];
//$ev_global = $_POST["ev_global"];
$estado = $_POST["estado"];
//$estado = $_POST["estado_ev"];
//$evaluar_trabajo = $_POST["evaluar_trabajo"];
$acepto_trabajo = $_POST["acepto_trabajo"];
$tipo = $_POST["tipo"];
$puntajeTotal = $_POST["puntajeTotal"];
$comentarios = $_POST["comentarios"];
$premio = $_POST["premio"];

$tipo_tl = $_POST["tipoTL"];

require("../envioMail_Config.php");
require "../conexion.php";
require "../clases/class.phpmailer.php";
require "../clases/trabajosLibres.php";
$trabajos = new trabajosLibre();
$mailOBJ = new phpmailer();
/*opcion = '".$opcion."',
 nota1 = '".$nota1."',
 nota2 = '".$nota2."',
 nota3 = '".$nota3."',
 nota4 = '".$nota4."',
 nota5 = '".$nota5."',
 nota6 = '".$nota6."',
 tipoEvaluacion = '$tipo',
 puntajeTotal = '".$puntajeTotal."',
 */
 
 $sql = "UPDATE evaluaciones SET
 evaluar_trabajo = '".$acepto_trabajo."',
 estadoEvaluacion = '".$estado."',
 comentarios = '".$comentarios."',
 fecha = '".date("Y-m-d")."' WHERE  idEvaluador = '".$_SESSION["idEvaluador"]."' AND numero_tl='".$_SESSION["txtCod"]."';";

/*$sql = "UPDATE evaluaciones SET 
 nota1 = '".$nota1."',
 nota2 = '".$nota2."',
 nota3 = '".$nota3."',
 nota4 = '".$nota4."',
 nota5 = '".$nota5."',
 nota6 = '".$nota6."',
 nota7 = '".$nota7."',
 ev_global = '".$ev_global."',
 evaluar_trabajo = '".$acepto_trabajo."',
 estadoEvaluacion = '".$estado."',
 comentarios = '".$comentarios."',
 fecha = '".date("Y-m-d")."' WHERE  idEvaluador = '".$_SESSION["idEvaluador"]."' AND numero_tl='".$_SESSION["txtCod"]."';";*/

$rs = $con->query($sql);
if(!$rs){
	die($con->error);
}

if($estado!="Correccion"){
$sql = "SELECT * FROM trabajos_libres WHERE numero_tl='".$_SESSION["txtCod"]."'";

	$row = $con->query($sql);
	$fila = $row->fetch_object();  
	/* personas */
	$arrayPersonas = array();
	$arrayInstituciones = array();
	$primero = true;
	$sql2 ="SELECT ID_participante, lee FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " . $fila->id_trabajo ." ORDER BY ID ASC;";
	$rs2 = $con->query($sql2);
	if(!$rs2){
		die($con->error);
	}
	while ($row2 = $rs2->fetch_array()){
		$sql3 = "SELECT * FROM personas_trabajos_libres WHERE ID_Personas =" . $row2["ID_participante"] . ";";
		$rs3 = $con->query($sql3);
			while ($row3 = $rs3->fetch_array()){
				$getIns = $con->query("SELECT * FROM instituciones WHERE ID_Instituciones='".$row3["Institucion"]."'");
				$rowIns = $getIns->fetch_array();
				
				//getPais
				$getPais = $con->query("SELECT * FROM paises WHERE ID_Paises='".$row3["Pais"]."'");
				$rowPais = $getPais->fetch_array();
				array_push($arrayInstituciones , $rowIns["Institucion"]);
				array_push($arrayPersonas, array($rowIns["Institucion"], $row3["Apellidos"], $row3["Nombre"], $rowPais["Pais"], $row3["Curriculum"], 			$row3["Mail"], $row2["lee"], $row3["inscripto"]));
			}
		}
		$imprimir .= "<span style='font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #000000;margin:0px'>";
		$arrayInstitucionesUnicas = array_unique($arrayInstituciones);
		$arrayInstitucionesUnicasNuevaClave = array();
		if(count($arrayInstitucionesUnicas)>0){
			foreach ($arrayInstitucionesUnicas as $u){
				if($u!=""){
					array_push($arrayInstitucionesUnicasNuevaClave, $u);
				}
			}
		}
		for ($i=0; $i < count($arrayPersonas); $i++){
			if($i>0){
				$imprimir .= "; ";
			}
			if($i==0){
				if($arrayPersonas[$i][3] != ""){
					$aster = "(*)";
				}
			}else{
				$aster = "";
			}
			if($arrayPersonas[$i][0]!=""){
				$claveIns = (array_search($arrayPersonas[$i][0] ,$arrayInstitucionesUnicasNuevaClave))+1;
			}else{
				$claveIns = "";
			}
			if ($arrayPersonas[$i][6]=="1"){
				$imprimir .= "<u>";
				$presentador = $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2];
				$presentadorAsunto = $presentador;
				$paisPresentador = $arrayPersonas[$i][3];
			}
			$imprimir .= $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2];
			if($primero){
				$PrimerAutor = $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2];
				$PrimerPais = $arrayPersonas[$i][3];
				$primero = false;
			}
			if ($arrayPersonas[$i][6]=="1"){
				$imprimir .= "</u>";
			}
			$imprimir .= "<sup> " . $claveIns . $aster  . "</sup>" ;
		}
	$imprimir .= "</span><br>";
	$divRegistrad=false;
	$primero = false;
	/*imprimo institucion y claves*/
	$imprimir .= "<span style='font-family: Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;margin:0px'>";
	if(count($arrayInstitucionesUnicasNuevaClave)>0){
		$clave = 1;
		foreach ($arrayInstitucionesUnicasNuevaClave as $ins){
			$imprimir .= "<i> $clave - $ins</i>";
			if ($primero == false ){
				if($arrayPersonas[0][3] != ""){
					$primero = true;
					$imprimir .= " | (*) " . $arrayPersonas[0][3];
				}
			}
			$clave = $clave + 1 ;
		}
	}
	if(count($arrayInstitucionesUnicasNuevaClave)==0){
		if($arrayPersonas[0][3] != ""){
			$imprimir .= "(*) " . $arrayPersonas[0][3];
		}
	}
	$imprimir .= "</span>";
	$autores = $imprimir;

	/* personas */

	/*MAIL*/	
		$cuerpoMail ='<br>
			  <table width="728" border="0" cellspacing="1" cellpadding="5" align="center" style="font-size:12px">
			    <tr>
			      <td><img src="'.$rutaBanner.'" style="width: 580px;"></td>
		        </tr>
			    <tr>
			      <td></td>
		        </tr>
			   <!-- <tr>
			      <td width="722">Su trabajo ha sido evaluado y ha merecido los siguientes comentarios los cuales tiene hasta 10 d&iacute;as para realizar los cambios:</td>
			      </tr>
			    <tr>
			      <td valign="top"><font size="3" face="Arial, Helvetica, sans-serif">'.$comentarios.'</font></td>
			      </tr>-->
			    </table>
			  <font size="3" face="Arial, Helvetica, sans-serif"><br>
</font>

<table width="850px" align="center" cellpadding="0px" cellspacing="0" bgcolor="#FBF6F0">
	<tr><td align="center"><br>
	<table width="800px" border="0" cellspacing="1" cellpadding="0" style="font:Geneva, Arial, Helvetica, sans-serif; font-size:13px; text-decoration:none">
		  <tr>
			<td bgcolor="#FFFFFF" align="center">
			<span class="letrasMenu">
			<br>
			<?=$congreso?><strong> - Presentaci&oacute;n de Trabajo Libre / Abstract Submission
			<br>
			Trabajo / Abstract N&ordm;: '.$fila->numero_tl.'</strong></span><br /><br />
			<table width="80%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td>Eje tem&aacute;tico / Topic: <strong>'.$trabajos->areaID($fila->area_tl)->Area.'</strong></td>
	    </tr>
	  <tr>
	    <td>Estado:<strong> '.$_POST["estado"].'</strong></td>
	    </tr>
	  <tr>
	    <td align="left" class="letrasMenu">&nbsp;</td>
	    </tr>
	  <tr>
	    <td align="center" class="letrasMenu"><br />
	     <strong> '.$fila->titulo_tl.'</strong></td>
	    </tr>
	  <tr>
		<td align="center">'.$autores.'</td>
	  </tr>
	  <tr>
	    <td align="justify"><div style="border-bottom:1px dashed; padding-bottom:10px; margin-bottom:10px">	<strong>Resumen</strong><br />
  '.$fila->resumen.'
  </div></td>
	    </tr>
	  
	  <tr>
	    <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td><br><br>Palabras claves / Keywords: <strong>'.$fila->palabrasClave.'</strong></td>
		  </tr>
        <tr>
	    <td>
		<hr>
		<br><br>Contacto / Contact
	      <br>
	      <br>
	      <table width="95%" border="0" cellspacing="1" cellpadding="4" style="font-size:12px">
	        <tr>
	          <td width="11%">E-mail</td>
	          <td width="48%"><strong>'.$fila->contacto_mail.'</strong></td>
	          <td width="10%">Pa&iacute;s</td>
	          <td width="31%"><strong>'.$trabajos->getPaisID($fila->contacto_pais).'</strong></td>
	          </tr>
	        <tr>
	          <td>Nombre / Name</td>
	          <td><strong>'.$fila->contacto_nombre.'</strong></td>
	          <td>Ciudad</td>
	          <td><strong>'.$fila->contacto_ciudad.'</strong></td>
	          </tr>
	        <tr>
	          <td>Apellido / Surname</td>
	          <td><strong>'.$fila->contacto_apellido.'</strong></td>
	          <td>Tel&eacute;fono</td>
	          <td><strong>'.$fila->contacto_telefono.'</strong></td>
	          </tr>
	        <tr>
	          <td>Instituci&oacute;n</td>
	          <td colspan="3"><strong>'.$fila->contacto_institucion.'</strong></td>
	          </tr>
	        <tr>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
	          </tr>
	        </table></td>
	    </tr>
		';
	$cuerpoMail .='
	        </table>
			<br />
			Estos son su c&oacute;digo y contrase&ntilde;a para verificar la condici&oacute;n de su resumen<br>
			These are your username and password to verify the status of your abstract<br>
			<br>
			<table width="50%" border="0" align="center" cellpadding="2" cellspacing="0"  style="font-size:12px; text-align:center">
			  <tr>
				<td width="50%">C&oacute;digo / Code: <strong>'.$fila->numero_tl.'</strong></td>
				  <td width="50%">Contrase&ntilde;a / Password: <strong>'.$fila->clave.'</strong></td>
			  </tr>
			  <tr>
				<td width="50%" colspan="2"><br><br>
					<a href="<?=$paginaAbstract?>"><?=$paginaAbstract?></a>
				</td>
			  </tr>
			 </table>
			<br>
			';

	 if($fila->archivo_tl!=""){
		$cuerpoMail .='
		 <center>
			<a href="<?=$paginaPrograma?>tl/'.$fila->archivo_tl.'" style="font-size:13px;"> Descargue aqu&iacute; su archivo para verificar que se ha subido correctamente.</a><br></center><center>
			</center>';
		 }
	
	$cuerpoMail .='</td>
		  </tr>
		</table>
	<br></td></tr>
	</table>';
		//$arrayMails_bck = array($fila->mailContacto_tl,"info@geo2013.com","geoplanners2013@gmail.com");
		//$arrayMails_bck = array($fila->contacto_mail);
		/*$arrayMails_bck = array($mail_congreso);
		foreach($arrayMails_bck as $cualMail){
			//	$mailOBJ->From    		= "info@geo2013.com";
				$mailOBJ->From    		= $mail_congreso;
				$mailOBJ->FromName 		= $congreso;
				$mailOBJ->Subject = utf8_decode("Trabajo evaluado [$fila->numero_tl] - [$fila->contacto_nombre $fila->contacto_apellido]");
				$mailOBJ->IsHTML(true);
				$mailOBJ->Body    = $cuerpoMail;
				$mailOBJ->Timeout=120;
				$mailOBJ->ClearAddresses();
				
				$mailOBJ->AddAddress($cualMail);
				if(!$mailOBJ->Send()){
					echo "<script>alert('Ocurrio un error al enviar el abstract');</script>";
				}
		}*/
	}
	/*MAIL RESPALDO*/

?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$congreso?> - Evaluaci&oacute;n de Trabajos</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
var c = <?=$clave?>;
var m = <?=$mail?>;
function continuar() {
	qs = "txtUsuario="+m+"&txtPassword="+c;
	document.location.href = "login02.php?"+qs;
}
</script>
</head>

<body>
<center>
<img src="<?=$rutaBanner?>" style="width: 580px;"><br>
<br>
<br>
<table width="582"  align="center" cellpadding="0px" cellspacing="0"  style="border:2px; border-color:#333333; border-style:solid">
  <tr><td>

    <table width="100%" cellpadding="20" cellspacing="0" bgcolor="#FFFFFF" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:center">
      <tr>
        <td >La evaluaci&oacute;n ha sido guardada con &eacute;xito.</td>
      </tr>
      <tr>
        <td >Contin&uacute;e evaluando haciendo <a href="personal.php" style="color:#993300; text-decoration:none">clic aqu&iacute;</a>
</td>
      </tr>
    </table>

</td></tr>
</table>
</center>
</body>
</html>