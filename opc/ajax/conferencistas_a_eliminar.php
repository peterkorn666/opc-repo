<?php
if(empty($_GET["conferencista_a_mantener"])){
	header("Location: /?page=conferencistasUnificar");
	die();
}
require("../class/core.php");
$core = new Core();

$conferencistas_sin_a_mantener = $core->query("
									SELECT 
										id_conf, nombre, apellido, email 
									FROM 
										conferencistas
									WHERE 
										id_conf<>".$_GET["conferencista_a_mantener"]
									);
?>
<h3>Conferencistas a eliminar</h3>
<div class="row">
    <div class="col-md-12" style="font-size: 14px;">
    	<div id="target" class="col-md-12">
        	<div class="row">
            	<div class="col-md-1">
                	&nbsp;
                </div>
                <div class="col-md-1">
                	ID
                </div>
                <div class="col-md-3">
                	Nombre
                </div>
                <div class="col-md-3">
                	Apellido
                </div>
                <div class="col-md-4">
                	Email
                </div>
            </div>
        	<?php
				foreach($conferencistas_sin_a_mantener as $conferencista){
					?>
                    	<div class="row">
                        	<div class="col-md-1">
                            	<input type="checkbox" name="conferencistas_a_eliminar[]" value="<?=$conferencista["id_conf"]?>">
                            </div>
                        	<div class="col-md-1">
                            	<?=$conferencista["id_conf"]?>
                            </div>
                            <div class="col-md-3">
                            	<?=$conferencista["nombre"]?>
                            </div>
                            <div class="col-md-3">
                            	<?=$conferencista["apellido"]?>
                            </div>
                            <div class="col-md-4">
                            	<?=$conferencista["email"]?>
                            </div>
                        </div>
                    <?php
				}
            ?>
            <div class="row">
            	<div class="col-md-12">
                	<input type="submit" value="Unificar" class="form-control btn btn-primary">
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
</script>

