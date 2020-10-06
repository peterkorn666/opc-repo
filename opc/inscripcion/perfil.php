<?php
if(!isset($_GET["key"]) || $_GET["key"] === ''){
	header("Location: ../");die();
}
$key = (int)base64_decode($_GET["key"]);
//$key = (int)$_GET["key"];
require("../init.php");
require("clases/Db.class.php");
require("clases/browser.php");
$browser = new Browser();
if($browser->getBrowser() == Browser::BROWSER_IE && $browser->getVersion() <= 9) {
    echo '<br><br><h2 align="center" style="color:red">You should complete form using other browser or update your Internet Explorer.</h2>'; die();
}
$db = \DB::getInstance();

require("clases/lang.php");
require("clases/inscripcion.class.php");
$inscripcion = new Inscripcion();
$lang = new Language("es");

$inscripto = $inscripcion->getInscripto($key);
if(count($inscripto) <= 0){
	header("Location: ../");die();
}

$paises = $inscripcion->getPaises();
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
    <script src="js/jquery.js" language="javascript" type="text/javascript"></script>
    <script src="js/perfil.js" language="javascript" type="text/javascript"></script>
    <style>
    .div-form input, textarea {
		font-size: 20px !important;
	}
	.error{
		color: red;
	}
    </style>
</header>    
<body>

