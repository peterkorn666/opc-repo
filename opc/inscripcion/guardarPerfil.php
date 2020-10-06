<?php
if(!isset($_POST['key']) || $_POST['key'] === '')
{
	header("Location: ../");
	die();
}

$campos_no_obligatorios = array(
	"area_trabajo_perfil", "redes_sociales", "comentarios_pre_evento", "comentarios_post_evento", "foto_viejo", "comprobante_viejo"
);
$hay_campos_vacios = false;
$ignore = array("comprobante_viejo");
foreach($_POST as $key => $campo){
	if(!in_array($key,$campos_no_obligatorios)){
		if($campo === ''){
			$c = $key;
			$hay_campos_vacios = true;
		}
	}
}
if($hay_campos_vacios){
	header("Location: ../");
	die();
}

$key = base64_decode($_POST['key']);

if(isset($_FILES) && $_FILES["foto_inscripto"]["error"] === 0){
	$formatosValidos = array("jpg", "jpeg", "png");
	$it = current($formatosValidos);
	$esFormatoValido = false;
	while($it && !$esFormatoValido){
		$explode_name = explode(".", $_FILES["foto_inscripto"]["name"]);
		if (strpos(strtolower(end($explode_name)), $it) !== false){
			$esFormatoValido = true;
		}
		$it = next($formatosValidos);
	}
	if(!$esFormatoValido){
		header("Location: perfil.php?key=".base64_encode($key)."&error=formatoInvalido");die();
	}
}

require("../init.php");
require("clases/Db.class.php");
require("clases/lang.php");
require("clases/class.smtp.php");
require("clases/class.phpmailer.php");
require("clases/inscripcion.class.php");
$inscripcion = new Inscripcion();
$mailOBJ = new phpmailer();
$lang = new Language("es");
$db = DB::getInstance();
$config = $db->query("SELECT * FROM config LIMIT 1")->first();
$pais = $db->query("SELECT * FROM paises WHERE ID_Paises=?", [$_POST["pais"]])->first();

$datos = array(
	"solapero" => $_POST['solapero'],
	"institucion" => $_POST['institucion'],
	"area_trabajo_perfil" => $_POST['area_trabajo_perfil'],
	"ciudad" => $_POST['ciudad'],
	"pais" => $_POST['pais'],
	"telefono" => $_POST['telefono'],
	"email" => $_POST['email'],
	"redes_sociales" => $_POST['redes_sociales'],
	"comentarios_pre_evento" => $_POST['comentarios_pre_evento'],
	"comentarios_post_evento" => $_POST['comentarios_post_evento']
);

$sql = $db->update("inscriptos","id=".$key,$datos);

//calculo el tiempo real de uruguay
$tiempo = calcularTiempoUruguay();
//cargo en la bd un registro para cada actualización
$sqlRegistro = $db->insert("inscriptos_registros", ['inscripto_id' => $key, 'time' => $tiempo]);

if(isset($_FILES) && $_FILES["foto_inscripto"]["error"] === 0){
	//borro viejo
	$archivo_viejo = $db->query("SELECT id, foto_perfil FROM inscriptos WHERE id=?", [$key])->first();
	if(count($archivo_viejo) > 0){
		if($archivo_viejo['foto_perfil'] !== NULL && $archivo_viejo['foto_perfil'] !== ""){
			if(file_exists("../inscriptos_fotos/".$archivo_viejo['foto_perfil']))
				@unlink("../inscriptos_fotos/".$archivo_viejo['foto_perfil']);
		}
	}
	//cargo nuevo
	$path = '../inscriptos_fotos/';
	$file_name = str_replace(" ", "_", $_FILES["foto_inscripto"]['name']);
	//$nombre_archivo = $key."_".$file_name;
	$explode_file_name = explode(".", $file_name);
	$nombre_archivo = $key."_".str_replace(" ", "", $datos["solapero"]).".".end($explode_file_name);
	$ruta_archivo = $path.$nombre_archivo;
	copy($_FILES["foto_inscripto"]['tmp_name'], $ruta_archivo);
	$sqlArchivo = $db->update("inscriptos", "id=".$key, ["foto_perfil" => $nombre_archivo]);
}

