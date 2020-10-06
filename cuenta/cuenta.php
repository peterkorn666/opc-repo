<?php
setlocale(LC_ALL, 'es_ES.UTF8');
require("../init.php");
//require("class/cuenta.class.php");
$cuenta = new Cuenta();
$config = $cuenta->getConfig();
$inscripto = $cuenta->getInscripto();
if($inscripto["estado"])
	$status = "circle-green";
else
	$status = "circle-red";
$datos =  $cuenta->getCuenta();

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$config["nombre_congreso"]?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/cuenta.css">
<link type="text/css" href="../opc/estilos/custom.css" rel="stylesheet">
</head>

<body>
<?php
if($_SERVER["SERVER_NAME"] == "beta-alas2017.easyplanners.info"):
?>
<div id="beta-alert"></div>
<?php
endif;
?>
<div class="bgt"></div>
<div class="container">
	<div class="row text-center">
        <img src="<?php echo $config['banner_congreso']?>" style="width:100%; max-width: 600px">
    </div>
	<div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center">
        	<!--<a href='../opc/pdfs/programa.pdf' download="programa.pdf" target="_blank" style="color:red;">Descargar Programa en formato PDF</a><br>-->
            <h3>Bienvenido/a <?=$_SESSION["cliente"]["nombre"]." ".$_SESSION["cliente"]["apellido"]?>
            <?php /*if($_SESSION["admin"]){*/ ?>
            <br>
            <small>
            	<?php
				
				if (count($inscripto)>0){
					if($inscripto["estado"]){
						echo "<a href='acp/certificado_inscripto.php?t=".base64_encode($inscripto["id"])."' target='_blank' style='color:red'>descargue aquí su constancia de asistencia a FEPAL 2020</a><br>";
					}
				}
				?>
            </small>
            <?php //} ?>
            <br>
			<?php/* if(count($inscripto)>0 || (count($inscripto)>0 && $_SESSION["admin"])) {  */?>
            <!--<div style="font-size:12px"><a href="https://www.easyplanners.net/alas/inscriptos/ver_recibos.php?key=<?php echo base64_encode($inscripto["id"]);?>" target="blank" >Puede ver sus recibos ingresando aqu&iacute;</a></div> -->          
			<?php } ?>
            
            <!--<p>Esta cuenta le permite ingresar sus trabajos.<br>
			Posteriormente podrá ingresar para efectivizar el pago o<br>indicar a través de que medio fue realizado.</p>-->
        </div>
    </div>
    
    
    <?php
		if($_GET['ce']=='1')
			echo '<div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center"><div class="alert alert-danger">Debe completar todos los campos</div></div></div>';
		if($_GET['ce']=='file_ext')
			echo '<div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center"><div class="alert alert-danger">El comprobante no tiene un formato correcto</div></div></div>';
		if($_GET['ce']=='file_size')
			echo '<div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center"><div class="alert alert-danger">El comprobante excede el tama&ntilde;o permitido</div></div></div>';
		if($_GET['ce']=='file')
			echo '<div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center"><div class="alert alert-danger">Hubo un error al guardar el comprobante</div></div></div>';
		if($_GET['d']=='nc')
			echo '<div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center"><div class="alert alert-danger">El número de comprobante ya existe</div></div></div>';
		if($_GET['d']=='ne')
			echo '<div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center"><div class="alert alert-danger">El número de comprobante NO existe</div></div></div>';
		if($_GET['ce']=='f')
			echo '<div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center"><div class="alert alert-success">El comprobante se subió correctamente</div></div></div>';
		if($_GET['ai']=='1')
			echo '<div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center"><div class="alert alert-info">Usted ya tiene una inscripción.</div></div></div>';
		
		if($_GET['tc']=='1')
			echo '<div class="row">
		<div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center"><div class="alert alert-success">La solicitud de pago con tarjeta se ha efectuado correctamente.<br>Por favor aguarde la confirmación via email.</div></div></div>';
	?>
    
    <div id="div_default_opt" class="row">
        <div class="col-md-12  col-sm-offset-0 text-center">
            <!--<a class="btn btn-primary tglbtn" href="<?=$config["url_opc"]?>abstract/?type=1" target="_blank">Resumen de Ponencia</a>&nbsp;&nbsp;&nbsp;&nbsp;-->
            <!--<a class="btn btn-info tglbtn" id="btn_opt_panel" href="#">Postulación de Panel</a>&nbsp;&nbsp;&nbsp;&nbsp;-->
            <!--este<a class="btn btn-info tglbtn" href="<?=$config["url_opc"]?>abstract/?type=2" target="_blank">Postulación de Panel</a>&nbsp;&nbsp;&nbsp;&nbsp;-->
            <!--<a class="btn btn-warning tglbtn <?php if(count($inscripto)>0){echo "disabled";}?>" href="<?=$config["url_inscripcion"]?>" target="_blank">Formulario de Pago</a>-->
            <?php 
				if(count($inscripto)>0 AND in_array($inscripto['forma_pago'], array('2', '3'))){
			?>
           		<!--<a class="btn btn-danger tglbtn" href="javascript:void(0)" onClick="toggle(['#div_comprobante'],['.bgt','#div_comprobante'])">Subir comprobante</a>-->&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="row" id="div_comprobante" style="display:none">
                	<div class="col-md-6 col-sm-offset-3 text-left">
                    	<div class="loading"></div>
                        <?php

							if($datos['comprobante'] || $inscripto["comprobante_archivo"]){
								echo '<p style="color:red;margin-top:10px" align="center"><b>Usted ya tiene un comprobante, si carga otro reemplazar&aacute; el anterior.</b></p>';
							}
						?>
                    	<form action="actions/comprobante.php" method="post" enctype="multipart/form-data" onSubmit="return comprobante()">
                            <div class="col-md-12 col-sm-offset-0">
                                <label>N&deg; comprobante:</label>
                                <?php 
								if(!$datos["numero_comprobante"] && !$inscripto["grupo_numero_comprobante"]):
								?>
                                <input type="text" name="numero_comprobante" class="form-control">
                                <?php
								else:
									echo '<br><b>'.($inscripto["grupo_numero_comprobante"] ? $inscripto["grupo_numero_comprobante"]:$datos["numero_comprobante"]).'</b>';
								endif;
								?>
                            </div>
                            <div class="col-md-12 col-sm-offset-0"><br>
                                <label>Seleccione el comprobante</label>
                                <input type="file" name="comprobante_pago">
                            </div>
                            <div class="col-md-12 col-sm-offset-0 text-center"><br>
                                <input type="submit" value="Guardar" class="btn btn-primary">
                            </div>
                        </form>
                        <?php
						/*else{
						?>
                        	<div class="col-md-6 col-sm-offset-0 text-center"><br>
                       	    	<a href="#"><img src="visa.png" width="50%" alt="visa"></a>
                            </div>
                            <div class="col-md-6 col-sm-offset-0 text-center"><br>
                            	<a href="#"><img src="mastercard.png" width="40%" alt="mastercard"></a>
                            </div>
                        <?php
						}*/
						?>
                        <div style="padding:10px"><button type="button" onClick="toggle(['#div_comprobante', '.bgt'], '')" class="btn"><i class="glyphicon glyphicon-menu-left"></i></button></div>
                    </div>
                </div>
            <?php
				}
			?>
            <!--<div class="btn btn-warning tglbtn" style="width:400px; text-align:center;" align="center">Sistema de Inscripción On Line en Mantenimiento</div>-->
            <?php if(count($inscripto)==0) { ?>
            	<!--<a class="btn btn-warning tglbtn" href="http://alas2017.easyplanners.info/inscripcion/" target="_blank">Formulario de Inscripción</a>-->
            <?php /*
				  }else if(is_null($inscripto["numero_recibo"])){
					  $tarjeta_link = "https://www.easyplanners.net/alas/inscriptos/form_tarjeta.php?key=".md5($inscripto['id'].$inscripto['email']);*/
			?>
            		<!--<a class="btn btn-primary tglbtn" href="<?php echo $tarjeta_link; ?>" target="_blank">Realizar Pago</a>-->
            <?php }else if($inscripto["estado"] === '1'){ ?>
                  	<a class="btn btn-warning tglbtn" href="acp/membresia.php?c=<?=base64_encode($datos["id"])?>" target="_blank">Certificado de Membres&iacute;a</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<?php } ?>
            <!-- https://www.easyplanners.net/index.php?option=com_rsform&formId=126 -->
        </div>
    </div>
    
    <!--<div class="row">
    	<div class="alert alert-warning col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center">
        	En próximos días se habilitará nuevamente el ingreso de PANELES.
        </div>
    </div>-->
    <!--<div class="row">
   		<div class="alert alert-warning col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center">
        	Ingreso y edición de PANELES en mantenimiento.
        </div>
    </div>-->
    
    <div id="div_opt_panel" class="row collapse">
    	<div class="col-md-12  col-sm-offset-0 text-center">
        	<button id="btn_opt_panel_back" title="Volver" class="btn btn-default"><i class="glyphicon glyphicon-menu-left"></i></button>
        	<a href="<?=$config["url_opc"]?>abstract/?type=2" class="btn btn-success">Soy coordinador del panel</a>
            <button id="btn_opt_search_author" class="btn btn-primary">Soy panelista</button>
        </div>
    </div>
    
    <div id="div_search_autor" class="row collapse">
    	<div class="col-md-6 col-md-offset-3  col-sm-offset-0">
            <label>Busque al coordinador de su panel por el Apellido:</label>
            <div class="input-group">
              <span class="input-group-btn">
                <button id="btn_search_author_back" title="Volver" class="btn btn-default"><i class="glyphicon glyphicon-menu-left"></i></button>
              </span>
              <input type="text" class="form-control" name="search_authors">
              <span class="input-group-btn">
                <button class="btn btn-danger" id="btn_search_author" type="button">Buscar</button>
              </span>
            </div>        	
        </div>
        <div class="col-md-6 col-md-offset-3  col-sm-offset-0">
        	<div id="div_authors_result" style="max-height: 200px; overflow: auto;"></div>
        </div>
    </div>
    
    <div id="div_set_author_title" class="row collapse">
    	<div class="col-md-6 col-md-offset-3  col-sm-offset-0">
        	<form action="actions/setAuthorTitle" method="post" id="save_author_title">
            	<label>Ingrese el título de su tema que se integrará al Panel de <span id="holder_coor"></span></label>
                <div class="input-group">
                  <span class="input-group-btn">
                  	<button id="btn_set_author_back" title="Volver" class="btn btn-default"><i class="glyphicon glyphicon-menu-left"></i></button>
              	  </span>
                  <input type="text" class="form-control" name="author_title">
                  <span class="input-group-btn">
                    <button class="btn btn-danger" type="submit">Guardar</button>
                  </span>
                </div>
                <div id="author_title_status"></div>
                <input type="hidden" name="id_trabajo" value="">
                <input type="hidden" name="id_coordinador" value="">
            </form>
        </div>
    </div>
    <?php
		/*ob_start();
		include("../buscar_trabajos/asignar.php");
		$tl = ob_get_contents();
		ob_clean();
		ob_end_flush();*/
	?>
    <!--<div class="row" id="trabajos-favoritos">
    	<div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center">
        	<form action="../buscar_trabajos/guardar.php" method="post">
            <div class="panel panel-default">
              <div class="panel-heading">Escriba aquí sus trabajos preferidos para agregar a su agenda personal</div>
              <div class="panel-body">
                <?php
                    echo $tl;
                ?>
              </div>
              <div class="panel-footer" style="display:none"><input type="submit" value="Guardar" class="btn btn-default"></div>
            </div>
            <input type="hidden" name="redirect" value="<?php echo $_SERVER["PHP_SELF"] ?>">
            </form>
        </div>
    </div>-->
    
    <div class="row" align="center">
    	<div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-left" style="text-align:justify;">
        	<strong align="center">En caso de ser el contacto de una presentación en Grupos de Trabajo o Panel, podrá descargar su certificado aquí debajo.<br>
