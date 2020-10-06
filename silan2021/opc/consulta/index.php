<?php
require("../../init.php");

require("../class/inscripcion.class.php");
require("../../inscripcion/clases/lang.php");
require("../class/util.class.php");
require("../class/estadisticas.class.php");
$util = new Util();
$util->isLogged();
$inscripcion = new Inscripcion();
$estadisticas = new Estadisticas();
$lang = new Language("es");
$listado = $inscripcion->litado();
$config = $inscripcion->getConfig();
$maximo_titulos = $lang->set["MAXIMO_TITULO"]["array"];
$tipos_documentos = $lang->set["TIPOS_DOCUMENTOS"]["array"];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Consulta</title>
<link type="text/css" href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link type="text/css" href="../estilos/datatables.min.css" rel="stylesheet">
<link type="text/css" href="../estilos/custom.css" rel="stylesheet">
</head>
<body>
<div class="container">
	<div class="row">
    	<div class="col-xs-12 text-center"><img src="<?=$config["banner_congreso"]?>"></div>
    </div><br>
    <div class="row">
    	<div class="col-xs-2 text-center">
        	Cuentas<br><?=$estadisticas->getCuentas()?>
        </div>
        <div class="col-xs-2 text-center">
        	Trabajos<br><?=$estadisticas->getTrabajos()?>
        </div>
        <div class="col-xs-2 text-center">
        	Cuentas con trabajos<br><?=$estadisticas->getCuentas("con_trabajos")?>
        </div>
        <div class="col-xs-2 text-center">
        	Cuentas sin trabajos<br><?=$estadisticas->getCuentas("sin_trabajos")?>
        </div>
        <div class="col-xs-4 text-center">
        	Cantidad de diplomas (si todos pagaran)<br><?=$estadisticas->getAutores()?>
        </div>
    </div>
    <br>
    <div class="row">
    	<div class="col-xs-12">
        	
            <table class="table" id="listado-inscriptos">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Estado</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Documento</th>
                    <th>Institución</th>
                    <th>País</th>
                    <th>Ciudad</th>
                    <th>Teléfono</th>
                    <th>Nacimiento</th>
                    <th>Título</th>
                  </tr>
                </thead>
                <tbody>
        <?php
        foreach($listado as $listado){
        ?>      
                  <tr>
                    <td><a href="../../inscripcion/login.php?key=<?=base64_encode($listado["id"])?>" target="_blank"><?=$listado["id"]?></a></td>
                    <?php
					if($_SESSION["usuario"]=="caja" || $_SESSION["tipoUsu"]=="1"){
					?>
                    <td class="td_inscripto">
						<?php
                        	if(!$listado["estado"]){
								echo '<span class="hide">Pago pendiente</span>';
								echo '<div class="circle-red persona-inscripto" data-id="'.$listado["id"].'" data-ins="1" style="cursor: pointer;"></div>';
							}else{
								echo '<span class="hide">Pago aprobado</span>';
								echo '<div class="circle-green persona-inscripto" data-id="'.$listado["id"].'" data-ins="0" style="cursor: pointer;"></div>';
							}
						?>
                    </td>
                    <?php
					}
					?>
                    <td><?=$listado["nombre"]?></td>
                    <td><?=$listado["apellido"]?> <?=$listado["apellido2"]?></td>
                    <td><?=$tipos_documentos[$listado["tipo_documento"]]?> <?=$listado["numero_pasaporte"]?></td>
                    <?php
					if($_SESSION["usuario"]!="caja"){
					?>
                    <td><?=$listado["institucion"]?></td>
                    <td>
                    	<?php
							$pais = $inscripcion->getPais($listado["pais"]);
                        	echo $pais["Pais"];
						?>
                    </td>
                    <td><?=$listado["ciudad"]?></td>
                    <td><?=$listado["telefono"]?></td>
                    <td><?=$listado["fecha_nacimiento"]?></td>
                    <td><?=$maximo_titulos[$listado["cargo"]]?></td>
                    <?php
					}
					?>
                  </tr>
        <?php
        }
        ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/datatables.min.js"></script>
<script type="text/javascript" src="js/consulta.js"></script>
</body>
</html>