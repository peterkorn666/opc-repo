<?php
global $tpl;
$util = $tpl->getVar('util');
$util->isLogged();
$core = $tpl->getVar('core');
$config = $tpl->getVar('config');
$templates = $tpl->getVar('templates');
$debug = $tpl->getVar('debug');
$core->Debug($debug);
$core->isAdmin();
//DEFINE HEADERS
$headers = array(
	"bootstrap/css/bootstrap.min.css"=>"css",
	"estilos/font-awesome.min.css"=>"css",
	"estilos/custom.css"=>"css",
	"bootstrap/js/bootstrap.min.js"=>"js",
);
$tpl->SetVar('headers',$headers);
if(!is_array($_POST["id_institucion"]) || empty($_POST["id_institucion"])){
	header("Location: ".$config["url_opc"]."?page=instituciones");
	die();
}
?>
<h3>Autores</h3>
<div class="row">
    <div class="col-md-12">
    <form action="<?=$config["url_opc"]?>actions/?page=unificarInstituciones" method="post">
<?php
foreach($_POST["id_institucion"] as $id){
	$institucion = $core->getInstitution($id);
	echo '<input type="hidden" name="id_institucion[]" value="'.$institucion["ID_Instituciones"].'">';
	echo '<input type="radio" name="id_save" value="'.$institucion["ID_Instituciones"].'"> '.$institucion["ID_Instituciones"].' - '.$institucion["Institucion"];
	echo "<br>";
}

?><br><br>
	<a href="<?php echo $config['url_opc']?>/?page=instituciones" class="btn btn-link">Volver</a> <input type="submit" class="btn btn-primary" value="Unificar"> 
    </form>
	</div>
</div>


