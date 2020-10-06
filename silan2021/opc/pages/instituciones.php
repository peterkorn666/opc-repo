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
$instituciones = $core->query("SELECT * FROM instituciones ORDER BY Institucion");
if(isset($_GET['id'])){
	$core->bind('id',$_GET['id']);
	$row = $core->row("SELECT * FROM instituciones WHERE ID_Instituciones=:id");
}
?>
<h3>Autores</h3>
<div class="row">
    <div class="col-md-12">
    	<?php
			echo $core->messages($_GET['status']);
		?>
    	<form action="<?=$config["opc_url"]?>ajax/agregarInstitucion.php" method="post" id="form_autores">
    	<table width="62%" class="table">
		  <tbody>
                <tr bgcolor="#FFFFFF">
                  <td width="8%" height="10">Nombre:</td>
                  <td height="10" colspan="2"><input type="text" id="nombre" name="nombre" class="form-control input-sm" value="<?=$row['Institucion']?>"></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="8%" height="10">&nbsp;</td>
                  <td width="35%" height="10" align="left"><input type="button" value="Limpiar" onclick="limpiar()" class="btn btn-default input-sm" name="nuevo" /></td>
                  <td width="48%" height="10" align="right"><input type="submit" value="Guardar" onclick="ValidarPersonaTL()" class="btn btn-primary input-sm" name="Submit" /></td>
                </tr>
              </tbody>
          </table>
          <input type="hidden" name="id" value="<?php echo $row['ID_Instituciones']?>" />
      </form>
  </div>  
</div>
<form action="<?=$config["url_opc"]?>?page=unificarInstituciones" method="post">
<div class="row">
	<div class="col-xs-12">
    	<input type="submit" id="unificar_autores" class="btn btn-link input-sm" value="unificar instituciones">
    	<table width="580" border="0" cellspacing="5" cellpadding="1" class="table table-borderer header-fixed">
        	<thead>
                  <tr>
                    <th><input type="checkbox" name="allid"></th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>&nbsp;</th>
                  </tr>
             </thead>
             <tbody>
<?php
foreach($instituciones as $institucion){
?>
          <tr>
            <td><input type="checkbox" name="id_institucion[]" value="<?=$institucion["ID_Instituciones"]?>"></td>
            <td><?=$institucion["ID_Instituciones"]?></td>
            <td><?=$institucion["Institucion"]?></td>
            <td nowrap>
            	<?php if($core->canEdit()){ ?>
            	<a href="<?php echo $config['opc_url']?>?page=instituciones&id=<?php echo $institucion['ID_Instituciones']?>"><i class="fa fa-pencil"></i></a>
                <?php } ?>
                <?php if($core->canDel()){ ?>
                &nbsp;<a href="#" class="eliminarInstitucion" data-id="<?php echo $institucion['ID_Instituciones']?>"><i class="fa fa-trash"></i></a>
                <?php } ?>
            </td>
          </tr>
<?php
}
?>
			</tbody>
        </table>
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
}
function limpiar(){
	$("input:not(:submit):not(:button):not(:file):not(:checkbox),select").val('');
}
</script>

