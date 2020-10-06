<?php
if(empty($_GET["id_autor"])){
	header("Location: /?page=programaExtendido");
	die();
}
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
	"bootstrap/css/bootstrap.min.css"=>"css",
	"estilos/font-awesome.min.css"=>"css",
	"estilos/custom.css"=>"css",
	"bootstrap/js/bootstrap.min.js"=>"js",
);
$tpl->SetVar('headers',$headers);

if(!empty($_POST["id_autor"])){
	$url_anterior = $_POST["url_anterior"];
	if(empty($_POST["rol_autor"])){
		$rol_autor = NULL;
	}else{
		$rol_autor = $_POST["rol_autor"];
	}
	$core->bind("id_autor", $_POST["id_autor"]);
	$core->bind("rol_autor", $rol_autor);
	$core->query("UPDATE personas_trabajos_libres SET rol_crono=:rol_autor WHERE ID_Personas=:id_autor");
	header("Location: ".$url_anterior);
	die();
}

$roles = $core->query("SELECT * FROM calidades_conferencistas ORDER BY calidad");
$autor = $core->query("SELECT ID_Personas, Nombre, Apellidos, rol_crono FROM personas_trabajos_libres WHERE ID_Personas=".$_GET["id_autor"])[0];
if(count($autor) == 0){
	header("Location: /?page=programaExtendido");
	die();
}
?>
<h3>Asignar Rol a <?=$autor["Nombre"]?> <?=$autor["Apellidos"]?> (ID autor <?=$autor["ID_Personas"]?>)</h3>
<div class="row">
    <div class="col-md-12" style="font-size: 14px;">
    	<?php
			echo $core->messages($_GET['status']);
		?>
        <form id="asignarRol" action="?page=asignarRol&id_autor=<?=$_GET["id_autor"]?>" method="POST" >
        	<input type="hidden" name="id_autor" value="<?=$autor["ID_Personas"]?>">
            <input type="hidden" name="url_anterior" value="">
        	<div class="row">
                <div class="col-md-12">
                    <label style="font-weight: bold;">Seleccione el rol</label>
                    <select name="rol_autor" class="form-control">
                        <option value=""></option>
                        <?php
                        foreach($roles as $rol){
							$selected = "";
							if($rol['ID_calidad'] == $autor["rol_crono"]){
								$selected = 'selected';
							}
                            ?>
                            <option value="<?=$rol['ID_calidad']?>" <?=$selected?>><?=$rol["calidad"]?></option>
                            <?php
                        }
						$selected = "";
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input type="submit" class="form-control btn btn-primary" value="Guardar">
                </div>
            </div><br>
        </form>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("input[name='url_anterior']").val(document.referrer);
		
		//Submit
		$("#asignarRol").submit(function(){
			console.log($("input[name='url_anterior']").val());
			if($("select[name='rol_autor'] option:selected").val()=="")
			{
				/*alert("Elija el rol a asignar.");
				$("select[name='rol_autor']").focus();
				return false;*/
				return confirm("¿Esta seguro que desea asignarle el rol vacío a la persona?");
			}
		});
	});
</script>