<div class="container">
	<div class="col-md-12">
		<div class="col-xs-12" style="text-align: center;"><img src="../imagenes/banner.jpg" style="width:580px;height:110px"></div>
	</div>
	<div class="col-md-offset-3 col-md-6 div-form">
        <h4>Complete los datos personales que desee que aparezcan en la aplicación y en la web interna.<br>Si usted no carga su foto o imagen que lo represente, daremos por descontado que no quiere aparecer de ninguna forma.</h4>
        <p style="font-size: 17px;text-align: center;"><a href="http://www.tea2018.org/inscriptos.php" target="_blank">acceda desde este link a los datos que subieron todos los inscriptos.</a></p>
        <form id="form-perfil" action="guardarPerfil.php" method="post" enctype="multipart/form-data">
        	<input type="hidden" name="key" value="<?=base64_encode($key)?>">
        <div class="row">
        	<div class="col-xs-12">
                <label>Su nombre</label>
                <input type="text" id="solapero" name="solapero" class="form-control input-sm" value="<?=$inscripto["solapero"]?>">
            </div>
			<div class="col-xs-12">
                <label><?=$lang->set["TXT_INSTITUCION"]?></label>
                <input type="text" id="institucion" name="institucion" class="form-control input-sm" value="<?=$inscripto["institucion"]?>">
            </div>
            
			<div class="col-xs-12">
                <label><?=$lang->set["TXT_CIUDAD"]?></label>
                <input type="text" id="ciudad" name="ciudad" class="form-control input-sm" value="<?=$inscripto["ciudad"]?>">
            </div>
            
            <div class="col-xs-12">
                <label><?=$lang->set["TXT_PAIS"]?></label>
                <select id="pais" name="pais" class="form-control input-sm">
                <?php
					foreach($paises as $key => $pais){
						$chk = "";
						if($key == $inscripto['pais'])
							$chk = 'selected';
				?>
                	<option value="<?=$key?>" <?=$chk?>><?=$pais?></option>
                <?php
					}
				?>
                </select>
            </div>
            
            <div class="col-xs-12">
                <label><?=$lang->set["TXT_TELEFONO"]?></label>
                <input type="text" id="telefono" name="telefono" class="form-control input-sm" value="<?=$inscripto["telefono"]?>">
            </div>
            
            <div class="col-xs-12">
                <label>Email</label>
                <input type="text" id="email" name="email" class="form-control input-sm" value="<?=$inscripto["email"]?>">
            </div>
            
            <div class="col-xs-12">
                <label>Redes sociales (Escriba la direcci&oacute;n de su perfil)</label>
                <input type="text" id="redes_sociales" name="redes_sociales" class="form-control input-sm" value="<?=$inscripto["redes_sociales"]?>">
            </div>
            
            
        	<div class="col-xs-12" style="margin: 20px 0 20px 0;">
            	<?php
                $foto_inscripto = "nophoto.png";
                if($inscripto["foto_perfil"]){
                    $foto_inscripto = $inscripto["foto_perfil"];
				}
                ?>
                <div id="confPhoto" class="col-md-12 well text-center">
                	<img id="img_seleccionada" src="../inscriptos_fotos/<?=$foto_inscripto?>" style="max-height: 420px; max-width: 300px">
                </div>
                <div class="row text-center">
                    <a href="#" class="uploadFile" data-target="foto_inscripto"> Haga click aquí para cargar su foto</a>
                    <input id="foto_inscripto" type="file" name="foto_inscripto" style="display: none;">
                    <input type="hidden" name="foto_viejo" value="<?=$inscripto["foto_perfil"]?>">
                </div>
            </div>

			<div class="col-xs-12">
            	¿Por qué asistiré al evento?<br>
                <textarea id="comentarios_pre_evento" name="comentarios_pre_evento" class="form-control" rows="3"><?=$inscripto['comentarios_pre_evento']?></textarea>
            </div>
            <div class="col-xs-12">
            	¿Qué me dejó el haber participado?<br>
                <textarea id="comentarios_post_evento" name="comentarios_post_evento" class="form-control" rows="3"><?=$inscripto['comentarios_post_evento']?></textarea>
            </div><br>
                
            

            <div class="col-xs-12 text-center" style="margin-top: 30px;">
                <?php
				//echo "<a href='comprobantes/".$inscripto["comprobante_archivo"]."' target='_blank'><i>Ya tiene un comprobante cargado.</i></a> <br>";
                if(!$inscripto["comprobante_archivo"] && $inscripto["estado"] === '0'){    
                ?>
                <!--<a href='#' class='eliminar_comprobante'>(Eliminar)</a>-->
                <div class="row text-center">
                	<a href="#" class="uploadFile btn btn-warning input-sm" data-target="comprobante">Si no cargo su comprobante, puede cargarlo haciendo click aquí</a><br>
                    <span id='span-comprobante'></span>
                	<input type="file" name="comprobante" style="display: none;">
                	<input type="hidden" name="comprobante_viejo" value="<?=$inscripto["comprobante_archivo"]?>">
				</div>
                <?php } ?>
            </div>
            

        </div><br><br><br>
        
        <div class="row">
        	<input type="submit" class="form-control input-sm btn-primary" value="Guardar cambios" style="height: 40px;">
        </div>
        
        </form>
    </div>
</div><br>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$("#foto_inscripto").change(function() {
		readURL(this);
	});
	
	$.validator.addMethod("valueNotEquals", function(value, element, arg){
		return arg !== value;
	}, "Value must not equal arg.");
	
	$("#form-perfil").validate({
		rules:{
			solapero: "required",
			institucion: "required",
			ciudad: "required",
			pais: { valueNotEquals: "247" },
			telefono: "required",
			email:{
				required: true,
				email: true
			}
		},
		messages:{
			solapero: "El solapero es obligatorio",
			institucion: "La institución es obligatoria",
			ciudad: "La ciudad es obligatoria",
			pais: { valueNotEquals: "El país es obligatorio" },
			telefono: "El teléfono es obligatorio",
			email:{
				required: "El email es obligatorio",
				email: "Debe escribir una dirección válida"
			}
		}
	});
});
function readURL(input) {
	
	if (input.files && input.files[0]) {
    	var reader = new FileReader();
		
    	reader.onload = function(e) {
			$('#img_seleccionada').attr('src', e.target.result);
    	}
		reader.readAsDataURL(input.files[0]);
 	}
}

</script>
</body>
</html>