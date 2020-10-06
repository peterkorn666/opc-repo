<?php
	session_start();
	error_reporting(E_ALL ^ E_NOTICE);
	/*require("class/browser.php");
	$browser = new Browser();
	if( $browser->getBrowser() == Browser::BROWSER_IE && $browser->getVersion() <= 10 ) {
		echo '<br><br><h2 align="center" style="color:red">You should complete form using other browser or update your Internet Explorer.</h2>';
		die();
	}*/
	
	require("../init.php"); var_dump('aca');die();
	require("class/core.php");
	require("class/abstract.php");
    $browser = new Browser();
	$trabajos = new abstracts();
	$core = new core();
	$getConfig = $core->getConfig();

	$_SESSION["abstract"]['tipo_tl'] = 1;
	
	/*if($_GET['type'])
	{
		if($_GET['type']!='1' && $_GET['type']!='2' && $_GET['type']!='3')
		{
			\Redirect::to($getConfig['url_base'].'cuenta');
			die();
		}
		unset($_SESSION['abstract']);
		$_SESSION["abstracts"]['tipo_tl'] = $_GET['type']; //se usa para separar contenido. ponencias, mesas, libros, videos, fotografia
		
		if($_SESSION["abstracts"]['tipo_tl']=='1' || $_SESSION["abstracts"]['tipo_tl']=='2'){
			$_SESSION["abstract"] = array();
			$_SESSION["abstract"]["tipo_tl"] = $_GET['type'];
		}
		
        \Redirect::to($getConfig['url_opc'].'abstract');
	}
    if(!isset($_SESSION["abstracts"]['tipo_tl'])){
        \Redirect::to($getConfig['url_base'].'cuenta');
        die();
    }
    if($_SESSION["abstracts"]['tipo_tl']=='1'){
        $css_panel_hiden = '';
        $css_trabajo_hiden = 'display:none';
		$css_libro_video_foto_hidden = 'display:none';
    }else if($_SESSION["abstracts"]['tipo_tl']=='2')
    {
        $css_panel_hiden = 'display:none';
        $css_trabajo_hiden = '';
		$css_libro_video_foto_hidden = 'display:none';
    }
	else {
		$css_panel_hiden = 'display:none';
        $css_trabajo_hiden = 'display:none';
		$css_libro_video_foto_hidden = '';
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
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript">
jQuery.noConflict();
</script>
<script type="text/javascript" src="js/editor/editor.js"></script>
<script language="javascript" type="text/javascript" src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<!--<script language="javascript" type="text/javascript" src="mce/mce.min.js"></script>-->
<script type="text/javascript">
//var animation = '<?=$animation?>';
var animation = false;
</script>
<script type="text/javascript" src="http://cdn.tinymce.com/4/tinymce.min.js"></script>
<script type="text/javascript" src="tinymce/langs/es.js"></script>
<script type="text/javascript" src="js/base64.js"></script>
<script type="text/javascript" src="js/underscore-min.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>

<!-- Editor html5 -->

<!-- include libries(jQuery, bootstrap, fontawesome) -->

<link rel="stylesheet" type="text/css" href="estilos/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="tinymce/skins/lightgray/skin.min.css"/>
<!--<link rel="stylesheet" type="text/css" href="estilos/bootstrap-wysihtml5.css"></link>

<script src="js/bootstrap.min.js"></script> -->
<link href="estilos/font-awesome.min.css">

<script src="js/editor/wysihtml5-0.3.0.js"></script>
<script src="js/editor/prettify.js"></script>
<script src="js/editor/bootstrap-wysihtml5.js"></script>

 <script src="js/editor/bootbox.min.js"></script>

<script type="text/javascript">
jQuery(document).ready(function($) {
    /*$('#titulo_tl').wysihtml5({
		"font-styles": false, //Font styling, e.g. h1, h2, etc. Default true
		"emphasis": true, //Italics, bold, etc. Default true
		"lists": false, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
		"html": true, //Button which allows you to edit the generated HTML. Default false
		"link": false, //Button to insert a link. Default true
		"image": false, //Button to insert an image. Default true,
		"color": false, //Button to change color of font
		"stylesheets": ["estilos/customeditor.css"]
	});*/
	/*$('#resumen_tl,#resumen_tl2,#resumen_tl3').wysihtml5({
		"font-styles": false, //Font styling, e.g. h1, h2, etc. Default true
		"emphasis": true, //Italics, bold, etc. Default true
		"lists": false, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
		"html": false, //Button which allows you to edit the generated HTML. Default false
		"link": false, //Button to insert a link. Default true
		"image": false, //Button to insert an image. Default true,
		"color": false, //Button to change color of font
		 events: {
			load: function() {
				var some_wysi = $('#resumen_tl').data('wysihtml5').editor;
				total_words = 0;
				get_words = some_wysi.getValue(true).split(" ");
				total_words = get_words.length;
				$(some_wysi.composer.element).bind('keyup', function(){
					get_words = some_wysi.getValue(true).split(" ");
					total_words = get_words.length; 
					$("input[name='words_total']").val(total_words);
					$("#txt_words_total").html("Palabras: "+total_words);
				});
				$("input[name='words_total']").val(total_words);
				$("#txt_words_total").html("Palabras: "+total_words);
			}
		}
	});*/
	
	tinymce.init({		
		selector:"#titulo_tl",
		plugins:["charmap","visualblocks","paste","legacyoutput"],
		menubar: false,
		statusbar: false,
		height:"60",
		resize:!1,
		toolbar:"undo redo | bold italic | superscript subscript | charmap",
		format:'text'
	})
	
	tinymce.init({		
		//selector:"#resumen_tl,#resumen_tl2,#resumen_tl3",
		selector:"#resumen_tl",
		plugins:["charmap","visualblocks","paste","legacyoutput", "wordcount"],
		menubar: false,
		//statusbar: false,
		resize:!1,
		toolbar:"undo redo | bold italic underline | superscript subscript | charmap",
		format:'text',
	})
	
	$(prettyPrint);
	/*$(document).on("click", ".specialchars", function(e) {
		bootbox.dialog({
			title: "Car&aacute;cteres especiales",
			message: specialchars
		});
	});*/

	
	init();
	initEffect();
});
	
