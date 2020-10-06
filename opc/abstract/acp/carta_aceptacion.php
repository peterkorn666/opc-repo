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

//Registro
$tiempo = new DateTime("now", new DateTimeZone("America/Montevideo"));
$fecha = $tiempo->format('Y-m-d H:i:s');

if($_SESSION["admin"]){
	
	$sqlRegistro = $db->prepare("INSERT INTO certificados_registro (trabajo_id, autor_id, tipo, calidad, fecha_descargado, admin) VALUES (?, ?, ?, ?, ?, ?)");
	$sqlRegistro->bindValue(6, 1, PDO::PARAM_INT);
} else {
	
	$sqlRegistro = $db->prepare("INSERT INTO certificados_registro (trabajo_id, autor_id, tipo, calidad, fecha_descargado) VALUES (?, ?, ?, ?, ?)");
}
$sqlRegistro->bindValue(1, $row["id_trabajo"], PDO::PARAM_INT);
$sqlRegistro->bindValue(2, $autor["ID_Personas"], PDO::PARAM_INT);
$sqlRegistro->bindValue(3, 1, PDO::PARAM_INT);
$sqlRegistro->bindValue(4, 'asistente', PDO::PARAM_STR);
$sqlRegistro->bindValue(5, $fecha);
$sqlRegistro->execute();

require("../../class/fpdf.php");
require('../../class/html2pdf.php');

$rem = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;");
$to = array("á", "é", "í", "ó","ú", "Á", "É", "Í", "Ó","Ú");
setlocale(LC_ALL,'es_ES');
$pdf=new PDF_HTML();
$pdf->AddPage('L', 'A4');
$pdf->AddFont('Candara-Bold', 'b', 'candarab.php');
$pdf->AddFont('Candara-Bold-Italic', 'bi', 'candarabi.php');

$pdf->Image('carta_aceptacion.jpg', 0, 0, 297, 209);

$pdf->SetFont('Candara-Bold-Italic', 'BI', 24);

$pdf->SetXY(59, 86);
//$pdf->Cell(180,15, strtoupper(utf8_decode($autor["Profesion"]." ".$autor["Nombre"]." ".$autor["Apellidos"])), 0, 1, 'C');
//$pdf->Cell(180,15, utf8_decode($autor["Profesion"]." ".$autor["Nombre"]." ".$autor["Apellidos"]), 0, 1, 'C');

$pdf->SetFont('Candara-Bold', 'B', 20);

$pdf->SetXY(59, 120);
//$pdf->Cell(180, 6, 'ASISTENTE', 0, 1, 'C');

/*$pdf->Image($config["banner_congreso"],60,5,180,0,'PNG');
$pdf->Ln(45);

$pdf->SetFont('Arial','',10);
$pdf->SetX(65);
$pdf->Cell(160, 4, "Se deja constancia que:", 0, 1, 'C');
$pdf->SetFont('Arial','',24);
$pdf->SetX(65);
$pdf->Cell(160,15,utf8_decode($autor["Profesion"]." ".$autor["Nombre"]." ".$autor["Apellidos"]),0,1,'C');
$pdf->SetFont('Arial','', 10);
$pdf->SetX(65);
$pdf->Cell(160, 4, utf8_decode('Participó en calidad de ASISTENTE en estos Congresos.'), 0, 1, 'C');
$pdf->Ln(30);
//$pdf->Image('firma.jpg', 65, 90, 190, 0, 'JPG');
$pdf->Image('firma1.jpg', 65, 107, 70, 0, 'JPG');
$pdf->Image('firma2.jpg', 155, 89, 50, 0, 'JPG');
$pdf->Ln(45);
$pdf->SetX(65);
$pdf->Cell(160, 5, 'Auspicios:');
$pdf->Ln(10);
$pdf->SetX(65);
$pdf->Cell(160, 10, "INAU - MIDES - MINTUR - MININTERIOR - APU - APPIA - CPU - SPU - AUPCV - FUPSI", 0, 1, 'C');*/


//$archivo_tl = ;

$pdf->Output("I", str_replace($rem,$to,utf8_decode(html_entity_decode("FEPAL2020_Carta_Aceptacion_".$row["numero_tl"]."_".$autor["Nombre"]."_".$autor["Apellidos"].".pdf"))));
?>