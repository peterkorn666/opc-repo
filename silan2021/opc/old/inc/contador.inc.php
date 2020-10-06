<span style="color:#FFF; font-size:12px; font:'Trebuchet MS', Arial, Helvetica, sans-serif">
<?
echo $visitas__;
$contar = true;
$sql = "SELECT visitas FROM estadisticas LIMIT 1";
$rs = mysql_query($sql, $con);
while($row=mysql_fetch_array($rs)){
	$contador = $row["visitas"];
}
if (@eregi("googlebot", $_SERVER['HTTP_USER_AGENT'])){
	$contar = false;
}
/*
if(!eregi("Yahoo",$_SERVER["HTTP_USER_AGENT"])){
	$contar = false;
}
if(!eregi("Slurp",$_SERVER["HTTP_USER_AGENT"])){
	$contar = false;
}
if(!eregi("msnbot",$_SERVER["HTTP_USER_AGENT"])){
	$contar = false;
}
if(!eregi("PEAR HTTP_Request class",$_SERVER["HTTP_USER_AGENT"])){
	$contar = false;
}
if(!eregi("ia_archiver",$_SERVER["HTTP_USER_AGENT"])){
	$contar = false;
}*/
if($contar){
	if($_SESSION["contador"]==false){
		$contador = $contador+1;
		$sql2 = "UPDATE estadisticas SET visitas = $contador";
		mysql_query($sql2,$con);
		$_SESSION["contador"]=true;
	}
}
echo " <span style='color:#FFC'><strong>".$contador."</strong></span>&nbsp;&nbsp;";

?></span>