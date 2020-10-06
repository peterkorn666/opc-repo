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
	"bootstrap/css/bootstrap.min.css"=>"css",
	"estilos/font-awesome.min.css"=>"css",
	"estilos/custom.css"=>"css",
	"bootstrap/js/bootstrap.min.js"=>"js",
);
$tpl->SetVar('headers',$headers);

if(!empty($_POST["conferencista_a_mantener"]) && !empty($_POST["conferencistas_a_eliminar"])){
	foreach($_POST["conferencistas_a_eliminar"] as $conf_a_eliminar){
		$core->bind("id_conf_a_mantener", $_POST["conferencista_a_mantener"]);
		$core->bind("id_conf_a_eliminar", $conf_a_eliminar);
		$core->query("UPDATE crono_conferencistas SET id_conf=:id_conf_a_mantener WHERE id_conf=:id_conf_a_eliminar");
		
		$core->bind("key_a_eliminar",$conf_a_eliminar);
		$core->query("DELETE FROM conferencistas WHERE id_conf=:key_a_eliminar");
	}
}

$conferencistas = $core->query("SELECT id_conf, nombre, apellido FROM conferencistas ORDER BY apellido");
?>
<h3>Unificar Conferencistas</h3>
<div class="row">
    <div class="col-md-12" style="font-size: 14px;">
    	<?php
			echo $core->messages($_GET['status']);
		?>
        <form id="formUnificarConferencista" action="?page=conferencistasUnificar" method="POST" >
        	<div class="row">
                <div class="col-md-12">
                    <label style="font-weight: bold;">Seleccione el conferencista original (el que se mantiene)</label>
                    <select name="conferencista_a_mantener" class="form-control">
                        <option value=""></option>
                        <?php
                        foreach($conferencistas as $conferencista){
                            ?>
                            <option value="<?=$conferencista['id_conf']?>">ID <?=$conferencista["id_conf"]?> - <?=$conferencista["nombre"]?> <?=$conferencista["apellido"]?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div><br>
            <div class="row">
            	<div class="col-md-12">
                	<label id="label-conferencistas-a-eliminar" style="font-weight: bold;">
                    	Seleccione los conferencistas que se eliminaran y seran reemplazados por el elegido anteriormente
                    </label>
                    <div id="div-conferencistas-a-eliminar">
                    	
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		//Select
		var label_conferencistas_a_eliminar = $("#label-conferencistas-a-eliminar");
		var div_conferencistas_a_eliminar = $("#div-conferencistas-a-eliminar");
		
		$("select[name='conferencista_a_mantener']").change(function(){
			label_conferencistas_a_eliminar.hide();
			div_conferencistas_a_eliminar.hide();
			div_conferencistas_a_eliminar.empty();
			
			var selected_conf = $(this).children("option:selected").val();
			if(selected_conf != undefined && selected_conf !== ""){
				div_conferencistas_a_eliminar
				.load("ajax/conferencistas_a_eliminar.php?conferencista_a_mantener="+selected_conf+" #target", 
				function(){
					label_conferencistas_a_eliminar.show();
					div_conferencistas_a_eliminar.show();
				})
			}
		});
		
		//Submit
		$("#formUnificarConferencista").submit(function(){
			if($("select[name='conferencista_a_mantener'] option:selected").val()=="")
			{
				alert("Elija el conferencista a mantener.");
				$("select[name='conferencista_a_mantener']").focus();
				return false;
			}
			
			var checkbox_conferencistas_a_eliminar = $("input[name='conferencistas_a_eliminar[]']:checked");
			if(checkbox_conferencistas_a_eliminar.length === 0){
				alert("Debe seleccionar al menos un conferencista para unificar.");
				return false;
			}
		});
	});
	
	function validar()
	{
		if($("input[name='conferencista_a_mantener']").val()=="")
		{
			alert("Elija el conferencista a mantener.");
			return false;
		}
	}
</script>

