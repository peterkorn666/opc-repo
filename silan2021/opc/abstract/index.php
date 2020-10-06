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
	/*if(!$_SESSION["admin"]){
		header("Location: trabajo.php");die();
	}*/
/*	
if(empty($_GET["t"])){
	echo '<br><br><h2 align="center" style="color:red">En mantenimiento</h2>';
	die();	
}*/

header('Content-Type: text/html; charset=utf-8');
require("class/class.lang.php");
if($_GET["lang"]=="" && $_SESSION["abstract"]["lang"]=="")
        $_SESSION["abstract"]["lang"] = "es";
    else if($_GET["lang"]!=""){
        if($_GET["lang"] != "es" && $_GET["lang"] != "en" && $_GET["lang"] != "pt"){
            header("Location: index.php");die();
        }
        $_SESSION["abstract"]["lang"] = $_GET["lang"];
    }

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
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript">
jQuery.noConflict();
</script>
<!--<script type="text/javascript" src="js/editor/editor.js"></script>-->
<script language="javascript" type="text/javascript" src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<!--<script language="javascript" type="text/javascript" src="mce/mce.min.js"></script>-->
<script type="text/javascript">
//var animation = '<?=$animation?>';
var animation = false;
</script>
<!--<script type="text/javascript" src="http://cdn.tinymce.com/4/tinymce.min.js"></script>
<script type="text/javascript" src="tinymce/langs/es.js"></script>-->
<script type="text/javascript" src="js/base64.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>

<!-- Editor html5 -->

<!-- include libries(jQuery, bootstrap, fontawesome) -->

<link rel="stylesheet" type="text/css" href="estilos/bootstrap.min.css">
<!--<link rel="stylesheet" type="text/css" href="tinymce/skins/lightgray/skin.min.css"/>-->
<!--<link rel="stylesheet" type="text/css" href="estilos/bootstrap-wysihtml5.css"></link>

<script src="js/bootstrap.min.js"></script> -->
<link href="estilos/font-awesome.min.css">

<!--<script src="js/editor/wysihtml5-0.3.0.js"></script>
<script src="js/editor/prettify.js"></script>
<script src="js/editor/bootstrap-wysihtml5.js"></script>-->

<!-- <script src="js/editor/bootbox.min.js"></script>-->

<script src="ckeditor/ckeditor.js"></script>

<script type="text/javascript">
jQuery(document).ready(function($) {	
	/*tinymce.init({		
		selector:"#titulo_tl",
		plugins:["charmap","visualblocks","paste","legacyoutput"],
		menubar: false,
		statusbar: false,
		height:"60",
		resize:!1,
		toolbar:"undo redo | bold italic | superscript subscript | charmap",
		format:'text',
	});
	
	tinymce.init({		
		selector:"#resumen_tl,#resumen_tl2",
		plugins:["charmap","visualblocks","paste","legacyoutput", "wordcount"],
		menubar: false,
		//statusbar: false,
		resize:!1,
		toolbar:"undo redo | bold italic underline | superscript subscript | charmap",
		format:'text',
	});*/
	
	CKEDITOR.replace( 'titulo_tl',{
		height:60,
		enterMode : CKEDITOR.ENTER_BR,
	});
	CKEDITOR.replace( 'resumen_tl',{
		height:200,
		enterMode : CKEDITOR.ENTER_BR
	});	
	CKEDITOR.replace( 'resumen_tl2',{
		height:200,
		enterMode : CKEDITOR.ENTER_BR
	});
	CKEDITOR.replace( 'resumen_tl3',{
		height:200,
		enterMode : CKEDITOR.ENTER_BR
	});
	CKEDITOR.replace( 'resumen_tl4',{
		height:200,
		enterMode : CKEDITOR.ENTER_BR,
		extraPlugins: 'simpleuploads,specialchar,htmlwriter,wordcount,notification'
	}).on( 'simpleuploads.localImageReady', scaleImage);
	
	CKEDITOR.replace( 'resumen_tl5',{
		height:200,
		enterMode : CKEDITOR.ENTER_BR
	});
	/*CKEDITOR.replace( 'resumen_tl6',{
		height:200,
		enterMode : CKEDITOR.ENTER_BR
	});*/
	
	init();
	initEffect();
});
	
