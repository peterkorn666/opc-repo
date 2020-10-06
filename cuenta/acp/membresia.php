<?php
session_start();
if(!isset($_SESSION['cliente']['id_cliente']) || !isset($_GET["c"])){
	header("Location: ../");
	die();
}
header('Content-Type: text/html; charset=UTF-8');
require("../../opc/abstract/conexion.php");
$db = conectaDb();
$config = $db->query("SELECT * FROM config WHERE id=1")->fetch();
$inscripto = $db->prepare("SELECT id, estado, nombre, apellido FROM inscriptos WHERE id_cuenta=?");
$inscripto->bindValue(1, base64_decode($_GET["c"]));
$inscripto->execute();
$row = $inscripto->fetch();
//var_dump($row);die();

require("../../opc/class/fpdf.php");
require('../../opc/class/html2pdf.php');

//$rem = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;");
//$to = array("á", "é", "í", "ó","ú", "Á", "É", "Í", "Ó","Ú");

setlocale(LC_ALL,'es_ES');
$pdf=new PDF_HTML();
$pdf->SetFont('Arial','',16);
$pdf->AddPage();
$pdf->Image('ALAS-Membresia.jpg', 0, 0, 210, 270);
$pdf->Ln(10);
$pdf->Cell(190, 205, utf8_decode($row["nombre"]." ".$row["apellido"]), 0, 0, 'C');

$pdf->Output("I",str_replace($rem,$to,utf8_decode(html_entity_decode("Certificado de Membres&iacute;a ALAS 2018-2019.pdf"))));
?>