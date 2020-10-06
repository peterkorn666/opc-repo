<?php
require "../inc/inc_config.php";

$resultado = '';
$delimiter = "\n";

$directorio = "";
$rutaweb = "";
$listaArchivos= "";

$directorio = "../../adjuntos";
$rutaweb = "../" . "adjuntos";
$urlbase = "http://difusion.cce.org.uy/envios/adjuntos";

$listaArchivos1 = cargarArchivosDirectorio("adjuntos",$directorio,$rutaweb,$urlbase ,".jpg|.gif|.png");

$listaArchivos.=$listaArchivos1;


// Since TinyMCE3.x you need absolute image paths in the list...
// $abspath = preg_replace('~^/?(.*)/[^/]+$~', '/\\1', $_SERVER['SCRIPT_NAME']);


$resultado .= 'var tinyMCEImageList = new Array(';

$resultado .= $listaArchivos;
	
$resultado .= ');';

header('Content-type: text/javascript');

echo $resultado;
	
function cargarArchivosDirectorio($referencia,$directorio,$rutaweb,$urlbase ,$condicion="*") {
	$resultado="";
	if (is_dir($directorio)) {
		$direc = opendir($directorio);		
		while ($file = readdir($direc)) {
			if (!preg_match('~^\.~', $file) && preg_match('/' . $condicion. '/', $file)) { //omite directorios, archivos ocul
				if (is_file("$directorio/$file")) {
					$resultado .= $delimiter
						. '["'
						. utf8_encode($referencia . ": " . $file)
						. '", "'
						. utf8_encode("$urlbase/$file")
						. '"],';
				}
			}
		}
		$resultado = substr($resultado, 0, -1);
		$resultado .= $delimiter;
		closedir($direc);
	}
	return $resultado;
}
?>