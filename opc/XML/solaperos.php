<?php
require("../class/core.php");
require("../class/util.class.php");
require("../class/templates.opc.php");
$util = new Util();
//$util->isLogged();
$core = new Core();
$config = $core->getConfig();
$templates = new templateOPC();

function html($txt){
	return "&lt;$txt&gt;";
}

function limpiar($html){
	$rem = array("&lt;","&gt;","&","&amp;nbsp;");
	$to = array("&amp;lt;","&amp;gt;", "&amp;amp;","");
	$html = str_replace($rem, $to, $html);
	return $html;
}

function limpiarTodo($str){
		
	$acutes = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", 
					"&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", 
					"&ntilde;", "&Ntilde;", "&ndash;", "&nbsp;", "&ldquo;", 
					"&rdquo;", "&reg;", "&plusmn;", "&ouml;", "&Ouml;", 
					"&ge;", "&deg;", "&mu;", "&le;", "&ccedil;", 
					"&Ccedil;", "&atilde;", "&Atilde;", "&auml;", "&Auml;", 
					"&lsquo;", "&rsquo;", "&micro;", "&ordm;", "&ensp;", 
					"&egrave;", "&Egrave;", "&copy;", "&-deg;", "&uuml;", 
					"&Uuml;", "&sup3;", "&iquest;", "&shy;", "&ordf;", 
					"&igrave;", "&acute;", "&ocirc;", "&Ocirc;", "&Otilde;", 
					"&otilde;", "&ecirc;", "&Ecirc;", "&agrave;", "&Agrave;", 
					"&acirc;", "&Acirc;", "&iexcl;", "&icirc;", "&Icirc;", 
					"&laquo;", "&raquo;", "&hellip;");//"&laquo;", "&raquo;"
	$tildes = array("á", "é", "í", "ó", "ú", 
					"Á", "É", "Í", "Ó", "Ú", 
					"ñ", "Ñ", "–", " ", '"',
					'"', "®", "±", "ö", "Ö", 
					"≥", "º", "μ", "≤", "ç", 
					"Ç", "ã", "Ã", "ä", "Ä", 
					"'", "'", "µ", "º", " ", 
					"è", "È", "©", "º", "ü", 
					"Ü", "³", "¿", "", "ª", 
					"Ì", "´", "ô", "Ô", "Õ", 
					"õ", "ê", "Ê", "à", "À", 
					"â", "Â", "¡", "î", "Î", 
					"«", "»", "");// "«", "»"
	$str = str_replace($acutes, $tildes, $str);
	return $str;
}

//GET
$get = $_GET;

/*if(!$get["ti"])
	$tipo_inscripcion = 1;
else
	$tipo_inscripcion = $get["ti"];

$countInscriptosCongreso = $core->query("SELECT id FROM inscriptos WHERE tipo_inscripcion=".$tipo_inscripcion);*/

$countInscriptosCongreso = $core->query("SELECT id FROM inscriptos");

//def variables
$dia_ = "";
$sala_ = "";

if($get["limit"])
	$limit = "LIMIT ".$get["limit"];
else
	$limit = "";
	
$where = "WHERE 1=1";
if($get["tipo"])
	$where .= " AND tipo_inscripcion = ".$get["tipo"];

$html = "";

//traigo los inscriptos ordenados por congreso-jornada y luego alfabetico
$infoInscriptos = $core->query("SELECT id, nombre, apellido, institucion, ciudad 
									FROM inscriptos ".$where." 
									ORDER BY tipo_inscripcion, apellido ".$limit);
$helper = 0;

echo html('?xml version="1.0" encoding="utf-8"?')."<br>";
echo html("root");

if($get["tipo"] == '2')
	$contador = count($countInscriptosCongreso) + 1; //tipo=2 es jornada, debe continuar el orden de tipo=1(congreso)
else
	$contador = 1;
foreach($infoInscriptos as $inscripto):
	
	echo html("inscripto");
	//NOMBRE
		echo html("nombre").$inscripto["nombre"].html("/nombre").BR.PHP_EOL;
	
	//APELLIDO
		echo html("apellido").mb_strtoupper(limpiarTodo($inscripto["apellido"]), "UTF-8").html("/apellido").BR;
	
	//INSTITUCION
		echo html("institucion").$inscripto["institucion"].html("/institucion").BR;
	
	//CIUDAD
		echo html("ciudad").$inscripto["ciudad"].html("/ciudad").BR;
	
	//NÚMERO
		echo html("orden").$contador.html("/orden");
		
	echo html("/inscripto")."###";
	$contador++;
endforeach;
echo '<br>';
echo html("/root");
?>