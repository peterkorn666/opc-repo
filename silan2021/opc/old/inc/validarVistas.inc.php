<?
$sql = "SELECT * FROM config;";
//$rs = mysql_query($sql, $con) or die(mysql_error());
$rs = $con->query($sql);
if(!$rs){
	die($con->error);
}
/* $row = mysql_fetch_array($rs) */
while ($row = $rs->fetch_array()){
	if($row["VerCurriculums"]==1){
			$verCurriculums =true;
	}else{
			$verCurriculums = false;
	}
	if($row["VerMails"]==1){
			$verMails =true;
	}else{
			$verMails = false;
	}
	if($row["VerTL"]==1){
			$verTL =true;
	}else{
			$verTL = false;
	}
}
?>