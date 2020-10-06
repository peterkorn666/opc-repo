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

$autor = $db->prepare("SELECT * FROM personas_trabajos_libres WHERE ID_Personas=?");
$autor->bindValue(1, base64_decode($_GET["k"]));
$autor->execute();
if($autor->rowCount()==0)
	die();
$autor = $autor->fetch();

$autores = $db->prepare("SELECT * FROM personas_trabajos_libres p JOIN trabajos_libres_participantes l ON l.ID_participante = p.ID_Personas WHERE l.ID_trabajos_libres = ?");
$autores->bindValue(1, base64_decode($_GET["t"]));
$autores->execute();
$autores = $autores->fetchAll(PDO::FETCH_ASSOC);

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

$arrayPersonas = array();
$arrayInstituciones = array();
$gestionAutores = "";

foreach($autores as $autor2)
{	
	array_push($arrayPersonas, array(
		"institucion" => $autor2["Institucion"], 
		"apellido" => $autor2["Apellidos"], 
		"nombre" => $autor2["Nombre"]
	));
	array_push($arrayInstituciones, $autor2["Institucion"]);
}

//Unifcacion Instituciones
$arrayInstitucionesUnicas =  array_values(array_unique($arrayInstituciones));

$arrayInstitucionesUnicasNuevaClave = array();
if(count($arrayInstitucionesUnicas)>0){
	foreach ($arrayInstitucionesUnicas as $u){
		if($u!=""){
			array_push($arrayInstitucionesUnicasNuevaClave, $u);
		}
	}
}

$autoreInscriptos = "";
$h = 0;
foreach($arrayPersonas as $persona){
	if($persona["institucion"]!=""){
		$claveIns = (array_search($persona["institucion"], $arrayInstitucionesUnicasNuevaClave)) + 1;
	}else{
		$claveIns = "";
	}

	$gestionAutores .= $persona["nombre"]." ".$persona["apellido"];
	
	$gestionAutores .= $claveIns;
	
	$gestionAutores .= "; ";
/*	if($h==5){
		$gestionAutores .= "<b";
	}*/
	$h++;
}
$gestionAutores = trim($gestionAutores, '; ');
$gestionIntituciones = '';
for ($i=0; $i < count($arrayInstitucionesUnicasNuevaClave); $i++){
	$ins = $db->prepare("SELECT * FROM instituciones WHERE ID_Instituciones=?");
	$ins->bindValue(1, $arrayInstitucionesUnicas[$i]);
	$ins->execute();
	$ins = $ins->fetch();
	
	
	$gestionIntituciones .=  ($i+1) . " - " . $ins["Institucion"] . "; ";
}
$gestionIntituciones = trim($gestionIntituciones, "; ");
require("../../class/fpdf.php");
require('../../class/html2pdf.php');

$rem = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;");
$to = array("á", "é", "í", "ó","ú", "Á", "É", "Í", "Ó","Ú");

setlocale(LC_ALL,'es_ES');
$pdf=new PDF_HTML();
$pdf->SetFont('Arial','',12);
$pdf->AddPage('L', 'A4');
//$pdf->WriteHTML($html);
$rem = array("<b>","<strong>","<i>", "</b>", "</strong>", "</i>");
$to = array("");
if($row["tipo_tl"] == 1){
	$pdf->Image('certificado_trabajo.jpg',0,0,297,210,'JPG');
}else{
	$pdf->Image('certificado_panel.jpg',0,0,297,210,'JPG');
}

$pdf->Ln(65);
$pdf->SetFontSize(18);
$pdf->MultiCell(280, 6, utf8_decode($autor["Nombre"]." ".$autor["Apellidos"]), 0, 'C');
$pdf->Ln(15);
$pdf->SetFontSize(14);
$pdf->MultiCell(280, 6, str_replace($rem,$to,utf8_decode(html_entity_decode($row["titulo_tl"]))), 0, 'C');
$pdf->Ln(5);
$pdf->ALIGN = 'center';
$pdf->SetXY(60, 114);
$pdf->SetFontSize(10);
$pdf->MultiCell(180, 6, utf8_decode(html_entity_decode($gestionAutores)), 0, 'C');
$pdf->SetFontSize(8);
$pdf->SetXY(60, 132);
$pdf->MultiCell(180, 4, utf8_decode(html_entity_decode($gestionIntituciones)), 0, 'C');


$pdf->Output("I", str_replace($rem,$to,utf8_decode(html_entity_decode("Certificacion - FEPAL 2020_".$row["numero_tl"]."_".$autor["Nombre"]."_".$autor["Apellidos"].".pdf"))));
?>