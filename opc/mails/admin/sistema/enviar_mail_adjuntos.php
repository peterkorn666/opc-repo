<?
require "inicializar.php";
controlarAcceso($sistema,2);
require "phpmailer/class.phpmailer.php";
?>
<html>
<head>
</head>
<?
$limite=leerParametro("limite",ENVIOS_POR_VEZ);
$espera=leerParametro("espera",TIEMPO_ESPERA_ENTRE_MAILS);
$tiempoRefresh=leerParametro("tiempoRefresh",TIEMPO_REFRESH);
$funcionRetorno=leerParametro("funcionRetorno","");

$urlRefresh="http://"  . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];

$enviados=0;
$errores=0;

//revisa si ya viene del mismo formulario o de afuera
$pr=leerParametro("pr","");
if ($pr=="") {
	if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!="") {
		$paginaRetorno=$_SERVER['HTTP_REFERER'];
	} else {
		$paginaRetorno=false;
	}
} else {
	$paginaRetorno=$pr;
}

$redirigir=false;

$id=leerParametro("id","");

$accion=leerParametro("accion","enviarTodos");

switch($accion) {
	case "enviarTodos":	
		if ($id!="") {
			$sql = "SELECT mails.*, envios.* FROM mails INNER JOIN envios ON mails.IdMail=envios.IdMail WHERE IdEnvio=$id;";
			$sistema->database->ejecutarSentenciaSQL($sql);
			$rsMail=$sistema->database->rs;
			if ($rsMail) {	
				// prepara el mail
				$row = mysqli_fetch_array($rsMail);
				//$cuerpoTexto=$row["CuerpoTexto"];
				$cuerpoTexto=$row["CuerpoTextoPreparado"];
				//$cuerpoHTML=$row["CuerpoHTML"];
				$cuerpoHTML=$row["CuerpoHTMLPreparado"];
				$asunto=$row["Asunto"];
				$fromNombre=$row["FromNombre"];
				$fromEmail=$row["FromEmail"];
				$replyToNombre=$row["ReplyToNombre"];
				$replyToEmail=$row["ReplyToEmail"];
				$senderNombre=$row["SenderNombre"];
				$senderEmail=$row["SenderEmail"];
				$importancia=$row["Importancia"];
				$prioridad=$row["Prioridad"];
				$confirmacionLectura=$row["ConfirmacionLectura"];
				$idMail=$row["IdMail"];
				$tablaDatosExtras=$row["TablaDatosExtras"];
				$condicionDatosExtras=$row["CondicionDatosExtras"];

				//listado de imagenes a adjuntar
				$sql = "SELECT * FROM mails_imgs WHERE IdMail=$idMail";
				$sistema->database->ejecutarSentenciaSQL($sql);
				$rsMailImgs = $sistema->database->rs;
				
				//listado de archivos a adjuntar
				$sql = "SELECT * FROM mails_adjuntos WHERE IdMail=$idMail";
				$sistema->database->ejecutarSentenciaSQL($sql);
				$rsMailAdjuntos = $sistema->database->rs;
				
				//subscriptos para enviar con este mail
				$select="IdEnvioSubscripto,envios_subscriptos.IdSubscripto AS IdSubscripto,envios_subscriptos.Email AS Email,Guid";
				$from="(envios_subscriptos INNER JOIN subscriptos ON envios_subscriptos.IdSubscripto=subscriptos.IdSubscripto)";

				$where="envios_subscriptos.IdEstadoEnvio=1 AND IdEnvio=$id";
				
			
				foreach(split(",",REEMPLAZO_VALORES) as $v) {
					$select.="," . $v;
				}
				$from.=" LEFT JOIN subscriptos_datos_personales ON subscriptos.IdSubscripto=subscriptos_datos_personales.IdSubscripto";


			
				/*
				$arrVariables=array();
				if ($tablaDatosExtras!=null) {
					
					//listado de variables extras a reemplazar
					$sql = "SELECT * FROM subscriptos_variables WHERE Tabla='$tablaDatosExtras'";
					$sistema->database->ejecutarSentenciaSQL($sql);
					$rsVariables = $sistema->database->rs;
					
					if ($rsVariables && mysqli_num_rows($rsVariables)>0 && mysqli_data_seek ($rsVariables,0)) {
						$i=0;
						while ($row = mysqli_fetch_array($rsVariables)){
							$arrVariables[$i]=$row["Campo"];
							$i++;	
						}
					}
					
					$select.=",$tablaDatosExtras.*";
					$from.=" LEFT JOIN $tablaDatosExtras ON envios_subscriptos.IdSubscripto=$tablaDatosExtras.IdSubscripto";
					$where.=" AND $tablaDatosExtras.IdEstadoEnvio=1"; // esto hace que si hay campos nulos en la tabla de datos extras no manda el mail, queda como inner join
					if ($condicionDatosExtras!=null) {
						$where.=" AND $condicionDatosExtras";
					}
				}
				*/
				
				$sql = "SELECT $select FROM $from WHERE $where LIMIT $limite;";

				$sistema->database->ejecutarSentenciaSQL($sql);
				$rsDestinatarios = $sistema->database->rs;
				
				if (MODO_PRUEBA==false) {
					if (mysqli_num_rows($rsDestinatarios)>0) {
						?>
						<script>
						  var version = parseInt(navigator.appVersion)
						  // replace is supported

						  if (version>=4 || window.location.replace)
						  setTimeout("window.location.replace('<? echo $urlRefresh;?>')",<? echo $tiempoRefresh * 1000;?>);
						  else
							window.location.href = "<? echo $urlRefresh;?>"
						</script>
						<?
					} else {
						if ($funcionRetorno!="") {?>  
							<script>
							alert("Envio completo");
							if (opener.<?echo $funcionRetorno?>) {		
							   opener.<?echo $funcionRetorno . "()"?>;
							 }  
							 window.close();
							 </script>
						  <?}
					}
				}

				echo "<hr>";
				echo "Para enviar: " . mysqli_num_rows($rsDestinatarios);

				enviar($rsDestinatarios,$tablaDatosExtras);
            }
        }
		break;
}

