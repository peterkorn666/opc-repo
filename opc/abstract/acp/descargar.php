<?php
session_start();
/*if(empty($_SESSION["id_tl"])){
	header("Location: ../");
	die();
}*/

header('Content-Type: text/html; charset=UTF-8');
require("../conexion.php");
$db = conectaDb();
$config = $db->query("SELECT * FROM config WHERE id=1")->fetch();
$trabajo = $db->prepare("SELECT id_trabajo, numero_tl, area_tl, titulo_tl, fecha_creado, tipo_tl FROM trabajos_libres WHERE id_trabajo=?");
$trabajo->bindValue(1, base64_decode($_GET["t"]));
$trabajo->execute();
$row = $trabajo->fetch();

//Get Autor
$sqlAutor = $db->prepare("SELECT * FROM personas_trabajos_libres WHERE ID_Personas=?");
$sqlAutor->bindValue(1, base64_decode($_GET["k"]));
$sqlAutor->execute();
$autor = $sqlAutor->fetch();

$a = array();
if($row["area_tl"]){
	$area = $db->prepare("SELECT * FROM areas_trabjos_libres WHERE id=?");
	$area->bindValue(1, $row["area_tl"]);
	$area->execute();
	$a = $area->fetch();
}
//Institucion
$ins = array();
if($autor["Institucion"])
{
	$ins = $db->prepare("SELECT * FROM instituciones WHERE ID_Instituciones=?");
	$ins->bindValue(1, $autor["Institucion"]);
	$ins->execute();
	$ins = $ins->fetch();
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
$pdf->Image($config["banner_congreso"],30,10,150,0,'PNG');
$pdf->Ln(10);
$pdf->Write(90,'Montevideo, '.strftime("%d de %B del %Y", strtotime($row["fecha_creado"])));
$pdf->Ln(20);
$pdf->Write(90,'Por intermedio de la presente se deja constancia que:');
$pdf->Ln(48);
$pdf->Cell(190,10,utf8_decode($autor["Profesion"]." ".$autor["Nombre"]." ".$autor["Apellidos"]),0,1,'C');
if($row["tipo_tl"]=="1")
	$pdf->Write(10,utf8_decode('presentó el resumen de la ponencia titulada:'));
else
	$pdf->Write(10,utf8_decode('presentó el resumen de la mesa redonda titulado:'));
$pdf->Ln(10);
$pdf->SetFont('Arial','BI',12);
//$pdf->MultiCell(190,6,utf8_decode(html_entity_decode($row["titulo_tl"])),0,'C');
$titulo_tl = utf8_decode(html_entity_decode($row["titulo_tl"]));
$titulo_tl = str_replace("&ldquo;", "", $titulo_tl);
$titulo_tl = str_replace("&rdquo;", "", $titulo_tl);
$pdf->WriteHTML($titulo_tl);
$pdf->SetFont('Arial','',12);
$pdf->Ln(5);
$pdf->MultiCell(190,6,utf8_decode($ins["Institucion"]),0,'C');
/*if($row["tipo_tl"]=="1"){
	$pdf->Ln(10);
	$pdf->Write(1, utf8_decode('para ser evaluada por los Coordinadores del Grupo de Trabajo Nº: '));
	$pdf->Ln(6);
	$pdf->MultiCell(190,6,utf8_decode(html_entity_decode($a["Area_es"])),0,'C');
}*/
$pdf->Ln(15);
$pdf->Write(1, utf8_decode('Se expide esta nota a pedido del interesado para ser presentado ante quién corresponda.'));
$pdf->Ln(30);
$pdf->Image('firma.jpg',35,180,140,0,'JPG');
/*$pdf->Ln(20);
$pdf->Cell(190,5, utf8_decode('Dra. Ana Rivoir'),0,1,'C');
$pdf->Ln(1);
$pdf->Cell(190,5, utf8_decode('Vice Presidenta'),0,1,'C');
$pdf->Ln(1);
$pdf->Cell(190,5, utf8_decode('Asociación Latinoamericana de Sociología'),0,1,'C');*/
$pdf->Output("I", str_replace($rem,$to,utf8_decode(html_entity_decode("Constancia de Presentaci&oacute;n de ponencia - FEPAL 2020_".$row["numero_tl"]."_".$autor["Nombre"]."_".$autor["Apellidos"].".pdf"))));
?>