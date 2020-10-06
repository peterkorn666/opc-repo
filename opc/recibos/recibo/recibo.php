<?php
session_start();
/*if(empty($_SESSION["id_tl"])){
	header("Location: ../");
	die();
}*/
error_reporting(E_ALL);
header('Content-Type: text/html; charset=UTF-8');
require("conexion.php");
require("class/phpmailer.class.php");
require("class/class.smtp.php");
$db = conectaDb();
/* Busqueda de recibo en BD con id de recibo por GET */
$trabajo = $db->prepare("SELECT * FROM inscriptos_recibo WHERE id=?");
$trabajo->bindValue(1, base64_decode($_GET["k"]));
$trabajo->execute();
$row = $trabajo->fetch();
/* Busqueda de la persona a quien va dirigido el recibo en BD con el id del inscripto tomado del mismo recibo */
/*$inscripto = $db->prepare("SELECT * FROM inscriptos WHERE id=?");
$inscripto->bindValue(1, $row["id_inscripto"]);
$inscripto = $inscripto->execute();*/

$config = $db->query("SELECT * FROM config WHERE id=1;")->fetch();
require("class/fpdf.php");
require('class/html2pdf.php');

$rem = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;");
$to = array("á", "é", "í", "ó","ú", "Á", "É", "Í", "Ó","Ú");
setlocale(LC_ALL,'es_ES');
$pdf=new PDF_HTML();
$pdf->SetFont('Arial','',12);
$pdf->AddPage();
//$pdf->WriteHTML($html);
$pdf->Image('recibo.jpg', 0, 0, 210, 270);
$pdf->Ln(10);
if ($row["numero_recibo"] != ''){
	$pdf->Text(180, 42, str_pad($row["numero_recibo"], 4, 0, STR_PAD_LEFT));
}
else {
	$pdf->Text(180, 42, str_pad($row["id"], 4, 0, STR_PAD_LEFT));
}
$fecha = explode("-",$row["fecha"]);
$pdf->Text(155, 61, $fecha[2]);
$pdf->Text(172, 61, $fecha[1]);
$pdf->Text(186, 61, $fecha[0]);
$pdf->Text(12, 79, utf8_decode($row["recibo_a"]));
$pdf->Text(12, 104, $row["direccion"]);
$pdf->Text(18, 130, "1");
$pdf->Text(29, 130, "Registro ALAS");
//$importe = number_format($row["importe"], 2, ",");
$pdf->Text(168, 130, 'U$S '.(float)$row["importe"]);
$pdf->Text(168, 148, 'U$S '.(float)$row["importe"]);
$pdf->Text(168, 155, 'U$S '.(float)$row["descuento"]);
//'<strong>U$S '.((int)$row["importe"]-(int)$row["descuento"]) . '</strong>';
$total = ((float)$row["importe"]-(float)$row["descuento"]);
$pdf->Text(168, 161, 'U$S '.$total);
$pdf->Ln(161);
$pdf->Write(5, $row["comentarios"]);


if ($_GET["enviar"]==1) {
	$pdf->Output("F","pdf/".$row["id"].".pdf");
	$asunto = "[".$row["numero_recibo"]."] [".$row["recibo_a"]."] ".$config["nombre_congreso"] . " - Recibo ";
	unset($mails_congreso);
	
	$mails_congreso[] = $row['email'];
	$mails_congreso[] = "register@easyplanners.com";
	$mails_congreso[] = "2017alas@gmail.com";
	//$mails_congreso[] = "p.ferrari@easyplanners.com";
	//$mails_congreso[] = "gegamultimedios@gmail.com";
	
	$html = '<div style="width:700px">';
		$html .= '<img src="https://www.easyplanners.net/alas/inscriptos/recibo/banner.png">';
		$html .= '<br><br>';
		$html .= 'Estimado/a '.$row["recibo_a"].',<br><br>Adjunto encontrará su recibo. ';
		$html .= 'N&uacute;mero de recibo:<strong> '.$row["numero_recibo"].'</strong> por el importe de U$S '.$total;
	$html .= '</div>';
	
	$mailOBJ = new PHPMailer();
	$mailOBJ->Body = $html;
	$mailOBJ->Subject = $asunto;
	
	$mailOBJ->CharSet = "utf-8";
	$mailOBJ->FromName = $config["nombre_congreso"];
	$mailOBJ->IsHTML(true);
	
	$mailOBJ->Timeout=120;
	//
	
	$mailOBJ->AddAttachment("pdf/".$row["id"].".pdf",
                         "Recibo ALAS 2017.pdf");
	
	$mailOBJ->IsSMTP();
	$mailOBJ->SMTPDebug  = false;
	//$mailOBJ->SMTPDebug  = true;
	$mailOBJ->SMTPAuth   = true;
	$mailOBJ->SMTPAutoTLS = false;
	$mailOBJ->SMTPSecure = true;
	

	$mailOBJ->Host       = "smtp.gmail.com";
	$mailOBJ->Username   = "register@easyplanners.com";	
	$mailOBJ->Password   = "F5Register2159";	
	 
	$mailOBJ->Port = 465;
	//$mailOBJ->From = "gega@easyplanners.net";
	$mailOBJ->From = "register@easyplanners.com";
	//$mailOBJ->addReplyTo("register@easyplanners.com",'Contacto - ' . $config["nombre_congreso"]);
	
	foreach($mails_congreso as $cualMail){
		
		$mailOBJ->ClearAddresses();
		$mailOBJ->AddAddress($cualMail);
	
		if(!$mailOBJ->Send()){
			echo "<script>alert('Ocurrio un error al enviar el abstract');</script>";
		}
		else
			echo "<p align='center'>El email se envio correctamente.</p>";
	}
	
	unlink("pdf/".$row["id"].".pdf");
	
	//echo "<p align='center'>El email se envio correctamente.</p>";
}else{
	$pdf->Output();
}
?>