echo "<hr>";
echo "<br>Enviados: $enviados";
echo "<br>Errores: $errores";

$sistema->actualizarEstadisticasEnviosCantidades($id,0,-$enviados-$errores,$enviados,$errores);
//}

?>
</body>
</html>


<?
function random($randlen = 16) {
   $randval = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
   $random = "";
   for ($i = 1; $i <= $randlen; $i++) {
       $random .= substr($randval, rand(0,(strlen($randval) - 1)), 1);
   }
   return $random;
}


function enviarMail($fromNombre,$fromEmail,$replyToEmail,$replyToNombre,$senderNombre,$senderEmail,$to,$asunto,$cuerpoHTML,$cuerpoTexto,$prioridad,$confirmacionLectura,$guid) {
 
 global $rsMailImgs,$rsMailAdjuntos;
 
 echo "<hr>enviando<br>";

 $mail = new PHPMailer();

	$mail->SetLanguage("es","phpmailer/language/");
	
	if (PHPMAILER_TIPO=="mail") {
		// envia con la funcion mail de php
		$mail->IsMail();
	} elseif (PHPMAILER_TIPO=="smtp") {
		//envia con smtp
		$mail->IsSMTP();
		$mail->SMTPDebug = 2;
		$mail->SMTPAuth   = true;
		$mail->SMTPAutoTLS = false;
		
		$mail->Host       = PHPMAILER_HOST;
		$mail->Username   = PHPMAILER_USERNAME;
		$mail->Password   = PHPMAILER_PASSWORD;
	}
	 
	$mail->Sender = $senderEmail;
	//$mail->From = $fromEmail;
	$mail->From = PHPMAILER_USERNAME;
	$mail->FromName = $fromNombre;
	$mail->AddReplyTo($replyToEmail, $replyToNombre);
	$mail->AddAddress($to);	
	$mail->Subject = $asunto;
	$mail->Body = $cuerpoHTML;
	$mail->WordWrap = 70;
	$mail->Priority = $prioridad;
	if ($confirmacionLectura==1) {
		$mail->$ConfirmReadingTo="\"$senderNombre\" <$senderEmail>";
	}	
	$mail->AddCustomHeader("X-guid:$guid");

	$mail->IsHTML(true);
	$mail->AltBody=$cuerpoTexto;
	$mail->CharSet=CHARSET_MAIL;
	
	$mail->Body=reemplazarImgs($mail,$mail->Body,$rsMailImgs,$guid);
	if ($rsMailAdjuntos && mysqli_num_rows($rsMailAdjuntos)>0 && mysqli_data_seek ($rsMailAdjuntos,0)) {
		while ($row = mysqli_fetch_array($rsMailAdjuntos)){
			if ($row["Archivo"]!="") {
				$mail->AddAttachment(DIR_ADJUNTOS .  $row["Archivo"],$row["Nombre"]);
			}
		}
		mysqli_data_seek($rsMailAdjuntos, 0);
	}

	if (MODO_PRUEBA==true) {
		print_r($mail->Body);
		echo "<hr>";
		return "modo prueba";
	} else {
		if ($mail->Send()) {
			return "";
		} else {
			return $mail->ErrorInfo;
		}
	}	
}

