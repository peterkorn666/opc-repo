<?
if ($_SESSION["idEvaluador"]!=""){
	$ev = $_SESSION["idEvaluador"];
	$sql = "SELECT * FROM trabajos_libres tl WHERE tl.numero_tl LIKE '%' AND NOT EXISTS (SELECT * FROM evaluaciones e WHERE e.numero_tl=tl.numero_tl AND e.idEvaluador='".$ev."');";
	
	//todos los evaluadores chequean los premios tmb???
	//$sql = "SELECT * FROM trabajos_libres tl WHERE NOT EXISTS (SELECT * FROM evaluaciones e WHERE e.numero_tl=tl.numero_tl AND e.idEvaluador='".$ev."');";
	//echo $sql. "<br>". "<br>";
	
	$rs = $con->query($sql);
	while ($row = $rs->fetch_array()) {
		$sql2 = "INSERT INTO evaluaciones (idEvaluador, numero_tl) VALUES ('".$ev."', '".$row["numero_tl"]."');";
		//echo $sql2 . "<br>";
		//mysql_query($sql2, $con) or die ("ERROR!!!!!!!!!!!!!!!!".$sql2);		
	}
}
?>