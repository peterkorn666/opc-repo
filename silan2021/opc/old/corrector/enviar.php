<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

function guardaMilog($que){
	$gestor = fopen("milog.txt", 'a');
	fwrite($gestor, $que . "\n");    
	fclose($gestor);
}
$nombreArchivo = $_FILES['archivo_TL']['name'];


//Contacto
$emailContacto = $_SESSION["emailContacto"];
$NombreContacto = $_SESSION["NombreContacto"];
$ApellidoContacto = $_SESSION["ApellidoContacto"];
$InstContacto = $_SESSION["InstContacto"];
$paisContacto = $_SESSION["paisContacto"];
$ciudadContacto = $_SESSION["ciudadContacto"];
$telContacto = $_SESSION["telContacto"];
$agraContacto = $_SESSION["agraContacto"];


$idiomaTL = $_SESSION["idiomaTL"];
$tipoTL = $_SESSION["tipoTL"];
$tituloTl = remplazar($_SESSION["titulo"]);
$resumen = remplazar($_SESSION["resumen"]);
$tema = $_SESSION["tema"];
$keywords = $_SESSION["keywords"];

//arrays
$array_id = 		    $_SESSION["id_persona"];
$array_nombre = 		$_SESSION["nombre"];
$array_apellido = 		$_SESSION["apellido"];
$array_institucion =	$_SESSION["institucion"];
$array_mail =		 	$_SESSION["mail"];
$array_pais = 			$_SESSION["pais"];
$array_lee = 			$_SESSION["lee"];
$array_inscripto = 		$_SESSION["inscripto"];
$array_ciudad = 		$_SESSION["ciudad"];
$array_agradecimientos = $_SESSION["agradecimientos"];

?>
<script language="javascript" type="text/javascript">
function bajarTL(cual){
	document.location.href= "../bajando_tl.php?id=" + cual;
}
</script>
<style type="text/css">
a{
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:12px;
font-weight:bold;
text-decoration:none;
color:#006600;
}
a:hover{
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:12px;
font-weight:bold;
text-decoration:none;
color:#009900;
}
</style>
<?
include "inc.gestionAutores.php";

/*if(($gestionAutores == "<br><i></i>")||($gestionAutores == "")){
	?>
	<script>document.location.href='index.php?error=2';</script>
	<?	
exit;
}*/
require('inc.config.php');
include "../conexion.php";
require "../clases/class.phpmailer.php";
require "clases/class.archivo.php";


$mailOBJ = new phpmailer();

