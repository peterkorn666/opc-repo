<?php
session_start();
/*if(empty($_SESSION["id_tl"])){
	header("Location: ../");
	die();
}*/
header('Content-Type: text/html; charset=UTF-8');
require("../conexion.php");
$db = conectaDb();
$trabajo = $db->prepare("SELECT id_trabajo, numero_tl, area_tl, titulo_tl, fecha_creado, tipo_tl FROM trabajos_libres WHERE id_trabajo=?");
$trabajo->bindValue(1, base64_decode($_GET["t"]));
$trabajo->execute();
$row = $trabajo->fetch();
$a = array();
if($row["area_tl"]){
	$area = $db->prepare("SELECT * FROM areas_trabjos_libres WHERE id=?");
	$area->bindValue(1, $row["area_tl"]);
	$area->execute();
	$a = $area->fetch();
}
require("../../class/fpdf.php");
require('../../class/html2pdf.php');

$rem = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;");
$to = array("á", "é", "í", "ó","ú", "Á", "É", "Í", "Ó","Ú");

setlocale(LC_ALL,'es_ES');
$pdf=new PDF_HTML();
$pdf->SetFont('Arial','',12);
$pdf->AddPage();
//$pdf->WriteHTML($html);
$pdf->Image('http://alas2017.easyplanners.info/imagenes/logopdf.png',60,10,90,0,'PNG');
$pdf->Ln(10);
$pdf->Write(90,'Montevideo, '.strftime("%d de %B del %Y",strtotime($row["fecha_creado"])));
$pdf->Ln(20);
$pdf->Write(90,'Por intermedio de la presente se deja constancia que:');
$pdf->Ln(48);
$pdf->Cell(190,10,base64_decode($_GET["k"]),0,1,'C');
if($row["tipo_tl"]=="1")
	$pdf->Write(10,utf8_decode('presentó el resumen de la ponencia titulada:'));
else
	$pdf->Write(10,utf8_decode('presentó el resumen del panel titulado:'));
$pdf->Ln(10);
$pdf->MultiCell(190,6,utf8_decode(html_entity_decode($row["titulo_tl"])),0,'C');
$pdf->Ln(10);
$pdf->Write(1, utf8_decode('para ser evaluada por los Coordinadores del Grupo de Trabajo Nº: '));
$pdf->Ln(6);
$pdf->MultiCell(190,6,utf8_decode(html_entity_decode($a["Area_es"])),0,'C');
$pdf->Ln(15);
$pdf->Write(1, utf8_decode('Se expide esta nota a pedido del interesado para ser presentado ante quién corresponda.'));
$pdf->Ln(15);
$pdf->Image('firma.jpg',100,180,15,0,'JPG');
$pdf->Ln(20);
$pdf->Cell(190,5, utf8_decode('Dra. Ana Rivoir'),0,1,'C');
$pdf->Ln(1);
$pdf->Cell(190,5, utf8_decode('Vice Presidenta'),0,1,'C');
$pdf->Ln(1);
$pdf->Cell(190,5, utf8_decode('Asociación Latinoamericana de Sociolgía'),0,1,'C');
$pdf->Output();
?>