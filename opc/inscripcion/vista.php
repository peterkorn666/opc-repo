<?php
session_start();

if($_SESSION["inscripcion"]["pasos"]!=1)
{
	header("Location: index.php");
	die();
}
$_SESSION["inscripcion"]["pasos"]=2;

//var_dump($_POST);var_dump($_FILES);die();
//POST
foreach($_POST as $name => $post)
{
	if(!is_array($_POST[$name]))
		$_SESSION["inscripcion"][$name] = trim($_POST[$name]);
	else
		$_SESSION["inscripcion"][$name] = $_POST[$name];
}
if(array_key_exists("grupo_check_comprobante", $_POST)){
	if(!isset($_POST["grupo_check_comprobante"])){
		$_SESSION["inscripcion"]["grupo_check_comprobante"] = NULL;
	}
}else
	$_SESSION["inscripcion"]["grupo_check_comprobante"] = NULL;
	
if(!isset($_POST["estado"])){
	$_SESSION["inscripcion"]["estado"] = 0;
}

$ignore = array("comentarios", "fecha_pago", "descuento", "estado", "grupo_check_comprobante", "grupo_numero_comprobante", "key_inscripto", "nombre_inscripto_pagador", "asocio_trabajos", "numero_comprobante", "codigo", "key_codigo", "forma_pago");

//
/*if ($_SESSION["inscripcion"]["forma_pago"]!=1 || ($_SESSION["inscripcion"]["grupo_check_comprobante"]!="" && $_SESSION["inscripcion"]["forma_pago"]==1)) {
	$ignore[] = "credit_card_type";
	$ignore[] = "credit_card_number";
	$ignore[] = "credit_card_expire";
	$ignore[] = "credit_card_cvc";
}*/
foreach($_POST as $name => $post)
{
	if(!in_array($name, $ignore)){
		if(empty($_SESSION["inscripcion"][$name]))
		{
			header("Location: index.php?empty=1&name=".$name);
			die();
		}
	}
}

/*if($_SESSION["inscripcion"]["admin"]){
	var_dump($_SESSION["inscripcion"]["estado"]);
}*/

$_SESSION["inscripcion"]["fecha_nacimiento"] = $_SESSION["inscripcion"]["day"]."/".$_SESSION["inscripcion"]["month"]."/".$_SESSION["inscripcion"]["year"];

if($_SESSION["inscripcion"]["grupo_check_comprobante"]=="1"){
	if(empty($_SESSION["inscripcion"]["grupo_numero_comprobante"]) && empty($_SESSION["inscripcion"]["key_inscripto"])){
		$_SESSION["inscripcion"]["grupo_numero_comprobante"] = NULL;
		$_SESSION["inscripcion"]["key_inscripto"] = NULL;
		$_SESSION["inscripcion"]["nombre_inscripto_pagador"] = NULL;
	}
	
	$_SESSION["inscripcion"]['numero_comprobante'] = NULL;
}else{
	$_SESSION["inscripcion"]["grupo_check_comprobante"] = NULL;
	$_SESSION["inscripcion"]["grupo_numero_comprobante"] = NULL;
	$_SESSION["inscripcion"]["key_inscripto"] = NULL;
	$_SESSION["inscripcion"]["nombre_inscripto_pagador"] = NULL;
		
	/*if($_SESSION["inscripcion"]["forma_pago"]=="3" || $_SESSION["inscripcion"]["forma_pago"]=="4"){
		if(empty($_SESSION["inscripcion"]['numero_comprobante'])){
			header("Location: index.php?empty=1&name=numero_comprobante");
			die();
		}
	} else {
		$_SESSION["inscripcion"]['numero_comprobante'] = NULL;
	}*/
}

//--POST
require("../init.php");
require("clases/Db.class.php");
require("clases/lang.php");
require("clases/inscripcion.class.php");
//$lang = new Language($_SESSION["inscripcion"]["lang"]);
$inscripcion = new Inscripcion("previa");
$lang = new Language("es");
$db = \DB::getInstance();


if($inscripcion->esBeca($_SESSION["inscripcion"]["costos_inscripcion"])){
	if(empty($_SESSION["inscripcion"]["codigo"])){
		header("Location: index.php?empty=1&name=codigo");die();
	}
	$_SESSION["inscripcion"]["forma_pago"] = NULL;
	$_SESSION["inscripcion"]['numero_comprobante'] = NULL;
}else {
	if(empty($_SESSION["inscripcion"]["forma_pago"])){
		header("Location: index.php?empty=1&name=forma_pago");die();
	}else if($inscripcion->esFormaPagoConComprobante($_SESSION["inscripcion"]["forma_pago"])){
		if(empty($_SESSION["inscripcion"]["numero_comprobante"])){
			header("Location: index.php?empty=1&name=numero_comprobante");die();
		}
	}
	$_SESSION["inscripcion"]["codigo"] = NULL;
}
?>
<html>
<header>
    <title><?=$lang->set["TXT_TITULO_CONGRESO"]?></title>
    <meta charset="utf-8">
    <link href="estilos.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../estilos/jquery.fileupload-ui.css">