function remplazarNomArchivo($donde){
	$valor = str_replace(" ", "_" , $donde);
	$valor = str_replace(".", "_" , $valor);
	$valor = str_replace(",", "_" , $valor);
	$valor = str_replace("á", "a" , $valor);
	$valor = str_replace("é", "e" , $valor);
	$valor = str_replace("í", "i" , $valor);
	$valor = str_replace("ó", "o" , $valor);
	$valor = str_replace("ú", "u" , $valor);
	$valor = str_replace("´", "" , $valor);
	$valor = str_replace(" ", "_" , $valor);
	return $valor;
}
function remplazar($donde){

	$valor = str_replace("<p>", "" , $donde);
	$valor = str_replace("</p>", "" , $valor);

	$valor = str_replace("<u>", "" , $valor);
	$valor = str_replace("</u>", "" , $valor);
	
	$valor = str_replace("<br><br>", "<br>" , $valor);
	$valor = str_replace("<br /><br />", "<br>" , $valor);

	$valor = str_replace("<strong>", "" , $valor);
	$valor = str_replace("</strong>", "" , $valor);
	
	$valor = str_replace("<h1>", "" , $valor);
	$valor = str_replace("</h1>", "" , $valor);	
	
	$valor = str_replace("<h2>", "" , $valor);
	$valor = str_replace("</h2>", "" , $valor);
		
	$valor = str_replace("<h3>", "" , $valor);
	$valor = str_replace("</h3>", "" , $valor);

	$valor = str_replace("<span>", "" , $valor);
	$valor = str_replace("</span>", "" , $valor);
	
	$valor = str_replace("'", "´" , $valor);
	$valor = str_replace("\'", "´" , $valor);
	$valor = str_replace("\\'", "´" , $valor);
	$valor = str_replace("\\\'", "´" , $valor);
	$valor = str_replace("\\\\'", "´" , $valor);
	$valor = str_replace("\\\\\'", "´" , $valor);
	$valor = str_replace("\\\\\\'", "´" , $valor);
		
	$valor = str_replace("\´", "´" , $valor);	

	$valor = str_replace('<p class=\"MsoNormal\">', "" , $valor);	
	$valor = str_replace('<p class=\\"MsoNormal\\">', "" , $valor);
	$valor = str_replace('<p class=\\\"MsoNormal\\\">', "" , $valor);
	$valor = str_replace('<p class="""MsoNormal""">', "" , $valor);	
	$valor = str_replace('<p class="MsoBodyText2">', "" , $valor);	
	$valor = str_replace('<p class="MsoNormal">', "" , $valor);	
	$valor = str_replace('<p align="center" class="MsoNormal">', "" , $valor);	
	
	$valor = str_replace('<span class=\"MsoNormal\">', "" , $valor);	
	$valor = str_replace('<span class=\\"MsoNormal\\">', "" , $valor);
	$valor = str_replace('<span class=\\\"MsoNormal\\\">', "" , $valor);
	$valor = str_replace('<span class="""MsoNormal""">', "" , $valor);	
	$valor = str_replace('<span class="MsoBodyText2">', "" , $valor);	
	$valor = str_replace('<span class="MsoNormal">', "" , $valor);	
	$valor = str_replace('<span align="center" class="MsoNormal">', "" , $valor);	
	$valor = addslashes($valor);

	return $valor;

}
function normalizarString($str){

	$nuevoStr = str_replace(".", "_", $str);
	$nuevoStr = str_replace(" ", "_", $nuevoStr);
	
	$nuevoStr = str_replace("á", "a", $nuevoStr);
	$nuevoStr = str_replace("Á", "A", $nuevoStr);
	$nuevoStr = str_replace("à", "a", $nuevoStr);
	$nuevoStr = str_replace("À", "A", $nuevoStr);
	$nuevoStr = str_replace("â", "a", $nuevoStr);
	$nuevoStr = str_replace("Â", "A", $nuevoStr);
	
	$nuevoStr = str_replace("É", "E", $nuevoStr);
	$nuevoStr = str_replace("é", "e", $nuevoStr);
	$nuevoStr = str_replace("È", "E", $nuevoStr);
	$nuevoStr = str_replace("è", "e", $nuevoStr);
	$nuevoStr = str_replace("Ê", "E", $nuevoStr);
	$nuevoStr = str_replace("ê", "e", $nuevoStr);
	
	$nuevoStr = str_replace("ì", "i", $nuevoStr);
	$nuevoStr = str_replace("Í", "I", $nuevoStr);
	$nuevoStr = str_replace("í", "i", $nuevoStr);
	$nuevoStr = str_replace("Ì", "I", $nuevoStr);
	$nuevoStr = str_replace("î", "i", $nuevoStr);
	$nuevoStr = str_replace("Î", "I", $nuevoStr);
	
	$nuevoStr = str_replace("ó", "o", $nuevoStr);
	$nuevoStr = str_replace("Ó", "O", $nuevoStr);
	$nuevoStr = str_replace("ò", "o", $nuevoStr);
	$nuevoStr = str_replace("Ò", "O", $nuevoStr);
	$nuevoStr = str_replace("ô", "o", $nuevoStr);
	$nuevoStr = str_replace("Ô", "O", $nuevoStr);
	
	$nuevoStr = str_replace("ú", "u", $nuevoStr);
	$nuevoStr = str_replace("Ú", "U", $nuevoStr);
	$nuevoStr = str_replace("ù", "u", $nuevoStr);
	$nuevoStr = str_replace("Ù", "U", $nuevoStr);
	$nuevoStr = str_replace("ü", "u", $nuevoStr);
	$nuevoStr = str_replace("Ü", "U", $nuevoStr);
	
	$nuevoStr = str_replace("ñ", "n", $nuevoStr);

	$nuevoStr = str_replace("ç", "c", $nuevoStr);
	$nuevoStr = str_replace("Ç", "C", $nuevoStr);
	$nuevoStr = str_replace("ã", "a", $nuevoStr);
	$nuevoStr = str_replace("Ã", "A", $nuevoStr);
	$nuevoStr = str_replace("õ", "o", $nuevoStr);

	$nuevoStr = str_replace("/", "_", $nuevoStr);
	$nuevoStr = str_replace("|", "_", $nuevoStr);
	$nuevoStr = str_replace(":", "_", $nuevoStr);
	$nuevoStr = str_replace("*", "_", $nuevoStr);
	$nuevoStr = str_replace("<", "_", $nuevoStr);
	$nuevoStr = str_replace(">", "_", $nuevoStr);
	$nuevoStr = str_replace("\"", "_", $nuevoStr);

	$nuevoStr = str_replace("`", "_", $nuevoStr);
	$nuevoStr = str_replace("´", "_", $nuevoStr);

	return $nuevoStr;
}