</script>
<!-- //Editor html5 -->
</head>

<body>
<div id="contenedor">
	<div id="banner" align="center"><img src="<?=$getConfig["banner_congreso"]?>" alt="<?=$getConfig["nombre_congreso"]?>" />
    	<div align="right"><a href="?lang=es">Español</a> - <a href="?lang=en">English</a> - <a href="?lang=pt">Português</a></div>
    </div>
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
    <!--<div class="login"><a href="#" class="link_login">Para modificar su ponencia haga click aquí</a></div>-->
    <!--<br /><div><a href="trabajo.php" style="font-size:18px;">Si usted quiere subir su PDF haga clic aqu&iacute;</a></div>-->
   	<?php
	}
		//}
		if($_GET["error"]=="file")
			echo "<div class='alert alert-danger' align='center'><h3 style='color:red;margin:10px'>El archivo no tiene un fomato v&aacute;lido.</h3></div>";
		if($_GET["error"]=="size")
			echo "<div class='alert alert-danger' align='center'><h3 style='color:red;margin:10px'>El archivo es muy pesado.</h3></div>";
    ?>
    <div class="login" style="display:none">
    <form action="login.php" method="post">
   		N&ordm; <input type="text" name="codigo" /> Clave: <input type="text" name="clave" /> <input type="submit" value="Ingresar" /> 
    </form>
   </div>
   <?php
	/*if (!$_SESSION["admin"]) {
		if(empty($_GET["u"])) {
			echo "<br><br><div class='alert alert-danger' align='center'><h3 style='color:red;margin:10px'>Ha finalizado la presentación de trabajos libres.</h3></div>";
			die();
		}
	}*/
	?>
   <?php
		//if($_GET["all"]=="ok"){
	if(!empty($_SESSION["abstract"]["id_tl"])){
		echo '<a href="salir.php">Salir</a>';
	}
    ?>
    
   <form action="guardar.php" name="peview" method="post" enctype="multipart/form-data">    
<?php
//if(!empty($_SESSION["abstract"]["titulo_tl"])){
?>
        <div id="effect_one" align="center" style="margin-top:20px">
        	<?=$lang['BIENVENIDA'];?>
            <a href="documentos/ReglamentoTrabajos.pdf" target="_blank"><?=$lang['REGLAMENTO DE TRABAJO']?></a><br />
           <? if($_SESSION["abstract"]["numero_tl"]!=""){ ?> <p>Trabajo N&deg; <?=$_SESSION["abstract"]["numero_tl"]?></p> <? } ?>
        </div>