</header>
<body>
<div align="center"><img src="../imagenes/banner.jpg" style="width:100%; max-width:440px"></div><br>
<div class="container">
	<form id="form_send" enctype="multipart/form-data" action="send.php" method="POST">
    
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-lg-offset-3 col-sm-offset-0">
                <?=$lang->set["TXT_COMPRUEBE_Y_ENVIE"]?>
            </div>
            <div class="col-md-3 col-md-offset-3 col-lg-offset-3 col-sm-offset-0">
                <!--<input type="button" onClick="continuar()" value="Finalizar / Enviar" class="btn btn-primary form-control">-->
                <input type="submit" value="Finalizar / Enviar" class="btn btn-primary form-control">
            </div>
            <div class="col-md-3 col-md-offset-0 col-lg-offset-0 col-sm-offset-0">
                <input type="button" onClick="volver()" value="Volver" class="btn btn-link form-control"> 
            </div>
        </div><br>
	<?php
    $vista = true;
	
    if(!isset($_SESSION["inscripcion"]["pago"]))
		require("form_previa.php");
	require("form_pago.php");
    echo $html;
    ?>
        <!--<div class="row">
            <div class="col-md-3 col-md-offset-3 col-lg-offset-3 col-sm-offset-0">
            	<input type="button" onClick="continuar()" value="Finalizar / Enviar" class="btn btn-primary form-control">
            </div>
            <div class="col-md-3 col-md-offset-0 col-lg-offset-0 col-sm-offset-0">
                <input type="button" onClick="volver()" value="Volver" class="btn btn-link form-control"> 
            </div>
    	</div>-->
    </form>
</div>
</body>
</html>
<script src="js/jquery.js" language="javascript" type="text/javascript"></script>
<script src="js/jquery.autotab.min.js" language="javascript" type="text/javascript"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-89204362-1', 'auto');
  ga('send', 'pageview');

</script>
<script type="text/javascript">
$(document).ready(function(e) {
	
	<?php
	if($inscripcion->esBeca($_SESSION["inscripcion"]["costos_inscripcion"])){
	?>
		$(".div_forma_pago").hide();
	<?php
	}else{
	?>
		$("#div_codigo").hide();
	<?php
	}
	?>
	
	<?php
	if(!$inscripcion->esFormaPagoConComprobante($_SESSION["inscripcion"]["forma_pago"])){
	?>
		$("#numero_comprobante").hide();
	<?php
	}
	?>
	
	$(document).on('change', ':file', function() {
		var input = $(this),
			numFiles = input.get(0).files ? input.get(0).files.length : 1,
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [numFiles, label]);
	});
	
	$(':file').on('fileselect', function(event, numFiles, label) {
		console.log(numFiles);
		console.log(label);
		$("#mostrar_archivo").html(label);
	});
	
	if($("input[name='numero_tl']").length){
		<?php
	//	unset($_SESSION["inscripcion"]["input_selected_autor"]);
		if(count($_SESSION["inscripcion"]["input_selected_autor"])>0){
			foreach($_SESSION["inscripcion"]["input_selected_autor"] as $id_autor){
				$trabajo = $db->query("SELECT l.ID_participante, l.ID_trabajos_libres, t.id_trabajo, t.numero_tl FROM trabajos_libres_participantes as l JOIN trabajos_libres as t ON t.id_trabajo=l.ID_trabajos_libres WHERE l.ID_participante = ?", [$id_autor])->first();
		?>
			searchTrabajo('<?=$trabajo["numero_tl"]?>', <?=json_encode(array_map('intval', $_SESSION["inscripcion"]["input_selected_autor"]))?>, function(){
				$("#result_trabajos a:not('.autor-select')").hide();
				$("#result_trabajos").html($("#result_trabajos").html().split(";").join(""));
				$("div[id^='autor-no-encontrado-']").hide();
				$("textarea[name='autores_template']").append($("#result_trabajos").html());
			});
		<?
			}
		}
		?>
		$("#buscar_trabajo").remove();
		/*$("#div_tarjeta").remove();*/
	}
});
</script>
<script type="text/javascript">
function volver()
{
	window.location.href = "index.php";
}
function continuar()
{
	window.location.href = "send.php";
}
</script>

</body>
</html>
