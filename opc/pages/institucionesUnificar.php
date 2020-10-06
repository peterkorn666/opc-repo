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

if(!empty($_POST["institucion_a_mantener"]) && !empty($_POST["instituciones_a_eliminar"])){
	foreach($_POST["instituciones_a_eliminar"] as $inst_a_eliminar){
		//Reemplazo en autores
		$core->bind("id_inst_a_mantener", $_POST["institucion_a_mantener"]);
		$core->bind("id_inst_a_eliminar", $inst_a_eliminar);
		$core->query("UPDATE personas_trabajos_libres SET Institucion=:id_inst_a_mantener WHERE Institucion=:id_inst_a_eliminar");
		
		//Reemplazo en conferencistas
		$core->bind("id_inst_a_mantener_conf", $_POST["institucion_a_mantener"]);
		$core->bind("id_inst_a_eliminar_conf", $inst_a_eliminar);
		$core->query("UPDATE conferencistas SET institucion=:id_inst_a_mantener_conf WHERE institucion=:id_inst_a_eliminar_conf");
		
		$core->bind("key_a_eliminar", $inst_a_eliminar);
		$core->query("DELETE FROM instituciones WHERE ID_Instituciones=:key_a_eliminar");
		
		header("Location: /?page=institucionesUnificar");
		die();
	}
}

$instituciones = $core->query("SELECT ID_Instituciones, Institucion FROM instituciones ORDER BY Institucion");
?>
<h3>Unificar Instituciones</h3>
<div class="row">
    <div class="col-md-12" style="font-size: 14px;">
    	<?php
			echo $core->messages($_GET['status']);
		?>
        <form id="formUnificarInstitucion" action="?page=institucionesUnificar" method="POST" >
        	<div class="row">
                <div class="col-md-12">
                    <label style="font-weight: bold;">Seleccione la institución original (la que se mantiene)</label>
                    <select name="institucion_a_mantener" class="form-control">
                        <option value=""></option>
                        <?php
                        foreach($instituciones as $institucion){
                            ?>
                            <option value="<?=$institucion['ID_Instituciones']?>">ID <?=$institucion["ID_Instituciones"]?> - <?=$institucion["Institucion"]?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div><br>
            <div class="row">
            	<div class="col-md-12">
                	<label id="label-instituciones-a-eliminar" style="font-weight: bold;">
                    	Seleccione las instituciones que se eliminaran y seran reemplazados por la elegida anteriormente
                    </label>
                    <div id="div-instituciones-a-eliminar">
                    	
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		//Select
		var label_instituciones_a_eliminar = $("#label-instituciones-a-eliminar");
		var div_instituciones_a_eliminar = $("#div-instituciones-a-eliminar");
		
		$("select[name='institucion_a_mantener']").change(function(){
			label_instituciones_a_eliminar.hide();
			div_instituciones_a_eliminar.hide();
			div_instituciones_a_eliminar.empty();
			
			var selected_inst = $(this).children("option:selected").val();
			if(selected_inst != undefined && selected_inst !== ""){
				div_instituciones_a_eliminar
				.load("ajax/instituciones_a_eliminar.php?institucion_a_mantener="+selected_inst+" #target", 
				function(){
					label_instituciones_a_eliminar.show();
					div_instituciones_a_eliminar.show();
				})
			}
		});
		
		//Submit
		$("#formUnificarInstitucion").submit(function(){
			if($("select[name='institucion_a_mantener'] option:selected").val()=="")
			{
				alert("Elija la institución a mantener.");
				$("select[name='institucion_a_mantener']").focus();
				return false;
			}
			
			var checkbox_instituciones_a_eliminar = $("input[name='instituciones_a_eliminar[]']:checked");
			if(checkbox_instituciones_a_eliminar.length === 0){
				alert("Debe seleccionar al menos una institución para unificar.");
				return false;
			}
		});
	});
</script>

