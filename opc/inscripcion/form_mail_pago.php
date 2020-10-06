<?php
$html ='
<div align="center"><img src="'.$lang->set["TXT_BANNER_CONGRESO"].'" style="width:100%; max-width:440px"></div><br><br>
<table width="580" border="0" cellspacing="5" cellpadding="1" align="center">
	<tr>
		<td colspan="2">Inscripcion '.$_SESSION["inscripcion"]["id_inscripto"].'</td>
	</tr>
	<tr>
		<td>'.$_SESSION['inscripcion']['nombre'].' '.$_SESSION['inscripcion']['apellido'].'</td>
	</tr>
</table>
<br>';
		
/*$html .= '<div style="width:580px; margin:auto">';
$html .= "El recibo se realizará a nombre de: <br><b>".$_SESSION["inscripcion"]["nombre_recibo"]."</b><br><br>";
$html .= '</div><br>';*/
if($_SESSION["inscripcion"]["tipo_inscripcion"] == '2')
	$costos_inscripcion = $inscripcion->renderInput("costos_inscripcion","radio", $lang->set["COSTOS_INSCRIPCION_JORNADA_PADRES"]["array"]);
else
	$costos_inscripcion = $inscripcion->renderInput("costos_inscripcion","radio", $lang->set["COSTOS_INSCRIPCION"]["array"]);
	
$html .= '
<br>
    
    <div style="margin:auto; width:580px">
        	<table bgcolor="#EAF5FD" width="580" cellpadding="5" cellspacing="0">
                <thead>
                  <tr>
                    <th align="left">'.$lang->set["TXT_INSCRIPCION"].'</th>
                  </tr>
                </thead>
            	<tbody> 
                <tr>
                	<td bgcolor="#FFFFFF">'.$costos_inscripcion.'</td>
                </tr> 
                </tbody>
          </table>
    </div><br>
    
    <div style="width:580px; margin:0 auto">';
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
				if($table[0]=="OPCIONES_DE_PAGO")
				{
					$table[0] = "Forma de Pago";
					$html_pago = "";
					$table[1] = $inscripcion->renderInput("forma_pago","radio", $lang->set["FORMA_PAGO"]["array"]);
					
					if($_SESSION["inscripcion"]["grupo_check_comprobante"]=="1"){
						$table[1] .= '<br>El pago la realizó mi institución u otra persona a mi nombre<br>
								<br>Número de comprobante: &nbsp;
									<strong>'.$_SESSION["inscripcion"]["grupo_numero_comprobante"].'</strong>
								<br>Lo realizó:
									<strong>'.$_SESSION["inscripcion"]["nombre_inscripto_pagador"].'</strong>
							';
					}
					$html .= '<table bgcolor="'.$bgtitle.'" width="580" cellspacing="0" cellpadding="5">';
						$html .=  '<tr>';
							$html .=  '<th class="marco" '.$colortitle.'>'.$table[0]."</th>";
						$html .=  '</tr>';
						$html .=  '<tr>';
							$html .=  '<td align="left" valign="top" bgcolor="#FFFFFF">'.$table[1].'</td>';
						$html .=  '</tr>';
					$html .=  '</table><br>';
				}
            }
			
$html .="	
<span style='color:white'>".$_SESSION["inscripcion"]["id_inscripto"]."</span>		
    </div>";
	
if($_SESSION["inscripcion"]["id_inscripto"]==0)
	$html .= "<br><br>".$_SESSION["inscripcion"]["browser"];
/*else
	$html .= "<br><br> <span style='color:white'>".$_SESSION["inscripcion"]["id_inscripto"]."</span>";*/