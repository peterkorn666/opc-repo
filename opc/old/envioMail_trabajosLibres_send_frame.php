<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

if(count($_SESSION["trabajo"])>0){
?>
<meta http-equiv="refresh" content="60">
<?
function guardaMilog($que){
	$gestor = fopen("envioMasivoTrabajos.txt", 'a');
	fwrite($gestor, $que . "\n");    
	fclose($gestor);
}
include('conexion.php');

require "clases/class.Cartas.php";
require ("clases/trabajosLibres.php");
$trabajos = new trabajosLibre;
$cartas = new cartas();


require "clases/class.smtp.php";
require "clases/class.phpmailer.php";
$mailOBJ = new phpmailer();

$a_quien_se_le_envio = "";
/*
echo $_SESSION["archivo"]["tmp_name"];

echo $_SESSION["archivo"]["name"];
*/




$imprimir = "";

function remplazar($cual){

	$valor = str_replace("\n", "<br>" , $cual);

	return  $valor;
}
function remplazarTitulo($cual) {
	
	$valor = str_replace("\n", " " , $cual);

	return  $valor;
}


$TL_rs = $trabajos->selectTL_ID($_SESSION["trabajo"][0],"mail");


$autorPrincipal = $trabajos->primer_autor($_SESSION["trabajo"][0]);

while ($row = $TL_rs->fetch_object()){

	$Remit_TL_cod = $row->numero_tl;

	$Remit_TL_titulo = $row->titulo_tl;

	$RemitMail = $row->contacto_mail;

	$RemitClave = $row->clave;
	
	$Casillero = $row->ID_casillero;

	$RemitMail_array = explode( ";", $RemitMail);	

	$RemitMail_array[] = $row->contacto_mail2;
	//require("inc/trabajoLibre.inc.php");


}
///////////ARMO LA CARTA
$sql = "SELECT * FROM trabajos_libres WHERE id_trabajo =".  $_SESSION["trabajo"][0] ;
$rs = $con->query($sql);
while($row= $rs->fetch_array()){
	
	//Comentarios evaluador
	$comentarios_evaluador = "";
	$k = 1;
	$sqlEv = $con->query("SELECT * FROM evaluaciones WHERE numero_tl='".$row["numero_tl"]."'");
	while ($rowEv = $sqlEv->fetch_array()) {
		if ($rowEv["comentarios"] != "") {
			if ($comentarios_evaluador != "") {
				$comentarios_evaluador = $comentarios_evaluador . "<br><br>Evaluador " . $k . ": <br>" . $rowEv["comentarios"];
				$k++;
			} else {
				$comentarios_evaluador = "<br>A continuación, transcribimos los comentarios de los evaluadores. Los mismos deberán ser tenidos en consideración al momento de presentar su trabajo en el congreso.<br><br>Evaluador 1: <br>" . $rowEv["comentarios"];
				$k++;
			}
		}
	}
	
	//Autores tl
	$autoresTL = "";
	$sqlIdParticipantes = $con->query("SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres='".$row["id_trabajo"]."'");
	while ($rowIdParticipantes = $sqlIdParticipantes->fetch_array()) {
		$sqlNombreParticipante = $con->query("SELECT * FROM personas_trabajos_libres WHERE ID_Personas='".$rowIdParticipantes["ID_participante"]."'");
		$rowNombreParticipante = $sqlNombreParticipante->fetch_array();
		if ($autoresTL == "") {
			$autoresTL = $rowNombreParticipante["Nombre"] . " " . $rowNombreParticipante["Apellidos"];
		}
		else {
			$autoresTL = $autoresTL . ", " . $rowNombreParticipante["Nombre"] . " " . $rowNombreParticipante["Apellidos"];
		}
	}
	
	
	$casilla = $row["id_crono"];
	$abr_tl = $row["abr_tl"];
	$numeracion = $row["numeracion"];
	$numero_de_trabajo = $row["numero_tl"];
	$numero_tl_viejo = $row["numero_tl_viejo"];
	$tipoTL = $row["tipo_tl"];
	$NombreContacto = $row["contacto_nombre"];               
    $ApellidoContacto = $row["contacto_apellido"];
	$paisContacto  = $row["contacto_pais"];
	$emailContacto = $row["contacto_mail"];
	$tema = $row["area_tl"];
	$cual_premio = $row["cual_premio"];
	$tituloTl = remplazarTitulo($row["titulo_tl"]);
	$titulo_tl_residente = remplazar($row["titulo_tl_residente"]);
	
	$id_trabajo = $row["id_trabajo"];
	$resumen = remplazar($row["resumen"]);
	$resumen_en = remplazar($row["resumen_en"]);
	$resumen2 = remplazar($row["resumen2"]);
	$resumen3 = remplazar($row["resumen3"]);
	$resumen4 = remplazar($row["resumen4"]);
	$resumen5 = remplazar($row["resumen5"]);
	$referencias_resumen = remplazar($row["referencias"]);
	
	$keywords = remplazar($row["palabrasClave"]);	
	$password = $row["clave"]; 
	$nombreArchivo = $row["archivo_trabajo_comleto"];
	$Hora_inicio_Trabajo = substr($row["Hora_inicio"],0,-3);
	$travel = $row["beca"];
	
	$cual_premio = $row["cual_premio"];
	$archivo_tl = $row["archivo_tl"];

/*$sqlDiaHora = "SELECT Dia, Sala, Hora_inicio, Titulo_de_actividad, Tipo_de_actividad FROM congreso WHERE Casillero = '" .$casilla ."' ";
$rsDiaHora = mysql_query($sqlDiaHora, $con);
while($rowDiaHora=mysql_fetch_array($rsDiaHora)){
	$dia = $rowDiaHora["Dia"];
	$sala = $rowDiaHora["Sala"];	
	$hora_inicio = substr($rowDiaHora["Hora_inicio"], 0, -3);
	$titulo = $rowDiaHora["Titulo_de_actividad"];
	$tipoAct = $rowDiaHora["Tipo_de_actividad"];
	
}*/



$arrayPersonas = array();
$arrayInstituciones = array();
$primero = true;
	  $sql2 ="SELECT ID_participante, lee FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " . $row["id_trabajo"] ." ORDER BY ID ASC;";
	  $rs2 = $con->query($sql2);
	  while ($row2 = $rs2->fetch_array()){

		$sql3 ="SELECT * FROM personas_trabajos_libres WHERE ID_Personas =" . $row2["ID_participante"] . ";";
		$rs3 = $con->query($sql3);
		while ($row3 = $rs3->fetch_array()){
			
			if(!empty($row3["Institucion"]))
			{
				$getInstitucion = $con->query("SELECT * FROM instituciones WHERE ID_Instituciones='".$row3["Institucion"]."'");
				if(!$getInstitucion){
					die($con->error);
				}
				$rowInstitucion = $getInstitucion->fetch_array();
			}

			array_push($arrayInstituciones , $rowInstitucion["Institucion"]);
			
			if(!empty($row3["Pais"]))
			{
				$getPais = $con->query("SELECT * FROM paises WHERE ID_Paises='".$row3["Pais"]."'");
				$rowPais = $getPais->fetch_array();
			}
			
			array_push($arrayPersonas, array($rowInstitucion["Institucion"], $row3["Apellidos"], $row3["Nombre"], $rowPais["Pais"], $row3["Curriculum"], $row3["Mail"], $row2["lee"], $row3["inscripto"]));
		}

	  }
$imprimir .= "<span style='font-family:Times New Roman, Times, serif; font-size: 12px;color: #000000;margin:0px'>";
	  $arrayInstitucionesUnicas = array_unique($arrayInstituciones);
	  $arrayInstitucionesUnicasNuevaClave = array();
	  if(count($arrayInstitucionesUnicas)>0){
		foreach ($arrayInstitucionesUnicas as $u){
			if($u!=""){
				array_push($arrayInstitucionesUnicasNuevaClave, $u);
			}
		}
	  }
	  $autoreInscriptos = "";
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
		
		if($arrayPersonas[$i][7]==1){
			$autoreInscriptos .= $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2] . "<br>";
		}
		
		if ($arrayPersonas[$i][6]=="1"){
			$imprimir .= "<u>";
			$presentador = $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2];
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
}	 
$imprimir .= "</span><br>";

