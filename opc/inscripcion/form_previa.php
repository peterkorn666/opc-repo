<?php
//unset($_SESSION["inscripcion"]);
$html = '';
	
	if($end){
		$html .='
		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center">
				<h2><span stlye="color: red;">'.$lang->set["TXT_DESPEDIDA"].'</span></h2>
			</div>
		</div><br>';
	}/*else{
		$html .='
		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0" style="text-align: center; font-size: 14px; color: red;">
				'.$lang->set["TXT_NOTA_ENCABEZADO"].'
			</div>
		</div>';
	}*/
/*
<div class="row">
	<div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
		<label>'.$lang->set["TXT_SOLAPERO"].'</label>
		'.$inscripcion->renderInput("solapero").'
	</div>
</div>
*/
$html .='
	<div class="row" align="center">
        <div class="col-md-6 col-md-offset-3 col-lg-offset-3 col-sm-offset-3">
        	<label>'.$lang->set["TXT_NUMERO_DOCUMENTO"].'</label>
            <br><b>'.$_SESSION["inscripcion"]["numero_pasaporte"].'</b>
        </div>
    </div>

	<div class="row">
        <div class="col-md-3 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
			<label>'.$lang->set["TXT_NOMBRE"].'</label>
			'.$inscripcion->renderInput("nombre").'
        </div>
		<div class="col-md-3 col-md-offset-0 col-lg-offset-0  col-sm-offset-0">
			<label>'.$lang->set["TXT_APELLIDO"].'</label>
			'.$inscripcion->renderInput("apellido").'
        </div>
    </div>
    
   
    
    <div class="row">
    	<div class="col-md-3 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
        	<label>'.$lang->set["TXT_INSTITUCION"].'</label>
            '.$inscripcion->renderInput("institucion").'
        </div>		
        
        <div class="col-md-3 col-md-offset-0 col-lg-offset-0  col-sm-offset-0">
			<label>'.$lang->set["TXT_PROFESION"].'</label>
            '.$inscripcion->renderInput("profesion").'
		</div>
    </div>
	
	<div class="row">
    	<div class="col-md-3 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
        	<label>'.$lang->set["TXT_CIUDAD"].'</label>
            '.$inscripcion->renderInput("ciudad").'
        </div>
		<div class="col-md-3 col-md-offset-0 col-lg-offset-0  col-sm-offset-0">
			<label>'.$lang->set["TXT_PAIS"].'</label>
            '.$inscripcion->renderInput("pais","select", $inscripcion->getPaises()).'
        </div>
        
    </div>
    
    <div class="row">
		<div class="col-md-3 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
        	<label>'.$lang->set["TXT_TELEFONO"].'</label>
            '.$inscripcion->renderInput("telefono").'
        </div>
        
        <div class="col-md-3 col-md-offset-0 col-lg-offset-0  col-sm-offset-0">
        	<label>'.$lang->set["TXT_EMAIL"].'</label>
            '.$inscripcion->renderInput("email").'
        </div>
    </div>';
	if(!isset($vista) && !isset($end)){
		if($_SESSION["inscripcion"]["trabajos_asociado_pasaporte"] != ''){
			$_SESSION["inscripcion"]["trabajos_asociado_pasaporte"] = "Esta es su participación en el congreso:<br>". $_SESSION["inscripcion"]["trabajos_asociado_pasaporte"];
		}
		$html .='
		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-right" style="color: red; font-size: 12px;">'.$lang->set["TXT_OBLIGATORIO"].'</div>
		</div><br>
		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-lg-offset-3 col-sm-offset-0">
				
				'.$_SESSION["inscripcion"]["trabajos_asociado_pasaporte"].'
			</div>
		</div><br>';
	}
	/*if(empty($end)){
		ob_start();
		include("../asignar_trabajos/asignar.php");
		$tl = ob_get_contents();
		ob_clean();
		ob_end_flush();
		$html .= $tl;
	}*/