<?
$arrDias = array();
$sqlDias = "SELECT * FROM dias WHERE 1";
$rsDias = mysql_query($sqlDias, $con);
while ($rowDias = mysql_fetch_array($rsDias)){
	$arrDias[$rowDias["Dia_orden"]] = $rowDias["Dia_ing"]; 
}
$arrSalas = array();
$sqlSalas = "SELECT * FROM salas WHERE 1";
$rsSalas = mysql_query($sqlSalas, $con);
while ($rowSalas = mysql_fetch_array($rsSalas)){
	$arrSalas[$rowSalas["Sala_orden"]] = $rowSalas["Sala_ing"]; 
}
$arrCalidad = array();
$sqlCalidad = "SELECT * FROM en_calidades WHERE 1";
$rsCalidad = mysql_query($sqlCalidad, $con);
while ($rowCalidad = mysql_fetch_array($rsCalidad)){
	$arrCalidad[$rowCalidad["En_calidad"]] = $rowCalidad["En_calidad_ing"]; 
}
$arrProfesion = array();
$sqlProfesion = "SELECT * FROM profesiones WHERE 1";
$rsProfesion = mysql_query($sqlProfesion, $con);
while ($rowProfesion = mysql_fetch_array($rsProfesion)){
	$arrProfesion[$rowProfesion["Profesion"]] = $rowProfesion["Profesion_ing"]; 
}
$arrCountry = array();
$sqlCountry = "SELECT * FROM paises WHERE 1";
$rsCountry = mysql_query($sqlCountry, $con);
while ($rowCountry = mysql_fetch_array($rsCountry)){
	$arrCountry[$rowCountry["Pais"]] = $rowCountry["Pais_ing"]; 
}
$arrInsIng = array();
$sqlPer = "SELECT * FROM personas WHERE 1";
$rsPer = mysql_query($sqlPer, $con);
while ($rowPer = mysql_fetch_array($rsPer)){
	$arrInsIng[$rowPer["ID_Personas"]] = $rowPer["institucionIng"]; 
}
?>