if(isset($_FILES) && $_FILES["comprobante"]["error"] === 0){
	//borro viejo
	$comprobante_viejo = $db->query("SELECT id, comprobante_archivo FROM inscriptos WHERE id=?", [$key])->first();
	if(count($comprobante_viejo) > 0){
		if($comprobante_viejo['comprobante_archivo'] !== NULL && $comprobante_viejo['comprobante_archivo'] !== ""){
			if(file_exists("comprobantes/".$comprobante_viejo['comprobante_archivo']))
				@unlink("comprobantes/".$comprobante_viejo['comprobante_archivo']);
		}
	}
	//cargo nuevo
	$path = 'comprobantes/';
	$file_name = str_replace(" ", "_", $_FILES["comprobante"]['name']);
	$nombre_archivo = $key."_".$file_name;
	$ruta_archivo = $path.$nombre_archivo;
	copy($_FILES["comprobante"]['tmp_name'], $ruta_archivo);
	$sqlComprobante = $db->update("inscriptos", "id=".$key, ["comprobante_archivo" => $nombre_archivo]);
}

$html ='
<div align="center"><img src="'.$lang->set["TXT_BANNER_CONGRESO"].'" style="width:100%; max-width:440px"></div><br><br>
<table width="580" border="0" cellspacing="5" cellpadding="1" align="center">
	<tr>
		<td colspan="2"><strong>Inscripcion '.$key.'</strong></td>
	</tr>
	<tr colspan="2">
		<td>Su nombre<br>
			<strong>'.$_POST["solapero"].'</strong>
		</td>
	</tr>
	<tr colspan="2">
		<td>Institución<br>
			<strong>'.$_POST["institucion"].'</strong>
		</td>
	</tr>
	<tr colspan="2">
		<td>Área de trabajo<br>
			<strong>'.$_POST["area_trabajo_perfil"].'</strong>
		</td>
	</tr>
	<tr colspan="2">
		<td>Ciudad<br>
			<strong>'.$_POST["ciudad"].'</strong>
		</td>
	</tr>
	<tr colspan="2">
		<td>País<br>
			<strong>'.$pais["Pais"].'</strong>
		</td>
	</tr>
	<tr colspan="2">
		<td>Móvil / Whatsapp<br>
			<strong>'.$_POST["telefono"].'</strong>
		</td>
	</tr>
	<tr colspan="2">
		<td>Email<br>
			<strong>'.$_POST["email"].'</strong>
		</td>
	</tr>
	<tr colspan="2">
		<td>Redes sociales<br>
			<strong>'.$_POST["redes_sociales"].'</strong>
		</td>
	</tr>
	<tr colspan="2">
		<td>¿Por qué asistiré al evento?<br>
			<strong>'.$_POST["comentarios_pre_evento"].'</strong>
		</td>
	</tr>
	<tr colspan="2">
		<td>¿Qué me dejó el haber participado?<br>
			<strong>'.$_POST["comentarios_post_evento"].'</strong>
		</td>
	</tr>
</table>
<span style="color:white">'.$key.'</span>	
';

$arrayMails = array();
$arrayMails[] = $config["email_respaldo"];

$mailOBJ->IsSMTP();
$mailOBJ->SMTPDebug  = false;
$mailOBJ->SMTPAuth   = true;
$mailOBJ->SMTPAutoTLS = false;

$mailOBJ->Host       = "mail.opc.tea2018.org";
$mailOBJ->Username   = "contacto@opc.tea2018.org";
$mailOBJ->Password   = "aC5w#h66";
 
$mailOBJ->Port = 25;
$mailOBJ->From = "contacto@opc.tea2018.org";
$mailOBJ->addReplyTo($lang->set["TXT_EMAIL_CONGRESO"],'Contacto - ' . $lang->set["TXT_TITULO_CONGRESO"]);

$mailOBJ->FromName = $lang->set["TXT_TITULO_CONGRESO"];

$mailOBJ->Subject = "Modificación Perfil - Inscripto ".$key;

$mailOBJ->IsHTML(true);	
$mailOBJ->Timeout=120;
$mailOBJ->ClearAttachments();
$mailOBJ->ClearBCCs();
$mailOBJ->Body = $html;

foreach($arrayMails as $cualMail){  
	$mailOBJ->ClearAddresses();
	$mailOBJ->AddAddress($cualMail);
	if(!$mailOBJ->Send()){	
		echo 'error';
	}
}

header("Location: perfil.php?key=".base64_encode($key));die();
//header("Location: perfil.php?key=".$key);die();

function calcularTiempoUruguay(){
	$server_time = (int)date('O');
	$uruguay_time = -300;
	$difference = $server_time-($uruguay_time);
	if($server_time > 0){
		$difference_in_hours = ($server_time+($uruguay_time)) / 100;
		$tiempo = date("Y-m-d H:i:s", strtotime("-".abs($difference_in_hours)." hours"));
	}else if($server_time < 0){
		$difference_in_hours = ($server_time-($uruguay_time)) / 100;
		$tiempo = date("Y-m-d H:i:s", strtotime("+".abs($difference_in_hours)." hours"));
	}else{
		$tiempo = date("Y-m-d H:i:s");
	}
	return $tiempo;
}
?>