$divRegistrad=false;
$primero = false;
	  /*imprimo institucion y claves*/
	  $imprimir .= "<span style='font-family:Times New Roman, Times, serif;font-size: 10px;color: #000000;margin:0px'>";
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
				//$imprimir .= "</span>";
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

if($_SESSION["chkMostrarUbicacion"]!="1"){
	$ubicacion = '';
}else{
	if($casilla!=0){
		setlocale(LC_TIME, 'es_ES');
		$ubicacion = "<br>";
		$ubicacion .= "<div style='font-family: Candara,Calibri,Segoe,Segoe UI,Optima,Arial,sans-serif; font-size: 16px;'>"; //div que engloba todo el ubicar
		$sqlU = $con->query("SELECT * FROM cronograma as c JOIN salas as s ON c.section_id=s.salaid JOIN trabajos_libres as t ON c.id_crono=t.id_crono WHERE c.id_crono='".$casilla."' ORDER BY c.start_date, s.orden");
		echo "SELECT * FROM cronograma as c JOIN salas as s ON c.section_id=s.salaid JOIN trabajos_libres as t ON c.id_crono=t.id_crono WHERE c.id_crono='".$casilla."' ORDER BY c.start_date, s.orden";
		
		$dia_sala_hora_escrita = false;
		$titulo_actividad_escrito = false;
		while($rowU = $sqlU->fetch_array()){
			if($dia_sala_hora_escrita === false){
				$ubicacion .= ucwords(utf8_encode(strftime("%A %d",strtotime(substr($rowU["start_date"],0,10))))).' | '.$rowU['name'].' | '.substr($rowU["start_date"],10,6).' - '.substr($rowU["end_date"],10,6)." ".$trabajos->getTipoActividad($rowU["tipo_actividad"])["tipo_actividad"];
				$dia_sala_hora_escrita = true;
			}
			$ubicacion .= "<div style='border-bottom:1px solid;margin-bottom:25px;font-family: Candara,Calibri,Segoe,Segoe UI,Optima,Arial,sans-serif;'></div>";
			
			if($titulo_actividad_escrito === false){
				$titulo_actividad_escrito = true;
				if($rowU["titulo_actividad"])
					$ubicacion .= $rowU["titulo_actividad"]."<br><br>";
			}
			
			$ubicacion .= "<div style='text-align:right; font-family: Candara,Calibri,Segoe,Segoe UI,Optima,Arial,sans-serif;'>";
				if($rowU["eje_transversal"])
					$ubicacion .= " | <i>".$rowU["eje_transversal"]."</i>";
				if($rowU["areas"])
					$ubicacion .= " | <i>".$rowU["areas"]."</i>";
				/*if($rowU["eje_tematico"])
					$ubicacion .= " | <i>".$rowU["eje_tematico"]."</i>";
				if($rowU["idioma"])
					$ubicacion .= " | <i>".$rowU["idioma"]."</i>";
				if($rowU["modalidad_presentacion"])
					$ubicacion .= " | <i>".$rowU["modalidad_presentacion"]."</i>";*/
			$ubicacion .= "</div>";
			
			$ubicacion .= "<strong style='font-family: Candara,Calibri,Segoe,Segoe UI,Optima,Arial,sans-serif;'>".$rowU["titulo_tl"]." &nbsp;&nbsp; (#".$rowU["numero_tl"].")</strong><br><br>";
			//Autores
			$ubicacion .= $trabajos->Autores($rowU["id_trabajo"])."<br><br>";
			//--Autores
			$ubicacion .= "<div style='text-align:justify; font-family: Candara,Calibri,Segoe,Segoe UI,Optima,Arial,sans-serif;'>";
				if($rowU["resumen"] != NULL){
					$ubicacion .= "<strong>Resumen:</strong><br>";
					$ubicacion .= $rowU["resumen"]."<br><br>";
				}
				if($rowU["resumen2"] != NULL){
					$ubicacion .= "<strong>Resumo:</strong><br>";
					$ubicacion .= $rowU["resumen2"]."<br><br>";
				}
			$ubicacion .= "</div>";
		}
		$ubicacion .= "</div>";//div que engloba todo el ubicar
	}
}

