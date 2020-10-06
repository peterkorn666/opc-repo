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

$sql = "SELECT * FROM personas_trabajos_libres where Apellidos like '" . $_POST["str_persona"] . "%' ORDER by  Apellidos,Nombre ASC";
$rs = mysql_query($sql,$con);

if(mysql_num_rows($rs)>0){
?>
<div style="overflow: auto; overflow-X: hidden; height:200px; width:500px; border:solid 2px #000000;" >
<?

}
while ($row = mysql_fetch_array($rs)){


if($row["inscripto"]==1){

 	$ins ="<img src=img/puntoVerde.png />";

}else{

	$ins ="";
	
}


$persona = $ins . "  <font size=2><strong>" . htmlentities($row["Apellidos"]) . ", " . htmlentities($row["Nombre"]) . "</strong> (" . htmlentities($row["Pais"]) . ") - " . htmlentities($row["Institucion"]) . "</font>"; 

?>
<div id="div_persona_tl_<?=$row["ID_Personas"] . $_POST["en_campo"]?>" onclick="cargar_persona_buscada(<?=$_POST["en_campo"]?>, <?=$row["ID_Personas"]?>, '<?=$persona?>')" onmouseover="pintar(this.id, '#ffffff')" onmouseout="despintar(this.id, '#C2DEED')" class='div_buscar_persona_TL'>
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