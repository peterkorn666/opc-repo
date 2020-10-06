<?php
//unset($_SESSION["inscripcion"]);
if(isset($_SESSION["inscripcion"]["pago"])) {
	$html = '';
	
	if($end){
		$html .='
		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center">
				<h2><span stlye="color: red;">'.$lang->set["TXT_DESPEDIDA"].'</span></h2>
				<a href="../cuenta/cuenta.php">Volver a la cuenta</a>
			</div>
		</div><br>';
	}
}
$html .='
    <div class="row">
    	<div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
        	<table class="table">
                <thead>
					<tr>
						<th align="left" class="marco">'.$lang->set["TXT_INSCRIPCION"].'</th>
						<th align="right" id="txt_valor_conferencia_top">&nbsp;</th>
					</tr>
                </thead>
            	<tbody> 
					<tr><td>'.$lang->set["TXT_FECHA_INSCRIPCION"].'</td></tr>';
			
			$html .= '<tr>';
				$html .= '<td>';
						if(!isset($vista) && !isset($end)){
							$html .= '<div class="desmarcar"><a class="desmarcar" data-nombre="costos_inscripcion" href="">Desmarcar selección</a></div>';
							foreach($precios as $precio){
								$chk = "";
								if($precio["id"] === $_SESSION["inscripcion"]["costos_inscripcion"])
									$chk = "checked";
								if($inscripcion->esBeca($precio["id"])){
									$data = 1;
								}else $data = 0;
								$html .= '<input type="radio" name="costos_inscripcion" '.$chk.' value='.$precio["id"].' data-beca='.$data.'> '.$precio["nombre"].' $u '.$precio["precio"].'<br>';
							}
						}else if($_SESSION["inscripcion"]["costos_inscripcion"]!==NULL){
							$opcion_precio = $inscripcion->getOpcionPrecioByID($_SESSION["inscripcion"]["costos_inscripcion"]);
							$html .= '<b>'.$opcion_precio['nombre'].' $u '.$opcion_precio['precio'].'</b><br>';
						}
						//$inscripcion->renderInput("costos_inscripcion","radio", $lang->set["COSTOS_INSCRIPCION"]["array"]).'
							$tiene_codigo = false;
							$html .= '<br>
								<div id="div_codigo">';
							if(!($vista || $end)){
								$html .='Escriba su código a continuación: ';
								$tiene_codigo = true;
							}else{
								if($inscripcion->esBeca($_SESSION["inscripcion"]["costos_inscripcion"])){
									$html .='Código: ';
									$tiene_codigo = true;
								}
								
							}
							if($tiene_codigo){
								$html .= 
										$inscripcion->renderInput("codigo").'<br>
										<div id="div_codigo_status"></div>
										<div class="clear">&nbsp;</div>
									</div>
									<input type="hidden" name="key_codigo" value="'.$_SESSION["inscripcion"]["key_codigo"].'">';
							}
						
			$html .= '</td>
					</tr> 
				</tbody>
			</table>
        </div>
    </div><br>
    
    <div class="row">
    	<div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">';
            foreach($lang->set["NOTICIAS"]["array"] as $key => $noticia)
            {
                $table = explode("=>",$noticia);
				$bgtitle = "#EAF5FD";
				$colortitle = "";
				if($table[2]=="importante")
				{
					$bgtitle = "#CC0000";
					$colortitle = "style='color:white'";
				}
				$cond_opciones_pago = ($table[0]=="OPCIONES_DE_PAGO");
				if($table[0]=="OPCIONES_DE_PAGO")
				{
					$table[0] = "Forma de Pago";
					$html_pago = "";
					$table[1] = '<div class="div_forma_pago">';
						if(!isset($vista) && !isset($end)){
							foreach($formas_pago as $forma_pago){
								$chk = "";
								if($forma_pago["id"] === $_SESSION["inscripcion"]["forma_pago"])
									$chk = 'checked';
								if($inscripcion->esFormaPagoConComprobante($forma_pago["id"])){
									$data_comprobante = 1;
								}else $data_comprobante = 0;
								$table[1] .= '<input type="radio" name="forma_pago" '.$chk.' value='.$forma_pago["id"].' data-comprobante='.$data_comprobante.'> <b>'.$forma_pago["nombre"].'</b><br>';
								$table[1] .= $forma_pago["descripcion"].'<br><br>';
							}
							$table[1] .= '<br>'.$lang->set["TXT_ENVIAR_MAIL"];
						}else{
							$opcion_forma_pago = $inscripcion->getOpcionFormaPagoByID($_SESSION["inscripcion"]["forma_pago"]);
							$table[1] .= '<b>'.$opcion_forma_pago['nombre'].'</b><br>';
							if($opcion_forma_pago["descripcion"] != NULL){
								$table[1] .= $opcion_forma_pago['descripcion'].'<br>';
							}
						}
						$table[1] .= '<div id="numero_comprobante">';
							if(!isset($vista) && !isset($end)){
								$table[1] .= '<br>Escriba el número de comprobante en el campo a continuación:<br>';
								$table[1] .= '<input type="text" name="numero_comprobante" class="form-control" value="'.$_SESSION["inscripcion"]["numero_comprobante"].'"><br>';
							}else if ($inscripcion->esFormaPagoConComprobante($_SESSION["inscripcion"]["forma_pago"])){
								if ($_SESSION["inscripcion"]["numero_comprobante"]){
									$table[1] .= '<br>Comprobante: ';
									$table[1] .= '<b>'.$_SESSION["inscripcion"]["numero_comprobante"].'</b>';
								}
							}
						$table[1] .= '</div>';
						/*$table[1] .= '						
						<br><br>';*/
					$table[1] .= '</div>'; //end div forma pago
					$html .= '<div class="div_forma_pago">';
					
					if(!$inscripcion->esBeca($_SESSION["inscripcion"]["costos_inscripcion"])){
						$html .= '<table bgcolor="'.$bgtitle.'" class="table">';
							$html .=  '<tr>';
								$html .=  '<th class="marco" '.$colortitle.'>'.$table[0]."</th>";
							$html .=  '</tr>';
							$html .=  '<tr>';
								$html .=  '<td align="left" valign="top" bgcolor="#FFFFFF">'.$table[1].'</td>';
							$html .=  '</tr>';
						$html .=  '</table>';
					}
					if($cond_opciones_pago)
						$html .= '</div>';
				}
				//if(!$end || ($end && !$cond_opciones_pago)){
				
            }
$html .='			
        </div>
    </div>';