<?php
	session_start();
	error_reporting(E_ALL ^ E_NOTICE);
	require("../../init.php");
	require("class/core.php");
	require("class/abstract.php");
    $browser = new Browser();
	$trabajos = new abstracts();
	$core = new core();
	$getConfig = $core->getConfig();
	/*if ($_GET["asd"] != '1'){
		header("Location: index.php");
		die();	
	}*/
	
/*if(empty($_GET["t"])){
	echo '<br><br><h2 align="center" style="color:red">En mantenimiento</h2>';
	die();	
}*/

header('Content-Type: text/html; charset=utf-8');
require("class/class.lang.php");
if($_GET["lang"]=="" && $_SESSION["abstract"]["lang"]=="")
	$_SESSION["abstract"]["lang"] = "es";
else if($_GET["lang"]!="")
	$_SESSION["abstract"]["lang"] = $_GET["lang"];

$getLang = new Lang($_SESSION["abstract"]["lang"]);

require("lang/".$getLang->lang.".php");

$_SESSION["abstract"]["paso1"] = true;
$_SESSION["abstract"]["browser"] = $browser->__toString();
$hide_titulo = "block";
$animation = "ocultar";
if(empty($_SESSION["abstract"]["id_tl"]))
	$hide_titulo = "none";
else
	$animation = "mostrar";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$getConfig['nombre_congreso']?></title>
<link rel="stylesheet" href="estilos/estilos.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="estilos/editor.css" />
<script type="text/javascript" src="js/jquery1.11.1.js"></script>
<script type="text/javascript">
jQuery.noConflict();
</script>
<script language="javascript" type="text/javascript" src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script type="text/javascript">
//var animation = '<?=$animation?>';
var animation = false;
</script>
<script type="text/javascript">
jQuery(document).ready(function($) {
    $("#link_tl").click(function(e)
	{
		e.preventDefault();
		$("input[name='archivo_tl']").click();
	})
	
	$("input[name='archivo_tl']").change(function()
	{
		$("#txt_tl span").html($("input[name='archivo_tl']").val().replace("C:\\fakepath\\", ""));
		$("#txt_tl").show();
	})
	
	$("#txt_tl img").click(function()
	{
		$("input[name='archivo_tl']").val("");
		$("#txt_tl").hide();
		$("#txt_tl span").html("");
	}).css("cursor","pointer")
});
</script>
<!--<link rel="stylesheet" type="text/css" href="estilos/bootstrap.min.css">-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="estilos/font-awesome.min.css">
<style>
	label, .titulo_contacto {
		font-weight: bold;
	}
</style>
<body>
<div id="contenedor">
	<div id="banner" align="center"><img src="<?=$getConfig["banner_congreso"]?>" alt="<?=$getConfig["nombre_congreso"]?>" />
    	<!--div align="right"><a href="?lang=es">Español</a> - <a href="?lang=en">Ingles</a></div-->
    </div>
    <?php
	/*if(!$_SESSION["admin"]){
		echo '<br><br><h2 align="center" style="color:red">Ha finalizado la presentación de resúmenes</h2>';
		die();
	}*/
	?>
    <?php
    if($_GET['error']=='empty')
        echo '<div class="alert alert-danger" id="obg" align="center">Todos los campos son obligatorios.</div>';
	if($_GET['error']=='emptyp')
        echo '<div class="alert alert-danger" id="obg" align="center">Debe completar el Apellido Paterno o Materno.</div>';
    ?>
	<div id="contenido">
    <?php
		//if($_GET["all"]=="ok"){
	if(empty($_SESSION["abstract"]["id_tl"])){
    ?>
    <!--<div class="login"><a href="#" class="link_login">Para modificar su trabajo haga click aquí</a></div>-->
   	<?php
	}
		//}
		if($_GET["error"]=="file")
			echo "<div class='alert alert-danger' align='center'><h3 style='color:red;margin:10px'>El archivo no tiene un fomato v&aacute;lido.</h3></div>";
		if($_GET["error"]=="size")
			echo "<div class='alert alert-danger' align='center'><h3 style='color:red;margin:10px'>El archivo es muy pesado.</h3></div>";
    ?>
     
   <?php
		//if($_GET["all"]=="ok"){
	if(!empty($_SESSION["abstract"]["id_tl"])){
		echo '<a href="salir.php">Salir</a>';
	}
    ?>
    
