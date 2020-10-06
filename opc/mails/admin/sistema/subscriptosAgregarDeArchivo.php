<?
require "inicializar.php";
controlarAcceso($sistema,2);
$presentacion->abrir("subscriptosAgregarDeArchivo.php","../paginas/","Principal");

require "../clases/form_class.php";
$form = new form_class();
$form->acciones["importar"]="importarSubscriptos";
$form->acciones["mostrarForm"]="mostrarForm";
$form->accionPorDefecto="mostrarForm";
$form->action="subscriptosAgregarDeArchivo.php";
$form->method="post";
$form->enctype="multipart/form-data";
$form->script_OnLoad="eval('iniciar();');";
$form->leerDatos();
$form->redirect=false;
$resultado="";
$form->procesar();

$presentacion->asignarValor("FormBuscador","");
$presentacion->asignarValor("Mensaje",$form->mensaje);

$grupos=$sistema->crearGrupos();
$rs=$grupos->buscarDatos("IdGrupo,Grupo","","Grupo");

$listadoGrupos="";
while ($row=$rs->darSiguienteFila()) {
	$listadoGrupos.= "<br/><input type='checkbox' name='IdGrupo[]' value='" . $row["IdGrupo"] . "' id='chk_grupo_" . $row["IdGrupo"] . "'><label for='chk_grupo_" . $row["IdGrupo"] . "'>" . $row["Grupo"] . "</label>";
}

$presentacion->asignarValor("listadoGrupos",$listadoGrupos);


if ($form->mostrar==1) {
	$presentacion->parse("FormEdicion",false);
	$presentacion->asignarValor("Resultado","");
} else {
	$presentacion->asignarValor("FormEdicion","");
	$presentacion->asignarValor("Resultado",$resultado);
}

$form->mostrarEnPresentacion($presentacion);

$presentacion->mostrar();

function importarSubscriptos() {
	global $sistema,$form,$resultado;
	
	$form->mostrarForm=false;
	$form->mostrarResultado=true;
	
	$operacion=leerParametro("operacion","");
	$comentarios=leerParametro("comentarios","");
	$arrGrupos=leerParametro("IdGrupo","");
	
	$limpiarGrupos=leerParametro("limpiarGrupos","");
	
	if ($limpiarGrupos==1 && $operacion=="altaSubscriptos" && is_array($arrGrupos)) {
		for ($ig=0;$ig<count($arrGrupos);$ig++) {		
			$sql="DELETE from subscriptos_grupos WHERE IdGrupo=" . $arrGrupos[$ig] ;
			$sistema->database->ejecutarSentenciaSQL($sql);								
			$resultado.= "<br> Vaciar grupo " . $arrGrupos[$ig];
			if ($sistema->database->filasAfectadas>0) {
				$resultado.=  " se quitaron del grupo " . $sistema->database->filasAfectadas . " subscriptos";
			} else {
				$resultado.=  " no había subscriptos";
			}
		}
	}
					
						
	if ($mails=uploadArchivo()) {

		$total=0;
		$unicos=0;
		$validos=0;
		$nuevos=0;
		
		$bajas=0;
		$bajasGrupos=0;
			
		$arrMails=(importarMails($mails));

		$arrMails=$arrMails[0];
		
		$total=count($arrMails);

		$arrMails=array_unique($arrMails);
		
		
		$i=0;
		//$reg="/[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+/";
		$reg="/[a-zA-Z0-9._-]+@([a-zA-Z0-9_-]+.)+[a-zA-Z]+/";

		foreach ($arrMails as $mail) {
			$i++;
			$mail=strtolower(trim($mail));

			if ($mail!="") {
			
				$unicos++;
				
				preg_match($reg, $mail, $coincidencias);	
				
				if (count($coincidencias)>0 && $mail==$coincidencias[0]) {
					$validos++;
					
					switch ($operacion) {
						case "altaSubscriptos":					
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
								if ($idSubscripto>0 && is_array($arrGrupos) ) {
									for ($ig=0;$ig<count($arrGrupos);$ig++) {									
										$sql="INSERT IGNORE into subscriptos_grupos (IdSubscripto,IdGrupo) VALUES (" . $idSubscripto . "," . $arrGrupos[$ig] . ")";
										$sistema->database->ejecutarSentenciaSQL($sql);								
									}
								}
								
							} else {
								$resultado.="Error al insertar ";
							}
						break;
						case "bajaSubscriptos":
							$sql="UPDATE subscriptos SET EnviosPendientes=':',Activo=0,Comentarios='$comentarios' WHERE Email='" . $mail . "'";
							
							$sistema->database->ejecutarSentenciaSQL($sql);

							$bajas+=$sistema->database->filasAfectadas;
							
							$sql="DELETE FROM envios_subscriptos WHERE IdEstadoEnvio=1 AND Email='" . $mail . "'";
							
							$sistema->database->ejecutarSentenciaSQL($sql);
							
						break;
						
						case "bajaGrupos":
								$idSubscripto=$sistema->buscarIdSubscripto($mail);
								if ($idSubscripto>0 && is_array($arrGrupos)) {
									for ($ig=0;$ig<count($arrGrupos);$ig++) {								
										$sql="DELETE FROM subscriptos_grupos WHERE (IdSubscripto=" . $idSubscripto . " AND IdGrupo=" . $arrGrupos[$ig] . ")";
										$sistema->database->ejecutarSentenciaSQL($sql);																		
										$bajasGrupos+=$sistema->database->filasAfectadas;
									}
								} 
						break;
					}
				} 
			}
		}
		
		switch ($operacion) {
			case "altaSubscriptos":		
				$resultado.="<br />Direcciones totales: $total";
				$resultado.="<br />Direcciones &uacute;nicas: $unicos";
				$resultado.="<br />Direcciones v&aacute;lidas: $validos";
				$resultado.="<br />Nuevas: $nuevos";
			break;
			case "bajaSubscriptos":
				$resultado.="<br />Bajas subscriptos: $bajas";
			break;
			case "bajaGrupos":
				$resultado.="<br />Bajas grupos: $bajasGrupos";
			break;
		}
	}
}

function mostrarForm() {
	global $form;
	$form->mostrarForm=true;
	$form->mostrarResultado=false;
	$form->mostrar=1;
	$form->accion="importar";
}


function importarMails($mails)
{
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
