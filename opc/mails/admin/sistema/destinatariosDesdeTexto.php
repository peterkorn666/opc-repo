<?
require "inicializar.php";
controlarAcceso($sistema,2);
$presentacion->abrir("destinatariosDesdeTexto.php","../paginas/","Principal");

require "../clases/form_class.php";
$form = new form_class();
$form->acciones["importar"]="importarSubscriptos";
$form->acciones["mostrarForm"]="mostrarForm";
$form->accionPorDefecto="mostrarForm";
$form->action="destinatariosDesdeTexto.php";
$form->method="post";
$form->script_OnLoad="eval('iniciar();');";
$form->leerDatos();
$form->redirect=false;
$resultado="";
$form->procesar();

$presentacion->asignarValor("FormBuscador","");
$presentacion->asignarValor("Mensaje",$form->mensaje);

$envios=$sistema->crearEnvios();

$presentacion->asignarValor("envios","<option value=-1>Seleccione mail</option>".cargarListBoxRS($envios->buscarDatos("IdEnvio,CONCAT('(',IdEnvio,') ',Descripcion)","","IdEnvio DESC"),$idEnvio));

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

	$mails=leerParametro("mails","");
	$operacion=leerParametro("operacion","");
	$comentarios=leerParametro("comentarios","");
	
	$form->mostrarForm=false;
	$form->mostrarResultado=true;

	$idEnvio=leerParametro("IdEnvio","");
	
		$sqlBase="insert into envios_subscriptos (IdEnvio,IdEstadoEnvio,IdSubscripto,Email)";
		$sqlBase.=" select $idEnvio,1,IdSubscripto,Email from subscriptos";
		$sqlBase.=" where Activo=1 and not (subscriptos.EnviosPendientes like '%:$idEnvio:%') and IdSubscripto in ";

		$sqlBase2="update subscriptos set EnviosPendientes=CONCAT(EnviosPendientes,$idEnvio,\":\")";
		$sqlBase2.=" where Activo=1 and not (subscriptos.EnviosPendientes like '%:$idEnvio:%') and IdSubscripto in ";
		$largoMaximoSQL=1024;
		$in="";
	
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
	//$reg="/[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+/";
	$reg="/[a-zA-Z0-9._-]+@([a-zA-Z0-9_-]+.)+[a-zA-Z]+/";
	
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


?>