<?php
if(empty($_SESSION["abstract"]["id_tl"])){
?>    
    <div class="login"><br />
    	<form action="login.php?t=1" method="post">
        	<div class="col-md-8 offset-md-2">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <label>Nº de trabajo:</label><br />
                        <input style="width: 100%" type="text" name="codigo" class="form-control" />
                    </div>
                </div>
                <div class="row">
                	<div class="col-md-6 offset-md-3">
                        <label>Clave:</label><br />
                        <input style="width: 100%" type="password" name="clave" class="form-control" />
                    </div>
                </div>
                <div class="row">
                	<div class="col-md-6 offset-md-3">
                    	<input style="width: 100%" type="submit" value="Ingresar" class="form-control btn btn-primary" /> 
                    </div>
                </div>
            </div>
            <!--<table width="240" border="0" cellspacing="1" cellpadding="5" align="center">
              <tr>
                <td align="center">Nº de trabajo: </td>
                <td><input type="text" name="codigo" /></td>
              </tr>
              <tr>
                <td align="center">Clave: </td>
                <td><input type="password" name="clave" /></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><input type="submit" value="Ingresar" /> </td>
              </tr>
            </table>-->
    	</form>    
   </div> 
<?php
}
if($_SESSION["abstract"]["id_tl"]){
	$areas = $core->getAreasIdTL($_SESSION["abstract"]["area_tl"]);
?>
   <form action="guardar.php?t=1" name="peview" method="post" enctype="multipart/form-data">
   <br /><br />
   	<div align="center">
    
        <p><a href="#" id="link_tl" style="color:red; font-weight:bold; border:1px solid gray; background-color:#F0F0F0; dsiplay:block; padding:10px;">HAGA CLICK AQUÍ PARA ADJUNTAR SU ARCHIVO</a></p>
        <p id="txt_tl" style="font-size:17px; margin-top:25px; display:none"><span></span> <img src="img/cross.png" alt="" title="No subir archivo" style="cursor: pointer;" width="16" height="16"></p>
        <p><strong><?=$lang['ARCHIVO_EXTENSION']?></strong></p>
            
            <input name="archivo_tl" style="display:none" type="file">
        
    </div><br /><br />
    <p align="center"><input type="submit" class="btn btn-primary" value="Enviar trabajo completo" style="text-align: center; width: 200px;" /></p>
    <br /><br />
    
    <div class="col-md-12" style="background-color: #FBF6F0">
    	<div class="letrasMenu" align="center">
			<br>
			<?=$lang["PRESENTACION_RESUMEN"]?><br>
			N&ordm;: <span style="font-size:28;color:red"><?=$_SESSION["abstract"]["numero_tl"]?></span>
        </div><br /><br />
        
		<div align="left">
			<?=$lang["CONGRESO"]?>: <strong><?=$areas?></strong><br>
			<!--<?=$lang["PREMIO"]?>: <strong><?=$_SESSION["abstract"]["premio"]?></strong>-->
		</div><br />
        
        <div align="center" style="font-weight: bold;">
        	<?=$_SESSION["abstract"]["titulo_tl"]?>
        </div><br />
        
        <div style="text-align: justify;">
        	<div style="border-bottom:1px dashed;">
                <label><?=$lang["RESUMEN"]?></label><br />
                <?=$_SESSION["abstract"]["resumen_tl"]?>
            </div><br />
            <div style="border-bottom:1px dashed;">
                <label><?=$lang["RESUMEN2"]?></label><br />
                <?=$_SESSION["abstract"]["resumen_tl2"]?>
            </div><br />
            <div style="border-bottom:1px dashed;">
                <label><?=$lang["RESUMEN3"]?></label><br />
                <?=$_SESSION["abstract"]["resumen_tl3"]?>
            </div><br />
            <div style="border-bottom:1px dashed;">
                <label><?=$lang["RESUMEN4"]?></label><br />
                <?=$_SESSION["abstract"]["resumen_tl4"]?>
            </div><br />
            <div style="border-bottom:1px dashed;">
                <label><?=$lang["RESUMEN5"]?></label><br />
                <?=$_SESSION["abstract"]["resumen_tl5"]?>
            </div>
        </div><br />
        	
        <div>
        	<?=$lang["PALABRAS_CLAVES"].': '.$_SESSION["abstract"]["palabras_claves"]?>
        </div>
        <br /><br />
        
        
        <div align="center" style="font-size: 15px; font-weight: bold;"><?=$lang["DATOS_CONTACTO"]?></div>
        <div class="row">
        	<div class="col-md-3">
        		<?=$lang["NOMBRES"]?>
            </div>
            <div class="col-md-3 titulo_contacto">
        		<?=$_SESSION["abstract"]["contacto_nombre"]?>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-3">
        		<?=$lang["APELLIDO"]?>
            </div>
            <div class="col-md-3 titulo_contacto">
        		<?=$_SESSION["abstract"]["contacto_apellido"]?>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-3">
        		Email contacto
            </div>
            <div class="col-md-3 titulo_contacto">
        		<?=$_SESSION["abstract"]["contacto_mail"]?>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-3">
        		Email alternativo
            </div>
            <div class="col-md-3 titulo_contacto">
        		<?=$_SESSION["abstract"]["contacto_mail2"]?>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-3">
        		<?=$lang["PAIS"]?>
            </div>
            <div class="col-md-3 titulo_contacto">
        		<?=$core->getPaisID($_SESSION["abstract"]["contacto_pais"])?>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-3">
        		<?=$lang["INSTITUCION"]?>
            </div>
            <div class="col-md-3 titulo_contacto">
        		<?=$_SESSION["abstract"]["contacto_institucion"]?>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-3">
        		<?=$lang["TELEFONO"]?>
            </div>
            <div class="col-md-3 titulo_contacto">
        		<?=$_SESSION["abstract"]["contacto_telefono"]?>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-3">
        		<?=$lang["CIUDAD"]?>
            </div>
            <div class="col-md-3 titulo_contacto">
        		<?=$_SESSION["abstract"]["contacto_ciudad"]?>
            </div>
        </div>
    </div><br />
   
	<!--<table width="850px" align="center" cellpadding="0px" cellspacing="0" bgcolor="#FBF6F0">
		<tr><td align="center"><br>
		<table width="800px" border="0" cellspacing="1" cellpadding="0" style="font-size:13px; text-decoration:none">
			  <tr>
				<td bgcolor="#FFFFFF" align="center">
				<span class="letrasMenu">
				<br>
				<?=$lang["PRESENTACION_RESUMEN"]?><br>
				N&ordm;: <span style="font-size:28;color:red"><?=$_SESSION["abstract"]["numero_tl"]?></span></strong></span><br /><br />
				<div align="left" style="margin-left: 20px">
					<?=$lang["CONGRESO"]?>: <strong><?=$areas?></strong><br>
					<?=$lang["PREMIO"]?>: <strong><?=$_SESSION["abstract"]["premio"]?></strong>
				</div>
				<table width="95%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="center" class="letrasMenu"><br />
			 <strong> <?=$_SESSION["abstract"]["titulo_tl"]?></strong></td>
			</tr>
		  <tr>
			<td align="center"><?=$_SESSION["abstract"]["autores"]?></td>
		  </tr>
		  <tr>
			<td style="text-align:justify"><br>
				<div style="border-bottom:1px dashed; padding-bottom:10px; margin-bottom:10px">	
				    <strong><?=$lang["RESUMEN"]?></strong><br />
					<?=$_SESSION["abstract"]["resumen_tl"]?>
				</div>
                
                <div style="border-bottom:1px dashed; padding-bottom:10px; margin-bottom:10px">	
				    <strong><?=$lang["RESUMEN2"]?></strong><br />
					<?=$_SESSION["abstract"]["resumen_tl2"]?>
				</div>
                
                <div style="border-bottom:1px dashed; padding-bottom:10px; margin-bottom:10px">	
				    <strong><?=$lang["RESUMEN3"]?></strong><br />
					<?=$_SESSION["abstract"]["resumen_tl3"]?>
				</div>
                
                <div style="border-bottom:1px dashed; padding-bottom:10px; margin-bottom:10px">	
				    <strong><?=$lang["RESUMEN4"]?></strong><br />
					<?=$_SESSION["abstract"]["resumen_tl4"]?>
				</div>
                
                <div style="border-bottom:1px dashed; padding-bottom:10px; margin-bottom:10px">	
				    <strong><?=$lang["RESUMEN5"]?></strong><br />
					<?=$_SESSION["abstract"]["resumen_tl5"]?>
				</div>
			
			<p><?=$lang["PALABRAS_CLAVES"].': '.$_SESSION["abstract"]["palabras_claves"]?></p>
			
			
			</td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			</tr>
		</table>
				<br />			
				<table style="font-size:13px">
				<tr>
					<td height="45" colspan="2" align="center" style="font-size:15px; font-family:\'Trebuchet MS\', Arial, Helvetica, sans-serif; color:#333"><strong><?=$lang["DATOS_CONTACTO"]?></strong></td>
					</tr>
				  <tr>
					<td width="142" ><?=$lang["NOMBRES"]?>:</td>
					<td width="407" valign="top" ><strong><?=$_SESSION["abstract"]["contacto_nombre"]?></strong></td>
					</tr>
				  <tr>
					<td ><?=$lang["APELLIDO"]?>:</td>
					<td valign="top" ><strong><?=$_SESSION["abstract"]["contacto_apellido"]?></strong></td>
					</tr>
				  <tr>
					<td >E-mail:</td>
					<td valign="top" ><strong><?=$_SESSION["abstract"]["contacto_mail"]?></strong></td>
					</tr>
					<tr>
					<td >E-mail alternativo:</td>
					<td valign="top" ><strong><?=$_SESSION["abstract"]["contacto_mail2"]?></strong></td>
					</tr>
				  <tr>
					<td><?=$lang["PAIS"]?></td>
					<td valign="top" ><strong><?=$core->getPaisID($_SESSION["abstract"]["contacto_pais"])?></strong></td>
					</tr>
				  <tr>
					<td><?=$lang["INSTITUCION"]?></td>
					<td valign="top" ><strong><?=$_SESSION["abstract"]["contacto_institucion"]?></strong></td>
					</tr>
				  <tr>
					<td><?=$lang["TELEFONO"]?>:</td>
					<td valign="top"><strong><?=$_SESSION["abstract"]["contacto_telefono"]?></strong></td>
					</tr>
				  <tr>
					<td><?=$lang["CIUDAD"]?></td>
					<td valign="top" ><strong><?=$_SESSION["abstract"]["contacto_ciudad"]?></strong></td>
					</tr>
				  </table>
				<br>
				<br>
				<br>
		</td>
			  </tr>
			</table>
		<br></td></tr>
		</table>-->
        
        
 	</form>   
<?
}
?>
</div>
</div>
</body>
</html>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$("form[name='peview']").submit(function(){
		if($("input[name='archivo_tl']").val()==""){
			alert("Debe cargar un trabajo completo.");
			return false;
		}
	})
});
</script>