/*
print_r($array_nombre);
echo "<br>";
print_r($array_apellido);
echo "<br>";
*/
if($_SESSION["nombre"] == ""){
	?>
	<script>document.location.href='index.php?error=2';</script>
	<?	
exit;
}

$upadateUsu = date("d/m/Y"). " - " . $_SERVER['REMOTE_ADDR'];
$ses = date("dmhis"). session_id();

/////SI EL TRABAJO VIENE DE MODIFICAR YA TENGO EL NUMERO SINO LE ASIGNO UNO
if($_SESSION["numero"]!=""){

	$numero_de_trabajo = $_SESSION["numero"];

}else{

	$sqlNUM="SELECT MAX(numero_tl) FROM trabajos_libres LIMIT 1";
	$rsNUM = mysql_query($sqlNUM, $con);
	while($row=mysql_fetch_array($rsNUM)){
		$numero_de_trabajo = intval($row[0]) + 1;
	}
	if($numero_de_trabajo<=9){
		$numero_de_trabajo = "00" . $numero_de_trabajo;
	}
	elseif($numero_de_trabajo<=99){
		$numero_de_trabajo = "0" . $numero_de_trabajo;
	}
	else{
		$numero_de_trabajo = $numero_de_trabajo;
	}
}

/*guardaMilog("ARRANCA/////////////");


///*******/////
/*
$extensionArchivoArray = explode ("." , $nombreArchivo);
$extensionArchivo = array_pop($extensionArchivoArray);
$extensionArchivo = substr($nombreArchivo, -3, 3); 
$nombreArc = $numero_de_trabajo . "_" . $array_apellido[0] . "_" . $array_nombre[0] . ".$extensionArchivo";
$nombreArc = remplazarNomArchivo($nombreArc);
if($extensionArchivo==""){$extensionArchivo = "doc";}
$nombreArchivo = $nombreArc . ".$extensionArchivo";

/* SUBIR ARCHIVO ********************/
//SI NO ES NECESARIO SUBIR ARCHIVO HABILITAR ESTO 
/*$puede_ingresar=true;
if(trim($_FILES["archivo_TL"]["tmp_name"])!=""){	

	$array_extension = explode(".", trim($_FILES["archivo_TL"]["name"]));
	
	$extension = array_pop($array_extension);
	
	$archivo = new archivo();
	
	$nombreArchivo = $numero_de_trabajo . "_" . normalizarString($array_apellido[0] . "_" . $array_nombre[0] ). "." . $extension;
	
	$puede_ingresar = $archivo->subirArchivo($nombreArchivo, trim($_FILES["archivo_TL"]["tmp_name"]));
	
}else{
	if($_SESSION["archivo_trabajo_comleto"]!=""){
		$nombreArchivo =  $_SESSION["archivo_trabajo_comleto"];
		$puede_ingresar=true;
	}
}
/*
if($nombreArchivo == ""){
	?>
	<script>document.location.href='index.php?error=3';</script>
	<?	
exit;
}*/

//$puede_ingresar=true;
/*if($_FILES["archivo_TL"]["tmp_name"]!=""){	
	if(!copy($_FILES["archivo_TL"]["tmp_name"], "../tl/$nombreArchivo")){
		guardaMilog("Archivo: " . $_FILES["archivo_TL"]["tmp_name"] );
		guardaMilog("Archivo:$nombreArchivo " . $nombreArchivo );
		//$puede_ingresar=false;		
	}
	if($puede_ingresar){
	//ELIMINO EL ARCHIVO ARRIBA SI INGRESA OTRO	
	if($_SESSION["archivo_trabajo_comleto"]!=""){
		if($nombreArchivo!=$_SESSION["archivo_trabajo_comleto"]){
			//unlink("../programa/tl/" . $_SESSION["archivo_trabajo_comleto"]);
			guardaMilog("Borrado "  . $_SESSION["archivo_trabajo_comleto"] );
		}
	}
	/////
	}
}else{
	if($_SESSION["archivo_trabajo_comleto"]!=""){
		$nombreArchivo =  $_SESSION["archivo_trabajo_comleto"];
	}
}
guardaMilog("Archivo FINAL: " . $nombreArchivo );*/
guardaMilog("ARRANCA/////////////");