///$ubicacionTL = 'D&iacute;a: '.$dia.' <br>Hora: '.$hora_inicio.'<br> Sala: '.$sala;

if($_SESSION["chkMostrarTrabajo"]!="1"){
	$muestroPantalla = '';
}else{
	$muestroPantalla = '<center>
	<div style="padding:4px; width:900; background-color:#FFFFFF">
	  <center>
	  
		<div  style="width:90%;">
		  <div align="left"> 
		  <br>';
if(!empty($dia))
{	
/*$muestroPantalla .= '	  
	<table width="100%" border="0" cellspacing="2" cellpadding="1">
	  <tr>
		<td bgcolor="#FFFF66" align="center" style="padding:10px"><font size="4" face="Arial, Helvetica, sans-serif"><strong>D&iacute;a: '.$dia.'<br />
	Hora: '.$hora_inicio.'</strong><br />
	<strong>Sala: '.$sala.' </strong></font></td>
	  </tr>
	</table>';*/
}
$muestroPantalla .= '		  
		  <font size="4" face="Times New Roman, Times, serif">Trabajo N&ordm;: '.$numero_de_trabajo.'<br />';
if($Hora_inicio_Trabajo=="00:00"){
	  //$muestroPantalla .= 'Su presentaci&oacute;n dar&aacute; comienzo a las '.$hora_inicio.' horas.<br>';
}else{
	 // $muestroPantalla .='Su presentaci&oacute;n dar&aacute; comienzo a las '.$Hora_inicio_Trabajo.' horas.<br>';
}
/*
<em>
'.$tipoTL.'
</em>
<font size="3" face="Times New Roman, Times, serif"><em>
				 '.$trabajos->areaID($tema)->Area.'<br>
				    '.$cual_premio.'
				  </em><br>
				</font> 
*/
$muestroPantalla .= '</font> <br>
          </div>
		</div>
		<div  style="width:90%; padding:5px;"></div>
		<div style="width:90%; padding:5px;"> <font style="font-family: Times New Roman, Times, serif; font-size: 16px;font-weight: bold;">
		 '.$tituloTl.'
		  </font><br>
		  <br>
		  '.$autores.'
		  <br>
		  <br>
		  <div align="justify"> <font style="font-family: Times New Roman, Times, serif; font-size: 12px;"> 
				';
			/*if($resumen!=""){
				$muestroPantalla .= $resumen;
			}else{*/
				$rem = array("<br>","<br />","<br/>");
				$porrem = array("","","");
				if($resumen){
					$muestroPantalla .= '
						<div><strong>RESUMEN:</strong><br />
						'.str_replace($rem,$porrem,$resumen).'</div><br />';
					
					/*$muestroPantalla .= '
						<div><strong>OBJETIVO:</strong><br />
						'.str_replace($rem,$porrem,$resumen2).'</div><br />';
						
					$muestroPantalla .= '
						<div><strong>METODOLOGÍA O ESTRATEGIAS:</strong><br />
						'.str_replace($rem,$porrem,$resumen3).'</div><br />';
						
					$muestroPantalla .= '
						<div><strong>RESULTADOS:</strong><br />
						'.str_replace($rem,$porrem,$resumen4).'</div><br />';
						
					$muestroPantalla .= '
						<div><strong>CONCLUSIONES:</strong><br />
						'.str_replace($rem,$porrem,$resumen5).'</div><br />';*/
				}
					
				$rem = array("<br>","<br />","<br/>");
				$porrem = array("","","");
				/*$muestroPantalla .= '
					<div><strong>Abstract:</strong><br />
					'.str_replace($rem,$porrem,$resumen_en).'</div><br />';*/
			//}
			$muestroPantalla .='</font><br>
		  </div>
		<br />
			<!--Estos son su c&oacute;digo y contrase&ntilde;a para verificar la condici&oacute;n de su resumen<br>
			These are your username and password to verify the status of your abstract<br>-->
			<br>
			<table width="50%" border="0" align="center" cellpadding="2" cellspacing="0"  style="font-size:12px; text-align:center">
			  <!--<tr>
				<td width="50%">C&oacute;digo / Code: <strong><br />'.$numero_de_trabajo.'</strong></td>
				  <td width="50%">Contrase&ntilde;a / Password: <strong><br />'.$password.'</strong></td>
			  </tr>
			  <tr>
				<td colspan="2"><a href="'.$paginaAbstract.'">Ir al formulario de abstract</a></td>
			  </tr>-->';
			  if($archivo_tl){
				$muestroPantalla .='
				<tr>
				<td colspan="2">&nbsp;</td>
			  </tr>';
			  	if(file_exists("../tlc/".$archivo_tl)){
					$muestroPantalla .='
					  <tr>
						<td colspan="2"><a href="http://opc.clatpu2016.congresoselis.info/tlc/'.$archivo_tl.'">Descargue aqu&iacute; su archivo</a></td>
					  </tr>';
				}
			  }
$muestroPantalla .='
		  </table>
		</div>
	  </center>
	<br>
	</div> 
	</center><br />';
	
}
$muestroPantalla .= $ubicacion;
////////////////CONFIGURACION///////////////////
include "envioMail_Config.php";
$asunto = $_SESSION["asunto0"] ." [$Remit_TL_cod][$PrimerAutor] "  . $_SESSION["asunto1"];
//////////////////////////////////////////////

