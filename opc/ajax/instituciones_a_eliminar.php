<?php
if(empty($_GET["institucion_a_mantener"])){
	header("Location: /?page=conferencistasUnificar");
	die();
}
require("../class/core.php");
$core = new Core();

$instituciones_sin_a_mantener = $core->query("
									SELECT 
										ID_Instituciones, Institucion
									FROM 
										instituciones
									WHERE 
										ID_Instituciones<>".$_GET["institucion_a_mantener"]
									);
?>
<h3>Instituciones a eliminar</h3>
<div class="row">
    <div class="col-md-12" style="font-size: 14px;">
    	<div id="target" class="col-md-12">
        	<div class="row">
            	<div class="col-md-1">
                	&nbsp;
                </div>
                <div class="col-md-2">
                	ID
                </div>
                <div class="col-md-9">
                	Nombre
                </div>
            </div>
        	<?php
				foreach($instituciones_sin_a_mantener as $institucion){
					?>
                    	<div class="row">
                        	<div class="col-md-1">
                            	<input type="checkbox" name="instituciones_a_eliminar[]" value="<?=$institucion["ID_Instituciones"]?>">
                            </div>
                        	<div class="col-md-2">
                            	<?=$institucion["ID_Instituciones"]?>
                            </div>
                            <div class="col-md-9">
                            	<?=$institucion["Institucion"]?>
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

