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

$autores = $db->prepare("SELECT * FROM personas_trabajos_libres p JOIN trabajos_libres_participantes l ON l.ID_participante = p.ID_Personas WHERE l.ID_trabajos_libres = ?");
$autores->bindValue(1, base64_decode($_GET["t"]));
$autores->execute();
$autores = $autores->fetchAll(PDO::FETCH_ASSOC);

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

$arrayPersonas = array();
$arrayInstituciones = array();
$gestionAutores = "";

foreach($autores as $autor2)
{
    if($autor2["Institucion"] == "Otra"){
        $txt_institucion = $autor2["Institucion_otro"];
    } else {
        $txt_institucion = $autor2["Institucion"];
    }
	array_push($arrayPersonas, array(
		"institucion" => $txt_institucion,
		"apellido" => $autor2["Apellidos"], 
		"nombre" => $autor2["Nombre"]
	));
	array_push($arrayInstituciones, $txt_institucion);
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
$sqlRegistro->bindValue(4, 'ponente', PDO::PARAM_STR);
$sqlRegistro->bindValue(5, $fecha);
$sqlRegistro->execute();

require("../../class/fpdf.php");
require('../../class/html2pdf.php');

$rem = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;");
$to = array("á", "é", "í", "ó","ú", "Á", "É", "Í", "Ó","Ú");
setlocale(LC_ALL,'es_ES');
$pdf=new PDF_HTML();
$pdf->SetFont('Arial','',12);
$pdf->AddPage('L', 'A4');
$pdf->AddFont('Candara-Bold', 'b', 'candarab.php');
$pdf->AddFont('Candara-Bold-Italic', 'bi', 'candarabi.php');

$pdf->Image('certificado_trabajo.jpg', 0, 0, 297, 209);

$pdf->SetXY(59, 86);
$pdf->SetFont('Candara-Bold-Italic', 'BI', 24);
//$pdf->Cell(180,15, strtoupper(utf8_decode($autor["Profesion"]." ".$autor["Nombre"]." ".$autor["Apellidos"])), 0, 1, 'C');
$pdf->Cell(180,15, utf8_decode($autor["Profesion"]." ".$autor["Nombre"]." ".$autor["Apellidos"]), 0, 1, 'C');

$pdf->SetXY(62, 120);
$pdf->SetFont('Candara-Bold-Italic', 'BI', 12);
$pdf->MultiCell(174, 6, str_replace($rem,$to,iconv('UTF-8', 'windows-1252', html_entity_decode($row["titulo_tl"]))), 0, 'C');
//$pdf->Ln(4);

$pdf->SetX(62);
$pdf->SetFont('Candara-Bold', 'B', 8);
$pdf->MultiCell(174, 6, iconv('UTF-8', 'windows-1252', $gestionAutores), 0, 'C');

$pdf->SetX(62);
$pdf->SetFontSize(8);
$pdf->MultiCell(174, 4, iconv('UTF-8', 'windows-1252', $gestionIntituciones), 0, 'C');

/*$pdf->Image($config["banner_congreso"],60,5,180,0,'PNG');
$pdf->Ln(30);
//$pdf->WriteHTML($html);
$pdf->SetFont('Arial','',10);
$pdf->SetX(65);
$pdf->Cell(160, 4, "Se deja constancia que:", 0, 1, 'C');
$pdf->SetFont('Arial','',24);
$pdf->SetX(65);
$pdf->Cell(160,15,utf8_decode($autor["Profesion"]." ".$autor["Nombre"]." ".$autor["Apellidos"]),0,1,'C');
$pdf->SetFont('Arial','', 10);
$pdf->Ln(3);
$pdf->SetX(65);
if($row["tipo_tl"]=="1")
	$pdf->Cell(160, 4, utf8_decode('presentó el resumen de la ponencia titulada:'), 0, 1, 'C');
else
	$pdf->Cell(160, 4, utf8_decode('presentó el resumen del taller titulado:'), 0, 1, 'C');
	
$pdf->Ln(3);
$pdf->SetFont('Arial','BI',12);
$pdf->SetX(65);
$pdf->MultiCell(160, 6, str_replace($rem,$to,iconv('UTF-8', 'windows-1252', html_entity_decode($row["titulo_tl"]))), 0, 'C');
$pdf->SetFont('Arial','',12);

$pdf->Ln(10);

$pdf->SetFontSize(10);
$pdf->SetX(65);
$pdf->MultiCell(160, 6, iconv('UTF-8', 'windows-1252', $gestionAutores), 0, 'C');
$pdf->SetFontSize(8);
$pdf->SetX(65);
$pdf->MultiCell(160, 4, iconv('UTF-8', 'windows-1252', $gestionIntituciones), 0, 'C');
$pdf->Ln(2);

//$pdf->Image('firma.jpg', 65, 105, 190, 0, 'JPG');
$pdf->Image('firma1.jpg', 65, 120, 65, 0, 'JPG');
$pdf->Image('firma2.jpg', 155, 105, 45, 0, 'JPG');
$pdf->Ln(65);
$pdf->SetFontSize(10);
$pdf->SetX(65);
$pdf->Cell(160, 5, 'Auspicios:');
$pdf->Ln(5);
$pdf->SetX(65);
$pdf->Cell(160, 5, "INAU - MIDES - MINTUR - MININTERIOR - APU - APPIA - CPU - SPU - AUPCV - FUPSI", 0, 1, 'C');*/

$pdf->Output("I", str_replace($rem,$to,utf8_decode(html_entity_decode("Presentaci&oacute;n - FEPAL 2020_".$row["numero_tl"]."_".$autor["Nombre"]."_".$autor["Apellidos"].".pdf"))));
?>