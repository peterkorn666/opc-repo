<?
include('inc/sesion.inc.php');
include('conexion.php');

$sala_ = $_POST["sala_"];
$sala_ing = $_POST["sala_ing"];
$obssala_ = $_POST["obssala_"];
$orden_ = $_POST["orden_"];

//$sql = "INSERT INTO salas (Sala, Sala_orden) VALUES ";
//$sql .= "('" . $sala_ . "','" . $orden_ ."');";

$sql = "INSERT INTO salas (Sala, Sala_ing, Sala_orden, Sala_obs) VALUES ";
$sql .= "('" . safes($sala_) . "','" . safes($sala_ing) . "','" . $orden_ ."','" . safes($obssala_) ."');";

mysql_query($sql, $con);
$lastID = mysql_insert_id();

if($_POST["sola"]==1){

	echo "<script type='text/javascript'>";
			echo 'var x = window.opener.document.getElementById("sala_");';				
			echo 'var option = document.createElement("option");';
			echo 'option.text = "'.$lastID." - ".safes($sala_).'";';
			echo 'option.value = '.safes($sala_);
			echo 'var sel = x.options[x.selectedIndex];';
			echo 'x.add(option, sel);';
			echo 'window.close()';
		echo "</script>";
	
}else{

	header ("Location:altaSala.php");
	
}

?>