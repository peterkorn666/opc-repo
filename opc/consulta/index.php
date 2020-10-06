<?php
require("../init.php");
require("../inscripcion/clases/Db.class.php");

require("../inscripcion/clases/lang.php");
require("../inscripcion/clases/inscripcion.class.php");
require("../class/util.class.php");
$util = new Util();
$util->isLogged();
$inscripcion = new Inscripcion();
$lang = new Language("es");
$listados = $inscripcion->getInscriptos();

$formas_pago = $lang->set["FORMA_PAGO"]["array"];
$categorias = $lang->set["COSTOS_INSCRIPCION"]["array"];
$categorias_movimiento_padres = $lang->set["COSTOS_INSCRIPCION_JORNADA_PADRES"]["array"];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Consulta de inscriptos</title>
<link type="text/css" href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link type="text/css" href="../estilos/datatables.min.css" rel="stylesheet">
<link type="text/css" href="../estilos/custom.css" rel="stylesheet">
<link type="text/css" href="estilos.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
	<div class="row">
    	<div class="col-xs-12 text-center"><img src="../imagenes/banner.jpg" style="width:580px;height:110px"></div>
    </div>
    <br>
    <div class="row">
    	<div class="col-xs-12">
        	<h3>Listado de inscriptos</h3>
        	<a href='../excels/inscriptos.php'>Descargar excel inscriptos</a><br>
            <table class="table" id="listado-inscriptos">
                <thead>
                  <tr>
                  	<th></th>
                    <th>Estado</th>
                    <th>ID</th>
                    <th>Recibos</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Documento</th>
                    <th>País</th>
                    <th>Email</th>
                    <th>Precio</th>
                    <th>Categor&iacute;a</th>
                    <th>Forma pago</th>
                    <th>Trabajos</th>
                    <!--<th>Nº comprobante</th>
                    <th>Foto</th>-->
                    <th>Comentarios</th>
                  </tr>
                </thead>
                <tfoot>
                    <tr>
                    	<th></th>
                        <th>Estado</th>
                    	<th>ID</th>
                        <th></th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Documento</th>
                    	<th></th>
                        <th>Email</th>
                        <th>Precio</th>
                        <th>Categor&iacute;a</th>
                        <th>Forma pago</th>
                        <th>Trabajos</th>
                        <!--<th></th>
                        <th>Foto</th>-->
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
        <?php
		$h = 0;
        foreach($listados as $listado){
			
			$costo_inscripcion = $inscripcion->getOpcionPrecioByID($listado["costos_inscripcion"]);
			$forma_pago = $inscripcion->getOpcionFormaPagoByID($listado["forma_pago"]);
			
			$foto_perfil = "No";
			if($listado["foto_perfil"])
				$foto_perfil = "<a href='../inscriptos_fotos/".$listado["foto_perfil"]."' target='_blank'>Si</a>";
        ?>      
                  <tr>
                  	<?php
					if($_SESSION["usuario"]=="caja" || $_SESSION["tipoUsu"]=="1"){
					?>
                  	<td class="td_inscripto">
						<?php
                        	if(!$listado["estado"]){
								echo '<span class="hide">Pago pendiente</span>';
								//echo '<div class="circle-red persona-inscripto" data-id="'.$listado["id"].'" data-ins="1" style="cursor: pointer;" align="center"></div>';
								echo '<div class="circle-red" style="cursor: pointer;" align="center"></div>';
							}else{
								echo '<span class="hide">Pago aprobado</span>';
								//echo '<div class="circle-green persona-inscripto" data-id="'.$listado["id"].'" data-ins="0" style="cursor: pointer;" align="center"></div>';
								echo '<div class="circle-green" style="cursor: pointer;" align="center"></div>';
							}
						?>
                    </td>
                    <?php
					}
					?>
                    <td><?=$listado["estado"]?></td>
                    <td><a href="../inscripcion/login.php?key=<?=base64_encode($listado["id"])?>" target="_blank"><?=$listado["id"]?></a></td>
                    <td><a href="../recibos/login.php?next=<?=md5($listado["id"].$listado["email"])?>" target="_blank">recibo</a></td>
                    <td><?=$listado["nombre"]?></td>
                    <td><a href="../inscripcion/perfil.php?key=<?=base64_encode($listado["id"])?>" target="_blank"><?=$listado["apellido"]?> <?=$listado["apellido2"]?></a></td>
                    <td><?=$listado["numero_pasaporte"]?></td>
                    <td>
                    	<?php
							$pais = $inscripcion->getPaisesID($listado["pais"]);
                        	echo $pais["Pais"];
						?>
                    </td>
                    <td><?=$listado["email"]?></td>
                    <td><?=$costo_inscripcion["precio"]?></td>
                    <td><?=$costo_inscripcion["nombre"]?></td>
                    <td><?=$forma_pago["nombre"]?></td>
					<!--if(strpos($forma_pago, "Bancaria") !== false)-->
                    <td><?php 
						echo $inscripcion->getTrabajosByPassaport($listado["numero_pasaporte"]);
					?></td>
                    <!--<td><a href='../inscripcion/comprobantes/<?=$listado["comprobante_archivo"]?>'><?=$listado["numero_comprobante"]?></a>--></td>
                    <!--<td><?php
					//if($listado["comprobante_archivo"] != NULL){
					?>
						<a href="../inscripcion/comprobantes/<?=$listado["comprobante_archivo"];?>" target="_blank"><?=$listado["numero_comprobante"];?></a>
                    <?php
					//}else
                    	//echo $listado["numero_comprobante"];
					?></td>
                    <td><?php //echo $foto_perfil?></td>-->
                    <td><?php 
					if ($listado["comentarios"]!='NULL')
							echo $listado["comentarios"]; ?></td>
                  </tr>
        <?php
			/*if($h == 100)
				break;
			$h++;*/
        }
        ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/jquery-1.12.4.js"></script>
<script type="text/javascript" src="../js/datatables.min.js"></script>
<script type="text/javascript" src="js/consulta.js"></script>
</body>
</html>