<?php
/*if(!$_SESSION["login"])
{
	header("Location: login.php");
	
	
	die();
}*/

session_start();
//var_dump($_SESSION);die();
if(!isset($_SESSION["inscripcion"]["numero_pasaporte"])){ //|| !isset($_SESSION["inscripcion"]["tipo_inscripcion"])
	header("Location: check.php");die();
}
require("../init.php");
require("clases/Db.class.php");
//unset($_SESSION["inscripcion"]);
require("clases/browser.php");
$browser = new Browser();
if( $browser->getBrowser() == Browser::BROWSER_IE && $browser->getVersion() <= 9 ) {
    echo '<br><br><h2 align="center" style="color:red">You should complete form using other browser or update your Internet Explorer.</h2>';
	die();
}

require("clases/lang.php");
require("clases/inscripcion.class.php");
/*if($_SESSION['cliente']['id_cliente'] === '1636'){
	var_dump($_SESSION);die();
}*/
$inscripcion = new Inscripcion();
/*if(empty($_SESSION["inscripcion"]["numero_pasaporte"])){
	if(trim($_POST["pasaporte"]) === ''){
		header("Location: check.php?error=1");die();
	}else{
		$_SESSION["inscripcion"]["numero_pasaporte"] = $_POST["pasaporte"];
		$_SESSION["inscripcion"]["tipo_inscripcion"] = $_POST["tipo_inscripcion"];
		$inscripcion->existeInscripcion();
	}
}*/

$db = \DB::getInstance();

$_SESSION["inscripcion"]["browser"] = $browser->__toString();
$_SESSION["inscripcion"]["pasos"] = 1;

/*if($_GET["lang"])
	$_SESSION["inscripcion"]["lang"] = $_GET["lang"];
else
	$_SESSION["inscripcion"]["lang"] = "es";*/

if($_GET["lang"]=="" && $_SESSION["inscripcion"]["lang"]=="")
        $_SESSION["inscripcion"]["lang"] = "es";
    else if($_GET["lang"]!=""){
        if($_GET["lang"] != "es" && $_GET["lang"] != "en" /*&& $_GET["lang"] != "pt"*/){
            header("Location: index.php");die();
        }
        $_SESSION["inscripcionv"]["lang"] = $_GET["lang"];
    }

$lang = new Language($_SESSION["inscripcion"]["lang"]);
//	$lang = new Language("es");

if($_SESSION["admin"]){
	$precios = $inscripcion->getPrecios();
	$formas_pago = $inscripcion->getFormasPago();
	
	//para panel admin
	$total_a_pagar = $inscripcion->calcularPrecio($_SESSION["inscripcion"]["id"]);
}else{
	$precios = $inscripcion->getPreciosHabilitados();
	$formas_pago = $inscripcion->getFormasPagoHabilitadas();
}

$trabajos_pasaporte = $inscripcion->getTrabajosByPasaporte();//var_dump($_POST);die();
$trabajos_asociados_pasaporte = "";
if(count($trabajos_pasaporte) > 0){
	foreach($trabajos_pasaporte as $trabajo_pasaporte){
		$trabajos_asociados_pasaporte .= $trabajo_pasaporte['numero_tl']." - ".$trabajo_pasaporte["titulo_tl"]."<br>";
	}
}
$_SESSION["inscripcion"]["trabajos_asociado_pasaporte"] = $trabajos_asociados_pasaporte;

/*for($i=0;$i<30;$i++)
{
	echo $lang->generarClave(10)."<br>";
}*/


//Comprobar cedula
/*$reg = 0;
if($_SESSION["inscripcion"]["id_inscripto"]){
	$sqlC = $db->prepare("SELECT * FROM inscriptos WHERE id=?");
	$sqlC->bindValue(1, $_SESSION["inscripcion"]["id_inscripto"]);
	$sqlC->execute();
	$reg = $sqlC->rowCount();
}*/

