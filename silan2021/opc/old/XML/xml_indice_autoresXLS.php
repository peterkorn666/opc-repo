<?php
set_time_limit(300);
require("../conexion.php");


/*
header("Content-Type: application/xml");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=indice.xml");*/

function nodo($cual){

	$abre ="&lt;";
	$cierra = "&gt;";

	$nodo = $abre . $cual . $cierra;

	return $nodo;

}

//$sql = "SELECT t.ID, l.ID_trabajos_libres, l.ID_participante, t.pagina, p.Apellidos, p.Nombre, t.numero_tl FROM trabajos_libres as t JOIN trabajos_libres_participantes as l ON t.ID=l.ID_trabajos_libres JOIN personas_trabajos_libres as p ON l.ID_participante ORDER BY t.pagina,p.Apellidos ASC LIMIT 0,5";

$sql = "SELECT * FROM personas_trabajos_libres ORDER BY Apellidos";
$query = mysql_query($sql,$con) or die(mysql_error());


//echo nodo('?xml version="1.0" encoding="utf-8"?');


//echo "<br>" . nodo("root");

while($row = mysql_fetch_object($query)){
	
	$sqlL = "SELECT * FROM trabajos_libres_participantes as l JOIN trabajos_libres as t ON t.ID=l.ID_trabajos_libres WHERE l.ID_participante='$row->ID_Personas' AND t.estado<>3 ORDER BY pagina";
	$queryL = mysql_query($sqlL,$con) or die(mysql_error());
	
	while($rowT = mysql_fetch_object($queryL)){	
		//echo nodo("autor").$row->Apellidos.", ".$row->Nombre.nodo("/autor")."@@@".nodo("numero_tl").$rowT->numero_tl.nodo("/numero_tl")."@@*@".nodo("pagina").$rowT->pagina.nodo("/pagina")."<br>";
		echo $row->Apellidos.", ".$row->Nombre."@@@".$rowT->numero_tl."@@@".$rowT->pagina."<br>";
	}
}

//echo  "<br>" . nodo("/root");

?>