<div id="preview_step1" style="color:black;"></div>        
<div id="mod_step1">    
		<div id="editor_titulo_tl" style="width:80%; margin:0 auto">
        	<div class="hide_titulo"><a href="#">
            	<?=$lang['HABILITAR_SEC1']?>
            </a></div>
            <div class="titulo_box"><?=$lang['TITULO']?>:</div>
            <textarea name="titulo_tl" class="std-radius tiny" id="titulo_tl" style="width:100%;height:40px;" placeholder="Escriba o pegue aquí el título de su trabajo"><?=$_SESSION["abstract"]["titulo_tl"]?></textarea>
        </div>
           <br /><br />
        <div id="div_autores">
        	<div><strong><?=$lang['AUTORES']?>: </strong> </div>
        	<!--<p><?=$lang['TXT_AUTORES']?> <span>--><input type="hidden" maxlength="2" style="width:40px;text-align:center;margin-top:6px" name="total_autores" class="std-radius" value="0" readonly="readonly" /><!--<span class="mas_autor nuevo_autor">+</span></span></p>-->
            <div style="float:right">
            	<strong><?=$lang['MARCA_PRESENTADOR']?></strong>
            </div>
            <div style="clear:both"></div>
            <div id="div_agregar_autores" align="center">
              <div class="row" style="margin:0px;">
            	<div class="col-xs-1" align="left" style="margin-right: 95px"><?=$lang['NOMBRES']?></div>
                <div class="col-xs-2" align="left" style="width: 160px;padding:0px"><?=$lang['APELLIDOS']?></div>
                <div class="col-xs-2" align="left"><?=$lang['INSTITUCION']?></div>
                <div class="col-xs-2" align="left">E-mail</div>
                <div class="col-xs-1" align="left"><?=$lang['PAIS']?></div>
            </div>
            <div style="clear:both"></div>
            <?php
				for($i=0;$i<($_SESSION["abstract"]["total_autores"]>0?$_SESSION["abstract"]["total_autores"]:"1");$i++){
			?>
			<table class="table_autores" border="0" cellspacing="0" cellpadding="4">
                  <tr>
                    <td  class="numero_autor">Autor_</td>
                    <td>
                    	<input type="text" name="nombre_" class="" value="<?=$_SESSION["abstract"]["nombre_".$i]?>" />
                    </td>
                    <td>
                    	<input type="text" name="apellido_" class="searchAutor" autocomplete="off" value="<?=$_SESSION["abstract"]["apellido_".$i]?>" />
                    </td>
                    <td><input type="text" class="autoins" name="institucion_" value="<?=$_SESSION["abstract"]["institucion_".$i]?>" /></td>
                    <td><input type="email" name="email_" value="<?=$_SESSION["abstract"]["email_".$i]?>" /></td>
                    <td><select name="pais_" style="width:150px" class="paisautor">
                      <option value=""></option>
                      <?php
								$paises = $core->getPais();
								foreach($paises as $rowp){
									if($_SESSION["abstract"]["pais_".$i]==$rowp["ID_Paises"]){
										$chkp = "selected";
									}
									echo '<option value="'.$rowp["ID_Paises"].'" '.$chkp.'>'.$rowp["Pais"].'</option>';
									$chkp = "";
								}
							?>
                    </select>
                    </td>
                    <td><input type="checkbox" class="lee" name="lee_" <?=($_SESSION["abstract"]["lee_".$i]?"checked":"")?> value="1" style="width:14px"  />                      <input type="hidden" class="nochange" name="id_autor[]" value="<?=$_SESSION["abstract"]["id_autor_".$i]?>" /></td>
                  </tr>
                </table>
			<?
				}
			?>
            </div>
            
             <div id="control_autor">
           	 	<div id="div_eliminar_autor" align="right"><a href="#"  class="eliminar_autor"><span class="round_link">-</span> <?=$lang['ELIMINAR_AUTOR']?></a></div>
          		<div id="div_nuevo_autor" align="right"><a href="#"  class="nuevo_autor"><span class="round_link">+</span> <?=$lang['AGREGAR_AUTOR']?><br><?=$lang['NOTA_MAX_AUTORES']?> 
          		<br />
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></div>
            	<div style="clear:both"></div>
        	 </div>
             <input type="hidden" name="t" value="<?=$_SESSION["abstract"]["id_tl"]?>" />
        </div>        
        <div id="second_step" class="input_next"><input type="button" id="step1" value="<?=$lang['CONTINUAR']?>" /></div><br><br>
        
</div>  