///*******/////
/*
$extensionArchivoArray = explode ("." , $nombreArchivo);
$extensionArchivo = array_pop($extensionArchivoArray);
$extensionArchivo = substr($nombreArchivo, -3, 3); 
$nombreArc = $numero_de_trabajo . "_" . $array_apellido[0] . "_" . $array_nombre[0] . ".$extensionArchivo";
$nombreArc = remplazarNomArchivo($nombreArc);
if($extensionArchivo==""){$extensionArchivo = "doc";}
$nombreArchivo = $nombreArc . ".$extensionArchivo";
*/
/* SUBIR ARCHIVO ********************/
//SI NO ES NECESARIO SUBIR ARCHIVO HABILITAR ESTO 
$puede_ingresar=true;
if(trim($_FILES["archivo_TL"]["tmp_name"])!=""){	

	$array_extension = explode(".", trim($_FILES["archivo_TL"]["name"]));
	
	$extension = array_pop($array_extension);
	
	$archivo = new archivo();
	
	$nombreArchivo = $numero_de_trabajo . "_" . normalizarString($array_apellido[0] . "_" . $array_nombre[0] ). "." . $extension;
	
	$puede_ingresar = $archivo->subirArchivo($nombreArchivo, trim($_FILES["archivo_TL"]["tmp_name"]));
	
}else{
	if($_SESSION["archivo_trabajo_comleto"]!=""){
		$nombreArchivo =  $_SESSION["archivo_trabajo_comleto"];
		$puede_ingresar=true;
	}
}

/*if($nombreArchivo == ""){
	?>
	<script>document.location.href='index.php?error=3';</script>
	<?	
exit;
}*/


//$puede_ingresar=true;
if($_FILES["archivo_TL"]["tmp_name"]!=""){	
	if(!copy($_FILES["archivo_TL"]["tmp_name"], "../tl/$nombreArchivo")){
		guardaMilog("Archivo: " . $_FILES["archivo_TL"]["tmp_name"] );
		guardaMilog("Archivo:$nombreArchivo " . $nombreArchivo );
		//$puede_ingresar=false;		
	}
	if($puede_ingresar){
	//ELIMINO EL ARCHIVO ARRIBA SI INGRESA OTRO	
	if($_SESSION["archivo_trabajo_comleto"]!=""){
		if($nombreArchivo!=$_SESSION["archivo_trabajo_comleto"]){
			unlink("../tl/" . $_SESSION["archivo_trabajo_comleto"]);
			guardaMilog("Borrado "  . $_SESSION["archivo_trabajo_comleto"] );
		}
	}
	/////
	}
}else{
	if($_SESSION["archivo_trabajo_comleto"]!=""){
		$nombreArchivo =  $_SESSION["archivo_trabajo_comleto"];
	}
}
guardaMilog("Archivo FINAL: " . $nombreArchivo );

//////METO AREAS
$ingresarAre = true;
$sql123 = "SELECT * FROM areas_trabjos_libres  WHERE Area = '".$tema."' ";
$rs123 = mysql_query($sql123, $con);
while($row = mysql_fetch_array($rs123)){
	$ingresarAre = false;
}
if($ingresarAre){
	$sqlIns = "INSERT INTO areas_trabjos_libres (Area)  VALUES('".$tema."')";
	mysql_query($sqlIns, $con);
}
////////
//SI MANDO UN ARCHIVO Y NO LO PUDO SUBIR NO INGRESA NADA, TIRA PARA ATRAS