</script>
<!-- //Editor html5 -->
</head>

<body>
<?php
$beta = substr($_SERVER["SERVER_NAME"],0,4);
if($beta == "beta"):
?>
<div id="beta-alert"></div>
<?php
endif;
?>
<div id="contenedor">
	<div id="banner" align="center"><img src="<?=$getConfig["banner_congreso"]?>" alt="<?=$getConfig["nombre_congreso"]?>" />
    	<!--div align="right"><a href="?lang=es">Español</a> - <a href="?lang=en">Ingles</a></div-->
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
   		<div class="login"><a href="#" class="link_login">Para modificar su ponencia haga click aquí</a></div>
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
    
   <form action="guardar.php" name="peview" method="post" enctype="multipart/form-data">    
<?php
//if(!empty($_SESSION["abstract"]["titulo_tl"])){
?>
        <div id="effect_one" align="center" style="margin-top:20px">
        	<?php 
				/*
				if ($_SESSION["abstracts"]['tipo_tl'] == '2') {
					$ver_pautas = '(<a href="http://www.alasru.org/index.php/congresos/presentacion-de-mesas-redondas" target="_blank">Ver Pautas</a>)';
				}
				else{
					$ver_pautas = '';
				}
				*/
			?>
        	<?=$lang['BIENVENIDA'].' '.$lang['VER_PAUTAS'];?><br></p>
			
           <? if($_SESSION["abstract"]["numero_tl"]!=""){ ?> <p>Trabajo N&deg; <?=$_SESSION["abstract"]["numero_tl"]?></p> <? } ?>
        </div>