/*
<br>
	<div style="width:65%; padding:5px; border:2px #000000 solid;background-color:#CFDEE7 ">
  <table width="80%" border="0" align="center" cellpadding="2" cellspacing="0"  style="font-size:14px;">
    <tr>
      <td><div align="center"  style="font-family: Times New Roman, Times, serif; font-size: 12px;">Código:<strong>'.$numero_de_trabajo.'</strong></div></td>
      <td><div align="center"  style="font-family: Times New Roman, Times, serif; font-size: 12px;">Contrase&ntilde;a: <strong>'.$password.'</strong></div></td>
    </tr>
  </table>
  <a href="http://amlar2008.congresoselis.info/programa/abstract/"  style="font-family: Times New Roman, Times, serif; font-size: 12px; font-weight:bold"> Haga click aquí para ingresar su trabajo extendido</a> </div>
$cuerpoMail = $_SESSION["carta"];

$cuerpoMail .= "<br><br>" . $imprimir;*/


if ( ($_SESSION["rbCarta"]=="Manual") || ($_SESSION["rbCarta"]=="") ) {
	$cartaMail = $_SESSION["carta"].'<br>';
} else {
	$rs = $cartas->cargarUna($_SESSION["rbCarta"]);
	if ($predefinida = $rs->fetch_array()){
		$cartaMail = $predefinida["cuerpo"];
		$cartaMail = $cartas->personificarPorPersonaTL($cartaMail, $_SESSION["trabajo"][0]);
		$cartaMail = str_replace("<:fecha>", $fechaParaCarta , $cartaMail);
	}
}


	$cartaUsu = '<font size="3" face="Candara, Arial, Helvetica, sans-serif">'. remplazar($cartaMail) .'</font><br /><center>---------------------------------------------------------</center>';