if($puede_ingresar==false){
echo '<body bgcolor="'.$colorFondo.'">
<br />
<center><div align="center" style="background-color:#FFFFFF; width:85%;border:4px solid #000000">
 <br />
    <center><h3><center><br /><br />Ocurrio un error cuando se subia el archivo.<br /> Puede que su archivo supere el tamaño permitido.</center></h3><br /><br><a href="index.php">Volver a intentarlo</a></center>
    <br />
  
</div></center>';
exit;
}
///SI PUDO SUBIR EL ARCHIVO INGRESO EL TRABAJO
if($puede_ingresar){
	if($_SESSION["ID_TL"]!=""){

		$sql = "UPDATE trabajos_libres SET
				
				titulo_tl = '$tituloTl', 
				
				area_tl = '$tema',
				tipo_tl = '$tipoTL',
				resumen = '$resumen',
				archivo_trabajo_comleto = '$nombreArchivo',
				archivo_tl = '$nombreArchivo',
				palabrasClave = '$keywords',
				nombreContacto = '$NombreContacto',
				apellidoContacto = '$ApellidoContacto',
				telefono = '$telContacto',
				agraContacto = '$agraContacto',
				institucionContacto = '$InstContacto',
				paisContacto = '$paisContacto',
				ciudadContacto = '$ciudadContacto',
				agraContacto = '$agraContacto',
				idioma = '$idiomaTL',
				mailContacto_tl = '$emailContacto', 				
				session = '$ses', 				
				ultima_actualizacion = '$upadateUsu' 
				
				WHERE ID='" . $_SESSION["ID_TL"] . "';";
				
		mysql_query($sql,$con);
		//
		
		$_SESSION["password"] = $_SESSION["clave"];
		guardaMilog($sql);
		$ultimo_ingresado = $_SESSION["ID_TL"];	
			
	}else{

		$pattern = "123456789123456789abcdefghijklmnopqrstuvwxyz";
		for($i=0;$i<5;$i++)
		{
		 $pass .= $pattern{rand(0,35)};
		}
		$_SESSION["password"] = $pass;
		$sql = "Insert into trabajos_libres (titulo_tl, area_tl, tipo_tl,  session, resumen, archivo_trabajo_comleto, archivo_tl , palabrasClave ,clave, idioma, 
	
			 mailContacto_tl,
			 nombreContacto,
			 apellidoContacto,
			 telefono,
			 institucionContacto,
			 paisContacto,
			 ciudadContacto,
			 agraContacto,
			 ultima_actualizacion) values ('$tituloTl','$tema', '$tipoTL', '".session_id()."',  '$resumen', '$nombreArchivo', '$nombreArchivo', '$keywords', '$pass', '$idiomaTL', 
	
				'$emailContacto',
				'$NombreContacto',
				'$ApellidoContacto',
				'$telContacto',
				'$InstContacto',
				'$paisContacto',
				'$ciudadContacto',
				'$agraContacto',			
				'$upadateUsu'
				);";
		mysql_query($sql,$con);
		//
		guardaMilog($sql);
		$ultimo_ingresado = mysql_insert_id();
		
		$sql11221 = "UPDATE trabajos_libres SET numero_tl= '" .$numero_de_trabajo."' WHERE ID = '".$ultimo_ingresado ."';";
		mysql_query($sql11221, $con);
		guardaMilog($sql11221);
	}
$u = 0;

if($_SESSION["ID_TL"]!=""){
	//elimino todos los Id de participantes que ya no estan en el terabajo
	$sql = "SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres='" . $_SESSION["ID_TL"] . "';";
	$rs = mysql_query($sql, $con);
	guardaMilog($sql);
	while ($row = mysql_fetch_array($rs)){
	
		if(!in_array ($row["ID_participante"], $array_id)){	
			$sql0 = "DELETE FROM trabajos_libres_participantes WHERE ID='" . $row["ID"] . "';";	
			guardaMilog($sql0);
			mysql_query($sql0,$con);	
		}	
	}
}
/////////////////////////////////////////////////////////////////////
foreach($array_nombre as $i){
	if($array_lee == ($u+1)){
		$leeOno = 1;
	}else{
		$leeOno = 0;
	}
		

		//////METO INST
		$ingresarInst = true;
		$sql123 = "SELECT * FROM instituciones WHERE Institucion = '".$array_institucion[$u]."' ";
		$rs123 = mysql_query($sql123, $con);
		while($row = mysql_fetch_array($rs123)){
			$ingresarInst = false;
		}
		if($ingresarInst){
			$sqlIns = "INSERT INTO instituciones(Institucion)  VALUES('".$array_institucion[$u]."')";
			mysql_query($sqlIns, $con);
		}
		////////
		//////METO PAIS
		$ingresarPais = true;
		$sql123 = "SELECT * FROM paises WHERE Pais = '".$array_pais[$u]."' ";
		$rs123 = mysql_query($sql123, $con);
		while($row = mysql_fetch_array($rs123)){
			$ingresarPais = false;
		}
		if($ingresarPais){
			$sqlPais = "INSERT INTO paises(Pais)  VALUES('".$array_pais[$u]."')";
			mysql_query($sqlPais, $con);
		}
		////////
		if($array_lee == ($u+1)){
			$leeOno = 1;
		}else{
			$leeOno = 0;
		}
		guardaMilog($leeOno);
		
	if($array_id[$u]==""){
		$sql = "INSERT INTO personas_trabajos_libres (Nombre , Apellidos , Pais , Institucion , Mail, ciudad, agradecimientos,  session) VALUES (
					'".$array_nombre[$u]."',
					'".$array_apellido[$u]."',
					'".$array_pais[$u]."',
					'".$array_institucion[$u]."',
					'".$array_mail[$u]."',
					'".$array_ciudad[$u]."',
					'".$array_agradecimientos[$u]."',
					'$ses')";
		//,'".session_id()."'
	//echo $sql . "<br>";
		mysql_query($sql,$con);
		$idPersona = mysql_insert_id();
		
		$sql = "INSERT INTO trabajos_libres_participantes (ID_trabajos_libres , ID_participante , lee)
					VALUES ('$ultimo_ingresado', '$idPersona', '".$leeOno."');";
		//echo $sql ."<br>------------------------------<br>";
		mysql_query($sql,$con);
		guardaMilog($sql);

}else{

		$sql = "UPDATE personas_trabajos_libres SET
			
					Nombre ='".$array_nombre[$u]."', 
					Apellidos ='".$array_apellido[$u]."', 
					Pais = '".$array_pais[$u]."', 
					Institucion = '".$array_institucion[$u]."', 
					Mail = '".$array_mail[$u]."',  
					ciudad = '".$array_ciudad[$u]."', 
					agradecimientos = '".$array_agradecimientos[$u]."', 
					session = '$ses' Where ID_Personas='".$array_id[$u]."';";

		//echo "$sql<br><br>";
		mysql_query($sql,$con);

		$sql = "UPDATE trabajos_libres_participantes SET lee='$leeOno' WHERE ID_participante='".$array_id[$u]."' AND ID_trabajos_libres='" . $_SESSION["ID_TL"] . "';";
		//	echo "$sql<br><br>";
		mysql_query($sql,$con);
		guardaMilog($sql);
	}	
	
	$u = $u + 1;
}