<div id="preview_step1" style="color:black;"></div>        
<div id="mod_step1">    
		<div id="editor_titulo_tl" style="width:80%; margin:0 auto">
        	<div class="hide_titulo"><a href="#">
            	<?=$lang['HABILITAR_SEC1']?>
            </a></div>
            <div class="titulo_box"><?=$lang['TITULO']?>:</div>
           <!-- <div class="editor-form">
            <fieldset>
              <!--<button type="button" class="btn" data-ed="cmd=bold"><b>Bold</b></button>->
              <button type="button" class="btn" data-ed="cmd=italic"><i>Italic</i></button>
              <button type="button" class="btn" data-ed="cmd=underline"><u>Underline</u></button>
              <button type="button" class="btn" data-ed="cmd=superscript">x<sup>2</sup></button>
              <button type="button" class="btn" data-ed="cmd=subscript">x<sub>2</sub></button>
            </fieldset>
            <div style="clear:both"></div>
            <div id="div_titulo_tl" class="editor innercircle" contenteditable="true" style="height:40px;"><?=$_SESSION["abstract"]["titulo_tl"]?>&nbsp;</div><!--not empty for Fx's cursor->
            <textarea id="titulo_tl" maxlength="30" name="titulo_tl"><?=$_SESSION["abstract"]["titulo_tl"]?></textarea>
            </div>-->
            <textarea name="titulo_tl" class="std-radius tiny" id="titulo_tl" style="width:100%;height:40px;" maxlength="30" placeholder="Escriba o pegue aquí el título de su trabajo"><?=$_SESSION["abstract"]["titulo_tl"]?></textarea>
        </div>
           
        <div id="div_autores">
        	<div><strong><?=$lang['AUTORES']?>: </strong> </div>
        	<!--<p><?=$lang['TXT_AUTORES']?> <span>--><input type="hidden" maxlength="2" style="width:40px;text-align:center;margin-top:6px" name="total_autores" class="std-radius" value="0" readonly="readonly" /><!--<span class="mas_autor nuevo_autor">+</span></span></p>-->
            <div style="float:right">
            		<strong><?=$lang['MARCA_PRESENTADOR']?></strong>
            </div>
            <div style="clear:both"></div>
            <div id="div_agregar_autores" align="center">
              <div class="row" style="margin:0px;">
            	<div class="col-xs-2" align="left" style="margin-left:10px;padding:0px;font-size:11px;"><?=$lang['NOMBRES']?></div>
                <div class="col-xs-2" align="left" style="padding:0px;font-size:11px;"><?=$lang['APELLIDOS']?></div>
                <div class="col-xs-1" align="left" style="margin-right:24px;padding:0px;font-size:11px;"><?=$lang['PASAPORTE']?></div>
                <div class="col-xs-2" align="left"><?=$lang['INSTITUCION']?></div>
                <div class="col-xs-2" align="left">E-mail</div>
                <div class="col-xs-1" align="left"><?=$lang['PAIS']?></div>
            </div>
            <div style="clear:both"></div>
            <?php
				$default_cant_autores = 1;
				for($i=0;$i<($_SESSION["abstract"]["total_autores"]>0?$_SESSION["abstract"]["total_autores"]:$default_cant_autores);$i++){
			?>
			<table class="table_autores" border="0" cellspacing="0" cellpadding="4">
                  <tr>
                    <td  class="numero_autor">Autor_</td>
                    <td>
                    	<input type="text" name="nombre_"  class="" value="<?=$_SESSION["abstract"]["nombre_".$i]?>" style="width:120px" />
                    </td>
                    <td>
                    	<input type="text" name="apellido_"  class="searchAutor" autocomplete="off" value="<?=$_SESSION["abstract"]["apellido_".$i]?>" style="width:120px" />
                        <!--<input type="text" name="apellido2_" style="width:93px" class="searchAutor" autocomplete="off" value="<?=$_SESSION["abstract"]["apellido2_".$i]?>" />-->
                    </td>
                    <td>
                    	<input type="text" name="pasaporte_" value="<?=$_SESSION["abstract"]["pasaporte_".$i]?>" style="width:95px" />
                    </td>
                    <td><input type="text" class="autoins" name="institucion_" value="<?=$_SESSION["abstract"]["institucion_".$i]?>" /></td>
                    <td><input type="email" name="email_" value="<?=$_SESSION["abstract"]["email_".$i]?>" /></td>
                    <td><select name="pais_" style="width:120px" class="paisautor">
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
                    	<td><input type="checkbox" class="lee" name="lee_" <?=($_SESSION["abstract"]["lee_".$i]?"checked":"")?> value="1" style="width:14px; "  />                      <input type="hidden" class="nochange" name="id_autor[]" value="<?=$_SESSION["abstract"]["id_autor_".$i]?>" /></td>
                    
                  </tr>
                </table>
			<?
				}
			?>
            </div>
            
             <div id="control_autor">
           	 	<div id="div_eliminar_autor" align="right"><a href="#"  class="eliminar_autor"><span class="round_link">-</span> <?=$lang['ELIMINAR_AUTOR']?></a></div>
          		<div id="div_nuevo_autor" align="right"><a href="#"  class="nuevo_autor"><span class="round_link">+</span> <?=$lang['AGREGAR_AUTOR']?> 
          		<br />
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></div>
            	<div style="clear:both"></div>
        	 </div>
             <?php
			 if($_SESSION["abstract"]["id_tl"])
			 	echo '<div id="div_invitacion"></div>';
			 ?>
             <input type="hidden" name="t" value="<?=$_SESSION["abstract"]["id_tl"]?>" />
        </div>
        <hr />
        
            <div id="div_resumen_tl" style="width:100%;">
            
            <div class="titulo_box"><?=$lang['RESUMEN']?></div>
            <textarea name="resumen_tl" class="tiny" id="resumen_tl" style="width:100%;height:166px;"><?=$_SESSION["abstract"]["resumen_tl"]?></textarea>
            
            <!--<div class="titulo_box"><?=$lang['RESUMEN2']?></div>
            <textarea name="resumen_tl2" class="tiny" id="resumen_tl2" style="width:100%;height:166px;"><?=$_SESSION["abstract"]["resumen_tl2"]?></textarea>-->
            
            <!--<div class="titulo_box"><?=$lang['RESUMEN3']?></div>
            <textarea name="resumen_tl3" class="tiny" id="resumen_tl3" style="width:100%;height:166px;"><?=$_SESSION["abstract"]["resumen_tl3"]?></textarea>-->
            <input type="hidden" name="words_total" value="0"  />
            
            <div id="limits_words" style="margin:0 0 30px 0;">
                <span style="color:red">Palabras limites: de 300 a 350</span>
                    
                <div id="txt_words_total" style=""></div>
            </div>
		
            
            <div style="clear:both"></div>

            	<?=$lang['PALABRAS_CLAVES']?>: 
                <input type="text" name="palabra_clave1" style="width:90px" value="<?php echo $_SESSION["abstract"]["palabra_clave1"]?>" /> 
                <input type="text" name="palabra_clave2" style="width:90px" value="<?php echo $_SESSION["abstract"]["palabra_clave2"]?>" /> 
                <input type="text" name="palabra_clave3" style="width:90px" value="<?php echo $_SESSION["abstract"]["palabra_clave3"]?>" /> 
                <!--<input type="text" name="palabra_clave4" style="width:90px" value="<?php echo $_SESSION["abstract"]["palabra_clave4"]?>" /> 
                <input type="text" name="palabra_clave5" style="width:90px" value="<?php echo $_SESSION["abstract"]["palabra_clave5"]?>" />-->
            </div>
            <div style="clear:both"></div>
            <br /><br />
        
        
        <div class="row">
            <div class="col-xs-2">
            <?=$lang['EJES_TEMATICOS']?>
            </div>
            <div class="col-xs-9">
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
        
    <!--<div class="row">
        <div class="col-xs-2">
        <?php //echo $lang['MODALIDAD']; ?>
        </div>
        <div class="col-xs-9">
        <?php
            /*
			$getModalidades = $core->getModalidades();
            foreach($getModalidades as $rowModalidad)
            {
                if($rowModalidad["id"]==$_SESSION["abstract"]["modalidad"])
                    $chk = "checked";
                echo "<input type='radio' style='width:auto' name='modalidad' value='".$rowModalidad["id"]."' $chk> &nbsp;".$rowModalidad["nombre"]."&nbsp;&nbsp;&nbsp;&nbsp;";
                $chk = "";
            }
			*/
        ?>
        </div>
    </div>-->
    
    <!--<div class="row" style="<?php echo $css_panel_hiden?>">
        <div class="col-xs-2">
        <?php //echo $lang['IDIOMA']; ?>
        </div>
        <div class="col-xs-9">
        <?php
            /*$getIdiomas = $trabajos->getIdiomas();
            foreach($getIdiomas as $rowIdiomas)
            {
                if($rowIdiomas["id"]==$_SESSION["abstract"]["idioma_tl"])
                    $chk = "checked";
                echo "<input type='radio' style='width:auto' name='idioma_tl' value='".$rowIdiomas["id"]."' $chk> &nbsp;".$rowIdiomas["idioma"]."&nbsp;&nbsp;&nbsp;&nbsp;";
                $chk = "";
            }*/
        ?>
        </div>
    </div>-->

        <!--<div align="center" style="<?php echo $css_trabajo_hiden ?>">
            <p style="border:1px solid gray; background-color:#F0F0F0; padding:10px; width:650px"><a href="#" id="link_cv" style="color:red; font-weight:bold;  dsiplay:block; "><?=$lang['SUBIR_CV']?></a></p>
            <p id="txt_cv" style="font-size:17px; margin-top:25px; display:none"><span></span> <img src="img/cross.png" width="16" height="16"  alt="" title="No subir archivo"/></p>
            <p><strong><?=$lang['ARCHIVO_EXTENSION']?></strong></p>
            <input type="file" name="archivo_cv[]" multiple style="display:none" />
        </div><br><br>-->
        
        <div id="second_step" class="input_next"><input type="button" id="step1" value="<?=$lang['CONTINUAR']?>" /></div><br><br>