Tenga en cuenta que es requisito haberlo presentado y estar inscripto pago.<br>
Solamente podrán descargar los certificados los titulares de la cuenta con la que se cargó al sistema; en caso de ser co autor y no haber subido usted mismo, solicítelo al titular.</strong>
        </div>
    </div>
    
    <?php
	if(count($cuenta->getTrabajosByType())>0){
	?>
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-left">
        <strong>Tiene <?=count($cuenta->getTrabajosByType()).(count($cuenta->getTrabajosByType())>1?" trabajos":" trabajo")?></strong>
        <hr style="margin:5px">
        <?php
		$estado = "";
		foreach($cuenta->getTrabajosByType() as $trabajos){
			if($trabajos["estado"]==4 || $trabajos["estado"]==2){
				$estado = " <b style='color:green;font-size:16px'>Aceptado</b>";
				//$estado .= "<br>descargar";
			}
			if($trabajos["estado"]=="1")
				$estado = " <b style='color:red'>No aceptado</b>";
			
			echo "<div class='row'>";	
				if($estado){
					echo "<div class='col-xs-12 col-md-4 col-lg-2'>";
						echo $estado;
					echo "</div>";
				}
				echo "<div class='col-xs-12 col-md-8 col-lg-10'>";
					/*if ($_SESSION["admin"]) {*/
					if ($trabajos["archivo_tl"] != ""){
						/*echo "<a href='".$config["url_opc"]."tl/".$trabajos["archivo_tl"]."' target='_blank' style='color:green'>[Usted ya tiene una ponencia cargada]</a><br>";*/
						echo "<a href='".$config["url_opc"]."abstract/login.php?id=".base64_encode($trabajos["id_trabajo"])."&c=1' target='_blank' style='color:green'>[Usted ya tiene una ponencia cargada, clickeando puede reemplazarla]</a> ";
					}
					else if ($trabajos["estado"]==4 || $trabajos["estado"]==2){
						echo "<a href='".$config["url_opc"]."abstract/login.php?id=".base64_encode($trabajos["id_trabajo"])."&c=1' target='_blank' style='color:red'>[cargar ponencia completa]</a>";
					}
					/*}*/
					echo $trabajos["numero_tl"]." - ".$trabajos["titulo_tl"]."<br>";
					if($trabajos["estado"]==4 || $trabajos["estado"]==2)
						echo $cuenta->templateAutoresTL($trabajos, false, false);
					$estado = "";
					echo "<br>";
					if($trabajos["estado"]==4 || $trabajos["estado"]==2) {
						$crono_trabajo = $cuenta->getTrabajoCrono($trabajos["id_crono"]);			
						$dia = utf8_encode(strftime($config["time_format"], strtotime(substr($crono_trabajo["start_date"],0,10))));
						$hora_inicio = substr($crono_trabajo["start_date"],10,6);
						$hora_fin = substr($crono_trabajo["end_date"],10,6);
						$sala = $cuenta->getSalaID($crono_trabajo["section_id"]);
						$edificio = $cuenta->getEdificioID($crono_trabajo["id_edificio"]);
						
						//echo sprintf('%s | %s - %s | %s | Sala: %s', utf8_decode(ucfirst($dia)), $hora_inicio, $hora_fin, $edificio["nombre"], $sala["name"]);
					
					?>
                    <!--<a class="crono_link" href="<?php echo $config["url_opc"]?>index.php?page=buscarProgramaExtendido&key=<?php echo base64_encode($crono_trabajo['id_crono']) ?>" target="blank">[ver]</a>-->
                    
                    <?php
					}
				echo "</div>";
			echo "</div>";	
		}
		?>
        </div>
    </div>
    <?php
	}
	?>
    
    <?php
	if(count($cuenta->getTrabajosByType(2))>0){
		$estado = "";
	?><br>
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-left">
        <strong>Tiene <?=count($cuenta->getTrabajosByType(2)).(count($cuenta->getTrabajosByType(2))>1?" paneles":" panel")?></strong>
        <hr style="margin:5px">
        <?php
		foreach($cuenta->getTrabajosByType(2) as $trabajos){
			$estado = "";
			if($trabajos["estado"]==4 || $trabajos["estado"]==2){
				$estado = " <b style='color:green;font-size:16px'>Aceptado</b>";
				//$estado .= "<br>descargar";
			}
			if($trabajos["estado"]=="1")
				$estado = " <b style='color:red'>No aceptado</b>";

			echo "<div class='col-xs-12 col-md-4 col-lg-2'>";
				echo $estado;
			echo "</div>";
			
			echo "<div class='col-xs-12 col-md-8 col-lg-10'>";
					if($_SESSION["admin"]) {
						echo "<a href='".$config["url_opc"]."abstract/login.php?id=".base64_encode($trabajos["id_trabajo"])."' target='_blank'>[cargar ponencia completa]</a> ";
					}
					echo $trabajos["numero_tl"]." - ".$trabajos["titulo_tl"]."<br>";
					if($trabajos["estado"]==4 || $trabajos["estado"]==2){
						$crono_trabajo = $cuenta->getTrabajoCrono($trabajos["id_crono"]);			
						$dia = utf8_encode(strftime($config["time_format"], strtotime(substr($crono_trabajo["start_date"],0,10))));
						$hora_inicio = substr($crono_trabajo["start_date"],10,6);
						$hora_fin = substr($crono_trabajo["end_date"],10,6);
						$sala = $cuenta->getSalaID($crono_trabajo["section_id"]);
						$edificio = $cuenta->getEdificioID($crono_trabajo["id_edificio"]);
						
						
						echo "<div style='clear:both'></div>";
						echo $cuenta->templateAutoresTL($trabajos, false, false);
						echo "<div style='clear:both'></div>";
						//echo sprintf('%s | %s - %s | %s | Sala: %s', utf8_decode(ucfirst($dia)), $hora_inicio, $hora_fin, $edificio["nombre"], $sala["name"]);
					}
					$estado = "";
			echo "</div>";
		}
		?>
        </div>
    </div>
    <?php
	}
	?>
    
    <?php
	//$trabajos_inscripcion = $cuenta->getTrabajosInscripto($inscripto["id"]); // los de cuenta_autores
	if(count($inscripto)>0 && $trabajos_inscripcion["trabajos"]!=array() && $_SESSION["admin"]){
	?>
    <!--<div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-left">
        <strong>Tiene <?=$trabajos_inscripcion["cant"].($trabajos_inscripcion["cant"]>1?" trabajos asociados a su inscripci&oacute;n":" trabajo asociado a su inscripci&oacute;n")?></strong>
        <hr style="margin:5px">
       <?php
		/*foreach($trabajos_inscripcion["trabajos"] as $cada_trabajo) {
			echo "<strong>".$cada_trabajo["numero_tl"]."</strong> - ".$cada_trabajo["titulo_tl"]."<br>";
			if($cada_trabajo["estado"]==4 || $cada_trabajo["estado"]==2) {
				$crono_trabajo = $cuenta->getTrabajoCrono($cada_trabajo["id_crono"]);			
				$dia = strftime($config["time_format"], strtotime(substr($crono_trabajo["start_date"],0,10)));
				$hora_inicio = substr($crono_trabajo["start_date"],10,6);
				$hora_fin = substr($crono_trabajo["end_date"],10,6);
				$sala = $cuenta->getSalaID($crono_trabajo["section_id"]);
				$edificio = $cuenta->getEdificioID($crono_trabajo["id_edificio"]);
				
				//echo '<strong>'.sprintf('%s | %s - %s | %s | Sala: %s', ucfirst($dia), $hora_inicio, $hora_fin, $edificio["nombre"], $sala["name"]).'</strong>';
			}
		?>
			<a class="crono_link" href="<?php echo $config["url_opc"]?>index.php?page=buscarProgramaExtendido&key=<?php echo base64_encode($crono_trabajo['id_crono']) ?>" target="blank">[ver]</a>
			<br><br>
        <?php
		}
		*/?>
        </div>
    </div>-->
    <?php
	}
	?>
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center">
			<?=$_SESSION["cliente"]["email"]." - cuenta: ".$_SESSION["cliente"]["id_cliente"]?>
            <?php
            if(count($inscripto)>0 && $_SESSION["admin"]){
                echo ' - inscripción: '. str_pad($inscripto["id"], 4, 0, STR_PAD_LEFT);
                /*if($inscripto["grupo_numero_comprobante"]){
                    $quienPago = $cuenta->getCuentaById($inscripto["key_cuenta"]);
                    echo sprintf('<br>El pago de esta inscripción la realizó <b>%s %s</b>', $quienPago["nombre"], $quienPago["apellido"]);
                }*/
                echo "<br>";
                /*if()
                echo 'Estado del pago: ';*/
            }
			
            if (count($inscripto)>0) {
                echo "<br>";
                echo "Documento: ".$inscripto["numero_pasaporte"];
                echo "<br>";
            }
			
            if($_SESSION["cliente"]["ultimo_acceso"]){
            ?>
            <br>último acceso: <?php echo date("d/m/Y", strtotime($_SESSION["cliente"]["ultimo_acceso"])) ?>
            <?php } ?>
            
            <br><h3><small><a href="salir.php">salir</a></small></h3>
        </div>
	</div>
    <br>
    <!--<div class="row">
        <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-left">
        <strong>Recordatorio, ponencias que marqué como interesante<br><small>(se habilitará a partir de la Comunicación de aceptación de Resúmenes)</small></strong>
        <hr style="margin:5px">
        <?php
		/*$trabajos_interesa = $cuenta->getTrabajoInteresa($_SESSION['cliente']['id_cliente']);
		if(count($trabajos_interesa)==0)
			echo '<p>No seleccionó ninguna ponencia.</p>';
		foreach($trabajos_interesa as $interesa){
			echo "<div>";
				echo "<a href='".$config["url_opc"]."?page=buscarProgramaExtendido&key=".base64_encode($interesa["id_crono"])."' target='_blank'>[ver]</a> ";
				echo '[<a href="#" class="me-interesa" data-key="'.base64_encode($interesa["id_trabajo"]).'" data-del="1">eliminar</a>] ';
				echo $interesa["numero_tl"]." - ";
				$elipsis = "";
				if(strlen($interesa["titulo_tl"])>110)
					$elipsis = "...";
				$rem = array("<b>","</b>","<strong>","</strong>");
				$por = array("");
				echo substr(str_replace($rem, $por, $interesa["titulo_tl"]),0,110).$elipsis;
			echo "</div>";
		}*/
		?>
        </div>
    </div>-->
    <?php
	
	?>
</div>    
</body>
</html>
<script type="text/javascript" src="../opc/js/config.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="../buscar_trabajos/js/trabajo.js"></script>
<script type="text/javascript" src="js/cuenta.js"></script>
<script type="text/javascript" src="../opc/js/programaTL.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-89204362-1', 'auto');
  ga('send', 'pageview');

</script>