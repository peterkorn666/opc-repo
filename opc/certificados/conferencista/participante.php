<?php
if(empty($_GET["conf"]) || empty($_GET["act"])){
	header("Location: ../../");die();
}

session_start();

header('Content-Type: text/html; charset=UTF-8');
require("../../class/core.php");
$core = new Core();
$config = $core->getConfig();


//Conferencista
$conferencista = $core->getConferencistaID($_GET["conf"]);
if (count($conferencista) == 0){
	
	header("Location: ../../");die();
}

//Actividad
$core->bind("id_crono", $_GET["act"]);
$core->bind("id_conf", $conferencista["id_conf"]);
$result_crono = $core->query("SELECT c.id_crono as id_crono, calconf.calidad_solo as calidad_conf, c.titulo_actividad as titulo_actividad FROM crono_conferencistas cc JOIN calidades_conferencistas calconf ON cc.en_calidad=calconf.ID_calidad JOIN cronograma c ON cc.id_crono=c.id_crono WHERE cc.id_crono = :id_crono AND cc.id_conf = :id_conf");
if(count($result_crono) == 0){
	
	header("Location: ../../");die();
}else
	$crono = $result_crono[0];
	
	
//Registro
$tiempo = new DateTime("now", new DateTimeZone("America/Montevideo"));
$fecha = $tiempo->format('Y-m-d H:i:s');

$core->bind("conf_id", $conferencista["id_conf"]);
$core->bind("crono_id", $crono["id_crono"]);
$core->bind("tipo", 2);
$core->bind("calidad", 'participante');
$core->bind("fecha", $fecha);

if($_SESSION["admin"]){
	
	$core->bind("admin", 1);
	$core->query("INSERT INTO certificados_registro (conferencista_id, crono_id, tipo, calidad, fecha_descargado, admin) VALUES (:conf_id, :crono_id, :tipo, :calidad, :fecha, :admin)");
} else {
	
	$core->query("INSERT INTO certificados_registro (conferencista_id, crono_id, tipo, calidad, fecha_descargado) VALUES (:conf_id, :crono_id, :tipo, :calidad, :fecha)");
}



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

$pdf->Image('../certificado.jpg', 0, 0, 297, 209);

$pdf->SetFont('Candara-Bold-Italic', 'BI', 24);

$pdf->SetXY(59, 86);
//$pdf->Cell(180,15, strtoupper(utf8_decode($conferencista["profesion"]." ".$conferencista["nombre"]." ".$conferencista["apellido"])), 0, 1, 'C');
$pdf->Cell(180,15, utf8_decode($conferencista["profesion"]." ".$conferencista["nombre"]." ".$conferencista["apellido"]), 0, 1, 'C');

$pdf->SetFont('Candara-Bold', 'B', 20);

$pdf->SetXY(59, 120);
$pdf->Cell(180, 6, strtoupper(iconv('UTF-8', 'windows-1252', $crono["calidad_conf"])), 0, 1, 'C');

/*$pdf->Image($config["banner_congreso"],60,5,180,0,'PNG');
$pdf->Ln(30);
//$pdf->WriteHTML($html);
$pdf->SetFont('Arial','',10);
$pdf->SetX(65);
$pdf->Cell(160, 4, "Se deja constancia que:", 0, 1, 'C');
$pdf->SetFont('Arial','',24);
$pdf->SetX(65);
$pdf->Cell(160,15,utf8_decode($conferencista["profesion"]." ".$conferencista["nombre"]." ".$conferencista["apellido"]),0,1,'C');
$pdf->SetFont('Arial','', 10);
$pdf->Ln(3);
$pdf->SetX(65);
$pdf->Cell(160, 4, utf8_decode('participó en la actividad titulada:'), 0, 1, 'C');
	
$pdf->Ln(3);
$pdf->SetFont('Arial','BI',12);

$pdf->SetX(65);
$pdf->MultiCell(160, 6, str_replace($rem,$to,iconv('UTF-8', 'windows-1252', html_entity_decode($crono["titulo_actividad"]))), 0, 'C');
$pdf->SetFont('Arial','',12);

$pdf->Ln(10);

$pdf->SetFontSize(10);
$pdf->SetX(65);
$pdf->Cell(160, 4, 'con el rol de', 0, 1, 'C');

$pdf->Ln(3);
$pdf->SetFontSize(12);
$pdf->SetX(65);
$pdf->MultiCell(160, 6, strtoupper(iconv('UTF-8', 'windows-1252', $crono["calidad_conf"])), 0, 'C');

$pdf->Image('../firma1.jpg', 65, 120, 65, 0, 'JPG');
$pdf->Image('../firma2.jpg', 155, 105, 45, 0, 'JPG');
$pdf->Ln(75);
$pdf->SetFontSize(10);
$pdf->SetX(65);
$pdf->Cell(160, 5, 'Auspicios:');
$pdf->Ln(5);
$pdf->SetX(65);
$pdf->Cell(160, 5, "INAU - MIDES - MINTUR - MININTERIOR - APU - APPIA - CPU - SPU - AUPCV - FUPSI", 0, 1, 'C');*/

$pdf->Output("I", str_replace($rem,$to,utf8_decode(html_entity_decode("Constancia - AUDEPP-FLAPPSIP 2019.pdf"))));
?>