</div>  


<div id="preview_step2"></div>
<div id="mod_step2">   
	<hr style="margin:20px 0;" color="#CCCCCC" />
    
   <div>
   <br />

	<div align="center" style="display: none;">
        <p><a href="#" id="link_tl" style="color:red; font-weight:bold; border:1px solid gray; background-color:#F0F0F0; dsiplay:block; padding:10px;"><?=$lang['SUBIR_ARCHIVO']?></a></p>
        <p id="txt_tl" style="font-size:17px; margin-top:25px; display:none"><span></span> <img src="img/cross.png" width="16" height="16"  alt="" title="No subir archivo"/></p>
        <!--<p><strong><?=$lang['ARCHIVO_EXTENSION']?></strong></p>-->
        <input type="file" name="archivo_tl" style="display:none" />
        <input type="hidden" name="archivo_tl_viejo" value="<?=$_SESSION["abstract"]["archivo_tl"]?>" style="display:none" />
	</div>

    <br />
    <div id="div_datos_contacto">
   	  <span class="titulo_box"><?=$lang['DATOS_CONTACTO']?></span><br /><br />
        <table width="811" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td width="58"><?=$lang['EMAIL']?></td>
    <td><input type="text" name="contacto_mail" value="<?=$_SESSION["abstract"]["contacto_mail"]?>" style="width:200px" /></td>
    <td><?=$lang['EMAIL_ALTERNATIVO']?></td>
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
    <td><!--<?=$lang['COUNTRY']?>--></td>
    <td><!--<select name="contacto_pais" style="width:210px">
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
    </select>--></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <!--<tr>
    <td><?=$lang['CIUDAD']?></td>
    <td><input type="text" name="contacto_ciudad" style="width:200px" value="<?=$_SESSION["abstract"]["contacto_ciudad"]?>" /></td>
    <td><?=$lang['TELEFONO']?></td>
    <td><input type="text" name="contacto_telefono" style="width:200px" value="<?=$_SESSION["abstract"]["contacto_telefono"]?>" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>-->
  <!--<tr>
    <td colspan="6"><?=$lang['CONTACTO_DATOS']?> </td>
    </tr>-->
        </table>

    </div>
    
    <br />
    <div align="center" class="input_next" style="margin-top:20px; margin-bottom:20px;"><input type="button" id="step2back" value="<?=$lang['VOLVER']?>" />&nbsp;&nbsp; <input type="submit" value="<?=$lang["ENVIAR"]?>" /><!--<input type="button" id="step2" value="<?=$lang['ACEPTAR_TRABAJO']?>" style="width:320px" />--></div>
</div>
	<!--<input type="hidden" value="<?php echo $_SESSION['abstracts']['tipo_tl']?>" name="abstracts_tipo_tl">-->
 </form>   
</div>
<?
//}
?>
</div>
</body>
</html>
<script>
  /*(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-89204362-1', 'auto');
  ga('send', 'pageview');*/
	
</script>