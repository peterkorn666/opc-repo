<?php
session_start();
/*if(empty($_SESSION["id_tl"])){
	header("Location: ../");
	die();
}*/
header('Content-Type: text/html; charset=UTF-8');
require("../../opc/abstract/conexion.php");
$db = conectaDb();
$trabajo = $db->prepare("SELECT id_trabajo, numero_tl, area_tl, titulo_tl, fecha_creado, tipo_tl FROM trabajos_libres WHERE id_trabajo=?");
$trabajo->bindValue(1, base64_decode($_GET["t"]));
$trabajo->execute();
$row = $trabajo->fetch();

$autor = $db->prepare("SELECT * FROM personas_trabajos_libres WHERE ID_Personas=?");
$autor->bindValue(1, base64_decode($_GET["k"]));
$autor->execute();
if($autor->rowCount()==0)
	die();
$autor = $autor->fetch();

//Institucion
$ins = array();
if($autor["Institucion"])
{
	$ins = $db->prepare("SELECT * FROM instituciones WHERE ID_Instituciones=?");
	$ins->bindValue(1, $autor["Institucion"]);
	$ins->execute();
	$ins = $ins->fetch();
}
//Pais
$pais = array();
if($autor["Pais"])
{
	$pais = $db->prepare("SELECT * FROM paises WHERE ID_Paises=?");
	$pais->bindValue(1, $autor["Pais"]);
	$pais->execute();
	$pais = $pais->fetch();
}

$a = array();
if($row["area_tl"]){
	$area = $db->prepare("SELECT * FROM areas_trabjos_libres WHERE id=?");
	$area->bindValue(1, $row["area_tl"]);
	$area->execute();
	$a = $area->fetch();
}
require("../../opc/class/fpdf.php");
require('../../opc/class/html2pdf.php');

$rem = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;");
$to = array("á", "é", "í", "ó","ú", "Á", "É", "Í", "Ó","Ú");

setlocale(LC_ALL,'es_ES');
$pdf=new PDF_HTML();
$pdf->SetFont('Arial','',12);
$pdf->AddPage();
//$pdf->WriteHTML($html);
$rem = array("<b>","<strong>","<i>", "</b>", "</strong>", "</i>");
$to = array("");
$pdf->Image('http://alas2017.easyplanners.info/imagenes/logopdf.png',60,10,90,0,'PNG');
$pdf->Ln(10);
$pdf->Write(90,'Montevideo, 07 de Abril del 2017');//strftime("%d de %B del %Y",strtotime($row["fecha_creado"])));
$pdf->Ln(10);
$pdf->Write(90,'Estimado/a '.utf8_decode($autor["Nombre"]." ".$autor["Apellidos"]." ".$autor["Apellidos2"]));
$pdf->Ln(5);
$pdf->Write(90,utf8_decode($pais["Pais"]));
$pdf->Ln(5);
$pdf->Write(90,'Presente');
$pdf->Ln(60);
$pdf->Write(6,utf8_decode('Nos es grato informarle que su propuesta de resumen de ponencia  titulada: '));
$pdf->Ln(10);
$pdf->MultiCell(190,6,str_replace($rem,$to,utf8_decode(html_entity_decode($row["titulo_tl"]))),0,'C');
$pdf->Ln(5);
$pdf->MultiCell(190,6,utf8_decode($ins["Institucion"]),0,'C');
$pdf->Ln(10);
$pdf->Write(6,utf8_decode('ha sido aceptada en el GT "'.html_entity_decode($a["Area_es"]).'" para participar del XXXI Congreso de la Asociación Latinoamericana de Sociología, a realizarse entre el 3 y el 8 de diciembre de 2017 en la ciudad de Montevideo.'));
$pdf->Ln(20);
$pdf->Write(1, utf8_decode('Agradeciendo su valiosa participación, saluda atentamente,'));
$pdf->Ln(6);
$pdf->Ln(15);
$pdf->Image('firma.jpg',NULL,NULL,180,0,'JPG');

$pdf->Output();
?>