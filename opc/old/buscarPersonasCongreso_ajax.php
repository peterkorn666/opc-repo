<?
header('Content-Type: text/html; charset=iso-8859-1');
?>
<style>

.div_buscar_persona_TL{
/*	width:480px;
	 overflow:hidden;
	 white-space:  nowrap; 
	 vertical-align: middle;  
	 height:20px; 
	 font-family:Arial, Helvetica, sans-serif; 
	 font-size:12px; 
	 border-bottom:solid 1px #000000; 
	 background-color:#ffffff; 
	 padding:2px;"*/
}

</style>
<?
if($_POST["str_persona"]!=""){
include "conexion.php";

$sql = "SELECT * FROM personas where apellido like '" . $_POST["str_persona"] . "%' AND deDonde='' ORDER by  apellido,nombre ASC";
$rs = mysql_query($sql,$con);

if(mysql_num_rows($rs)>0){
?>
<div class="col-xs-12 ajax-confs" >
<?

}
while ($row = mysql_fetch_array($rs)){


if($row["inscripto"]==1){

 	$ins ="<img src=img/puntoVerde.png />";

}else{

	$ins ="";
	
}


$persona = $ins . " <strong>" . htmlentities($row["apellido"]) . ", " . htmlentities($row["nombre"]) . "</strong> (" . htmlentities($row["pais"]). ") - " . htmlentities($row["institucion"]); 

?>
<div id="div_persona_tl_<?=$row["ID_Personas"] . $_POST["en_campo"]?>" onclick="cargar_persona_buscadaCongreso(<?=$_POST["en_campo"]?>, <?=$row["ID_Personas"]?>, '<?=$persona?>')"  class='div_buscar_persona_TL'>
  <?  
  echo $persona;
  ?>
</div>
<?
	}

?>
</div>
<?
}
?>