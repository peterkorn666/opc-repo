<?php
	session_start();
	/*if(!$_SESSION["abstract"]["is_admin"] && empty($_SESSION["abstract"]["id_tl"]) && !$_SESSION["admin"] && ($_GET["u"] != 1)){
		header("Location: modificar_trabajo.php");die();
	}*/
	/*if(empty($_SESSION["abstract"]["reglamento"]) || empty($_SESSION["abstract"]["modalidad"])){
	    header("Location: reglamento.php");die();
    } else if($_SESSION["abstract"]["reglamento"] == '2' && empty($_SESSION["abstract"]["conflicto_descripcion"])) {
        header("Location: reglamento.php");die();
    }*/
	error_reporting(E_ALL ^ E_NOTICE);
	require("class/Browser.class.php");
	$browser = new Browser();
	if( $browser->getBrowser() == Browser::BROWSER_IE && $browser->getVersion() <= 10 ) {
		echo '<br><br><h2 align="center" style="color:red">You should complete form using other browser or update your Internet Explorer.</h2>';
		die();
	}
	//var_dump($_SESSION["abstract"]);
	
	require("../init.php");
	require("class/DB.class.php");
	require("class/core.php");//var_dump('aca');die();
	require("class/abstract.php");
    $browser = new Browser();
	$trabajos = new abstracts();
	$core = new core();
	$getConfig = $core->getConfig();

    $palabras_clave = $core->getPalabrasClave();
    $titulos_academicos = $trabajos->getTitulosAcademicosHabilitados();
    $instituciones = $trabajos->getInstitucionesHabilitadas();

    if($_GET["lang"]=="" && $_SESSION["abstract"]["lang"]=="")
        $_SESSION["abstract"]["lang"] = "es";
    else if($_GET["lang"]!=""){
        if($_GET["lang"] != "es" && $_GET["lang"] != "en" && $_GET["lang"] != "pt"){
            header("Location: index.php");die();
        }
        $_SESSION["abstract"]["lang"] = $_GET["lang"];
    }

	//$_SESSION["abstract"]['tipo_tl'] = 1;
	
	
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

$disabled = "";
$display = "";
if(!empty($_SESSION["abstract"]["id_tl"]) && !$_SESSION["abstract"]["is_admin"]){
    $disabled = "readonly='readonly'";
    $display = "style='display:none;'";
}

?>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$getConfig["nombre_congreso"]?></title>

    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link href="../../font-awesome/css/all.css" type="text/css" rel="stylesheet" />

    <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/idioma.js"></script>

    <script type="text/javascript">
        jQuery.noConflict();
        var animation = false;
    </script>
    <script type="text/javascript" src="js/base64.js"></script>
    <script type="text/javascript" src="js/lang/<?=$_SESSION["abstract"]["lang"]?>.js"></script>
    <script type="text/javascript" src="js/funciones.js"></script>
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>

    <!--<link rel="stylesheet" href="estilos/estilos.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="estilos/editor.css" />
    <script type="text/javascript" src="js/jquery1.11.1.js"></script>
    <script type="text/javascript" src="js/prototype.js"></script>
    <script type="text/javascript">
    jQuery.noConflict();
    </script>
    <script type="text/javascript" src="js/editor/editor.js"></script>
    <script language="javascript" type="text/javascript" src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <script type="text/javascript" src="js/base64.js"></script>
    <script type="text/javascript" src="js/lang/<?=$_SESSION["abstract"]["lang"]?>.js"></script>
    <script type="text/javascript" src="js/funciones.js"></script>
    <link rel="stylesheet" type="text/css" href="estilos/bootstrap.min.css">
    <link href="estilos/font-awesome.min.css">
    <script src="ckeditor/ckeditor.js"></script>-->

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var lang = '<?=$_SESSION["abstract"]["lang"]?>';

            CKEDITOR.replace( 'titulo_tl',{
                language: lang,
                height: 100,
                enterMode : CKEDITOR.ENTER_BR,
            });

            CKEDITOR.replace( 'resumen_tl',{
                language: lang,
                height: 200,
                enterMode : CKEDITOR.ENTER_BR,
                extraPlugins: 'simpleuploads,specialchar,htmlwriter,wordcount,notification'
            });

            /*CKEDITOR.replace( 'resumen_tl2',{
                language: 'es',
                height:200,
                enterMode : CKEDITOR.ENTER_BR,
                extraPlugins: 'simpleuploads,specialchar,htmlwriter,wordcount,notification'
            });

            CKEDITOR.replace( 'resumen_tl3',{
                language: 'es',
                height:200,
                enterMode : CKEDITOR.ENTER_BR,
                extraPlugins: 'simpleuploads,specialchar,htmlwriter,wordcount,notification'
            });*/

            init();
            initEffect();
        });
    </script>