?>
<html>
<header>
    <title><?=$lang->set["TXT_TITULO_CONGRESO"]?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="estilos.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../estilos/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="../estilos/jquery.fileupload-ui.css">
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=Intl.~locale.es"></script>
	<script type="text/javascript" src="js/lang/<?=$_SESSION["inscripcion"]["lang"]?>.js"></script>
	<script type="text/javascript">
        jQuery(document).ready(function($) {
            var lang = '<?=$_SESSION["inscripcion"]["lang"]?>';
	</script>
</header>    
<body>

<form enctype="multipart/form-data" id="form1" name="form1" action="vista.php" method="post" onSubmit="return validar_form()">
<div align="center"><img src="../imagenes/banner.jpg" style="width:100%; max-width:440px"></div>

<!--div de idiomas-->
<div align="center" >
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6" style="margin-top: 0px; padding: 0px;">
                        <input type="button" onClick="es()" value="es" class="btn btn-link form-control" style="color: black;">
                    </div>
                    <!--<div class="col-md-4" style="margin-top: 0px; padding: 0px;">
                        <input type="button" onClick="en()" value="<?=$lang["TXT_ENGLISH"]?>" class="btn btn-link form-control" style="color: black;">
                    </div>-->
                    
                </div>
            </div>
        </div><br>
		<!--END div de idiomas-->

<div class="container">
	<?php
	if($_SESSION["inscripcion"]["admin"]){
		if($_SESSION["inscripcion"]["estado"])
			$ch = 'checked';
		else 
			$ch = '';
	?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0" style="padding:10px; background-color:orange">
                <label>Comentarios</label>
                <textarea class="form-control" name="comentarios"><?=$_SESSION["inscripcion"]["comentarios"]?></textarea>
            </div><br>
            <div class="col-md-3 col-md-offset-3 col-lg-offset-3  col-sm-offset-0" style="padding:10px; background-color:orange; margin-top:0px;">
                <label>Fecha pago</label>
                <input id="fecha_pago" class="form-control" type="text" name="fecha_pago" maxlength="10" value="<?=$_SESSION["inscripcion"]["fecha_pago"]?>">
            </div>
            <div class="col-md-2 col-md-offset-0 col-lg-offset-0  col-sm-offset-0" style="padding:10px; background-color:orange; margin-top:0px;">
                <label>Descuento</label>
                <input class="form-control" type="text" name="descuento" value="<?=$_SESSION["inscripcion"]["descuento"]?>">
            </div>
            <div class="col-md-1 col-md-offset-0 col-lg-offset-0  col-sm-offset-0" style="padding:10px; background-color:orange; margin-top:0px;">
                <input type="checkbox" name="estado" value="1" <?=$ch?>> Pago
            </div>
        </div>
        <div class="row">
            
        </div>
        <br><br>
	<?php
	}
	?>
    <?php
	if($_GET["error"]){
		if($_GET["error"] === 'formatoInvalido'){
			echo "<div class='row'>
					<div class='col-md-6 col-md-offset-3 col-lg-offset-3 col-sm-offset-0 text-center alert alert-danger'>
						Formato de archivo inválido.<br> Por favor adjunte de nuevo su archivo con un formato correspondiente.
					</div>
				  </div>";
		}
	}
	?>

	<?php
	if($_GET["empty"]){
	?>
	<div class="row">
    	<div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
            <div class="alert alert-danger">TODOS LOS CAMPOS SON OBLIGATORIOS</div>
        </div>
    </div>
	<?php
	}
	if(!isset($_SESSION["inscripcion"]["pago"]))
		require("form_previa.php");
	require("form_pago.php");
	echo $html;
    ?>
    <div class="row">
    	<div class="col-md-3 col-md-offset-3 col-lg-offset-3 col-sm-offset-0">
    		<input type="submit" value="<?=$lang->set["TXT_BTN_CONTINUAR"]?>" class="btn btn-primary form-control">
        </div>
        <div class="col-md-3 col-md-offset-0 col-lg-offset-0 col-sm-offset-0">
            <input type="button" onClick="volver()" value="<?=$lang->set["TXT_BTN_VOLVER"]?>" class="btn btn-link form-control"> 
        </div>
    </div>
</div>
</form>
<script src="js/jquery.js" language="javascript" type="text/javascript"></script>
<script type="text/javascript">
//var costos_inscripcion = Array();
<?php
	/*if(count($lang->set["COSTOS_INSCRIPCION"]["array"])>0)
	{
		foreach($lang->set["COSTOS_INSCRIPCION"]["array"] as $key => $costos)
		{
			$table_costo = explode("=>",$costos);
			if($table_costo[3]=="habilitado" || $_SESSION["login"])
			{
				echo "costos_inscripcion[$key] = ".trim($table_costo[1]).";";
			}
		}
	}*/
	
	
?>
</script>
<script src="js/funciones.js" language="javascript" type="text/javascript"></script>
<script src="js/jquery.autotab.min.js" language="javascript" type="text/javascript"></script>
<!--<script src="../asignar_trabajos/js/trabajo.js" language="javascript" type="text/javascript"></script>-->

<script src="../js/jquery-1.12.4.js" language="javascript" type="text/javascript"></script>
<script src="../js/jquery-ui.js" language="javascript" type="text/javascript"></script>
<script src="../js/jquery-ui.min.js" language="javascript" type="text/javascript"></script>


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
	//if($("input[name='numero_tl']").length){
		<?php
	//	unset($_SESSION["inscripcion"]["input_selected_autor"]);
		/*$_SESSION["inscripcion"]["asocio_trabajos"] = true;
		if(count($_SESSION["inscripcion"]["input_selected_autor"])>0){
			foreach($_SESSION["inscripcion"]["input_selected_autor"] as $id_autor){
				$trabajo = $db->query("SELECT l.ID_participante, l.ID_trabajos_libres, t.id_trabajo, t.numero_tl FROM trabajos_libres_participantes as l JOIN trabajos_libres as t ON t.id_trabajo=l.ID_trabajos_libres WHERE l.ID_participante = ?", [$id_autor])->first();*/
		?>
			//searchTrabajo('<?=$trabajo["numero_tl"]?>', <?=json_encode(array_map('intval', $_SESSION["inscripcion"]["input_selected_autor"]))?>, null);
		<?
			//}
		//}
		?>
	//}
	
	
	$( function() {
		$("#fecha_pago").datepicker({ dateFormat: 'yy-mm-dd' });
		$("#fecha_pago").datepicker("option", "showAnim", "slideDown");
	} );
	
	checkCostosInscripcion();
	$("input[name='costos_inscripcion']").click(function(){
		checkCostosInscripcion();
	});
	
	checkFormaPago();
	$("input[name='forma_pago']").click(function(){
		checkFormaPago();
	});
	
	$(".desmarcar").click(function(e){
		e.preventDefault();
		$("input[name="+$(this).data('nombre')+"]:checked").prop('checked', false);
	});
});
function checkCostosInscripcion(){
	$("#div_forma_pago").show();
	if($("input[name='costos_inscripcion']").is(':checked')){
		if($("input[name='costos_inscripcion']:checked").data('beca') === 1){
			$("#div_codigo").show();
			$("#div_forma_pago").hide();
			$("input[name='forma_pago']:checked").prop('checked', false);
			checkFormaPago();
		}else{
			$("input[name='codigo']").val("");
			$("#div_codigo").hide();
		}
	}else{
		$("input[name='codigo']").val("");
		$("#div_codigo").hide();
	}
}

function checkFormaPago(){
	if($("input[name='forma_pago']").is(':checked')){
		if($("input[name='forma_pago']:checked").data('comprobante') === 1){
			$("#numero_comprobante").show();
		}else{
			$("input[name='numero_comprobante']").val("");
			$("#numero_comprobante").hide();
		}
	}else{
		$("input[name='numero_comprobante']").val("");
		$("#numero_comprobante").hide();
	}
}
</script>
<script type="text/javascript">
function volver()
{
	window.location.href = "check.php";
}
</script>
</body>
</html>