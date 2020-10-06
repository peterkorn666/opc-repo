<? 
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache"); 
include "../conexion.php";
include "../envioMail_Config.php";
require "../clases/class.Conferencistas.php";
require ("../clases/class.Traductor.php");
require "../clases/class.phpmailer.php";
require "../clases/class.Cartas.php";
$cartas = new cartas();
$dir = "";
if($_POST["copia"]=="1"){
	$dir = $_POST["direccion"];
}
$mailOBJ = new phpmailer();
$err=0;
$mailOBJ->From    		= $mail_congreso;
$mailOBJ->FromName 		= $congreso;
$mailOBJ->IsHTML(true);
$mailOBJ->Timeout=120;
$arrayMails = array ();
$conferencista = new conferencistas_congreso();
$lista = $conferencista->seleccionar_evaluadores_del_filtrado($_SESSION["listaConferncistas"]);
while ($row = mysql_fetch_object($lista)){	
	$datos = array($row->mail, $row->id, $row->nombre, $row->clave);
	array_push($arrayMails, $datos);
}

$cantidad_personas = count($datos);
$asunto = "";

foreach($arrayMails as $cualMail){
	$imprimir = "";
		if($cualMail[5]=="Spanish"){
			$lenguaje="es";
		}
		if($cualMail[5]=="English"){
			$lenguaje="ing";
		}
		//SET $lenguaje en ingles porque el congreso lo pide	
		$lenguaje="esp";
		//
		$traductor = new traductor();
		$traductor->setIdioma($lenguaje);
	
	if($_POST["carta"]=="manual"){
		$cartaMail = nl2br($_POST["cuerpoMail"]);
		$cartaMail = str_replace("<:nombre>", $cualMail[2] , $cartaMail);
		$cartaMail = str_replace("<:mail>", $cualMail[0] , $cartaMail);
		$cartaMail = str_replace("<:clave>", $cualMail[3] , $cartaMail);
	}else{
		$rs = $cartas->cargarUna($_POST["carta"]);
		if ($predefinida = mysql_fetch_array($rs)){
			$cartaMail = $predefinida["cuerpo"];
			$cartaMail = $cartas->personificarPorPersona($cartaMail, $cualMail[4]);
			$cartaMail = str_replace("<:id>", $cualMail[1] , $cartaMail);
			$cartaMail = str_replace("<:nombre>", $cualMail[2] , $cartaMail);
			$cartaMail = str_replace("<:link>", "<a href='http://www.cicat2016.org/programa/corrector/eval.php?key=".base64_encode($cualMail[1])."'>HAGA CLICK AQU&Iacute; PARA RESPONDER<br>LA INVITACI&Oacute;N DE FORMA ONLINE</a>" , $cartaMail);
			$cartaMail = str_replace("<:mail>", $cualMail[0] , $cartaMail);
			$cartaMail = str_replace("<:clave>", $cualMail[3] , $cartaMail);
			$cartaMail = str_replace("<:fecha>", $fechaParaCarta , $cartaMail);
			$cartaMail = str_replace("<:fecha2>", $fechaParaCartaEsp , $cartaMail);
			$cartaMail = str_replace("<:participaciones>", $imprimir , $cartaMail);
		}
	}	
	$dire = "http://cipesur2011.atenea.com.uy/programa/imagenes/banner.png";
	$cuerpo = '<table width="650px" cellpadding="10px" cellspacing="10px" align="center">
					<tr>
						<td align="center" style="padding:0px">
							<a href="http://www.cicat2016.org"><img src="'.$dirBanner.'" width="900"></a>
						</td>
					</tr>
             		<tr>
                   		<td align="left" valign="top" bgcolor="#FFFFFF" style="font-family:Arial, Helvetica, sans-serif;font-size: 12px;color:#000000;">'.nl2br($cartaMail).'</td>
		          </tr>
        </table>';	
		
	$asunto = $_POST["asuntoMail"]." ".$cualMail[2]." ".$_POST["asuntoMail2"];
	$mailOBJ->Subject = utf8_decode($asunto);
	$mailOBJ->Body  = $cuerpo;
	$mailOBJ->ClearAddresses();
	$mailOBJ->ClearCCs();
	$mailOBJ->ClearAttachments();
	if($_POST["demo"]=="demo"){
		$mailOBJ->AddAttachment("docs/demos.pdf", "Demo.pdf");
	}
	if($_POST["correos"]==1){
		$mailOBJ->AddCC($dir);
		$mailOBJ->AddAddress(trim($cualMail[0]));
		if(!$mailOBJ->Send()){
			$err = 1;
			echo "<script>alert('Ocurrio un error al enviar el e-mail $cualMail[0]');</script>";
		}
	}else{
		$mailOBJ->AddAddress($dir);
		if(!$mailOBJ->Send()){
			$err = 1;
			echo "<script>alert('Ocurrio un error al enviar el e-mail $cualMail[0]');</script>";
		}
	}
	$que = "";
	$fecha = date("d/m/Y H:i");
	/*$sql ="SELECT * FROM personas WHERE	ID_Personas = '".$cualMail[4]."';";
			$que = "[Participantes][".$fecha."] - Se ha enviado el mail a ".$cualMail[2]." ".$cualMail[3]." (".$cualMail[0].") a ".$dir;
			//echo $sql." - ";
			$rs = mysql_query($sql, $con);
			if($row = mysql_fetch_array($rs)){
				$update = "UPDATE personas SET cartasEnviadas = '".$row["cartasEnviadas"]."<br />".$que."' WHERE ID_Personas = '".$cualMail[4]."';";
				//echo $update."<br />";
				$rs = mysql_query($update, $con);
			}*/
}
if ($err!=1) {
	$_SESSION["realizoEnvio"] = true;
	header("Location: evaluadores.php");
}
?>

