<?php
require("../class/core.php");
require("../class/util.class.php");
require("../class/templates.opc.php");
//header("content-type: application/xml; charset=UTF-8");
//header('Content-Disposition: attachment; filename="programaDiaSalaHora.xml"');
$util = new Util();
//$util->isLogged();
$core = new Core();
$config = $core->getConfig();
$templates = new templateOPC();

function html($txt){
	return "&lt;$txt&gt";
}

function limpiar($html){
	
		$acutes = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&ntilde;", "&Ntilde;", "&ndash;", "&nbsp;", "&ldquo;", "&rdquo;", "&reg;", "&plusmn;", "&ouml;", "&Ouml;", "&ge;", "&deg;", "&mu;", "&le;", "&ccedil;", "&Ccedil;", "&atilde;", "&Atilde;", "&auml;", "&Auml;", "&lsquo;", "&rsquo;", "&micro;", "&ordm;", "&ensp;", "&egrave;", "&Egrave;", "&copy;", "&-deg;", "&uuml;", "&Uuml;", "&sup3;", "&iquest;", "&shy;", "&ordf;", "&igrave;", "&acute;");
	$tildes = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "Ñ", "–", " ", '"', '"', "®", "±", "ö", "Ö", "≥", "º", "μ", "≤", "ç", "Ç", "ã", "Ã", "ä", "Ä", "'", "'", "µ", "º", " ", "è", "È", "©", "º", "ü". "Ü", "³", "¿", "", "ª", "Ì", "´");
	$html = str_replace($acutes, $tildes, $html);
	
	
	$rem = array("&lt;","&gt;","&","&amp;nbsp;");
	$to = array("&amp;lt;","&amp;gt;", "&amp;amp;","");
	$html = str_replace($rem, $to, $html);
	return $html;
}

//Trabajos ordenados por dia, sala, hora, area, numero
$trabajos = $core->query("SELECT t.id_trabajo, t.titulo_tl, t.numero_tl, t.resumen, t.resumen2, t.resumen3, t.resumen4, t.resumen5, c.id_crono, c.titulo_actividad FROM trabajos_libres t LEFT JOIN cronograma c ON t.id_crono=c.id_crono WHERE t.contacto_mail<>'gegamultimedios@gmail.com' AND t.estado=2 ORDER BY SUBSTRING(c.start_date,1,10), c.section_id, SUBSTRING(c.start_date,12,5), c.id_crono, t.area_tl, t.orden, t.numero_tl");

echo html('?xml version="1.0" encoding="utf-8"?');
echo html("root");

$titulo_actividad_ = "";

foreach($trabajos as $trabajo):

	//TITULO ACTIVIDAD
	if($trabajo["titulo_actividad"] != $titulo_actividad_){
		if ($titulo_actividad_ != "") echo "###";
		echo html("titulo_actividad").limpiar($trabajo["titulo_actividad"]).html("/titulo_actividad").BR;
		//CONFERENCISTAS
		$getCronoConf = $core->getCronoConferencistas($trabajo["id_crono"]);
		if(count($getCronoConf)>0)
		echo html("conferencistas");
		foreach($getCronoConf as $cronoConf):
			$getConf = $core->getConferencistaID($cronoConf["id_conf"]);
			$getRol = $core->getRolID($cronoConf["en_calidad"]);
			$txt = "";
			if($cronoConf["titulo_conf"])
				$txt .= html("conferencista_titulo").limpiar($cronoConf["titulo_conf"]).html("/conferencista_titulo").BR;
			if($templates->hiddenConf($getConf["nombre"],$getConf["apellido"]))
			{
				if($getRol["calidad"])
					$txt .= html("conferencista_calidad").$getRol["calidad"].":@@@".html("/conferencista_calidad");
				$txt .= html("conferencista").$getConf["nombre"]." ".$getConf["apellido"].html("/conferencista");
				if($getConf["institucion"])
					$txt .= html("conferencista_institucion")." - ".limpiar($core->getInstitution($getConf["institucion"])["Institucion"]).html("/conferencista_institucion");
				if($getConf["pais"] && $getConf["pais"]!=247)
					$txt .= html("conferencista_pais")." (".$core->getPais($getConf["pais"])["Pais"].")".html("/conferencista_pais");
				//Resumenes
				if($cronoConf["observaciones_conf"]){
					$txt .= BR.html("conferencista_resumen");
						$txt .= $cronoConf["observaciones_conf"];
					$txt .= html("/conferencista_resumen");
				}
			}
			
			echo $txt.BR;			
		endforeach;
		
		if(count($getCronoConf)>0)
		echo html("/conferencistas");
	}
	
	$txt = "";
	
	//TRABAJOS LIBRES
	echo BR.html("trabajos_libres");
	
		$txt .=  html("trabajo_titulo").limpiar($trabajo["titulo_tl"]).html("trabajo_numero")." (#".$trabajo["numero_tl"].")".html("/trabajo_numero"). html("/trabajo_titulo").BR;
		$txt .= html("trabajo_autores");
			$txt .= str_replace(array("<sup>","</sup>", "<i>", "</i>"),array("&lt;sup&gt;","&lt;/sup&gt;","&lt;autor_institucion&gt;", "&lt;/autor_institucion&gt;"),limpiar($templates->templateAutoresTL($trabajo)));
		$txt .= html("/trabajo_autores").BR;		

		$txt .= html("trabajo_resumen");
		
			if($trabajo["resumen"]){
				$txt .= "<b>Resumen en español:</b>".BR;
				$txt .= limpiar($trabajo["resumen"]).BR.BR;
			}
			
			if($trabajo["resumen2"]){
				$txt .= "<b>Resumen en Portugués:</b>".BR;
				$txt .= limpiar($trabajo["resumen2"]).BR.BR;
			}
			
			if($trabajo["resumen3"]){
				$txt .= "<b>Bibliografía:</b>".BR;
				$txt .= limpiar($trabajo["resumen3"]).BR.BR;
			}
			
			/*if($trabajo["resumen4"]){
				$txt .= "<b>Resultados:</b>".BR;
				$txt .= limpiar($trabajo["resumen4"]).BR.BR;
			}
			
			if($trabajo["resumen5"]){
				$txt .= "<b>Conclusiones:</b>".BR;
				$txt .= limpiar($trabajo["resumen5"]).BR.BR;
			}*/
			
		$txt .= html("/trabajo_resumen");
		echo $txt;
	
	echo html("/trabajos_libres");
	
	$titulo_actividad_ = $trabajo["titulo_actividad"];
endforeach;
echo '<br>';
echo html("/root");
?>