/*if(trim($_SESSION["carta"])!=""){
	$cartaUsu = '<font size="2" face="Arial, Helvetica, sans-serif">'. remplazar($_SESSION["carta"]) .'</font><br /><center>---------------------------------------------------------</center>';
}else{
	$cartaUsu = ' ';
}*/
$imagen_costos_inscripcion = "<img src='".$paginaINFOlink."imagenes/tabla_costos_inscripcion.png' width='750'>";

$cuerpoMail = str_replace("<:dirBanner>", $dirBanner , $cartaEstandarTrabajos);
$cuerpoMail = str_replace("<:congreso>", $congreso , $cuerpoMail);
$cuerpoMail = str_replace("<:cuerpo>", $cartaUsu , $cuerpoMail);
$cuerpoMail = str_replace("<:ubicacion>", $ubicacionTL , $cuerpoMail);
$cuerpoMail = str_replace("<:pantalla>", $muestroPantalla , $cuerpoMail);
$cuerpoMail = str_replace("<:numero_tl>", $numero_de_trabajo , $cuerpoMail);
$cuerpoMail = str_replace("<:clave>", $password , $cuerpoMail);
$cuerpoMail = str_replace("<:nombreContacto>", $NombreContacto , $cuerpoMail);
$cuerpoMail = str_replace("<:apellidoContacto>", $ApellidoContacto , $cuerpoMail);
$cuerpoMail = str_replace("<:mailContacto>", $emailContacto , $cuerpoMail);
$cuerpoMail = str_replace("<:titulo_tl>", $tituloTl , $cuerpoMail);
$cuerpoMail = str_replace("<:autores_tl>", $autoresTL , $cuerpoMail);
$cuerpoMail = str_replace("<:tipo_tl>", $tipoTL , $cuerpoMail);
$cuerpoMail = str_replace("<:titulo_tl_residente>", $titulo_tl_residente , $cuerpoMail);
$cuerpoMail = str_replace("<:comentarios_evaluador>", $comentarios_evaluador , $cuerpoMail);
$cuerpoMail = str_replace("<:link_trabajo_completo>", "<a href='http://cau2014.personasuy.info/programa/tl/$archivo_tl'>Descargue aquí el TRABAJO COMPLETO para su evaluaci&oacute;n.</a>", $cuerpoMail);
$link_programa_completo = "<a href='".$paginaINFOlink."'>aquí</a>";
$cuerpoMail = str_replace("<:link_programa_completo>", $link_programa_completo, $cuerpoMail);
$link_editar_trabajo = "<a href='".$paginaAbstract."login.php?id=".base64_encode($id_trabajo)."'>aquí</a>";
$cuerpoMail = str_replace("<:link_editar_trabajo_aqui>", $link_editar_trabajo, $cuerpoMail);
$cuerpoMail = str_replace("<:imagen_costos_inscripcion>", $imagen_costos_inscripcion, $cuerpoMail);

