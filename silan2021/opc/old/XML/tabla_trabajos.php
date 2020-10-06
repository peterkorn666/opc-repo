<?php

function nodo($cual){

	$abre ="&lt;";
	$cierra = "&gt;";

	$nodo = $abre . $cual . $cierra;

	return $nodo;

}

function limpiar($string){
	$string = str_replace("&lt;","&amp;lt;",$string);
	//$string = str_replace("<0","&lt;0",$string);
	return $string;
}


	require("../conexion.php");
	
function getArea($area){
	global $con;
	$sql = "SELECT * FROM areas_trabjos_libres WHERE id='$area'";
	$query = mysql_query($sql,$con);
	$row = mysql_fetch_array($query);
	return $row["Area"];
}
	
	define("br","<br>");
	$sql = "SELECT * FROM trabajos_libres WHERE ID_casillero<>'' ORDER BY area_tl,SUBSTRING(numero_tl FROM 4)";
	$query = mysql_query($sql,$con);
	
	
	echo nodo('?xml version="1.0" encoding="utf-8"?');
	echo "<br>" . nodo("root").br;
	
	$sqlAutoresT = "SELECT * FROM trabajos_libres ORDER BY numero_tl";
	$queryAutoresT = mysql_query($sqlAutoresT,$con) or die(mysql_error());
	
	while($rowAutoresT = mysql_fetch_array($queryAutoresT)){
		$sqlAutoresL = "SELECT * FROM trabajos_libres_participantes as l JOIN personas_trabajos_libres as p ON l.ID_participante=p.ID_Personas WHERE ID_trabajos_libres='".$rowAutoresT["ID"]."'";
		$queryAutoresL = mysql_query($sqlAutoresL,$con) or die(mysql_error());
		while($rowAutoresL = mysql_fetch_array($queryAutoresL)){
			$nombreAutores[$rowAutoresT["ID"]][] = $rowAutoresL["Nombre"];
			$apellidoAutores[$rowAutoresT["ID"]][] = $rowAutoresL["Apellidos"];
			$institucionAutores[$rowAutoresT["ID"]][] = $rowAutoresL["Institucion"];
			$leeAutores[$rowAutoresT["ID"]][] = $rowAutoresL["lee"];
			$inscriptoAutores[$rowAutoresT["ID"]][] = $rowAutoresL["inscripto"];
		}
	}
	
	while($row = mysql_fetch_object($query)){
			include("inc.gestionAutores.php");
	echo nodo("TL");
			if($row->area_tl!=$area_){
				echo nodo("area_tl").$row->area_tl." - ".getArea($row->area_tl).nodo("/area_tl").br;
			}
			$area_ = $row->area_tl;
			echo nodo("numero").$row->numero_tl.nodo("/numero").br;
			echo nodo("numero_tl").substr($row->numero_tl,3).nodo("/numero_tl").br;
		//	echo nodo("hora_tl").substr($row->Hora_inicio,0,-3).nodo("/hora_tl");
			echo nodo("titulo_tl").$row->titulo_tl.nodo("/titulo_tl");
		echo br;		
			echo $gestionAutores;
		echo br;
			echo nodo("resumen");
			
				echo "&lt;strong&gt;Antecedentes y Objetivos:&lt;/strong&gt;".br;
				echo limpiar($row->resumen).br;
				
				echo "&lt;strong&gt;Desarrollo:&lt;/strong&gt;".br;
				echo limpiar($row->resumen2).br;
				
				echo "&lt;strong&gt;Conclusiones:&lt;/strong&gt;".br;
				echo limpiar($row->resumen3).br;
				
			echo nodo("/resumen");
	echo nodo("/TL");
		echo br.br;
	}
	
echo  "<br>" . nodo("/root");	
?>