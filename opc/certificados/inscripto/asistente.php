<?php
if(empty($_GET["insc"])){
	header("Location: ../../");die();	
}

session_start();

header('Content-Type: text/html; charset=UTF-8');
require("../../class/core.php");
$core = new Core();
$config = $core->getConfig();


//Conferencista
$core->bind("id", $_GET["insc"]);
$insc = $core->query("SELECT id, nombre, apellido FROM inscriptos WHERE id = :id");
if(count($insc) == 0){
	
	header("Location: ../../");die();
}
$inscripto = $insc[0];

//Registro
$tiempo = new DateTime("now", new DateTimeZone("America/Montevideo"));
$fecha = $tiempo->format('Y-m-d H:i:s');

$core->bind("inscripto_id", (int)$inscripto["id"]);
$core->bind("tipo", 3);
$core->bind("calidad", 'asistente');
$core->bind("fecha_descargado", $fecha);

if($_SESSION["admin"]){
	
	$core->bind("admin", 1);
	$core->query("INSERT INTO certificados_registro (inscripto_id, tipo, calidad, fecha_descargado, admin) VALUES (:inscripto_id, :tipo, :calidad, :fecha_descargado, :admin)");
} else {
	
	$core->query("INSERT INTO certificados_registro (inscripto_id, tipo, calidad, fecha_descargado) VALUES (:inscripto_id, :tipo, :calidad, :fecha_descargado)");
}


require("../../class/fpdf.php");
require('../../class/html2pdf.php');

$rem = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;");
$to = array("á", "é", "í", "ó","ú", "Á", "É", "Í", "Ó","Ú");
setlocale(LC_ALL,'es_ES');
$pdf=new PDF_HTML();
$pdf->SetFont('Arial','',12);
$pdf->AddPage('L', 'A4');

$pdf->Image($config["banner_congreso"],60,5,180,0,'PNG');
$pdf->Ln(45);
//$pdf->WriteHTML($html);
/*$pdf->Write(90,'Montevideo, '.strftime("%d de %B del %Y", strtotime($row["fecha_creado"])));
$pdf->Ln(20);*/

$pdf->SetFont('Arial','',10);
$pdf->SetX(65);
$pdf->Cell(160, 4, "Se deja constancia que:", 0, 1, 'C');
$pdf->SetFont('Arial','',24);
$pdf->SetX(65);
$pdf->Cell(160,15,utf8_decode($inscripto["nombre"]." ".$inscripto["apellido"]),0,1,'C');
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
$pdf->Cell(160, 10, "INAU - MIDES - MINTUR - MININTERIOR - APU - APPIA - CPU - SPU - AUPCV - FUPSI", 0, 1, 'C');

$pdf->Output("I", str_replace($rem,$to,utf8_decode(html_entity_decode("Constancia de Asistencia - AUDEPP-FLAPPSIP 2019.pdf"))));
?>