<div id="preview_step2"></div>
<div id="mod_step2">
	<a href="documentos/ReglamentoTrabajos.pdf" target="_blank">Reglamento de trabajo</a><br />   
	<hr style="margin:20px 0;" color="#CCCCCC" />
    
   <div>
   <br />
   
   
       <div class="row">
            <div class="col-xs-1">
            <?=$lang['CONGRESO']?>
            </div>
            <div class="col-xs-10">
            <select name="area_tl" style="width:600px">
                <option value=""></option>
                <?php
                    $getAreas = $core->getAreasTL();
                    foreach($getAreas as $rowAreas)
                    {
                        if($rowAreas["id"]==$_SESSION["abstract"]["area_tl"])
                            $chk = "selected";
                        echo "<option value='".$rowAreas["id"]."' $chk>".$rowAreas["Area_".$_SESSION["abstract"]["lang"]]."</option>";
                        $chk = "";
                    }
                ?>
            </select>
            </div>
        </div>

    
        <br />
        <table width="90%" border="0" cellspacing="5" cellpadding="1">
          <tr>
            <td width="15%"><?=$lang['MODALIDAD']?></td>
            <td>
            <?php
				$tipo_tl = $core->getTipoTL();
				foreach($tipo_tl as $row)
				{
					if($_SESSION["abstract"]["tipo_tl"]==$row["id"])
						$chkt = "checked";
					echo '<input type="radio" name="tipo_tl" value="'.$row["id"].'" '.$chkt.'> '. $row["tipoTL_".$_SESSION["abstract"]["lang"]]." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					$chkt = "";
                }
			?>
            <br />            
            </td>
          </tr>
        </table>
        
        <br />
		<input  type="radio" name="premio" value="No" style="visibility:hidden;" checked <?php if($_SESSION["abstract"]["premio"]=="No"){ echo "checked";} ?>> 
        <!--<table width="90%" border="0" cellspacing="5" cellpadding="1">
          <tr>
            <td width="15%"><?=$lang['PREMIO']?></td>
            <td>
            	<input type="radio" name="premio" value="Si" <?php if($_SESSION["abstract"]["premio"]=="Si"){ echo "checked";} ?>> Si &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="premio" value="No" <?php if($_SESSION["abstract"]["premio"]=="No"){ echo "checked";} ?>> No
            <br />            
            </td>
          </tr>
        </table>-->
        
        

   </div>
    
    <!--<div id="idiomas" style="display:none">
    	<span><?=$lang['IDIOMA']?></span> &nbsp;&nbsp;
        <select name="idioma1" style="width:60%; margin-left:52px;">
        	<option value=""></option>
            <?php
				$getIdiomas = $trabajos->getIdiomas();
				foreach($getIdiomas as $rowI){
					if($rowI["idioma"]==$_SESSION["abstract"]["idioma"]){
						$chkI = "selected";
					}
					echo '<option value="'.$rowI["idioma"].'" '.$chkI.'>'.$rowI["idioma"].'</option>';
					$chkI = "";
				}
			?>
        </select>
        <input type="text" name="idioma" value="<?=$_SESSION["abstract"]["idioma"]?>" style="display:none" />
    </div>-->
    
    <br /><br />
    <div id="div_resumen_tl" style="width:100%">
            <div class="titulo_box"><strong><?=$lang['RESUMEN']?></strong></div>
                <textarea name="resumen_tl" class="tiny" id="resumen_tl" style="width:100%;height:166px;"><?=$_SESSION["abstract"]["resumen_tl"]?></textarea>

            <div class="titulo_box"><strong><?=$lang['RESUMEN2']?></strong></div>
                <textarea name="resumen_tl2" class="tiny" id="resumen_tl2" style="width:100%;height:166px;"><?=$_SESSION["abstract"]["resumen_tl2"]?></textarea>

            
            <div class="titulo_box"><strong id="txt_clinico"><?=$lang['RESUMEN3']?></strong></div>
                <textarea name="resumen_tl3" class="tiny" id="resumen_tl3" style="width:100%;height:166px;"><?=$_SESSION["abstract"]["resumen_tl3"]?></textarea>
            

            <div id="hidden_clinico">	
                <div class="titulo_box"><strong><?=$lang['RESUMEN4']?></strong></div>
                    <textarea name="resumen_tl4" class="tiny" id="resumen_tl4" style="width:100%;height:166px;"><?=$_SESSION["abstract"]["resumen_tl4"]?></textarea>
			</div>
            
            <div class="titulo_box"><strong><?=$lang['RESUMEN5']?></strong></div>
                <textarea name="resumen_tl5" class="tiny" id="resumen_tl5" style="width:100%;height:166px;"><?=$_SESSION["abstract"]["resumen_tl5"]?></textarea>

            
            <!--<div class="titulo_box"><strong><?=$lang['RESUMEN6']?></strong></div>
                <textarea name="resumen_tl6" class="tiny" id="resumen_tl6" style="width:100%;height:166px;"><?=$_SESSION["abstract"]["resumen_tl6"]?></textarea>-->
   </div><br /><br />
   Palabras totales: <span id="totalwords"></span>
   <input type="hidden" name="tw" />
   
   <br /><br />
           
    <div>
        <!--<?=$lang['PALABRAS_CLAVES']?>: <input type="text" name="palabra_clave1" style="width:90px" value="<?=$_SESSION["abstract"]["palabra_clave1"]?>" /> <input type="text" name="palabra_clave2" style="width:90px" value="<?=$_SESSION["abstract"]["palabra_clave2"]?>" /> <input type="text" name="palabra_clave3" style="width:90px" value="<?=$_SESSION["abstract"]["palabra_clave3"]?>" /> <input type="text" name="palabra_clave4" style="width:90px" value="<?=$_SESSION["abstract"]["palabra_clave4"]?>" /> <input type="text" name="palabra_clave5" style="width:90px" value="<?=$_SESSION["abstract"]["palabra_clave5"]?>" />
    	</div>-->
        <div style="clear:both"></div>
        <br /><br />
          
    
	<!--
        <div align="center">
        <p><a href="#" id="link_tl" style="color:red; font-weight:bold; border:1px solid gray; background-color:#F0F0F0; dsiplay:block; padding:10px;"><?=$lang['SUBIR_ARCHIVO']?></a></p>
        <p id="txt_tl" style="font-size:17px; margin-top:25px; display:none"><span></span> <img src="img/cross.png" width="16" height="16"  alt="" title="No subir archivo"/></p>
        <p><strong><?=$lang['ARCHIVO_EXTENSION']?></strong></p>
        <input type="file" name="archivo_tls" style="display:none" />
        <input type="hidden" name="archivo_tl_viejo" value="<?=$_SESSION["abstract"]["archivo_tl"]?>" style="display:none" />
        </div>-->
    <br />
    <div id="div_datos_contacto">
   	  <span class="titulo_box" style="font-size:16px"><?=$lang['DATOS_CONTACTO']?></span><br /><br />
      <span style="font-size:12px; margin-left:40px">A través de los emails de contacto usted recibirá información.</span><br />
