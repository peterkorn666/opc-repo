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
	"estilos/datatables.min.css"=>"css",
	"estilos/datatables.fixedHeader.css"=>"css",
	"bootstrap/js/bootstrap.min.js"=>"js",
	"js/autores.js"=>"js",
	"js/datatables.min.js"=>"js"
);
$tpl->SetVar('headers',$headers);
if($_POST["buscar"]){
	
	$core->bind("ins", "%".$_POST["buscar"]."%");
	$rowI = $core->query("SELECT * FROM instituciones WHERE Institucion LIKE :ins");
	$w = "WHERE Nombre LIKE :buscara OR Apellidos LIKE :buscarb OR Mail LIKE :buscarc";
	$core->bind("buscara", "%".$_POST["buscar"]."%");
	$core->bind("buscarb", "%".$_POST["buscar"]."%");
	$core->bind("buscarc", "%".$_POST["buscar"]."%");
	
	foreach($rowI as $key => $ins){
		$w .= " OR Institucion=:buscar".$key;
		$core->bind("buscar".$key, $ins["ID_Instituciones"]);
	}
	
	
}
$personas = $core->query("SELECT *, p.ID_Personas as id_personas FROM trabajos_libres as t JOIN trabajos_libres_participantes as tp ON t.id_trabajo=tp.ID_trabajos_libres JOIN personas_trabajos_libres as p ON tp.ID_participante=p.ID_Personas $w ORDER BY Apellidos");
if(isset($_GET['id'])){
	$core->bind('id',$_GET['id']);
	$row = $core->row("SELECT * FROM personas_trabajos_libres WHERE ID_Personas=:id");
}

function lee($txt, $lee){
	if($lee)
		return "<u>".$txt."</u>";
	else
		return $txt;
}
?>
<h3>Autores</h3>
<!--<div class="row">
    <div class="col-md-12">
    	<?php
			echo $core->messages($_GET['status']);
		?>
    	<form action="<?=$config["opc_url"]?>ajax/autores.php" method="post" id="form_autores">
    	<table width="62%" class="table">
		  <tbody>
                <tr bgcolor="#FFFFFF">
                  <td width="8%" height="10">Nombre:</td>
                  <td width="35%" height="10"><input type="text" id="nombre" name="nombre" class="form-control input-sm" value="<?=$row['Nombre']?>"></td>
                  <td width="9%">Profesión:</td>
                  <td width="48%">
                    <select id="profesiones" name="profesion" class="form-control input-sm">
                    	<option value=""></option>
                        <?php
                        $profesiones = $core->getProfesiones();
                        foreach($profesiones as $profesion){
                            if($profesion['ID_Profesiones']==$row['Profesion'])
                                $chk = 'selected';
                            echo "<option value='".$profesion['ID_Profesiones']."' $chk>".$profesion['Profesion']."</option>";
                            $chk = '';
                        }
                        ?>
                    </select>
                  <a href="#" class="agregarProfesion">Agregar Profesión</a></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="8%" height="10">Apellidos:</td>
                  <td height="10">
                    <input type="text" id="apellidos" name="apellidos" class="form-control input-sm" value="<?=$row['Apellidos']?>">
                  </td>
                  <td>Cargo:</td>
                  <td>
                    <select id="cargos" name="cargo" class="form-control input-sm">
                        <option value=""></option>
                        <?php
                        $cargos = $core->getCargos();
                        foreach($cargos as $cargo){
                            if($cargo['ID_Cargo']==$row['Cargos'])
                                $chk = 'selected';
                            echo "<option value='".$cargo['ID_Cargo']."' $chk>".$cargo['Cargos']."</option>";
                            $chk = '';
                        }
                        ?>
                    </select>
                  <a href="#" class="agregarCargos">Agregar Cargo</a></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td height="10">Institución:</td>
                  <td height="10">
                    <select id="institucion" name="institucion" class="form-control input-sm">
                    	<option value=""></option>
                    <?php
					$instituciones = $core->getInstitutiones();
					foreach($instituciones as $institucion){
						if($institucion['ID_Instituciones']==$row['Institucion'])
							$chk = 'selected';
						echo "<option value='".$institucion['ID_Instituciones']."' $chk>".$institucion['Institucion']."</option>";
						$chk = '';
					}
					?>
                    </select>
                  <a href="#" class="agregarIns">Agregar Institución</a></td>
                  <td>Curriculum:</td>
                  <td>
                    <input type="file" id="archivo" name="archivo">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="8%" height="10">País:</td>
                  <td height="10">
                    <select id="paises" name="pais" class="form-control input-sm">
                    <?php
					$paises = $core->getPaises();
					foreach($paises as $pais){
						if($pais['ID_Paises']==$row['Pais'])
							$chk = 'selected';
						echo "<option value='".$pais['ID_Paises']."' $chk>".$pais['Pais']."</option>";
						$chk = '';
					}
					?>
                    </select>
                  <a href="#" class="agregarPais">Agregar País</a></td>
                  <td>E-mail:</td>
                  <td>
                    <input type="text" id="mail" name="mail" class="form-control input-sm" value="<?=$row['Mail']?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="8%" height="10">&nbsp;</td>
                  <td height="10" colspan="2" align="left"><input type="button" value="Limpiar" onclick="limpiar()" class="btn btn-default input-sm" name="nuevo" /></td>
                  <td height="10" align="right"><input type="submit" value="Guardar" onclick="ValidarPersonaTL()" class="btn btn-primary input-sm" name="Submit" /></td>
                </tr>
              </tbody>
          </table>
          <input type="hidden" name="id" value="<?php echo $row['ID_Personas']?>" />
      </form>
  </div>  
