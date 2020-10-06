<?php
if (empty($_GET["key"])){
	header("Location: /");
	die();
}

global $tpl;
$util = $tpl->getVar('util');
//$util->isLogged();
$core = $tpl->getVar('core');
$templates = $tpl->getVar('templates');
$debug = $tpl->getVar('debug');
$core->Debug($debug);
/*if(!$core->isAdmin()){
	header("Location: /");
	die();
}*/
//DEFINE HEADERS
$headers = array(
	"bootstrap/css/bootstrap.min.css"=>"css",
	"estilos/font-awesome.min.css"=>"css",
	"estilos/custom.css"=>"css",
);
$tpl->SetVar('headers', $headers);

$inscriptos = $core->query("SELECT id, nombre, apellido FROM inscriptos");
foreach($inscriptos as $insc){
	if(md5($insc["id"]) == $_GET["key"]){
		$inscripto = $insc;
		break;
	}
}
if(count($inscripto) == 0){
	
	header("Location: /");
	die();
}
?>
<h3>Bienvenido/a <strong><?php echo $inscripto["nombre"]." ".$inscripto["apellido"]; ?></strong></h3>
<div class="row">

    <div class="col-md-12">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3" style="font-size: 16px;">
            
                <input type="button" value="Descargar constancia de asistencia" class="descargar_certificado_asistencia form-control btn btn-info" data-insc="<?=$inscripto["id"]?>">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	
	$(".descargar_certificado_asistencia").click(function(){
		
		var insc = $(this).data('insc');
		var url = "certificados/inscripto/asistente.php?insc="+insc;
		window.open(url);
	});
});
</script>