function enviar($rsDestinatarios,$tablaDatosExtras) {
	global $sistema,$espera,$id;
	global $fromNombre,$fromEmail,$replyToEmail,$replyToNombre,$senderNombre,$senderEmail,$to,$asunto,$cuerpoHTML,$cuerpoTexto,$prioridad,$confirmacionLectura;
	global $enviados, $errores;

	$idEnvio=$id;
	
	while ($row = mysqli_fetch_array($rsDestinatarios)){
		$idSubscripto = $row["IdSubscripto"];
		$para = $row["Email"];
		$idEnvioSubscripto = $row["IdEnvioSubscripto"];
		$guid = $row["Guid"];
		if ($guid=="") {
			$guid=random(LARGO_GUID) . $idEnvioSubscripto;
		}

		$arrBuscarTextos=array(REEMPLAZO_BUSCAR_PREFIJO . "REPLYTO" . REEMPLAZO_BUSCAR_SUFIJO,REEMPLAZO_BUSCAR_PREFIJO . "GUID" . REEMPLAZO_BUSCAR_SUFIJO,REEMPLAZO_BUSCAR_PREFIJO . "EMAIL" . REEMPLAZO_BUSCAR_SUFIJO);
		$arrReemplazarPor=array($replyToEmail,$guid,$row["Email"]);
		foreach (split(",",REEMPLAZO_VALORES) as $v) {
			array_push($arrBuscarTextos,REEMPLAZO_BUSCAR_PREFIJO . strtoupper($v) . REEMPLAZO_BUSCAR_SUFIJO);
			array_push($arrReemplazarPor,$row[$v]);
		}

		$cuerpoHTMLPersonalizado=str_replace($arrBuscarTextos,$arrReemplazarPor,$cuerpoHTML);
		
		$cuerpoTextoPersonalizado=str_replace($arrBuscarTextos,$arrReemplazarPor,$cuerpoTexto);

		$resultado=enviarMail($fromNombre,$fromEmail,$replyToEmail,$replyToNombre,$senderNombre,$senderEmail,$para,$asunto,$cuerpoHTMLPersonalizado,$cuerpoTextoPersonalizado,$prioridad,$confirmacionLectura,$guid);
		
		if ($resultado=="") {
			$idEstadoEnvio=2;
			$enviados++;
		} else {
			$idEstadoEnvio=3;
			$resultado=str_replace("'","\"",$resultado);
			$errores++;
		}
		
		echo "<br>" . $para . " -> " . $idEstadoEnvio . " " . $resultado;
		
		$fechaHora=date("Y-m-d G:i:s");

		if (MODO_PRUEBA==false) {
			//actualiza el registro en envios_subscriptos
			$sql = "UPDATE envios_subscriptos SET Guid='$guid', IdEstadoEnvio=$idEstadoEnvio, Comentarios='$resultado', FechaHora='$fechaHora' WHERE IdEnvioSubscripto='$idEnvioSubscripto'";

			$sistema->database->ejecutarSentenciaSQL($sql);
		
			if ($tablaDatosExtras!=null) {
				// actualiza el envio en la tabla extra
				$sql = "UPDATE $tablaDatosExtras SET IdEstadoEnvio=$idEstadoEnvio WHERE IdSubscriptoDatos=" .  $row["IdSubscriptoDatos"];
				echo "<br>$sql";
				$sistema->database->ejecutarSentenciaSQL($sql);
			} // no permite que se envie otra ves a este destinatario.
				
				//CAMBIAR LA FORMA DE ENVIO PARA QUE FUNCIONE GENERICO (AGREGAR DATOS DE LA TABLA EXTRA EN ENVIOS_SUBSCRIPTOS?
			
			//actualiza el registro en subscriptos
			$sql="update subscriptos set ";
			$sql.="EnviosPendientes=IF(LOCATE(':$idEnvio:',EnviosPendientes)>0,CONCAT(LEFT(EnviosPendientes,LOCATE(':$idEnvio:',EnviosPendientes)), RIGHT(EnviosPendientes, LENGTH(EnviosPendientes)-LOCATE(':$idEnvio:',EnviosPendientes)-LENGTH(':$idEnvio:')+1)),EnviosPendientes)";
			if ($idEstadoEnvio==2) {
				$sql.=",EnviosHechos=CONCAT(EnviosHechos,$idEnvio,\":\")";
			}
			if ($idEstadoEnvio==3) {
				$sql.=",EnviosRebotados=CONCAT(EnviosRebotados,$idEnvio,\":\")";
			}
			$sql.=" where IdSubscripto='$idSubscripto'";
			
			$sistema->database->ejecutarSentenciaSQL($sql);
		}

		sleep($espera);
	}
}

