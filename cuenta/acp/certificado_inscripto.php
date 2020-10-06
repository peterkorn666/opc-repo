<?php
session_start();
/*if(empty($_SESSION["id_tl"])){
	header("Location: ../");
	die();
}*/
header('Content-Type: text/html; charset=UTF-8');
require("../../opc/abstract/conexion.php");
$db = conectaDb();
$inscripto = $db->prepare("SELECT id, nombre, apellido FROM inscriptos WHERE id=?");
$inscripto->bindValue(1, base64_decode($_GET["t"]));
$inscripto->execute();
$row = $inscripto->fetch();

if($row === false){
	die();
}

require("../../opc/class/fpdf.php");
require('../../opc/class/html2pdf.php');

$rem = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;");
$to = array("á", "é", "í", "ó","ú", "Á", "É", "Í", "Ó","Ú");

setlocale(LC_ALL,'es_ES');
$pdf=new PDF_HTML();
$pdf->SetFont('Arial','',12);
$pdf->AddPage('L', 'A4');
//$pdf->WriteHTML($html);
$rem = array("<b>","<strong>","<i>", "</b>", "</strong>", "</i>");
$to = array("");
$pdf->Image('certificado_participante.jpg',0,0,297,210,'JPG');

$pdf->Ln(95);
$pdf->ALIGN = 'center';
$pdf->SetFontSize(28);
$pdf->WriteHTML(utf8_decode($row["nombre"]." ".$row["apellido"]));
//$pdf->MultiCell(280, 6, $parsed, 1, 'C');


$pdf->Output();
?>