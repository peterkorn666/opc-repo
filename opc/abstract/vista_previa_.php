<?php
	//header('Content-Type: text/html; charset=iso-8859-1');
	session_start();
	require("../init.php");
	require("class/DB.class.php");
	require("class/core.php");
	//require("../configs/config.php");var_dump('aca');die();
    require("class/abstract.php");
    $db = \DB::getInstance();
	require("datos.post.php");
	$core = new core();
	//$trabajos = new abstracts();
	
	//header('Content-Type: text/html; charset=iso-8859-1');
	
	require("lang/".$_SESSION["abstract"]["lang"].".php");
	

	if($_POST["step"]==1){
		if($gestionAutores=="")
		{
			header("Location: index.php?error=autores");
			die();
		}
		//var_dump($_SESSION);

?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <div align="center">
    	<strong><?=$_SESSION["abstract"]["titulo_tl"]?></strong></div>
    <div align="center"><?=$gestionAutores?></div><br>
    <?php
    if ($_SESSION["abstract"]["resumen_tl"]){
	?>
        <b><?=$lang["RESUMEN"]?>:</b>
        <div style="color:black">
            <?=$_SESSION["abstract"]["resumen_tl"];?>
        </div><br>
    <?php
	}
    if ($_SESSION["abstract"]["resumen_tl2"]){
	?>
        <strong><?=$lang["RESUMEN2"]?>:</strong>
        <div style="color:black">
            <?=$_SESSION["abstract"]["resumen_tl2"];?>
        </div><br>
    <?php
	}
    if ($_SESSION["abstract"]["resumen_tl3"]){
        ?>
        <strong><?=$lang["RESUMEN3"]?>:</strong>
        <div style="color:black">
            <?=$_SESSION["abstract"]["resumen_tl3"];?>
        </div><br>
        <?php
    }
	?>
    <?php
	if($_SESSION["abstract"]["palabras_claves"]){
	?>
    	<p><?=$lang["PALABRAS_CLAVES"]?>: <strong><?php echo $_SESSION["abstract"]["palabras_claves"]?></strong></p>
    <?php
	}
	/*var_dump($_SESSION);
	?>
    /*<br><?=$lang["TIPO_TL"]?>: <strong><?=$core->getTipoTLID($_SESSION["abstract"]["tipo_tl"])?></strong>
    <br><?=$lang["EJES_TEMATICOS"]?>: <strong><?=$core->getAreasIdTL($_SESSION["abstract"]["area_tl"])?></strong>
    <?php
	if($_SESSION['abstract']['area_tl'] === '1' || $_SESSION['abstract']['area_tl'] === '2' || $_SESSION['abstract']['area_tl'] === '3'){
	?>
    	<br><?=$lang["TEMATICA"]?>: <strong><?=$core->getTematicaTLByID($_SESSION["abstract"]["tematica_tl"])?></strong>
    <?php
    }*/
    if(!empty($_SESSION["abstract"]["area_tl"])){
        $area_tl = $core->getAreasIdTL($_SESSION["abstract"]["area_tl"]);
        echo "<br>".$lang["EJES_TEMATICOS"].": <strong>".$area_tl."</strong>";
    }
    if(!empty($_SESSION["abstract"]["linea_transversal"])){
        $linea_transversal = $core->getLineaTransversalByID($_SESSION["abstract"]["linea_transversal"]);
        echo "<br>".$lang["LINEA_TRANSVERSAL"].": <strong>".$linea_transversal["linea_transversal_".$_SESSION["abstract"]["lang"]]."</strong>";
    }
    if(!empty($_SESSION["abstract"]["modalidad"])){
        $modalidad = $core->getModalidadID($_SESSION["abstract"]["modalidad"]);
        echo "<br>".$lang["MODALIDAD"].": <strong>".$modalidad."</strong>";
    }
	?>

<?php
	}else if($_POST["step"]==2){
?><br />
<!--<br />
<?=$lang["MODALIDAD"]?>: <strong><?php //echo $core->getTipoTLID($_SESSION["abstract"]["tipo_tl"])?></strong>
<br />
<br />-->


    <!--<br />
    <?=$lang["DATOS_CONTACTO"]?><br />
    <table width="900" border="0" cellspacing="0" cellpadding="4" align="center" style="color:black">
  <tr>
    <td colspan="4" align="center"><?=$_SESSION["abstract"]["contacto_nombre"]?>
    <?php //echo $_SESSION["abstract"]["contacto_apellido"]?> (
    <?php //echo $_SESSION["abstract"]["contacto_mail"]?>
    ) - 
    <?php //echo $_SESSION["abstract"]["contacto_ciudad"]?>, 
    <?php //echo $core->getPaisID($_SESSION["abstract"]["contacto_pais"])?></td>
    </tr>
  <tr>
    <td colspan="4" align="center"><?php //echo $_SESSION["abstract"]["contacto_institucion"]?></td>
    </tr>
  <tr>
    <td colspan="4" align="center"><?php //echo $_SESSION["abstract"]["contacto_telefono"]?></td>
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
			/*if($_POST["step"]==2)
			{
				echo "<strong style='font-size:14px;color:red'>Una vez que presione el bot&oacute;n ENVIAR no podr&aacute; realizar correciones,<br>revise la ortograf&iacute;a, la redacci&oacute;n y especialmente ponga atenci&oacute;n si utiliz&oacute; s&iacute;mbolos especiales.</strong>";
			}*/
		?>
    </td>
  </tr>-->
  <tr>
    <td colspan="4" align="center"><input type="button" id="step3back" value="<?=$lang["VOLVER"]?>" /> <input type="submit" value="<?=$lang["ENVIAR"]?>" /></td>
    </tr>
</table>
<?php
	}
?>