guardaMilog("ACA TERMINA////////");


if($_SESSION["ID_TL"]!=""){
	$asunto = $congreso . " [ID: $numero_de_trabajo] - Modificación de Trabajo [" . $array_apellido[0] . "]";
}else{
	$asunto = $congreso . " [ID: $numero_de_trabajo] - Recepción de Trabajo [" . $array_apellido[0] . "]";
}


// Tem&aacute;tica: </font></strong><font face="Arial, Helvetica, sans-serif">' .  $areaTL  . ' </font>
$cuerpoMail ='<center>
<h2>'.$congreso.' - Presentación de Trabajo Libre</h2>
		<div  style="width:60%;">
          <div align="left">
		  <font size="4" face="Arial, Helvetica, sans-serif">Trabajo Nº: ' .$numero_de_trabajo. '</font> <br>
		  <font size="3" face="Arial, Helvetica, sans-serif"><em>Presentación: ' .$tipoTL. '</em><br></font>
          <font size="3" face="Arial, Helvetica, sans-serif"><em>Eje tem&aacute;tico: ' .$tema. '</em><br></font>
		  </div>
  </div>
		<div  style="width:60%; padding:5px;">
		  <div align="right">
		  <font size="2" face="Arial, Helvetica, sans-serif">
    	  Presentador: <font size="5"> <strong>' .  $autorPresentador . '</strong></font> <br>
		  Primer Autor: <strong>' . $array_apellido[0] . ", " . $array_nombre[0] . "<em><font color='#990000' > (" . $array_pais[0] . ')</font></em></strong> <br>
		     Inscrito: <strong>' . $autoreInscriptos . '</strong> </font><br>
		  </div>
	      <div align="left"><font size="3">Contacto:<br><strong>'.$ApellidoContacto.', '. $NombreContacto .'</strong><em>('.$paisContacto.')</em></font><br>
<font size="4"><strong>'. $emailContacto . '</strong></font> </div>
		</div>
		<div style="width:60%; padding:5px; border:1px #000000 solid">
					<font style="font-family: Times New Roman, Times, serif; font-size: 16px;font-weight: bold;">'.$tituloTl.'</font><br>'.$gestionAutores.'<br>
					<br>
				<div align="left">
					<font style="font-family: Times New Roman, Times, serif; font-size: 12px;">
					<b>Resumen:</b> <br>
					'.$resumen.'</font><br> 
				</div>
  </div><br><br>
<font  style="font-size:14px;">Estos son su<strong> código y contraseña</strong> para <strong>modificar</strong> su trabajo</font>
<div style="width:65%; padding:5px; border:2px #000000 solid;background-color:'.$colorFondoArriba.' ">
  <table width="80%" border="0" align="center" cellpadding="2" cellspacing="0"  style="font-size:14px;">
    <tr>
      <td><div align="center">Código:<strong>'.$numero_de_trabajo.'</strong></div></td>
      <td><div align="center">Contrase&ntilde;a: <strong>'.$_SESSION["password"].'</strong></div></td>
    </tr>
  </table></div>
<br>';
  
if($nombreArchivo!=""){
  $cuerpoMail .='
<a href=\''.$pagina.'/bajando_tl.php?id='.$nombreArchivo.'\' style="font-size:14px;"> Descargue aquí su archivo para verificar que se ha subido correctamente.</a><br />
</center><br /><br />';
}


