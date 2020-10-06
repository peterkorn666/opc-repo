<?php
require("../init.php");
require("clases/Db.class.php");
require("clases/browser.php");
$browser = new Browser();
if( $browser->getBrowser() == Browser::BROWSER_IE && $browser->getVersion() <= 9 ) {
    echo '<br><br><h2 align="center" style="color:red">You should complete form using other browser or update your Internet Explorer.</h2>';
	die();
}
require("clases/lang.php");
require("clases/inscripcion.class.php");
$lang = new Language("es");
$inscripcion = new Inscripcion();

?>
<html>
<header>
    <title><?=$lang->set["TXT_TITULO_CONGRESO"]?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="estilos.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=Intl.~locale.es"></script>
</header>    
<body>
<div style='text-align: center;'><img src="../imagenes/banner.jpg" style='width: 550px;'></div><br>
<?php
	if ($_GET["error"]){
		if ($_GET["error"] == 1) {
			echo "<div class='row'>
					<div class='col-md-4 col-md-offset-4 col-lg-offset-4 col-sm-offset-0 text-center alert alert-danger'>
						Ha ocurrido un error con el documento
					</div>
				  </div>";
		}
	}
	//col-xs-6 col-lg-offset-2 col-md-6 col-lg-7
	if ($_GET["ae"] == 1) {
		echo "<div class='row'>
				<div class='col-md-4 col-md-offset-4 col-lg-offset-4 col-sm-offset-0 text-center alert alert-warning'>
					Usted ya posee una inscripción
				</div>
			  </div>";
	}
?>
<form id="formCheck" name="formCheck" action="checkPass.php" method="post">
	<div class="row">
        <div class="col-md-4 col-md-offset-4 col-lg-offset-4 col-sm-offset-0" style='margin-bottom: 4px;'>
			<label><?=$lang->set["TXT_INGRESE_PASAPORTE"]?></label>
			<input name='pasaporte' type='text' style='font-size:16px;' class='form-control input-sm' value='<?=$_SESSION["inscripcion"]["numero_pasaporte"]?>' placeholder="12345678">
        </div>
        <!--<div class="col-md-3 col-md-offset-4 col-lg-offset-4 col-sm-offset-0" style='margin-bottom: 4px;'>
			<!--<label><?=$lang->set["TXT_TIPO_INSCRIPCION"]?></label><br>
                <input name='tipo_inscripcion' type='radio' style='margin-bottom: 8px;' value='1' 
					<?php if($_SESSION["inscripcion"]["tipo_inscripcion"]==='1') echo 'checked';?>
                > 
				<?=$lang->set["TIPO_INSCRIPCION"]["array"][1];?><br>
                
                <input name='tipo_inscripcion' type='radio' value='2' 
					<?php if($_SESSION["inscripcion"]["tipo_inscripcion"]==='2') echo 'checked';?>
                > 
				<?=$lang->set["TIPO_INSCRIPCION"]["array"][2];?><br>
        </div>-->
        <div class="col-md-4 col-md-offset-4 col-lg-offset-4 col-sm-offset-0" style='text-align: center;'>
        	<input class="btn btn-primary form-control" name='guardar_form' type='submit' value='Continuar'>
        </div>
    </div>
</form>

</body>
<script src="js/jquery.js" language="javascript" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(e) {
	
	$("input[name='pasaporte']").keyup(function (e) {
		checkComprobante(this);
	});
	$(document).on("paste","input[name='pasaporte']",function (e) {
		checkComprobante(this);
	});
	
	$("#formCheck").submit(function(e){
		if($("input[name='pasaporte']").val() === '' || $("input[name='pasaporte']").val() === undefined){
			alert("Escriba su pasaporte");
			return false;
		}
		/*if(!$("input[name='tipo_inscripcion']").is(':checked')){
			alert("Seleccione un tipo de inscripción");
			return false;
		}*/
	});
});

function checkComprobante(e){
	var str = $(e).val();
	str = str.replace(/[^a-zA-Z 0-9]+/g, '');
	str = str.replace(/\s/g, '');
	//console.log(str)
	$(e).val(str);
}
</script>