<?
require "inicializar.php";
controlarAcceso($sistema,2);
$presentacion->abrir("destinatariosDesdeArchivo.php","../paginas/","Principal");

require "../clases/form_class.php";
$form = new form_class();
$form->acciones["importar"]="importarSubscriptos";
$form->acciones["mostrarForm"]="mostrarForm";
$form->accionPorDefecto="mostrarForm";
$form->action="destinatariosDesdeArchivo.php";
$form->method="post";
$form->enctype="multipart/form-data";
$form->script_OnLoad="eval('iniciar();');";
$form->leerDatos();
$form->redirect=false;
$resultado="";
$form->procesar();

$presentacion->asignarValor("FormBuscador","");
$presentacion->asignarValor("Mensaje",$form->mensaje);

$envios=$sistema->crearEnvios();

$idEnvio=leerParametro("IdEnvio","");
$presentacion->asignarValor("envios","<option value=-1>Seleccione mail</option>".cargarListBoxRS($envios->buscarDatos("IdEnvio,CONCAT('(',IdEnvio,') ',Descripcion)","","IdEnvio DESC"),$idEnvio));

if ($form->mostrar==1) {
	$presentacion->parse("FormEdicion",false);
	$presentacion->asignarValor("Resultado",$resultado);
} else {
	$presentacion->asignarValor("FormEdicion","");
	$presentacion->asignarValor("Resultado",$resultado);
}

$form->mostrarEnPresentacion($presentacion);

$presentacion->mostrar();

function importarSubscriptos() {
	global $sistema,$form,$resultado;
	
	$form->mostrarForm=true;
	$form->mostrarResultado=true;

	$comentarios="";
	
	$idEnvio=leerParametro("IdEnvio","");
	
		$sqlBase="insert into envios_subscriptos (IdEnvio,IdEstadoEnvio,IdSubscripto,Email)";
		$sqlBase.=" select $idEnvio,1,IdSubscripto,Email from subscriptos";
		$sqlBase.=" where Activo=1 and not (subscriptos.EnviosPendientes like '%:$idEnvio:%') and IdSubscripto in ";

		$sqlBase2="update subscriptos set EnviosPendientes=CONCAT(EnviosPendientes,$idEnvio,\":\")";
		$sqlBase2.=" where Activo=1 and not (subscriptos.EnviosPendientes like '%:$idEnvio:%') and IdSubscripto in ";
		$largoMaximoSQL=1024;
		$in="";
						
	if ($mails=uploadArchivo()) {

		$total=0;
		$unicos=0;
		$validos=0;
		$nuevos=0;
		$agregados=0;
		
		$arrMails=(importarMails($mails));

		$arrMails=$arrMails[0];
		
		$total=count($arrMails);

		$arrMails=array_unique($arrMails);
			
		$i=0;
		$reg="/[a-zA-Z0-9._-]+@([a-zA-Z0-9_-]+.)+[a-zA-Z]+/"; // no esta seleccionando <mail@dominio.com>
		
		foreach ($arrMails as $mail) {

			$mail=strtolower(trim($mail));
			
			if ($mail!="") {
				$unicos++;
				preg_match($reg, $mail, $coincidencias);	
				
				if (count($coincidencias)>0 && $mail==$coincidencias[0]) {
					$validos++;
	
					$sql="INSERT IGNORE into subscriptos (Email,Comentarios,EnviosPendientes,EnviosHechos,EnviosRebotados) VALUES ('" . $mail . "','" . $comentarios . "',':',':',':')";
			
					if ($sistema->database->ejecutarSentenciaSQL($sql)) {

						if ($sistema->database->filasAfectadas==1) {
							$nuevos++;
							$idSubscripto=$sistema->database->idInsert;
							$sql="INSERT into subscriptos_datos_personales (IdSubscripto) VALUES (" . $idSubscripto . ")";
							$sistema->database->ejecutarSentenciaSQL($sql);
						} else {
							$idSubscripto=$sistema->buscarIdSubscripto($mail);
							$sql="UPDATE subscriptos SET Activo=1,Comentarios='$comentarios' WHERE Email='" . $mail . "'";
							$sistema->database->ejecutarSentenciaSQL($sql);
						}

						if ($in<>"" && strlen($sqlBase . " (" . $in . "," . $idSubscripto . ")")>$largoMaximoSQL) {
							$sql=$sqlBase . " (" . $in .")";
							$sistema->database->ejecutarSentenciaSQL($sql);			
							$agregados+=$sistema->database->filasAfectadas;
							
							$sql=$sqlBase2 . " (" . $in .")";
							$sistema->database->ejecutarSentenciaSQL($sql);
														
							$in=$idSubscripto;
						} else {
							if ($in<>"") {
								$in.=",";
							}
							$in.=$idSubscripto;
						}
						$i++;
					}  else {
						$resultado.="<br />Error al insertar: $mail";
					}
				} 
			}
		}
		
		if ($in<>"") {
			$sql=$sqlBase . " (" . $in .")";		
			$sistema->database->ejecutarSentenciaSQL($sql);
			$agregados+=$sistema->database->filasAfectadas;
			
			$sql=$sqlBase2 . " (" . $in .")";
			$sistema->database->ejecutarSentenciaSQL($sql);
		}
		
		$resultado.="<br />Direcciones totales: $total";
		$resultado.="<br />Direcciones &uacute;nicas: $unicos";
		$resultado.="<br />Direcciones v&aacute;lidas: $validos";
		$resultado.="<br />Nuevas: $nuevos";
		$resultado.="<br />Agregadas al env&iacute;o: $agregados";
		
		$sistema->actualizarEstadisticasEnviosCantidades($idEnvio,$agregados,$agregados,0,0);
				
	} else {
		$resultado.="No se importó el archivo";
	}
	
	$form->mostrarForm=true;
	$form->mostrarResultado=true;
	$form->mostrar=1;
	$form->accion="importar";
}