</div>-->

<!-- Crear autor -->
<!--<div class="row">
    <div class="col-md-12">
    	<?php
			echo $core->messages($_GET['status']);
		?>
    	<form action="<?=$config["opc_url"]?>ajax/autores.php" method="post" id="form_autores">
            <table width="62%" class="table">
                <tbody>
                    <tr bgcolor="#FFFFFF">
                    	<td width="8%" height="10">Profesión:</td>
                        <td width="8%" height="10">Nombres:</td>
                        <td width="8%" height="10">Apellidos</td>
                        <td width="8%" height="10">Pasaporte</td>
                        <td width="8%" height="10">Institución</td>
                        <td width="8%" height="10">Email</td>
                        <td width="8%" height="10">País</td>
                    </tr>
                    <tr>
                    	<td width="8%" height="10">
                        	<input type="text" id="profesion" name="profesion" class="form-control" value="<?=$row['Profesion']?>">
                        </td>
                    	<td width="8%" height="10">
                        	<input type="text" id="nombre" name="nombre" class="form-control" value="<?=$row['Nombre']?>">
                        </td>
                        <td width="8%" height="10">
                        	<input type="text" id="apellidos" name="apellidos" class="form-control" value="<?=$row['Apellidos']?>">
                        </td>
                        <td width="8%" height="10">
                        	<input type="text" id="pasaporte" name="pasaporte" class="form-control" value="<?=$row['pasaporte']?>">
                        </td>
                        <td height="10">
                            <select id="institucion" name="institucion" class="form-control">
                                <option value=""></option>
                            <?php
                            
                            $instituciones = $core->getInstitutiones();
                            foreach($instituciones as $institucion){
                                if($institucion['ID_Instituciones']==$row['Institucion'])
                                    $chk = 'selected';
                                echo "<option value='".$institucion['ID_Instituciones']."' $chk>".$institucion['Institucion']."</option>";
                                $chk = '';
                            }
                            
                            ?>
                            </select>
							<a href="#" class="agregarIns">Agregar Institución</a>
                        </td>
                        <td width="8%" height="10">
                        	<input type="text" id="mail" name="mail" class="form-control" value="<?=$row['Mail']?>">
                        </td>
                        <td height="10">
                            <select id="paises" name="pais" class="form-control">
                            <?php
                            
                            $paises = $core->getPaises();
                            foreach($paises as $pais){
                                if($pais['ID_Paises']==$row['Pais'])
                                    $chk = 'selected';
                                echo "<option value='".$pais['ID_Paises']."' $chk>".$pais['Pais']."</option>";
                                $chk = '';
                            }
                            
                            ?>
                            </select>
							<a href="#" class="agregarPais">Agregar País</a>
						</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                        <td width="8%" height="10">&nbsp;</td>
                        <td height="10" colspan="2" align="left"><input type="button" value="Limpiar" onclick="limpiar()" class="btn btn-default input-sm" name="nuevo" /></td>
                        <?php //onclick="ValidarPersonaTL()" ?>
                        <td height="10" align="right"><input type="submit" value="Guardar" class="btn btn-primary input-sm" name="Submit" /></td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="id" value="<?php echo $row['ID_Personas']?>" />
		</form>
	</div>  