function reemplazarImgs(&$mail,$cuerpoHTML,$rsMailImgs,$guid){
	//personalizacion
	//imgs
	$imgsReemplazar=-1;
	$imgsOriginal=array();
	$imgsNuevo=array();
	$encoding = 'base64';
	$type = 'application/octet-stream';
	if ($rsMailImgs && mysqli_num_rows($rsMailImgs)>0 && mysqli_data_seek ($rsMailImgs,0)) {
		$imgsN=0;
		while ($row = mysqli_fetch_array($rsMailImgs)){
			//hay que terminar la url con una comilla o espacio para evitar que reemplace la url en imagenes
			//por ejemplo url=http://www.midominio.com e imagen=http://www.midominio.com/imagenes/img.gif
			if ($row["Archivo"]!="") {
				$imgsN++;

				$archivo=$row["Archivo"];
				
				$extension="";
				if (strlen($archivo)>4) {
					$extension=substr($archivo,-3);
				}
				echo $extension;
				
				switch (strtolower($extension)) {
					case "jpg":
						$type = 'image/jpeg';
					break;
					case "gif":
						$type = 'image/gif';
					break;
					case "png":
						$type = 'image/png';
					break;
					default:
						$type = 'application/octet-stream';
					break;
				}
				

				$mail->AddEmbeddedImage(DIR_ADJUNTOS . $archivo, $guid . $imgsN,$archivo,$encoding,$type) ;			

				$imgsReemplazar++;
				$imgsOriginal[$imgsReemplazar]="src=\"".$row["Url"]."\"";
				$imgsNuevo[$imgsReemplazar]="src=\"cid:".$guid . $imgsN."\"";

				$imgsReemplazar++;
				$imgsOriginal[$imgsReemplazar]="SRC=\"".$row["Url"]."\"";
				$imgsNuevo[$imgsReemplazar]="src=\"cid:".$guid . $imgsN."\"";

				$imgsReemplazar++;
				$imgsOriginal[$imgsReemplazar]="src='".$row["Url"]."'";
				$imgsNuevo[$imgsReemplazar]="src='cid:".$guid . $imgsN."'";

				$imgsReemplazar++;
				$imgsOriginal[$imgsReemplazar]="SRC='".$row["Url"]."'";
				$imgsNuevo[$imgsReemplazar]="src='cid:".$guid . $imgsN."'";
			}
		}
		mysqli_data_seek($rsMailImgs, 0);
	}
	return str_replace($imgsOriginal,$imgsNuevo,$cuerpoHTML);	
}

?>