</head>

<body>
    <?php
    if($_SERVER["SERVER_NAME"] == "localhost"):
        ?>
        <div id="beta-alert"></div>
    <?php
    endif;
    ?>
    <div class="container">
        <div align="center">
            <div class="col-md-6">
                <img src="<?=$getConfig["banner_congreso"]?>" alt="<?=$lang["NOMBRE_CONGRESO"]?>" class="img-fluid">
            </div>
        </div>
        <div align="center" class="div_idioma">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6" style="margin-top: 0px; padding: 0px;">
                        <input type="button" onClick="es()" value="<?=$lang["TXT_SPANISH"]?>" class="btn btn-link form-control" style="color: black;">
                    </div>
                    <!--<div class="col-md-4" style="margin-top: 0px; padding: 0px;">
                        <input type="button" onClick="en()" value="<?=$lang["TXT_ENGLISH"]?>" class="btn btn-link form-control" style="color: black;">
                    </div>-->
                    <div class="col-md-6" style="margin-top: 0px; padding: 0px;">
                        <input type="button" onClick="pt()" value="<?=$lang["TXT_PORTUGUES"]?>" class="btn btn-link form-control" style="color: black;">
                    </div>
                </div>
            </div>
        </div><br>

        <div align="center">
            <?php
            if($_GET['error'] == 'empty'){
                ?>
                <div class="col-md-8">
                    <div class="alert alert-danger">
                        Todos los campos son obligatorios.
                    </div>
                </div>
                <?php
            }
            if($_GET['error'] == 'emptyp'){
                ?>
                <div class="col-md-8">
                    <div class="alert alert-danger">
                        Debe completar el Apellido Paterno o Materno.
                    </div>
                </div>
                <?php
            }
            if($_GET['error'] == 'file'){
                ?>
                <div class="col-md-8">
                    <div class="alert alert-danger">
                        El archivo no tiene un fomato válido.
                    </div>
                </div>
                <?php
            }
            if($_GET['error'] == 'size'){
                ?>
                <div class="col-md-8">
                    <div class="alert alert-danger">
                        El archivo es muy pesado.
                    </div>
                </div>
                <?php
            }
            ?>

            <?php
            if($_SESSION["admin"]){
                if(empty($_SESSION["abstract"]["id_tl"])){
                    ?>
                    <!--<div class="login col-md-10 text-left">
                        <a href="#" class="link_login">Para editar su trabajo haga click aquí</a>
                    </div>
                    <div class="login col-md-10 text-left" style="display: none;">
                        <form action="login.php" method="post">
                            <div class="row" style="padding-bottom: 10px;">
                                <div class="col-md-4">
                                    <label>Número de trabajo</label>
                                    <input type="text" name="codigo" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label>Clave</label>
                                    <input type="text" name="clave" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="submit" value="Ingresar" class="btn btn-primary btn-block">
                                </div>
                            </div>
                        </form>
                    </div>-->
                    <!--<div class="col-md-10 text-left">
                        <a href="modificar_trabajo.php?lang=<?=$_SESSION['abstract']['lang']?>" style="font-size: 14px;"><?=$lang["LOGIN_TXT"]?></a>
                    </div><br>-->
                    <?php
                } else {
                    ?>
                    <div class="col-md-10 text-left">
                        <a href="salir.php"><?=$lang["TXT_SALIR"]?></a>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="col-md-10 text-right">
                <a class="btn btn-link"
                   href="<?=$getConfig["url_website"]?>"><?=$lang["RETORNAR_WEB"]?></a>
            </div>
        </div>

        <!-- Contenido -->
        <div align="center">
            <form action="guardar.php" name="peview" method="post" enctype="multipart/form-data">
                <input type="hidden" name="es_admin" value="<?=$_SESSION["abstract"]["is_admin"]?>" />
                <div id="effect_one" class="col-md-10">
                    <h3 style="font-weight: bold;"><?=$lang["TXT_BIENVENIDOS"]?></h3>
                    <?=$lang["GRACIAS_POR_RESPONDER"]?><br>
                    <a href="modificar_trabajo.php?lang=<?=$_SESSION['abstract']['lang']?>" style="font-size: 14px;"><?=$lang["LOGIN_TXT"]?></a><br>
                    <?php
                    /*if($_SESSION["abstract"]["lang"] === "pt"){
                        ?>
                        <a href="documentos/pt/ENVIO_DE_PROPOSTAS.pdf" target="_blank"><?=$lang["VER_PAUTAS"]?></a>
                        <?php
                    } else {
                        ?>
                        <a href="documentos/es/ENVIO_DE_TRABAJOS.pdf" target="_blank"><?=$lang["VER_PAUTAS"]?></a>
                        <?php
                    }*/
                    ?>
                    <!--<a href="documentos/REGLAMENTO_PRESENTACION_INTENCIONES.pdf" target="_blank"><?=$lang["VER_PAUTAS"]?></a>-->
                    <!--<br><br>-->

                    <?php
                    if($_SESSION["abstract"]["numero_tl"]!=""){
                        echo $lang["TXT_TRABAJO"]." ".$_SESSION["abstract"]["numero_tl"];
                    }
                    ?>
                    <br>
                </div>

                <div id="preview_step1" class="col-md-10 text-left"></div>
                <div id="mod_step1" class="col-md-10">

                    <div align="center">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="titulo_box text-left">
                                    <?=$lang['MODALIDADES']?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-9 sin_padding_izquierdo">
                                    <select name="modalidad" class="form-control">
                                        <option value=""></option>
                                        <?php
                                        $modalidades = $core->getModalidades();
                                        foreach($modalidades as $modalidad)
                                        {
                                            if($modalidad["id"]==$_SESSION["abstract"]["modalidad"])
                                                $chk = "selected";
                                            echo "<option value='".$modalidad["id"]."' data-tiene_eje='".$modalidad['tiene_eje']."' data-tiene_descripcion='".$modalidad['tiene_descripcion']."' ".$chk.">"
                                                .$modalidad["modalidad_".$_SESSION["abstract"]["lang"]]."</option>";
                                            $chk = "";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3 div-no_tiene_descripcion">
                                    <a href="<?=$lang['TXT_MODALIDADES_LINK']?>" target="_blank"><?=$lang["TXT_DESCRIPCION"]?></a>
                                </div>
                            </div>
                        </div><br>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="div-tiene_descripcion text-left" style="font-weight:
                                bold;">
                                    <?=$lang['TXT_DETALLES_NO_TIENE_EJE']?><br>
                                </div>
                            </div>
                        </div><br>
                    </div>


                    <div id="editor_titulo_tl">
                        <div class="hide_titulo">
                            <a href="#"><?=$lang['HABILITAR_SEC1']?></a>
                        </div>
                        <div class="titulo_box text-left">
                            <?=$lang['TITULO']?>:
                        </div>
                        <textarea id="titulo_tl" name="titulo_tl" class="std-radius tiny" maxlength="30" placeholder="Escriba o pegue aquí el título de su trabajo"><?=$_SESSION["abstract"]["titulo_tl"]?></textarea>
                    </div><br>

                    <div id="div_autores">
                        <div class="text-left" style="font-weight: bold;">
                            <?=$lang['AUTORES']?>:
                            <input type="hidden" name="total_autores" maxlength="2" class="std-radius" readonly="readonly" />
                        </div>
                        <div id="div_agregar_autores">
                            <?php
                            $default_cant_autores = 1;
                            /*if ($_SESSION["abstracts"]['tipo_tl'] == '2'){
                                $default_cant_autores = 3;
                            }*/
                            $total_autores = ($_SESSION["abstract"]["total_autores"]>0?$_SESSION["abstract"]["total_autores"]:$default_cant_autores);
                            for ($i = 0; $i < $total_autores; $i++){

                                $disabled_profesion = "";
                                $disabled_nombre = "";
                                $disabled_apellido = "";
                                $disabled_institucion = "";
                                $disabled_email = "";
                                $disabled_pais = "";
                                /*if ($disabled != ""){
                                    if(!empty($_SESSION["abstract"]["profesion_".$i])){
                                        //$disabled_profesion = "disabled";
                                        $disabled_profesion = "readonly='readonly'";
                                        $disabled_profesion_txt = "readonly='readonly'";
                                    }
                                    if(!empty($_SESSION["abstract"]["nombre_".$i]))
                                        $disabled_nombre = "readonly='readonly'";
                                    if(!empty($_SESSION["abstract"]["apellido_".$i]))
                                        $disabled_apellido = "readonly='readonly'";
                                    if(!empty($_SESSION["abstract"]["institucion_".$i])){
                                        //$disabled_institucion = "disabled";
                                        $disabled_institucion = "readonly='readonly'";
                                        $disabled_institucion_txt = "readonly='readonly'";
                                    }
                                    if(!empty($_SESSION["abstract"]["email_".$i]))
                                        $disabled_email = "readonly='readonly'";
                                    if(!empty($_SESSION["abstract"]["pais_".$i]))
                                        $disabled_pais = "readonly='readonly'";
                                }*/
                                ?>
                                <div class="table_autores col-md-12 text-left">
                                    <div class="row">
                                        <div class="col-md-12 sin_padding_izquierdo padding_horizontal">
                                            <?=$lang["TXT_AUTOR"]?> <span class="numero_autor"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 sin_padding_izquierdo padding_horizontal">
                                            <label><?=$lang['NOMBRES']?></label>
                                            <input type="text" name="nombre_" value="<?=$_SESSION["abstract"]["nombre_".$i]?>" class="form-control" <?=$disabled_nombre?> /><!-- placeholder="<?=$lang['NOMBRES']?>" -->
                                        </div>
                                        <div class="col-md-4 sin_padding_izquierdo padding_horizontal">
                                            <label><?=$lang['APELLIDOS']?></label>
                                            <input type="text" name="apellido_" autocomplete="off" value="<?=$_SESSION["abstract"]["apellido_".$i]?>" class="searchAutor form-control" <?=$disabled_nombre?> /><!-- placeholder="<?=$lang['APELLIDOS']?>" -->
                                        </div>
                                        <div class="col-md-4 sin_padding_izquierdo padding_horizontal">
                                            <!--<label><?=$lang['PROFESION']?></label>
                                            <select name="profesion_" class="profesion form-control" <?=$disabled_profesion?>>
                                                <option value=""></option>
                                                <?php
                                            $slctd = "";
                                            foreach($titulos_academicos as $titulo_academico){
                                                if($_SESSION["abstract"]["profesion_".$i] == $titulo_academico["nombre_titulo_academico_".$_SESSION["abstract"]["lang"]])
                                                    $slctd = "selected";
                                                ?>
                                                    <option value="<?=$titulo_academico['nombre_titulo_academico_'.$_SESSION["abstract"]["lang"]]?>" <?=$slctd?>>
                                                        <?=$titulo_academico['nombre_titulo_academico_'.$_SESSION["abstract"]["lang"]]?>
                                                    </option>
                                                    <?php
                                                $slctd = "";
                                            }
                                            ?>
                                            </select>
                                            <div class="columna_profesion padding_horizontal" style="display: none;">
                                                <input type="text" name="profesion-txt_"  class="form-control" value="<?=$_SESSION["abstract"]["profesion-txt_".$i]?>" <?=$disabled_profesion_txt?> />
                                            </div>-->
                                            <label><?=$lang['PERTENENCIA']?></label>
                                            <select name="pertenencia_" class="pertenencia form-control">
                                                <option value=""></option>
                                                <option value="1" <?=($_SESSION["abstract"]["pertenencia_".$i] ==
                                                '1' ? 'selected' : '')?>>
                                                    <?=$lang['PERTENENCIA_OPCIONES'][1]?>
                                                </option>
                                                <option value="2" <?=($_SESSION["abstract"]["pertenencia_".$i] ==
                                                '2' ? 'selected' : '')?>>
                                                    <?=$lang['PERTENENCIA_OPCIONES'][2]?>
                                                </option>
                                                <option value="3" <?=($_SESSION["abstract"]["pertenencia_".$i] ==
                                                '3' ? 'selected' : '')?>>
                                                    <?=$lang['PERTENENCIA_OPCIONES'][3]?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 sin_padding_izquierdo padding_horizontal">
                                            <label><?=$lang['INSTITUCION']?></label>
                                            <select name="institucion_" class="institucion form-control" <?=$disabled_institucion?>>
                                                <option value=""></option>
                                                <?php
                                                $slctd = "";
                                                foreach($instituciones as $institucion){
                                                    if($_SESSION["abstract"]["institucion_".$i] == $institucion["nombre_institucion"])
                                                        $slctd = "selected";
                                                    ?>
                                                    <option value="<?=$institucion['nombre_institucion']?>" <?=$slctd?>>
                                                        <?=$institucion['nombre_institucion']?>
                                                    </option>
                                                    <?php
                                                    $slctd = "";
                                                }
                                                ?>
                                            </select>
                                            <div class="columna_institucion padding_horizontal" style="display: none;">
                                                <input type="text" name="institucion-txt_"  class="form-control" value="<?=$_SESSION["abstract"]["institucion-txt_".$i]?>" <?=$disabled_institucion_txt?> />
                                            </div>
                                        </div>
                                        <div class="col-md-4 sin_padding_izquierdo padding_horizontal">
                                            <label><?=$lang["EMAIL"]?></label>
                                            <input type="email" name="email_" value="<?=$_SESSION["abstract"]["email_".$i]?>" <?=$disabled_email?> class="form-control" /><!-- placeholder="<?=$lang["EMAIL"]?>" -->
                                        </div>
                                        <div class="col-md-4 sin_padding_izquierdo padding_horizontal">
                                            <label><?=$lang['PAIS']?></label>
                                            <select name="pais_" class="paisautor form-control" <?=$disabled_pais?>>
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
                                        </div>
                                    </div>
                                    <?php
                                    if($_SESSION["admin"] || $_SESSION["abstract"]["id_tl"]) {
                                        ?>
                                        <div class="row div_persona_ya_registrada">
                                            <div class="col-md-4 sin_padding_izquierdo padding_horizontal">
                                                <!--<label><?=$lang['DESCARGAR_CONSTANCIA']?></label><br>-->
                                                <?php
                                                /*if ($_SESSION["abstract"]["inscripto_" . $i] == 1) {
                                                    ?>
                                                    <div class="div_constancia">
                                                        <a href="acp/asistente.php?t=<?= base64_encode($_SESSION["abstract"]["id_tl"]) ?>&k=<?= base64_encode($_SESSION["abstract"]["id_autor_" . $i]) ?>"
                                                           style="color: green;"> como asistente</a><br/>
                                                        <a href="acp/ponente.php?t=<?= base64_encode($_SESSION["abstract"]["id_tl"]) ?>&k=<?= base64_encode($_SESSION["abstract"]["id_autor_" . $i]) ?>"
                                                           style="color: green;"> como expositor</a>
                                                    </div>
                                                    <?php
                                                } else {
                                                    echo "<strong style='color: darkred;'>".$lang['PERSONA_NO_PAGA']."</strong>";
                                                }*/
                                                ?>
                                            </div>
                                            <!--<div class="col-md-4 sin_padding_izquierdo padding_horizontal">
                                            <label><?= $lang['ROL'] ?></label>
                                            <select name="rol_" class="form-control">
                                                <option value=""></option>
                                                <?php
                                            $roles = $core->getRolesConferencistas();
                                            foreach ($roles as $rol) {
                                                if ($_SESSION["abstract"]["rol_" . $i] == $rol["ID_calidad"]) {
                                                    $chk_rol = "selected";
                                                }
                                                echo '<option value="' . $rol["ID_calidad"] . '" ' . $chk_rol . '>' . $rol["calidad"] . '</option>';
                                                $chk_rol = "";
                                            }
                                            ?>
                                            </select>
                                        </div>-->
                                        </div>
                                        <?php
                                    } //end div_persona_ya_registrada
                                    else{
                                        echo "<br>";
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12 sin_padding_izquierdo padding_horizontal text-right">
                                            <?=$lang["TXT_PRESENTADOR"]?> <input type="checkbox" class="lee" name="lee_" <?=($_SESSION["abstract"]["lee_".$i]?"checked":"")?> value="1"  />
                                            <input type="hidden" class="nochange" name="id_autor[]" value="<?=$_SESSION["abstract"]["id_autor_".$i]?>" />
                                        </div>
                                    </div>
                                </div><!-- end div table_autores -->
                            <?php
                            }
                            ?>
                        </div>
                        <div id="control_autor">
                            <div class="row">
                                <div class="col-md-3 text-left">
                                    <div id="div_nuevo_autor">
                                        <a href="#" class="nuevo_autor" style="color: gray;">
                                            <i class="fas fa-plus-square"></i> <?=$lang['AGREGAR_AUTOR']?>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                </div>
                                <div clasS="col-md-3">
                                    <div id="div_eliminar_autor" class="text-right">
                                        <a href="#" class="eliminar_autor" style="color: gray;">
                                            <i class="fas fa-minus-square"></i> <?=$lang['ELIMINAR_AUTOR']?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                        </div><br>
                        <div class="text-left" style="font-weight: bold;">
                            <?=$lang['MARCA_PRESENTADOR']?>
                        </div>
                        <input type="hidden" name="t" value="<?=$_SESSION["abstract"]["id_tl"]?>" />
                    </div>
                    <br>
                    <hr />

                        <div id="div_resumen_tl">
                            <div class="titulo_box text-left">
                                <?=$lang['RESUMEN']?>
                            </div>
                            <textarea id="resumen_tl" name="resumen_tl" class="tiny"><?=$_SESSION["abstract"]["resumen_tl"]?></textarea>

                            <!--<br>
                            <div class="titulo_box text-left">
                                <?=$lang['RESUMEN2']?>
                            </div>
                            <textarea id="resumen_tl2" name="resumen_tl2" class="tiny"><?=$_SESSION["abstract"]["resumen_tl2"]?></textarea>-->

                            <!--<br>
                            <div class="titulo_box text-left">
                                <?=$lang['RESUMEN3']?>
                            </div>
                            <textarea id="resumen_tl3" name="resumen_tl3" class="tiny"><?=$_SESSION["abstract"]["resumen_tl3"]?></textarea>-->

                            <input type="hidden" name="words_total" value="0"  />
                            <div id="limits_words" style="margin:0 0 30px 0;" class="text-left">
                                <?=$lang['TOTAL_PALABRAS']?>: <span id="totalwords"></span>

                            </div>

                            <!--<div class="titulo_box text-left">
                                <?php //echo $lang['PALABRAS_CLAVES']." - ".$lang["PALABRAS_CLAVES_DESCRIPCION"]
                                //.":<br>"; ?>
                                <?php //echo $lang['PALABRAS_CLAVES'].":<br>"; ?>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-15 sin_padding_izquierdo padding_horizontal">
                                        <input type="text" name="palabra_clave1" value="<?php echo $_SESSION["abstract"]["palabra_clave1"]; ?>" class="form-control" />
                                    </div>
                                    <div class="col-md-15 sin_padding_izquierdo padding_horizontal">
                                        <input type="text" name="palabra_clave2" value="<?php echo $_SESSION["abstract"]["palabra_clave2"]; ?>" class="form-control" />
                                    </div>
                                    <div class="col-md-15 sin_padding_izquierdo padding_horizontal">
                                        <input type="text" name="palabra_clave3" value="<?php echo $_SESSION["abstract"]["palabra_clave3"]; ?>" class="form-control" />
                                    </div>
                                    <div class="col-md-15 sin_padding_izquierdo padding_horizontal">
                                        <input type="text" name="palabra_clave4" value="<?php echo $_SESSION["abstract"]["palabra_clave4"]; ?>" class="form-control" />
                                    </div>
                                    <div class="col-md-15 sin_padding_lateral padding_horizontal">
                                        <input type="text" name="palabra_clave5" value="<?php echo $_SESSION["abstract"]["palabra_clave5"]; ?>" class="form-control" />
                                    </div>
                                </div>
                            </div>-->
                        </div><br>

                        <div class="div-tiene_eje">
                            <div class="titulo_box text-left">
                                <?=$lang['EJES_TEMATICOS']?>
                            </div>
                            <div align="left">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-9 sin_padding_izquierdo">
                                            <select name="area_tl" class="form-control">
                                                <option value=""></option>
                                                <?php
                                                $getAreas = $core->getAreasTL();
                                                foreach($getAreas as $rowAreas)
                                                {
                                                    if($rowAreas["id"]==$_SESSION["abstract"]["area_tl"])
                                                        $chk = "selected";
                                                    if($rowAreas["id"]!=21)
                                                        echo "<option value='".$rowAreas["id"]."' $chk>".$rowAreas["Area_".$_SESSION["abstract"]["lang"]]."</option>";
                                                    $chk = "";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="<?=$lang['TXT_EJES_LINK']?>" target="_blank"><?=$lang["TXT_DESCRIPCION"]?></a>
                                        </div>
                                    </div>
                                </div>
                            </div><br>

                            <div class="titulo_box text-left">
                                <?=$lang['LINEAS_TRANSVERSALES']?>
                            </div>
                            <div align="left">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-9 sin_padding_izquierdo">
                                            <select name="linea_transversal" class="form-control">
                                                <option value=""></option>
                                                <?php
                                                $lineas_transversales = $core->getLineasTransversales();
                                                foreach($lineas_transversales as $linea_transversal)
                                                {
                                                    if($linea_transversal["id"] == $_SESSION["abstract"]["linea_transversal"])
                                                        $chk = "selected";
                                                    echo "<option value='".$linea_transversal["id"]."' $chk>".$linea_transversal["linea_transversal_".$_SESSION["abstract"]["lang"]]."</option>";
                                                    $chk = "";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="<?=$lang['TXT_EJES_LINK']?>" target="_blank"><?=$lang["TXT_DESCRIPCION"]?></a>
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                        </div>

                        <div align="left">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="checkbox" name="apoyo_audiovisual" value="1"
                                            <?=($_SESSION["abstract"]["apoyo_audiovisual"] == '1' ? 'checked' : '')?>>
                                        <?=$lang["TXT_APOYO_AUDIOVISUAL"]?>
                                    </div>
                                </div>
                            </div>
                        </div><br>

                        <div id="second_step" class="input_next">
                            <input id="step1" type="button" value="<?=$lang['CONTINUAR']?>" class="btn btn-primary btn-block" />
                        </div><br>
                </div><!-- end step1 -->

                <div id="preview_step2" class="col-md-10 text-left"></div>
                <div id="mod_step2" class="col-md-10">
                    <hr style="margin:20px 0;" color="#CCCCCC" />

                    <div id="div_datos_contacto">
                        <div class="titulo_box text-left">
                            <?=$lang['DATOS_CONTACTO']?>
                        </div><br>
                        <div class="row text-left">
                            <div class="col-md-6 padding_horizontal">
                                <label><?=$lang['EMAIL']?></label><br>
                                <input type="text" name="contacto_mail" value="<?=$_SESSION["abstract"]["contacto_mail"]?>" class="form-control" />
                            </div>
                            <div class="col-md-6 padding_horizontal">
                                <label><?=$lang['EMAIL_ALTERNATIVO']?></label><br>
                                <input type="text" name="contacto_mail2" value="<?=$_SESSION["abstract"]["contacto_mail2"]?>" class="form-control" />
                            </div>
                        </div>
                        <div class="row text-left">
                            <div class="col-md-6 padding_horizontal">
                                <label><?=$lang['NOMBRES']?></label><br>
                                <input type="text" name="contacto_nombre" value="<?=$_SESSION["abstract"]["contacto_nombre"]?>" class="form-control" />
                            </div>
                            <div class="col-md-6 padding_horizontal">
                                <label><?=$lang['APELLIDO']?></label><br>
                                <input type="text" name="contacto_apellido" value="<?=$_SESSION["abstract"]["contacto_apellido"]?>" class="form-control" />
                            </div>
                        </div>
                        <div class="row text-left">
                            <div class="col-md-6 padding_horizontal">
                                <label><?=$lang['INSTITUCION']?></label><br>
                                <input type="text" name="contacto_institucion" value="<?=$_SESSION["abstract"]["contacto_institucion"]?>" class="form-control" />
                            </div>
                            <!--<div class="col-md-6 padding_horizontal">
                            <label><?=$lang['COUNTRY']?></label><br>
                            <select name="contacto_pais" class="form-control">
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
                            </select>
                        </div>-->
                        </div>
                        <!--<div class="row text-left">
                            <div class="col-md-6 padding_horizontal">
                                <label><?=$lang['CIUDAD']?></label><br>
                                <input type="text" name="contacto_ciudad" value="<?=$_SESSION["abstract"]["contacto_ciudad"]?>" class="form-control" />
                            </div>
                            <div class="col-md-6 padding_horizontal">
                                <label><?=$lang['TELEFONO']?></label><br>
                                <input type="text" name="contacto_telefono" value="<?=$_SESSION["abstract"]["contacto_telefono"]?>" class="form-control" />
                            </div>
                        </div>-->
                        <br>
                        <div class="row text-left input_next">
                            <div class="col-md-6 padding_horizontal">
                                <input type="button" id="step2back" value="<?=$lang['VOLVER']?>" class="btn btn-link btn-block" />
                            </div>
                            <div class="col-md-6 padding_horizontal">
                                <input type="submit" value="<?=$lang["ENVIAR"]?>" class="btn btn-primary btn-block" />
                            </div>
                        </div>
                    </div>
                    <!--<input type="hidden" value="<?php echo $_SESSION['abstracts']['tipo_tl']; ?>" name="abstracts_tipo_tl">-->

                </div><!-- end step2 -->
            </form>
        </div><!-- end contenido -->

    </div><!-- end container -->
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