</div>-->

<!--<form action="<?=$config["url_opc"]?>?page=personasTL" method="post">
<div class="row">
	<div class="col-xs-6 col-xs-offset-3"> 
        <div class="input-group">
          <input type="text" name="buscar" class="form-control" value="<?=$_POST["buscar"]?>">
          <span class="input-group-btn">
            <button class="btn btn-warning" type="submit">Buscar</button>
          </span>
        </div>
    </div>
</div>
</form>-->
<form action="<?=$config["url_opc"]?>?page=unificarTLa" method="post">
<div class="row">
	<div class="col-xs-12">
    	<!--<input type="submit" id="unificar_autores" class="btn btn-link input-sm" value="unificar autores">-->
		<div class="table-responsive" style="height:500px">        
    	<table id="listado-autores" border="0" cellspacing="5" cellpadding="1" class="table table-borderer header-fixed">
        	<thead>
                  <tr>
                    <!--<th><input type="checkbox" name="allid" style="display:none"></th>-->
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>ID</th>
                    <th>trabajo</th>
                    <th>Profesión</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Pasaporte</th>
                    <th>Institución</th>
                    <th>Pais</th>
                    <th>Email</th>
                    <!--<th>&nbsp;</th>-->
                  </tr>
             </thead>
             <tfoot>
                <tr>
                	<th></th>
                    <th>Estado</th>
                    <th></th>
                    <th>trabajo</th>
                    <th></th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Pasaporte</th>
                    <th></th>
                    <th></th>
                    <th>Email</th>
                </tr>
            </tfoot>
            <tbody>
<?php
foreach($personas as $persona){
?>
          <tr>
            <!--<td>
            <?php /*if($core->canEdit()){ ?>
            	<a href="<?php echo $config['opc_url']?>?page=personasTL&id=<?php echo $persona['ID_Personas']?>"><i class="fa fa-pencil"></i></a> 
                <?php }*/ ?>
            </td>-->
            <td>
            	<input type="checkbox" name="id_autor[]" value="<?=$persona["ID_Personas"]?>" style="display:none">
				<?php
				$color = 'red';
            	if($persona["inscripto"])
					$color = 'green';
				else if($persona["numero_inscripcion"])
					$color = 'yellow';
				echo "<div class='circle-$color autor-inscripto' data-id='".$persona["ID_Personas"]."' data-ins='".($persona["inscripto"]?0:1)."'></div>";
				?></td>
            <td><?=$persona["inscripto"]?></td>
            <td><?=$persona["id_personas"]?></td>
            <td><?=$persona["numero_tl"]?></td>
            
            <td><?=$persona["Profesion"]?></td>
            <td <?php if($persona["lee"]){echo "bgcolor='#eeeeee'";} ?>><?=lee($persona["Nombre"],$persona["lee"])?></td>
            <td <?php if($persona["lee"]){echo "bgcolor='#eeeeee'";} ?>>
			<?php
				if($core->canEdit())
					echo "<a href='".$config['opc_url']."?page=personasTL&id=".$persona['ID_Personas']."'>";
				echo lee($persona["Apellidos"],$persona["lee"]);
				if($core->canEdit())
					echo "</a>";
			?></td>
            <td><?=$persona["pasaporte"]?></td>
            <td style="font-size:10px"><?=$core->getInstitution($persona["Institucion"])['Institucion']?></td>
            <td><?=$core->getPais($persona["Pais"])['Pais']?></td>
            <td><?=$persona["Mail"]?></td>
            <!--<td nowrap>
                <?php if($core->canDel()){ ?>
                <!--&nbsp;<a href="#" class="eliminarAutor" data-id="<?php echo $persona['ID_Personas']?>"><i class="fa fa-trash"></i></a>
                <?php } ?>
            </td>-->
          </tr>
<?php
}
?>
			</tbody>
        </table>
        </div>
    </div>
</div>
</form>
<script type="text/javascript">
function validar()
{
	if($("input[name='nombre']").val()=="")
	{
		alert("Escriba un nombre");
		return false;
	}
	if($("input[name='apellidos']").val()=="")
	{
		alert("Escriba un apellido");
		return false;
	}
	if($("input[name='mail']").val()=="")
	{
		alert("Escriba un email");
		return false;
	}
}
function limpiar(){
	$("input:not(:submit):not(:button):not(:file):not(:checkbox),select").val('');
}
</script>