<span style="font-size:12px; margin-left:40px">Para asegurar la comunicación, solicitamos que uno de los dos no sea HOTMAIL.</span><br /><br />
        <table width="811" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td width="58">E-mail</td>
    <td><input type="text" name="contacto_mail" value="<?=$_SESSION["abstract"]["contacto_mail"]?>" style="width:200px" /></td>
    <td>E-mail alternativo</td>
    <td><input type="text" name="contacto_mail2" value="<?=$_SESSION["abstract"]["contacto_mail2"]?>" style="width:200px" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><?=$lang['NOMBRES']?></td>
    <td width="218"><input type="text" name="contacto_nombre" style="width:200px" value="<?=$_SESSION["abstract"]["contacto_nombre"]?>" /></td>
    <td width="50"><?=$lang['APELLIDO']?></td>
    <td width="147"><input type="text" name="contacto_apellido" style="width:200px" value="<?=$_SESSION["abstract"]["contacto_apellido"]?>" /></td>
    <td width="93">&nbsp;</td>
    <td width="197">&nbsp;</td>
    </tr>
  <tr>
    <td><?=$lang['INSTITUCION']?></td>
    <td ><input type="text" name="contacto_institucion" style="width:200px" value="<?=$_SESSION["abstract"]["contacto_institucion"]?>" /></td>
    <td><?=$lang['COUNTRY']?></td>
    <td><select name="contacto_pais" style="width:210px">
    	<option value=""></option>
        <option value="231">Uruguay</option>
        <?php
			$contactoPais = $core->getPais();
			foreach($contactoPais as  $rowp){
				if($rowp["ID_Paises"]==$_SESSION["abstract"]["contacto_pais"]){
					$chkp = "selected";
				}
				echo '<option value="'.$rowp["ID_Paises"].'" '.$chkp.'>'.$rowp["Pais"].'</option>';
				$chkp = "";
			}
		?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?=$lang['CIUDAD']?></td>
    <td><input type="text" name="contacto_ciudad" style="width:200px" value="<?=$_SESSION["abstract"]["contacto_ciudad"]?>" /></td>
    <td><?=$lang['TELEFONO']?></td>
    <td><input type="text" name="contacto_telefono" style="width:200px" value="<?=$_SESSION["abstract"]["contacto_telefono"]?>" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <!--<tr>
    <td colspan="6"><?=$lang['CONTACTO_DATOS']?> </td>
    </tr>-->
        </table>

    </div>
    
    <br />
    <div align="center" class="input_next" style="margin-top:20px; margin-bottom:20px;"><input type="button" id="step2back" value="<?=$lang['VOLVER']?>" />&nbsp;&nbsp; <!--<input type="submit" value="<?=$lang["ENVIAR"]?>" />--><input type="button" id="step2" value="<?=$lang['ACEPTAR_TRABAJO']?>" style="width:320px" /></div>
</div>
 </form>   
</div>
<?
//}
?>
</div>
</body>
</html>