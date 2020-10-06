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
	"js/autores.js"=>"js",
);
$tpl->SetVar('headers',$headers);
if(!is_array($_POST["id_autor"]) || empty($_POST["id_autor"])){
	header("Location: ".$config["url_opc"]."?page=personasTL");
	die();
}
?>
<h3>Autores</h3>
<div class="row">
    <div class="col-md-12">
    <form action="<?=$config["url_opc"]?>actions/?page=unificarAutores" method="post">
<?php
foreach($_POST["id_autor"] as $id){
	$autor = $core->getAutor($id);
	echo '<input type="hidden" name="id_autor[]" value="'.$autor["ID_Personas"].'">';
	echo '<input type="radio" name="id_save" value="'.$autor["ID_Personas"].'"> '.$autor["ID_Personas"].' - '.$autor["Nombre"]." ".$autor["Apellidos"];
	if($autor["Institucion"])
		echo " - ".$core->getInstitution($autor["Institucion"])["Institucion"];
	if($autor["Pais"])
		echo " - ".$core->getPais($autor["Pais"])["Pais"];
	if($autor["Mail"])
		echo " - ".$autor["Mail"];
	echo "<br>";
}

?><br><br>
	<input type="button" class="btn btn-default" value="Volver"> <input type="submit" class="btn btn-primary" value="Unificar"> 
    </form>
	</div>
</div>