function mostrarForm() {
	global $form;
	$form->mostrarForm=true;
	$form->mostrarResultado=false;
	$form->mostrar=1;
	$form->accion="importar";
}


function importarMails($mails) {
	$mails=" " . $mails;
	$mails=str_replace(array("\"","'",",",";")," ",$mails);

	// incluye  un punto al final para que alvaro@adinet.com. uy ingrese como alvaro@adinet.com. para luego validar. Si no se incluye el punto al final lo toma como alvaro@adinet.com
	//no incluye direcciones con ip

	$reg="/[\s][a-zA-Z0-9._-]+@([a-zA-Z0-9_-]+\.)+[a-zA-Z]+(\.)*/";
	
	preg_match_all($reg, $mails, $array);

	return $array;
	// a la salida de acá hay que validarle que termine con texto de dominios válidos
};

function uploadArchivo() {
	ini_set("max_execution_time", "10000");
	ini_set("max_input_time", "10000");
	ini_set("post_max_size", "512M");
	ini_set("upload_max_filesize", "10M");
	ini_set("memory_limit", "64M");

	$array_extension = explode(".", utf8_decode($_FILES["archivo"]["name"]));

	$extension = array_pop($array_extension);
	
	$nombreArchivo_original = utf8_decode($_FILES["archivo"]["name"]);

	$nombreArchivo_tmp = "tmp_" . date("Ymd_Gis") . "_" . $nombreArchivo_original;

	$uploadFile = DIR_ABSOLUTO . "tmp/" .  $nombreArchivo_tmp ;
	if(move_uploaded_file($_FILES["archivo"]['tmp_name'], $uploadFile)){
		$resultado="";
		$gestor = fopen($uploadFile, "r");
		if ($gestor) {
			while (!feof($gestor)) {
				$bufer = fgets($gestor, 4096);
				$resultado.= "\n" . $bufer;
			}
			fclose ($gestor);
		}
		return $resultado;
	} else {
		return false;
	}
}

?>
