<?php
	//header('Content-Type: text/html; charset=iso-8859-1');
	session_start();
	require("../../init.php");
	require("class/core.php");
	require("../configs/config.php");
	require("class/abstract.php");
	require("datos.post.php");
	$trabajos = new abstracts();
	//header('Content-Type: text/html; charset=iso-8859-1');
	
	require("lang/".$_SESSION["abstract"]["lang"].".php");
	
	

	if($_POST["step"]==1){
		if($gestionAutores=="")
		{
			header("Location: index.php?error=autores");
			die();
		}
?>
<meta charset="utf-8">
	<br><br>
    <div align="center">
    	<strong><?=$_SESSION["abstract"]["titulo_tl"]?></strong></div>
    <div align="center"><?=$gestionAutores?></div><br>
<?php
	}else if($_POST["step"]==2){
?><br />

<?php
	echo $lang["CONGRESO"].": <strong>{$core->getAreasIdTL($_SESSION["abstract"]["area_tl"])}</strong><br>";
	echo $lang["MODALIDAD"].": <strong>{$core->getTipoTLID($_SESSION["abstract"]["tipo_tl"])}</strong><br>";
	//echo $lang["PREMIO"].": <strong>{$_SESSION["abstract"]["premio"]}</strong>";
?>	
<br><br>

<b><?=$lang["RESUMEN"]?>:</b>
<div style="color:black">
    <?=$_SESSION["abstract"]["resumen_tl"];?>
</div><br>

<b><?=$lang["RESUMEN2"]?>:</b>
<div style="color:black">
    <?=$_SESSION["abstract"]["resumen_tl2"];?>
</div><br>

<?php
if($_SESSION["abstract"]["tipo_tl"] == 1){
?>
	<b><?=$lang["RESUMEN3"]?>:</b>
<?php
}else{
?>
	<b><?=$lang["RESUMEN3_CASO_CLINICO"]?>:</b>
<?php
}
?>
<div style="color:black">
    <?=$_SESSION["abstract"]["resumen_tl3"];?>
</div><br>

<?php
if($_SESSION["abstract"]["tipo_tl"] == 1){
?>
    <b><?=$lang["RESUMEN4"]?>:</b>
    <div style="color:black">
        <?=$_SESSION["abstract"]["resumen_tl4"];?>
    </div><br>
<?php
}
?>

<b><?=$lang["RESUMEN5"]?>:</b>
<div style="color:black">
    <?=$_SESSION["abstract"]["resumen_tl5"];?>
</div><br><br>

<!--<b><?=$lang["RESUMEN6"]?>:</b>
<div style="color:black">
    <?=$_SESSION["abstract"]["resumen_tl6"];?>
</div><br><br>-->

<!--<?=$lang["PALABRAS_CLAVES"].": <strong>".$_SESSION["abstract"]["palabras_claves"];?></strong><br>-->
    
    
    	
    <br />
    <p align="center"><?=$lang["DATOS_CONTACTO"]?></p>
    <table width="900" border="0" cellspacing="0" cellpadding="4" align="center" style="color:black">
  <tr>
    <td colspan="4" align="center"><?=$_SESSION["abstract"]["contacto_nombre"]?>
    <?=$_SESSION["abstract"]["contacto_apellido"]?> (
    <?=$_SESSION["abstract"]["contacto_mail"]?>
    ) - 
    <?=$_SESSION["abstract"]["contacto_ciudad"]?>, 
    <?=$core->getPaisID($_SESSION["abstract"]["contacto_pais"])?></td>
    </tr>
  <tr>
    <td colspan="4" align="center"><?=$_SESSION["abstract"]["contacto_institucion"]?></td>
    </tr>
  <tr>
    <td colspan="4" align="center"><?=$_SESSION["abstract"]["contacto_telefono"]?></td>
    </tr>
  <tr>
    <td width="67" align="center">&nbsp;</td>
    <td width="198" align="center">&nbsp;</td>
    <td width="76" align="center">&nbsp;</td>
    <td width="127" align="center">&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="4" align="center">
    	<?php
			if($_POST["step"]==2)
			{
				echo "<strong style='font-size:14px;color:red'>Se debe corregir minuciosamente el trabajo antes de presionar el bot&oacute;n ENVIAR.<br>Evite errores tipográficos u ortográficos, o incongruencias en los datos que puedan impedir su aceptación.<br>No podr&aacute; realizar correciones una vez enviado.</strong>";
			}
			//texto viejo
			/*Una vez que presione el bot&oacute;n ENVIAR no podr&aacute; realizar correciones,<br>revise la ortograf&iacute;a, la redacci&oacute;n y especialmente ponga atenci&oacute;n si utiliz&oacute; s&iacute;mbolos especiales.*/
		?>
    </td>
  </tr>
  <tr>
    <td colspan="4" align="center"><input type="button" id="step3back" value="<?=$lang["VOLVER"]?>" /> <input type="submit" value="<?=$lang["ENVIAR"]?>" /></td>
    </tr>
</table>
<?
	}
?>
