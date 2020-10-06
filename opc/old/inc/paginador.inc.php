<?
if ($total_paginas > 1){ 
echo "Paginas: ";
    for ($i=1;$i<=$total_paginas;$i++){ 
		if ($pagina == $i) {
			echo "<span style='color:#039'>".$pagina . " </span>"; 
		}else{
			echo " <a href='estadoTL.php?estado=". $estado ."&ubicado=". $ubicado ."&area=". $area ."&tipo=". $tipo . "&clave=". $Pclave ."&inscr=".$inscr."&premio=".$premio."&quePremio=&idioma=&eliminado=0&adjunto=".$adjunto."&pagina=" . $i ."' class='paginas'>&nbsp;" . $i . "&nbsp;</a> ";
		}
	}	
} 
?>