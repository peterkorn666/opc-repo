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

$conferencistas = $core->getConferencistas();
foreach($conferencistas as $conf){
	if(md5($conf["id_conf"]) == $_GET["key"]){
		$conferencista = $conf;
		break;
	}
}
if(count($conferencista) == 0){
	
	header("Location: /");
	die();
}
?>
<h3>Bienvenido/a <strong><?php echo $conferencista["profesion"]." ".$conferencista["nombre"]." ".$conferencista["apellido"]; ?></strong></h3>
<div class="row">

    <div class="col-md-12">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3" style="font-size: 16px;">
            
                <input type="button" value="Descargar constancia de asistencia" class="descargar_certificado_asistencia form-control btn btn-info" data-conf="<?=$conferencista["id_conf"]?>">
            </div>
        </div>
    </div>
    <?php
	
	echo $templates->actividadConferencistaCertificado($conferencista["id_conf"]);
	
    ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	
	$(".descargar_certificado_asistencia").click(function(){
		
		var conf = $(this).data('conf');
		var url = "certificados/conferencista/asistente.php?conf="+conf;
		window.open(url);
	});
	
	$(".descargar_certificado_participacion").click(function(){
		
		var conf = $(this).data('conf');
		var actividad = $(this).data('actividad');
		var url = "certificados/conferencista/participante.php?conf="+conf+"&act="+actividad;
		window.open(url);
	});
});
</script>

