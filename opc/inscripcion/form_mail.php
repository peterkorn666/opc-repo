<?php
$html ='
<div align="center"><img src="'.$lang->set["TXT_BANNER_CONGRESO"].'" style="width:100%; max-width:440px"></div><br><br>
<table width="580" border="0" cellspacing="5" cellpadding="1" align="center">
  <tr>
  	<td colspan="2">Inscripcion '.$_SESSION["inscripcion"]["id_inscripto"].'</td>
  </tr>
  <tr>
  	<td colspan="2">'.
		$lang->set["TXT_NUMERO_DOCUMENTO"].'
            <strong>'.$inscripcion->renderInput("numero_pasaporte").'</strong></td>
  </tr>
  <tr>
  	<td>'.$lang->set["TXT_NOMBRE"].'
            <strong>'.$inscripcion->renderInput("nombre").'</strong></td>
    <td>'.$lang->set["TXT_APELLIDO"].'<br>
            <strong>'.str_replace("<br>","", $inscripcion->renderInput("apellido")).'</strong></td>
  </tr>
  <tr>
    <td>'.$lang->set["TXT_INSTITUCION"].'
            <strong>'.$inscripcion->renderInput("institucion").'</strong></td>
	<td>'.$lang->set["TXT_PROFESION"].'<br>
            <strong>'.str_replace("<br>","", $inscripcion->renderInput("profesion")).'</strong></td>
  </tr>
  <tr>
    <td>'.$lang->set["TXT_CIUDAD"].'
            <strong>'.$inscripcion->renderInput("ciudad").'</strong></td>
	<td>'.$lang->set["TXT_PAIS"].'
            <strong>'.$inscripcion->renderInput("pais","select", $inscripcion->getPaises()).'</strong></td>
  </tr>
  <tr>
    <td>'.$lang->set["TXT_TELEFONO"].'
            <strong>'.$inscripcion->renderInput("telefono").'</strong></td>
	<td>'.$lang->set["TXT_EMAIL"].'
		<strong>'.$inscripcion->renderInput("email").'</strong></td>
  </tr>
</table>
<br><br>';
		if ($_SESSION["inscripcion"]["trabajos_asociado_pasaporte"]){
			$html .= '<div style="width:600px; margin:0 auto">';
				$html .= $_SESSION["inscripcion"]["trabajos_asociado_pasaporte"];
			$html .= '</div><br><br>';
		}

		/*if(count($_SESSION["inscripcion"]["input_selected_autor"])>0){
			$html .= '<div style="width:600px; margin:0 auto">';
			foreach($_SESSION["inscripcion"]["input_selected_autor"] as $id_autor){
				$trabajo = $db->query("SELECT l.ID_participante, l.ID_trabajos_libres, t.id_trabajo, t.numero_tl, t.titulo_tl, p.ID_Personas, p.Nombre, p.Apellidos FROM trabajos_libres_participantes as l JOIN trabajos_libres as t ON t.id_trabajo=l.ID_trabajos_libres JOIN personas_trabajos_libres as p ON p.ID_Personas=l.ID_participante WHERE l.ID_participante = ?", [$id_autor])->first();
				
				$html .= $trabajo["numero_tl"].' '.$trabajo["titulo_tl"]."<br>";
				if ($trabajo["Apellidos2"] != '')
					$html .= "<b>".$trabajo["Nombre"]." ".$trabajo["Apellidos"]." ".$trabajo["Apellidos2"]."</b><br><br>";
				else
					$html .= "<b>".$trabajo["Nombre"]." ".$trabajo["Apellidos"]."</b><br><br>";
		
			}
            $html .= '</div><br>';
		}*/
		
/*$html .= '<div style="width:600px; margin:0 auto">';
$html .= "El recibo se realizará a nombre de: <br><b>".$_SESSION["inscripcion"]["nombre_recibo"]."</b><br><br>";
$html .= '</div><br>';*/

if($_SESSION["inscripcion"]["costos_inscripcion"] !== NULL){
	$costo_inscripcion = $inscripcion->getOpcionPrecioByID($_SESSION["inscripcion"]["costos_inscripcion"]);
	$costo_inscripcion_precio = '<b>'.$costo_inscripcion['nombre'].' $u '.$costo_inscripcion['precio'].'</b><br>';
}

$html .= '
<br><br>
    
    <div style="margin:auto; width:580px">
        	<table bgcolor="#EAF5FD" width="580" cellpadding="5" cellspacing="0">
                <thead>
                  <tr>
                    <th align="left">'.$lang->set["TXT_INSCRIPCION"].'</th>
                  </tr>
                </thead>
            	<tbody> 
                <tr>
                	<td bgcolor="#FFFFFF">'.$costo_inscripcion_precio.'</td>
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
					if($_SESSION["inscripcion"]["forma_pago"] != NULL){
						$forma_pago = $inscripcion->getOpcionFormaPagoByID($_SESSION["inscripcion"]["forma_pago"]);
						$table[1] = '<b>'.$forma_pago["nombre"].'</b><br>';
						if($forma_pago["descripcion"] != NULL){
							$table[1] .= $forma_pago['descripcion'].'<br>';
						}
					}
					/*if($_SESSION["inscripcion"]["grupo_check_comprobante"]=="1"){
						$table[1] .= '<br>El pago la realizó mi institución u otra persona a mi nombre<br>
								<br>Número de comprobante: &nbsp;
									<strong>'.$_SESSION["inscripcion"]["grupo_numero_comprobante"].'</strong>
								<br>Lo realizó:
									<strong>'.$_SESSION["inscripcion"]["nombre_inscripto_pagador"].'</strong>
							';
					}else {
						if($_SESSION["inscripcion"]["numero_comprobante"])
							$table[1] .= '<br> <b>Número de comprobante: '.$_SESSION["inscripcion"]["numero_comprobante"].'</b><br><br>';	
					}*/
					if($_SESSION["inscripcion"]["forma_pago"] != NULL){
						if($inscripcion->esFormaPagoConComprobante($_SESSION["inscripcion"]["forma_pago"])){
							if($_SESSION["inscripcion"]["numero_comprobante"]){
								$table[1] .= '<br> <b>Número de comprobante: '.
									$_SESSION["inscripcion"]["numero_comprobante"].'</b><br><br>';
							}
						}
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