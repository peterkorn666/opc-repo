<?php
require("clases/class.browser.php");
$browser = new Browser();
if( $browser->getBrowser() == Browser::BROWSER_IE) {
    echo '<br><br><h2 align="center">POR FAVOR UTILICE UN NAVEGADOR DIFERENTE A INTERNET EXPLORER<br>PARA COMPLETAR ESTE FORMULARIO.<br>HEMOS DETECTADO FALLAS AL UTILIZAR EL MISMO</h2>';
	die();
}
require("../../abstract/conexion.php");
$db = conectaDb();
/*if($_GET["key"]=="" && $_GET["status"]=="")
{
	header("Location: http://www.cicat2016.org");
	die();
}*/
if($_GET['keys'])
	$_GET['key'] = base64_encode($_GET['keys']);
if($_GET["key"]!="")
{
	$sql = $db->prepare("SELECT * FROM evaluadores WHERE id=?");
	$sql->bindValue(1,base64_decode($_GET["key"]));
	$sql->execute();
	if($sql->rowCount()>0)
	{
		$row = $sql->fetch();
		if($row['acepta_evaluador']!=NULL)
			header("Location: ?error=1");
	}else{
		header("Location: ?error=2");
	}
	
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CICat 2016</title>
<style>
.rect{
	padding:1px 6px 1px 6px;
	font-size:9px;
	background-color:#707070;
	color:white;
	border-radius:3px
}
</style>

</head>

<body>
<h1 id="result"></h1>
<div id="div_form">
<table width="900" align="center">
  <tr>
    <td colspan="2"><img src="http://www.cicat2016.org/img/banner.png" width="900"></td>
  </tr>
<?php

if(empty($_GET['key'])){
?>
   <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
    <td colspan="2">
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
    <p align="center"><img src="guia.jpg" width="900"  alt=""/></p>
    <p align="center">Copie el ID que le enviamos a su correo electr&oacute;nico como muestra la imagen aqu&iacute;</p>
    <?php
	switch($_GET['error']){
		case '1':
			echo '<p align="center" style="color:red"><strong>Usted ya completo este formulario.</strong></p>';
		break;
		case '2':
			echo '<p align="center" style="color:red"><strong>El ID que ingreso no existe.</strong></p>';
		break;
	}
	?>
    <table width="179" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td width="36">ID</td>
        <td width="144"><input type="text" name="keys" value=""></td>
      </tr>
      <tr>
        <td colspan="2" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" value="Enviar"></td>
        </tr>
    </table>
    </form>
    </td>
    </tr>
<?php
}

if($_GET["status"]=="" && $_GET['key'])
{
?>  
<form action="save_eval.php" name="form_eval" method="post" onSubmit="return check()">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><h3>Estimado Dr. <?=$row["nombre"]?><br><br>
El Comité Organizador del XXV Congreso  Iberoamericano de Catálisis (CICat 2016) que tendrá lugar del 18 al 23 de  setiembre de 2016 en Montevideo, Uruguay, desea invitarle a integrar el Comité Evaluador  del evento. En caso de aceptar la invitación recibirá los trabajos a evaluar a  partir del mes de marzo.</h3> </td>
    </tr>
  <tr>
    <td width="460">&nbsp;</td>
    <td width="436">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><h3>&iquest;Acepta ser evaluador?&nbsp;&nbsp;&nbsp;&nbsp; Si
<input type="radio" name="acepta_evaluador" onClick="show()" value="Si"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No
<input type="radio" name="acepta_evaluador" onClick="show()" value="No"></h3> </td>
  </tr>
  <tr id="tr_tematicas" style="display:none">
    <td colspan="2" align="left">
    	<h3>Seleccione las temáticas de su interés.</h3>
        	<?php
				$sql = $db->query("SELECT * FROM areas_trabjos_libres ORDER BY id");
				while($row = $sql->fetch())
				{
        			echo '<input type="checkbox" name="tematicas[]" value="'.$row["id"].'"> '.$row["Area"]."<br>";
				}
			?>
        </td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" value="Guardar" style="width:200px; border:1px solid gray; padding:5px"></td>
  </tr>
<input type="hidden" name="key" value="<?=$_GET["key"]?>">
</form>   
<?php
}else if($_GET["status"])
{
	switch($_GET["status"])
	{
		case "1":
			$txt = "<h3 align='center'>El formulario se guard&oacute; correctamente.</3>";
		break;
		case "2":
		case "3":
			$txt = "<h3 align='center'>Hubo un error al guardar.</h3>";
		break;
	}
?>
	<tr>
    	<td colspan="2"><?=$txt?></td>
    </tr>   
<?
}
?>  

</table>

</div>
<script type="text/javascript">
function check()
{
	if(document.form_eval["acepta_evaluador"].value=="")
	{
		alert("Todos los campos son obligatorios.");
		return false;
	}
	
	if(document.form_eval["acepta_evaluador"].value=="Si")
	{
		var alertt = true;
		for(i=0;i<document.form_eval["tematicas[]"].length;i++)
		{
			if(document.form_eval["tematicas[]"][i].checked)
			{
				alertt = false;
			}
		}
		
		if(alertt)
		{
			alert("Todos los campos son obligatorios.");
			return false;
		}
	}
}

function clearSelected(){
	var elements = document.form_eval["tematicas[]"];
	
	for(var i = 0; i < elements.length; i++){
	  elements[i].checked = false;
	}
}

function show()
{
	document.getElementById("tr_tematicas").style.display = "none";
	if(document.form_eval["acepta_evaluador"].value=="Si")
	{
		document.getElementById("tr_tematicas").style.display = "";
	}else
	{
		clearSelected();
	}
}
show();
</script>
</body>
</html>