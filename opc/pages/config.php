<?php
global $tpl;
$util = $tpl->getVar('util');
$util->isLogged();
$core = $tpl->getVar('core');
$config = $tpl->getVar('config');
$templates = $tpl->getVar('templates');
$debug = $tpl->getVar('debug');
$core->Debug($debug);
if(!$core->isAdmin()){
	header("Location: /");
	die();
}
//DEFINE HEADERS
$headers = array(
	"estilos/config.css"=>"css",
	"bootstrap/css/bootstrap.min.css"=>"css",
	"estilos/custom.css"=>"css"
);
$tpl->SetVar('headers',$headers);

if($_POST)
{
	$core->bind("config_nombre_congreso",$_POST["config_nombre_congreso"]);
	$core->bind("config_banner",$_POST["config_banner"]);
	$core->bind("config_url_website",$_POST["config_url_website"]);
	$core->bind("config_url_opc",$_POST["config_url_opc"]);
	$core->bind("conig_email_congreso",$_POST["conig_email_congreso"]);
	$core->bind("config_email_inscripcion",$_POST["config_email_inscripcion"]);
	$core->bind("config_email_abstract",$_POST["config_email_abstract"]);
	$updateConfig = $core->query("UPDATE config SET 
										nombre_congreso=:config_nombre_congreso,
										banner_congreso=:config_banner,
										url_website=:config_url_website,
										url_opc=:config_url_opc,
										email_congreso=:conig_email_congreso,
										email_inscripcion=:config_email_inscripcion,
										email_abstract=:config_email_abstract
								 ");
	header("Location: /?page=config");
}
?>
<h3>Configuración OPC</h3>
<form action="index.php?page=config" method="post">
<div class="row">
    <div class="col-md-4">
    	<label>Nombre</label>
    	<input type="text" name="config_nombre_congreso" class="form-control" value="<?=$config["nombre_congreso"]?>">
    </div>
    <div class="col-md-4">
    	<label>URL website</label>
    	<input type="text" name="config_url_website" class="form-control" value="<?=$config["url_website"]?>">
    </div>
    
    <div class="col-md-4">
    	<label>URL OPC</label>
    	<input type="text" name="config_url_opc" class="form-control" value="<?=$config["url_opc"]?>">
    </div>
</div>

<div class="row">
	<div class="col-md-4">
    	<label>Banner</label>
    	<input type="text" name="config_banner" class="form-control" value="<?=$config["banner_congreso"]?>">
    </div>
    
    <div class="col-md-4">
    	<label>Email Insc.</label>
    	<input type="text" name="config_email_inscripcion" class="form-control" value="<?=$config["email_inscripcion"]?>">
    </div>
   
    <div class="col-md-4">
    	<label>Email Abstract</label>
    	<input type="text" name="config_email_abstract" class="form-control" value="<?=$config["email_abstract"]?>">
    </div>
</div>
<div><br>
<a href="<?=$config["url_opc"]?>Cambiar ETIQUETAS_01.pdf">Tutorial Cambio de Etiquetas</a>
<br>
<?php
/*$archivo = fopen("../abstract/lang/ddd.txt","r");
    if( $archivo == false ) {
      echo "Error al abrir el archivo";
    }*/
?>
<!--<textarea id="editor1" name="editor1" class="std-radius tiny" ><?=$archivo?></textarea>
</div>-->
	<br>
    <p align="center"><input type="submit" value="Guardar configuración" class="btn btn-primary"></p>
</form>