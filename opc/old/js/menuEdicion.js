function OcultarDiv(cual){
	document.getElementById(cual).style.display='none';
}

function MostrarDiv(cual){
	document.getElementById(cual).style.display='block';
/*	if(cual=="ventanaCrono"){
		aparecer(cual)
	}else{
		document.getElementById(cual).style.display='block';
	}
	
	if(cual=="ventanaCrono"){
		//setTimeout("OcultarDiv('ventanaCrono')",3000);	
		setTimeout("desaparecer('"+cual+"')",6000);	
		
	}*/
}
function MostrarDivCrono(){
		MostrarDiv('DivDiasCrono');
		activadoCrono = true;
		var IE = document.all?true:false;
		if (!IE) document.captureEvents(Event.MOUSEMOVE)
		document.onmouseover = getMouseXY;
		var tempX = 0;
		var tempY = 0;
		function getMouseXY(e) {
			if (IE) { //para IE
			tempX = event.clientX + document.body.scrollLeft;
			tempY = event.clientY + document.body.scrollTop;
			}
			else { //para netscape
			tempX = e.pageX;
			tempY = e.pageY;
			}
			if (tempX < 0){tempX = 0;}
			if (tempY < 0){tempY = 0;}
			
			/*document.Show.MouseY.value = tempY;*/
			if(activadoCrono == true){							
				document.getElementById('DivDiasCrono').style.left = tempX +  "px";
				document.getElementById('DivDiasCrono').style.top = tempY +  "px";
			}
			activadoCrono = false;
			return true;
		}
	document.onClick = getMouseXY;
		petision('menu_crono_ajax.php', 'DivDiasCrono', 'POST', '');
		setTimeout("OcultarDiv('DivDiasCrono')",6000);
}
var casillaAnterior = 0;
function MostrarConDelay(casilla, estado, usuario, queelimino, salagr){	
		if(casillaAnterior != casilla){
			setTimeout("MostrarDetalleCrono('"+ casilla +"', '"+ estado +"', '"+ usuario +"', '"+ queelimino +"',' "+ salagr +"')",600);
			casillaAnterior = casilla;
		}

}


function MostrarDetalleCrono(casilla, estado, usuario, queelimino, salagr, dia, sala){		
	MostrarDiv('ventanaCrono');	
	activado = true;
		var IE = document.all?true:false;
		if (!IE) document.captureEvents(Event.MOUSEMOVE)
		document.onclick = getMouseXY;
		var tempX = 0;
		var tempY = 0;
		function getMouseXY(e) {
			if (IE) { //para IE
			//tempX = event.clientX + document.body.scrollLeft;
			tempY = event.clientY + document.body.scrollTop;
			}
			else { //para netscape
			//tempX = e.pageX;
			tempY = e.pageY;
			}
			if (tempX < 0){tempX = 0;}
			if (tempY < 0){tempY = 0;}
			
			/*document.Show.MouseY.value = tempY;*/
			if(activado == true){
				cuantomas = -100;				
				//document.getElementById('ventanaCrono').style.left = tempX + cuantomas+ "px";
				document.getElementById('ventanaCrono').style.top = tempY + cuantomas+ "px";
			}
			activado = false;
			return true;
		}
	document.onClick = getMouseXY;
	petision('detalleCronoExtendido.php', 'DivContenidoCasilleroGlobo', 'POST', 'casillero='+casilla);
	//if(estado==1){		
		petision('detalleCronoEdicion.php', 'DivEdicionCasilleroglobo', 'POST', 'casillero='+casilla+"&status="+estado+"&tipoUsu="+usuario+"&eliminar="+queelimino+"&salagrupo="+salagr+"&dia="+dia+"&sala="+sala);
	//}

	
}
function eliminar_casillero(cual, deCrono, agrupada, idioma){

	if(agrupada == 0){
		
		var return_value = confirm("¿Esta seguro que desea eliminar este casillero?");
		activarCasillero = 0;
		if (return_value == true) {
			activarCasillero = 0;
			document.location.href = "eliminarCasilleroUnico.php?id_casillero=" + cual + "&crono=" + deCrono + "&idioma=" + idioma;
		}
		
	}else{
		var return_value = confirm("¿Esta sala esta agrupada con otras si elimina este casillero eliminara el grupo de salas. ¿Esta seguro que eliminara este grupo de casilleros?");
		activarCasillero = 0;
		if (return_value == true) {
			activarCasillero = 0;
			document.location.href = "eliminarCasilleroAgrupado.php?id_casillero=" + cual + "&crono=" + deCrono + "&idioma=" + idioma;
		}
		
	}
	
}

function modificar_casillero(cual,idioma){
	
	activarCasillero = 0;
	document.location.href = "altaCasillero.php?id_casillero=" + cual + "&idioma=" + idioma;
}

function desagrupar_salas(cual,deCrono, dia){
	
	var return_value = confirm("¿Esta seguro en desarmar este grupo de salas?");
	activarCasillero = 0;
	
	if (return_value == true) {
		
		activarCasillero = 0;
		document.location.href = "desagruparSalas.php?id_casillero=" + cual + "&crono=" + deCrono + "&dia_=" + dia;
	
	}
	
}