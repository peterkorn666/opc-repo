<?php
error_reporting(E_ALL ^ E_NOTICE);
global $tpl;
$util = $tpl->getVar('util');
//$util->isLogged();
$core = $tpl->getVar('core');
$config = $tpl->getVar('config');
$templates = $tpl->getVar('templates');
$debug = $tpl->getVar('debug');
$core->Debug($debug);
$pagination = $tpl->getVar('pagination');
$page = isset($_GET['pages']) ? ((int) $_GET['pages']) : 1;
//DEFINE HEADERS
$headers = array(
	"bootstrap/css/bootstrap.min.css"=>"css",
	"estilos/font-awesome.min.css"=>"css",
	"estilos/programaExtendido.css"=>"css",
	"estilos/custom.css"=>"css",
	"estilos/datatables.min.css"=>"css",
	//"js/jquery-1.12.4.js"=>"js",
	"js/datatables.min.js"=>"js",
	"js/estadisticasDataTable.js"=>"js"
);
$tpl->SetVar('headers',$headers);

$inscriptos = $core->getInscriptos();
$cantInscriptos = count($inscriptos);
$cantInscriptosConArea = 0;
?>
<!-- <a class="btn btn-info" id="genero" href="javascript:void(0)">Por Género</a><a class="btn btn-info" id="edad" href="javascript:void(0)">Por Edad</a><a class="btn btn-info" id="paises" href="javascript:void(0)">Por Países</a>-->
<h3>Estadísticas Inscriptos</h3>
<div class="row">
	<div class="col-md-10 col-md-offset-1">
    	<?php
			// nombre_id => nombre_Menu
			$arrayMenus = array("genero" => "Por Género", "edad" => "Por Edad", "paises" => "Por Países", "areas" => "Por Áreas", "categorias" => "Por Categorías", "planilla" => "Planilla");
			foreach($arrayMenus as $idMenu => $nombre_menu){
		?>
        		<a class="btn btn-info" id="<?=$idMenu?>" href="javascript:void(0)"><?=$nombre_menu?></a>
        <?php
			}
			$arrayGeneros = array("Femenino", "Masculino");
			$arrayEdades = array(
				"menores30" => "Menores de 30", 
				"menores40" => "Entre 30 y 39", 
				"menores50" => "Entre 40 y 49", 
				"menores60" => "Entre 50 y 59", 
				"mayores60" => "Mayores de 60"
			);
			$contGenero = array("Femenino" => 0, "Masculino" => 0);
			$contEdades = array(
				"menores30" => 0,
				"menores40" => 0,
				"menores50" => 0,
				"menores60" => 0,
				"mayores60" => 0
			);
			$arrayAreasTrabajo = array(
				1 => "Pediatría",
				2 => "Psiquiatría Pediátrica",
				3 => "Psicología", 
				4 => "Educ. Inicial", 
				5 => "Educ. Primaria", 
				6 => "Educ. Media y Superior", 
				7 => "Educ. Física", 
				8 => "Educ. Especial", 
				9 => "Psicomotricidad", 
				10 => "Fonoaudiología", 
				11 => "ONG", 
				12 => "Terapia Ocupacional", 
				13 => "Acompañante Terapéutico", 
				14 => "Musicoterapia", 
				15 => "Fisioterapia", 
				16 => "Otros", 
				17 => "Psiquiatría Adultos",
				18 => "Madre, Padre o familiar"
			);
			$arrayCategoriasInscripcionCongreso = array(
				1 => "Socios SUPIA", 
				2 => "Profesionales No socios", 
				3 => "Docentes", 
				4 => "Padres", 
				5 => "Estudiantes"
			);
			$arrayCategoriasInscripcionJornadaPadres = array(
				1 => "Inscripciones Generales (Jornada)"
			);
			$arrayPaises = array();
			$arrayAreas = array();
			$arrayCategoriasCongreso = array();
			$arrayCategoriasJornadaPadres = array();
			?>
			<div class="row seccion_planilla">
				<h4>Inscriptos</h4>
				<table border="0" class="table" id="planilla-inscriptos">
					<thead>
						<tr>
							<th>Número</th>
							<th>Solapero</th>
							<th>País - Ciudad</th>
							<th>Actividad</th>
							<th>Categoría</th>
						</tr>
					</thead>
					<tbody>
            <?php
			foreach($inscriptos as $inscripto){ //comienza recorrido de inscriptos
				//Genero
				if($inscripto["genero"]===1)
					$contGenero["Femenino"] += 1;
				elseif($inscripto["genero"]===2)
					$contGenero["Masculino"] += 1;
					
				//Edad
				$edad = '';
				$edad = calcularEdad($inscripto["fecha_nacimiento"]);
				if($edad < 30)
					$contEdades["menores30"] += 1;
				else if($edad < 40)
					$contEdades["menores40"] += 1;
				else if($edad < 50)
					$contEdades["menores50"] += 1;
				else if($edad < 60)
					$contEdades["menores60"] += 1;
				else{
					$contEdades["mayores60"] += 1;
				}
					
				//País
				$nombre_pais = $core->getPaisID($inscripto["pais"]);
				if(array_key_exists($nombre_pais, $arrayPaises)){
					$arrayPaises[$nombre_pais]["contPais"] += 1;
				}else{
					$arrayPaises = $arrayPaises + array($nombre_pais => array("contPais" => 1, "nombrePais" => $nombre_pais));
				}
				
				//Areas
				$nombre_area = $arrayAreasTrabajo[$inscripto["area_trabajo"]];
				if($inscripto["area_trabajo"]!==NULL){
					$cantInscriptosConArea++;
					if(array_key_exists($nombre_area, $arrayAreas))
						$arrayAreas[$nombre_area]["contArea"] += 1;
					else
						$arrayAreas = $arrayAreas + array($nombre_area => array("contArea" => 1, "nombreArea" => $nombre_area));
				}
				
				//Categorías
				if($inscripto["costos_inscripcion"] != 50 && $inscripto["costos_inscripcion"] != 100){
					$nombre_categoria = "";
					if($inscripto["tipo_inscripcion"]===1){
						switch($inscripto["costos_inscripcion"]){
							//Socios Supia
							case 1:
								$index_categoria = 1;
								break;
							case 6:
								$index_categoria = 1;
								break;
							case 11:
								$index_categoria = 1;
								break;
							//Profesionales No socios
							case 2:
								$index_categoria = 2;
								break;
							case 7:
								$index_categoria = 2;
								break;
							case 12:
								$index_categoria = 2;
								break;
							//Docentes
							case 3:
								$index_categoria = 3;
								break;
							case 8:
								$index_categoria = 3;
								break;
							case 13:
								$index_categoria = 3;
								break;
							//Padres
							case 4:
								$index_categoria = 4;
								break;
							case 9:
								$index_categoria = 4;
								break;
							case 14:
								$index_categoria = 4;
								break;
							//Estudiantes
							case 5:
								$index_categoria = 5;
								break;
							case 10:
								$index_categoria = 5;
								break;
							case 15:
								$index_categoria = 5;
								break;
							default:
								$index_categoria = $inscripto["costos_inscripcion"];
								break;
						}
						$arrayCategoriasCongreso[$index_categoria]["cant"] += 1;
						$arrayCategoriasCongreso[$index_categoria]["formaPago"][$inscripto["forma_pago"]] += 1;
						$nombre_categoria = $arrayCategoriasInscripcionCongreso[$index_categoria];
					}else if($inscripto["tipo_inscripcion"]===2){
						if($inscripto["costos_inscripcion"] == 1 || $inscripto["costos_inscripcion"] == 2)
							$index_categoria = 1;
						else
							$index_categoria = $inscripto["costos_inscripcion"];
						$arrayCategoriasJornadaPadres[$index_categoria]["cant"] += 1;
						$arrayCategoriasJornadaPadres[$index_categoria]["formaPago"][$inscripto["forma_pago"]] += 1;
						$nombre_categoria = $arrayCategoriasInscripcionJornadaPadres[$index_categoria];
					}
				}
				
				$nombre_ciudad = substr($inscripto["ciudad"],0,20);
			?>
                        <tr>
                            <td><?=$inscripto["id"]?></td>
                            <td><?=$inscripto["solapero"]?></td>
                            <td><?=$nombre_pais.' - '.$nombre_ciudad?></td>
                            <td><?=$nombre_area?></td>
                            <td><?=$nombre_categoria?></td>
                        </tr>
		<?php
			} //finaliza recorrido de inscriptos
			ksort($arrayPaises);
			ksort($arrayAreas);
			ksort($arrayCategoriasCongreso);
			ksort($arrayCategoriasJornadaPadres);
		?>
                	</tbody>
        		</table>
            </div>
            <div class="row seccion_genero">
                <h4>Géneros</h4>
                <table border="0" class="table">
                    <thead>
                        <tr>
                            <th>Genero</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($arrayGeneros as $name){
                        $porcentaje_genero = ($contGenero[$name] / $cantInscriptos) * 100;
                        $sumatoriaGenero += $contGenero[$name];
                    ?>
                        <tr>
                            <td><?=$name?></td>
                            <td><?=$contGenero[$name]?></td>
                            <td><?php echo round($porcentaje_genero,2).'%'; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td><?=$sumatoriaGenero?></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row seccion_edad">
                <h4>Edades</h4>
                <table border="0" class="table">
                    <thead>
                        <tr>
                            <th>Edad</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($arrayEdades as $key => $name){
                        $porcentaje_edades = ($contEdades[$key] / $cantInscriptos) * 100;
                        $sumatoriaEdades += $contEdades[$key];
                    ?>
                        <tr>
                            <td><?=$name?></td>
                            <td><?=$contEdades[$key]?></td>
                            <td><?php echo round($porcentaje_edades,2).'%'; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td><?=$sumatoriaEdades?></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row seccion_paises">
                <h4>Paises</h4>
                <table border="0" class="table">
                    <thead>
                        <tr>
                            <th>País</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($arrayPaises as $pais){
                        $porcentaje_pais = ($pais["contPais"] / $cantInscriptos) * 100;
                        $sumatoriaPaises += $pais["contPais"];
                    ?>
                        <tr>
                            <td><?=$pais["nombrePais"]?></td>
                            <td><?=$pais["contPais"]?></td>
                            <td><?php echo round($porcentaje_pais,2).'%'; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td><?=$sumatoriaPaises?></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row seccion_areas">
                <h4>Áreas</h4>
                <table border="0" class="table">
                    <thead>
                        <tr>
                            <th>Área</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($arrayAreas as $area){
                        $porcentaje_area = ($area["contArea"] / $cantInscriptosConArea) * 100;
                        $sumatoriaAreas += $area["contArea"];
                    ?>
                        <tr>
                            <td><?=$area["nombreArea"]?></td>
                            <td><?=$area["contArea"]?></td>
                            <td><?php echo round($porcentaje_area,2).'%'; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td><?=$sumatoriaAreas?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Jornada del Movimiento Asociativo de Padres</td>
                        <td><?=$cantInscriptos-$sumatoriaAreas?></td>
                        <td></td>
                    </tr>
                    <tr><td></td><td><?=$cantInscriptos?></td><td></td></tr>
                    </tbody>
                </table>
            </div>
            <div class="row seccion_categorias">
                <h4>Categorías</h4>
                <table border="0" class="table"><!-- table-bordered -->
                    <thead>
                        <tr>
                            <th>Categoria</th>
                            <th>Total</th>
                            <th></th>
                            <!--<th colspan="2">ABITAB</th>
                            <th colspan="2">Western Union</th>
                            <th colspan="2">Transferencia Bancaria</th>-->
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $porcenaje = 0;
                    $sumatoria = 0;
                    foreach($arrayCategoriasCongreso as $key => $value){
                        $porcentaje = ($value["cant"] / $cantInscriptos) * 100;
                        $sumatoria += $value["cant"];
                    ?>
                        <tr>
                            <th><?=$arrayCategoriasInscripcionCongreso[$key]?></th>
                            <th><?=$value["cant"]?></th>
                            <th><?php echo round($porcentaje,2).'%'; ?></th>
                            <!--<th><?=$value["formaPago"][3]?></th>
                            <th>plata1</th>
                            <th><?=$value["formaPago"][2]?></th>
                            <th>plata2</th>
                            <th><?=$value["formaPago"][1]?></th>
                            <th>plata3</th>-->
                        </tr>
                    <?php
                    }
                    foreach($arrayCategoriasJornadaPadres as $key => $value){
                        $porcentaje = ($value["cant"] / $cantInscriptos) * 100;
                        $sumatoria += $value["cant"];
                    ?>
                        <tr>
                            <th><?=$arrayCategoriasInscripcionJornadaPadres[$key]?></th>
                            <th><?=$value["cant"]?></th>
                            <th><?php echo round($porcentaje,2).'%'; ?></th>
                            <!--<th><?=$value["formaPago"][3]?></th>
                            <th>plata1</th>
                            <th><?=$value["formaPago"][2]?></th>
                            <th>plata2</th>
                            <th><?=$value["formaPago"][1]?></th>
                            <th>plata3</th>-->
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td><?=$sumatoria?></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
	</div><!-- end div contiene todo -->
</div> <!-- end div row -->

<?php
function calcularEdad($fecha_nacimiento){
	$fecha = explode("/", $fecha_nacimiento);
	$anio_nacimiento = $fecha[2];
	$mes_nacimiento = $fecha[1];
	$dia_nacimiento = $fecha[0];
	$largo_anio = strlen($anio_nacimiento);
	if($largo_anio < 4){
		if($largo_anio === 2)
			$anio_nacimiento = '19'.$anio_nacimiento;
	}
	$edad = date("Y") - $anio_nacimiento;
	$mes_actual = date("n");
	if($mes_nacimiento > $mes_actual)
		$edad -= 1;
	else if($mes_nacimiento == $mes_actual){
		$dia_actual = date("j");
		if($dia_actual < $dia_nacimiento){
			$edad -= 1;
		}
	}
	return $edad;
}
?>
<!--<script src="../inscripcion/js/jquery.js"></script>-->
<script type="text/javascript">
$(document).ready(function(e) {
	var clases = ["planilla", "genero", "edad", "paises", "areas", "categorias"];
	$.each(clases, function(key, value){
		$(".seccion_"+value).hide();
		
		$("#"+value).click(function(){
			$("[class*='seccion']").hide().not(".seccion_"+value);
			$(".seccion_"+value).toggle();
		});
	});
});
</script>