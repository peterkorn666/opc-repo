<?php
require("../class/core.php");
$core = new Core();

if(isset($_POST['ins'])){
	$core->bind('ins', $_POST['ins']);
	$core->bind('id', $_POST['id']);
	$sql = $core->query("UPDATE inscriptos SET estado=:ins WHERE id=:id");
	if($sql)
		echo 'ok';
	$sqlTrabajos = $core->query("SELECT id, numero_pasaporte FROM inscriptos WHERE id=:id");
	if(count($sqlTrabajos) > 0){
		$core->bind('pasaporte', $sqlTrabajos['numero_pasaporte']);
		$sql2 = $core->query("UPDATE personas_trabajos_libres SET inscripto=:ins WHERE pasaporte=:pasaporte");
	}
}
?>