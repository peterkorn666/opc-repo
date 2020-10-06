<?
header('Content-Type: text/html; charset=UTF-8');

if($_POST["id"]!=""){
	require_once("../class/core.php");
	$core = new Core();
	$sql = $res->prepare("SELECT * FROM trabajos_libres WHERE id_trabajo=? ORDER BY numero_tl ASC");
	$sql->bindValue(1,$_POST["id"]);
	$sql->execute() or die(json_encode(print_r($db->errorInfo())));
	if($sql->rowCount()>0)
	{
		$trabajos = array();
		$helper = 0;
		while($row = $sql->fetch())
		{
			$allTables = $core->returnAllTables("trabajos_libres");
			foreach($allTables as $table)
				$trabajos[$helper][$table["Field"]] = $row[$table["Field"]];
			$helper++;
		}
		echo json_encode($trabajos);
	}else
		echo json_encode("not found");
}
?>