<?php
if(empty($_GET["conf"])){
	header("Location: ../../");die();	
}

session_start();

header('Content-Type: text/html; charset=UTF-8');
require("../../class/core.php");
$core = new Core();
$config = $core->getConfig();

//Conferencista
$conferencista = $core->getConferencistaID($_GET["conf"]);
if(count($conferencista) == 0){
	
	header("Location: ../../");die();
}

//Registro
$tiempo = new DateTime("now", new DateTimeZone("America/Montevideo"));
$fecha = $tiempo->format('Y-m-d H:i:s');

$core->bind("conferencista_id", (int)$conferencista["id_conf"]);
$core->bind("tipo", 2);
$core->bind("calidad", 'asistente');
$core->bind("fecha_descargado", $fecha);

if($_SESSION["admin"]){
	
	$core->bind("admin", 1);
	$core->query("INSERT INTO certificados_registro (conferencista_id, tipo, calidad, fecha_descargado, admin) VALUES (:conferencista_id, :tipo, :calidad, :fecha_descargado, :admin)");
} else {
	
	$core->query("INSERT INTO certificados_registro (conferencista_id, tipo, calidad, fecha_descargado) VALUES (:conferencista_id, :tipo, :calidad, :fecha_descargado)");
}


require("../../class/fpdf.php");
require('../../class/html2pdf.php');

$rem = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;");
$to = array("á", "é", "í", "ó","ú", "Á", "É", "Í", "Ó","Ú");
setlocale(LC_ALL,'es_ES');
$pdf=new PDF_HTML();
$pdf->AddPage('L', 'A4');
$pdf->AddFont('Candara-Bold', 'b', 'candarab.php');
$pdf->AddFont('Candara-Bold-Italic', 'bi', 'candarabi.php');

$pdf->Image('../certificado.jpg', 0, 0, 297, 209);

$pdf->SetFont('Candara-Bold-Italic', 'BI', 24);

$pdf->SetXY(59, 86);
//$pdf->Cell(180,15, strtoupper(utf8_decode($conferencista["profesion"]." ".$conferencista["nombre"]." ".$conferencista["apellido"])), 0, 1, 'C');
$pdf->Cell(180,15, utf8_decode($conferencista["profesion"]." ".$conferencista["nombre"]." ".$conferencista["apellido"]), 0, 1, 'C');

$pdf->SetFont('Candara-Bold', 'B', 20);

$pdf->SetXY(59, 120);
$pdf->Cell(180, 6, 'ASISTENTE', 0, 1, 'C');

/*$pdf->Image($config["banner_congreso"],60,5,180,0,'PNG');
$pdf->Ln(45);

$pdf->SetFont('Arial','',10);
$pdf->SetX(65);
$pdf->Cell(160, 4, "Se deja constancia que:", 0, 1, 'C');
$pdf->SetFont('Arial','',24);
$pdf->SetX(65);
$pdf->Cell(160,15,utf8_decode($conferencista["profesion"]." ".$conferencista["nombre"]." ".$conferencista["apellido"]),0,1,'C');
$pdf->SetFont('Arial','', 10);
$pdf->SetX(65);
$pdf->Cell(160, 4, utf8_decode('Participó en calidad de ASISTENTE en estos Congresos.'), 0, 1, 'C');
$pdf->Ln(30);
$pdf->Image('../firma1.jpg', 65, 107, 70, 0, 'JPG');
$pdf->Image('../firma2.jpg', 155, 89, 50, 0, 'JPG');
$pdf->Ln(45);
$pdf->SetX(65);
$pdf->Cell(160, 5, 'Auspicios:');
$pdf->Ln(10);
$pdf->SetX(65);
$pdf->Cell(160, 10, "INAU - MIDES - MINTUR - MININTERIOR - APU - APPIA - CPU - SPU - AUPCV - FUPSI", 0, 1, 'C');*/

$pdf->Output("I", str_replace($rem,$to,utf8_decode(html_entity_decode("Constancia - AUDEPP-FLAPPSIP 2019.pdf"))));
?>