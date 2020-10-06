<?php
require("conexion.php");
$dia = $_POST["dia"];
if($dia!=""){
	$filtro = "WHERE cartasEnviadas LIKE '%$dia%'";
}

$sql = "SELECT * FROM trabajos_libres $filtro";
$query = mysql_query($sql,$con);

$cants = mysql_num_rows($query);

$sqlDia = "SELECT * FROM trabajos_libres WHERE cartasEnviadas<>'' ORDER BY numero_tl";
$queryDia = mysql_query($sqlDia,$con);

while($cartas = mysql_fetch_object($queryDia)){
	$fecha = explode("[",$cartas->cartasEnviadas);
	$fecha = str_replace("]","",$fecha[2]);
	$fechas[] = str_replace(" - ","",substr($fecha,0,-9));
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
div{
	padding:5px;
}
</style>
</head>

<body>

<?
$fechas = array_unique($fechas);
asort($fechas);
echo "Cantidad encontrados: ".$cants;
?>
<form action="" method="post" name="form1">
<select name="dia" onchange="document.form1.submit()">
<option value=''></option>
	<?
	
	foreach($fechas as $value){
		if($dia==$value){
			$chk = "selected";
		}
		echo "<option value='$value' $chk>$value</option>";
			$chk = "";
	}
	?>
</select><br />
<?php

	$bg = "#EFF9FC";
	while($row = mysql_fetch_object($query)){
		$rem = array("Se ha enviado el mail del trabajo",$row->numero_tl,"< />");
		$por = array("","","");
		
		if($bg=="#E3F3F7"){
			$bg = "#EFF9FC";
		}else{
			$bg = "#E3F3F7";
		}
		echo "<div style='background-color:$bg'>".$row->numero_tl." <div style='margin-left:20px;'> ".str_replace($rem,$por,preg_replace("/br/","",$row->cartasEnviadas,1))." </div></div>";
	}
?>
</form>
</body>
</html>