if(strstr($_SERVER['HTTP_USER_AGENT'], "Windows NT 5.1")){ 
     $user_os = "Windows XP"; 
 }elseif(strstr($_SERVER['HTTP_USER_AGENT'], "Windows NT 5.0")){ 
     $user_os = "Windows 2000"; 
 }elseif(strstr($_SERVER['HTTP_USER_AGENT'], "Windows NT 4")){ 
     $user_os = "Windows NT 4.0"; 
 }elseif(strstr($_SERVER['HTTP_USER_AGENT'], "Windows 9") || strstr($_SERVER['HTTP_USER_AGENT'], "Win 9")){ 
     $user_os = "Windows 9x"; 
 }elseif(strstr($_SERVER['HTTP_USER_AGENT'], "Windows Me")){ 
     $user_os = "Windows Me"; 
 }elseif(strstr($_SERVER['HTTP_USER_AGENT'], "Linux")){ 
     $user_os = "Linux"; 
 }elseif(strstr($_SERVER['HTTP_USER_AGENT'], "Macintosh") || strstr($_SERVER['HTTP_USER_AGENT'], "Mac_PowerPC")){ 
     $user_os = "Macintosh"; 
 }else{ 
     $user_os = "Otro"; 
 } 
		

if (ereg("MSIE", $_SERVER["HTTP_USER_AGENT"])) {
    $navegador = "Internet explorer";
} else if (ereg("^Mozilla/", $_SERVER["HTTP_USER_AGENT"])) {
     $navegador =  "Mozilla";
} else if (ereg("^Opera/", $_SERVER["HTTP_USER_AGENT"])) {
     $navegador =  "Opéra";
} else {
     $navegador =  "Navegador desconocido";
}
$cuerpoExt = "<br><br> Sistema Op.: ".$user_os . "<br><br>Navegador: " . $navegador;
foreach($arrayMails as $cualMail){

		$mailOBJ->From    		= $mailCongreso;
		$mailOBJ->FromName 		= $congreso;
		$mailOBJ->Subject = $asunto;
		$mailOBJ->IsHTML(true);
		$mailOBJ->Body    = $cuerpoMail;
		$mailOBJ->Timeout=120;
		$mailOBJ->ClearAddresses();
	
		if($cualMail == "javigega@gmail.com"){
			$mailOBJ->Body    = $cuerpoMail . $cuerpoExt ;
		}
		$mailOBJ->AddAddress($cualMail);
		if(!$mailOBJ->Send()){
			echo "<script>alert('Ocurrio un error al enviar el abstract');</script>";
		}
}


// vacio los arrais de autores////////////////
$_SESSION["nombre"] = "";
$_SESSION["apellido"] = "";
$_SESSION["institucion"] = "";
$_SESSION["mail"] = "";
$_SESSION["pais"] = "";
$_SESSION["lee"] = "";
$_SESSION["inscripto"] = "";
$_SESSION["ciudad"] = "";
	$numero_de_trabajo = "";
	$tipoTL = "";
	//$NombreContacto = row["nombreContacto"];               
    $ApellidoContacto = ""; 
	$emailContacto = "";
	$tema = "";
	$tituloTl = "";
	$resumen = "";
	$keywords = "";	
	