$cuerpoMail = str_replace("<:nombre_premio>", $cual_premio , $cuerpoMail);
if($cual_premio!=""){	
	if($cual_premio=="Premio Profesor Dr. Antonio Puigvert para el mejor trabajo de investigacion urologica (basica o clinica)"){
		$cuerpoMail = str_replace("<:cantidad_premio>", "2 mejores" , $cuerpoMail);
	}else{
		$cuerpoMail = str_replace("<:cantidad_premio>", "3 mejores" , $cuerpoMail);
	}
}
//
//

$mailOBJ->IsSMTP();
$mailOBJ->SMTPDebug  = 2;
$mailOBJ->SMTPAuth   = true;
$mailOBJ->SMTPAutoTLS = false;

$sqlDatosMail = "SELECT email_host, email_username, email_password FROM config WHERE id=1";
$rsDatosMail = $con->query($sqlDatosMail);
while($rowDatosMail = $rsDatosMail->fetch_array()){
	$email_host = $rowDatosMail['email_host'];
	$email_username = $rowDatosMail['email_username'];
	$email_password = $rowDatosMail['email_password'];
}

$mailOBJ->Host       = $email_host;
$mailOBJ->Username   = $email_username;
$mailOBJ->Password   = $email_password;
 
$mailOBJ->Port= 25;
$mailOBJ->From= $email_username;
//$mailOBJ->FromName= "CONFERENCIA ARROZ 2018";
$mailOBJ->addReplyTo($mail_congreso, "Contacto - ".$congreso);


//$mailOBJ->From    		= $mail_congreso;
$mailOBJ->FromName 		= $congreso;
$mailOBJ->Subject 		= $asunto;
$mailOBJ->IsHTML(true);

$mailOBJ->Timeout=120;
$mailOBJ->ClearAttachments();
$mailOBJ->ClearAddresses();
$mailOBJ->ClearBCCs();
$mailOBJ->CharSet = "utf8";
/*if($tieneBanner==true){
	$mailOBJ->AddEmbeddedImage("arhivosMails/banner_mail.jpg",'banner');
}*/
//$mailOBJ->AddAttachment("arhivosMails/" . $_SESSION["arhchivoNombre"], $_SESSION["arhchivoNombre"]);
//$mailOBJ->AddAttachment("abstract/reglamento.pdf","Bases y Convocatorias.pdf");

if($_SESSION['archivoNombre'] !== NULL && $_SESSION['archivoNombre'] !== ""){
	$mailOBJ->AddAttachment("../archivos_mails/".$_SESSION['archivoNombre'], $_SESSION["archivoNombre"]);
}

//$mailOBJ->AddAttachment("../archivos_mails/Formulario-Autorización-publicaciones.doc", "Formulario-Autorización-publicaciones.doc");

