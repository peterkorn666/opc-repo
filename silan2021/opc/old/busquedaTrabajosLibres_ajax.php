<?php
require("conexion.php");
header('Content-Type: text/html; charset=UTF-8');
$buscar = trim($_POST["tl_trabajo"]);
if($buscar==""){
	return;
}
if(strpos($buscar," ")===false){
	$buscar = addslashes($buscar);
	$where = "numero_tl LIKE '%$buscar%' OR titulo_tl LIKE '%$buscar%'";
}else{
	$exp = explode(" ",$buscar);
	for($i=0;$i<count($exp);$i++){
		if($i!=0){
			$where .= " OR ";
		}
		$exp[$i] = addslashes($exp[$i]);
		$where .= "numero_tl LIKE '%$exp[$i]%' OR titulo_tl LIKE '%$exp[$i]%'";
	}
}
$sql = sprintf("SELECT * FROM trabajos_libres WHERE %s",$where);
//echo $sql;
$query = mysql_query($sql,$con);

echo "<ul id='ul_tl' class='tl_sortable'>";
while($row = mysql_fetch_array($query)){
	echo "<li>".$row["numero_tl"]." - ".$row["titulo_tl"]." <input type='hidden' name='tl_id[]' value='".$row["ID"]."'></li>";
}
echo "</ul>";
if(mysql_num_rows($query)>0)
	echo "<p align='right'><button type='button' id='cerrar_result_tl' class='btn btn-primary btn-xs'>Cerrar</button></p>";
?>