///////////////////////////////////////////////
$sql = "SELECT * FROM trabajos_libres WHERE ID =".  $ultimo_ingresado;
$rs = mysql_query($sql, $con);
while($row=mysql_fetch_array($rs)){
	$numero_de_trabajo = $row["numero_tl"];
	$tipoTL = $row["tipo_tl"];
	//$NombreContacto = row["nombreContacto"];               
    $ApellidoContacto = $row["apellidoContacto"]; 
	$emailContacto = $row["mailContacto_tl"];
	$tema = $row["area_tl"];
	$tituloTl = remplazar($row["titulo_tl"]);
	$resumen = remplazar($row["resumen"]);
	$keywords = remplazar($row["palabrasClave"]);	
	//$archivoTrabajo = $row["archivo_trabajo_comleto"];

$arrayPersonas = array();
$arrayInstituciones = array();
$primero = true;
	  $sql2 ="SELECT ID_participante, lee FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " . $row["ID"] ." ORDER BY ID ASC;";
	  $rs2 = mysql_query($sql2,$con);
	  while ($row2 = mysql_fetch_array($rs2)){

		$sql3 ="SELECT * FROM personas_trabajos_libres WHERE ID_Personas =" . $row2["ID_participante"] . ";";
		$rs3 = mysql_query($sql3,$con);
		while ($row3 = mysql_fetch_array($rs3)){

			array_push($arrayInstituciones , $row3["Institucion"]);
			array_push($arrayPersonas, array($row3["Institucion"], $row3["Apellidos"], $row3["Nombre"], $row3["Pais"], $row3["Curriculum"], $row3["Mail"], $row2["lee"], $row3["inscripto"]));
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

$muestroPantalla = '<center><span><img src="https://registration.congresoselis.info/copinaval/imagenes/banner_inscripcion2.jpg" width="600" height="128"></span></center><br />

<title>'.$congreso.' - Presentación de Trabajo</title><body bgcolor="'.$colorFondo.'">

<center>
<div style="padding:4px; width:600; color:#000000" align="left"><strong>A continuación se muestran los datos que se han guardado de su trabajo.</strong></div>

<div style="border:3px solid #000000; padding:4px; width:600; background-color:#FFFFFF">
  <center>
    <h2>'.$congreso.' - Presentaci&oacute;n de Trabajo Libre</h2>
    <div  style="width:90%;">
      <div align="left"> <font size="4" face="Arial, Helvetica, sans-serif">Trabajo N&ordm;:
        '.$numero_de_trabajo.'      
        </font> <br>
            <font size="3" face="Arial, Helvetica, sans-serif"><em>
              Presentación: '.$tipoTL.'
              </em><br>
            </font><font size="3" face="Arial, Helvetica, sans-serif"><em>
              Eje tem&aacute;tico: '.$tema.'
              </em><br>
            </font></div>
    </div>
    <div  style="width:90%; padding:5px;">
      <div align="right"> <font size="2" face="Arial, Helvetica, sans-serif"> Presentador: <font size="5"> <strong>
        '.$presentador.'
        </strong></font> <br>
        Primer Autor: <strong>'.$PrimerAutor.'<em><font color="#990000" > ( '.$PrimerPais.' )</font></em></strong> <br>
        Inscrito: <strong> '.$autoreInscriptos.' </strong> </font></div>
		<br>
      <div align="left"><font size="3">Contacto:<br>
            <strong>'. $ApellidoContacto.', '. $NombreContacto .'</strong><em>(
              '.$paisContacto.'
              )</em></font><br>
            <font size="4"><strong>
              '.$emailContacto.'
            </strong></font> </div>
    </div>
    <div style="width:90%; padding:5px; border:1px #000000 solid"> <font style="font-family: Times New Roman, Times, serif; font-size: 16px;font-weight: bold;">
     '.$tituloTl.'
      </font><br>
      '.$autores.'
      <br>
      <br>
      <div align="left"> <font style="font-family: Times New Roman, Times, serif; font-size: 12px;"> <b>Resumen:</b> <br>
            '.$resumen.'
        </font><br>
       </div>
    </div>
  </center><br /><br>
<font  style="font-size:14px;">Estos son su<strong> código y contraseña</strong> para <strong>modificar</strong> su trabajo</font>
<div style="width:65%; padding:5px; border:2px #000000 solid;background-color:'.$colorFondoArriba.' ">
  <table width="80%" border="0" align="center" cellpadding="2" cellspacing="0"  style="font-size:14px;">
    <tr>
      <td><div align="center">Código:<strong>'.$numero_de_trabajo.'</strong></div></td>
      <td><div align="center">Contrase&ntilde;a: <strong>'.$_SESSION["password"].'</strong></div></td>
    </tr>
  </table></div>
<br>';
if($nombreArchivo!=""){
$muestroPantalla .= '
<a href=\'javascript:bajarTL("'.$nombreArchivo.'")\' style="font-size:14px;"> Descargue aquí su archivo para verificar que se ha subido correctamente.</a><br />';
}
$muestroPantalla .= '
</div> 
</center><br /><br />';
echo $muestroPantalla;
?><center>
<br />
<div align="center" style="background-color:#FFFFCC; width:800px; border:3px solid #000000; font-size:14px;"> <br />
      <strong>En breve recibir&aacute; la confirmaci&oacute;n de su env&iacute;o.&nbsp; </strong><br />
    Si no la recibe dentro de un d&iacute;a comun&iacute;quese con la Secretar&iacute;a <br />
    del 
    Congreso a <a href="mailto:<?=$mailCongreso?>"><?=$mailCongreso?></a> mencionando el <strong>c&oacute;digo de su trabajo</strong>. <br />
        <br />
        <input type="button" name="Submit" value="Enviar otro Trabajo" style="width:200px" onclick="javascript:document.location.href='index.php'" />
        <br />
        <br />
  </div>
</center>
<?
}

session_unset();
session_destroy();
?>



</div>