$mailOBJ->Body  = $cuerpoMail;
//$mailOBJ->Body  = '<font size="1" color="#B2B2B2">cartaoralproblema</font>'.$cuerpoMail;


if($_SESSION["A_otro"]==1){

	$mailAotro_array = explode( ";", $_SESSION["mailAotro"]);

	foreach($mailAotro_array as $u){

		$a_quien_se_le_envio .=  "[<a href=\'mailto:$u\'>$u</a>]";
		$a_quien_se_le_envio_PARA_LOG .=  "[$u]";
		$mailOBJ->AddBCC(trim($u));

	}

}

if($_SESSION["A_contacto"]==1){

	$RemitMail_array = array_unique($RemitMail_array);

	foreach($RemitMail_array as $i){

		$a_quien_se_le_envio .= "[<a href=\'mailto:$i\'>$i</a>]";
		$a_quien_se_le_envio_PARA_LOG .=  "[$i]";
		$mailOBJ->AddAddress(trim($i));

	}

}

//$mailOBJ->AddBCC("guatemalafiap@gmail.com");

if($_SESSION["INSTRUCCIONES"]==1){
	$mailOBJ->AddAttachment("../adjuntos/instrucciones_generales.pdf","Instrucciones Generales.pdf");
}
if($_SESSION["TALLERES"]==1){	
	$mailOBJ->AddAttachment("../adjuntos/instrucciones_talleres.pdf","Instrucciones Talleres.pdf");
}

if($_SESSION["DIAPOSITIVA"]==1){
	$mailOBJ->AddAttachment("../adjuntos/formato_diapositivas.pptx","Formato Diapositivas.pptx");
}

if($_SESSION["HOTEL_IMG"]==1){
	$mailOBJ->AddAttachment("../adjuntos/hotel_img.jpg","Hotel.jpg");
}

if(!$mailOBJ->Send()){

	echo "Ocurrio un error";

}else{

	$_SESSION["numero_de_envio"] = $_SESSION["numero_de_envio"] + 1;

	$numero_de_envio = $_SESSION["numero_de_envio"];

	$total_de_envio = $_SESSION["total_de_envio"];
	date_default_timezone_set('America/Montevideo');
		//**GUARDO EN LOG**/////
			$fecha = date("d/m/Y H:i");
			guardaMilog("[Trabajos][".$fecha."] - [".$numero_de_envio." de ".$total_de_envio."] Se ha enviado el mail del trabajo $Remit_TL_cod a: ".$a_quien_se_le_envio_PARA_LOG);
			///////////
			$sql ="SELECT * FROM trabajos_libres WHERE numero_tl = '".$Remit_TL_cod."';";
			$que = "[$asunto] [Trabajos][".$fecha."] - [".$numero_de_envio." de ".$total_de_envio."] ".$a_quien_se_le_envio_PARA_LOG;
			$rs = $con->query($sql);
			if($row = $rs->fetch_array()){
				$update = "UPDATE trabajos_libres SET cartasEnviadas = '".$row["cartasEnviadas"]."<br />".$que."' WHERE numero_tl = '".$Remit_TL_cod."';";
				$rs = $con->query($update);
			}
			
	echo "<script>\n";
	echo "parent.document.getElementById('divEnvios').innerHTML += '[$numero_de_envio de $total_de_envio] Se ha enviado el mail del trabajo <b>$Remit_TL_cod </b>a: $a_quien_se_le_envio<br>'\n;";
	echo "</script>\n";

	array_shift ($_SESSION["trabajo"]);
	}
	
	if(count($_SESSION["trabajo"])==0){
		echo "<script>\n";
			echo "parent.document.getElementById('divEnvios').innerHTML += '<center><br><font size=\'4\'>------------- El envio a finalizado correctamente -------------</font><br /><br /><a href=\'envioMail_trabajosLibres.php\'>[ Volver al envio de e-mail  de trabajos ]</a></center>';\n";
			
		echo "</script>\n";
		
		$_SESSION["finalizo"]=1;
		guardaMilog("[FIN][".$fecha."]");
	}else{
		
		echo "<script>\n";
		echo "setTimeout(function(){document.location.href = 'envioMail_trabajosLibres_send_frame.php'\n;},10000)";
		echo "</script>\n";
		
	}
		
		
}
?>
