function ampliar(idTL){
	window.open("resumenAmpliado.php?idTL=" + idTL ,"","scrollbars=yes,width=600,height=300");
}

function bajarTL(cual){
	document.location.href= "bajando_tl.php?id=" + cual;
}
function bajarPosterTL(cual){
	document.location.href= "bajando_tl_poster.php?id=" + cual;
}

function bajarOralTL(tema,cual){
	document.location.href= "bajando_tl_oral.php?id=" + cual+"&tema="+tema;
}
function bajarPremio(cual){
	document.location.href= "poster_tl/"+cual;
}

function cargarLee(){


	for(u=0; u<cantidadAutores; u++){	
		
			if(document.form1.elements['lee_[]'][u].checked == true){
				document.form1.elements['lee[]'][u].value = "1";
			}else{
				document.form1.elements['lee[]'][u].value = "0";
			}
			
	}
}

function SinHoras(){
if(form1.chkSinHora.checked == true)
	{	
	form1.hora_inicio_.disabled = true;
	form1.hora_fin_.disabled = true;
	}
else{	
	form1.hora_inicio_.disabled = false;
	form1.hora_fin_.disabled = false;
	}
}


function validar(){
	//cargarLee();
	H_inicio = document.form1.hora_inicio_.value.replace(":","")
	H_inicio = H_inicio.replace(":","")
	
	H_fin = document.form1.hora_fin_.value.replace(":","")
	H_fin = H_fin.replace(":","")


if(document.form1.chkSinHora.checked==false){
	if(H_fin < H_inicio){ 
		alert("La hora inicio no puede ser mayor a la hora de fin");
		return;
	}else if (H_fin == H_inicio){
		alert("La hora inicio no puede igual a la hora de fin");
		return;
	}
	
}

	
	
	document.form1.submit();
}


function eliminar(cual, param2){
 		
		var return_value = confirm("�Esta seguro que desea eliminar el/los trabajo/s libre/s seleccionado/s?");
		
		
		if (return_value == true) {
			 document.location.href = "eliminarTL.php?id=" + cual + "&estado=" + param2 ;
		}
		 
}

function eliminarVarios(est){
	 document.form1.action = "eliminarTL.php?estado=" + est
	 document.form1.submit();
}

function mover(){
	
	 document.form1.action = "moverTL.php";
	 document.form1.submit();

}
function ubicar(){
	
	 document.form1.action = "ubicarTL.php";
	 document.form1.submit();

}
function envioMailsFiltrados(){
	
	 document.form1.action = "envioMail_trabajosLibres.php";
	 document.form1.submit();

}

function asignarArea(pag){
	
	 document.form1.action = "asignarAreaTL.php?pag=" + pag;
	 document.form1.submit();

}

function asignarTipo(pag){

	 document.form1.action = "asignarTipoTL.php?pag=" + pag;
	 document.form1.submit();

}

function modificar(cual){
	//document.location.href="altaTrabajosLibres.php?id=" + cual
	document.location.href="../abstract/login.php?key=" + cual
}


function filtrar(param0,  param1,  param2,  param3, param4, param5,param6,param7,param8,param9,param10,param11,param12, para13, para14){

	document.form1.action = "?estado="+param0+"&ubicado=" + param1 + "&area=" + param2 + "&tipo=" + param3 + "&clave=" + param4 + "&inscr=" + param5 + "&premio=" + param6 + "&quePremio=" + param7+"&idioma="+param8+"&adjunto="+param9+"&adjunto_poster="+param10+"&adjunto_oral="+param11+"&eliminado="+param12+"&dropbox="+para13+"&filtroCongreso="+para14;
	document.form1.submit();
	
}
function getRadioButtonSelectedValue(ctrl)
{
    for(i=0;i<ctrl.length;i++)
        if(ctrl[i].checked) return ctrl[i].value;
}


function abrirFiltro(){
	
	/*if(document.getElementById('divFiltro').style.display=="none"){*/
		document.getElementById('divFiltro').style.display='inline';
		document.getElementById('divTitFiltro').className='borde_1_Iz_Der_arriba';
		/*
	}else{
		document.getElementById('divFiltro').style.display='none';
		document.getElementById('divTitFiltro').className='none';
	}
	*/
}

function masInfoTL(cual, boton){
	
	if(document.getElementById(cual).style.display=="none"){
		document.getElementById(cual).style.display='inline';	
		document.getElementById(boton).innerHTML = '[ocultar resumen]'
	}else{
		document.getElementById(cual).style.display='none';
		document.getElementById(boton).innerHTML = '[ver resumen]'
	}
	
}


var CuantosTL = 0;

function marcar(que){
	
	for(i=0; i<CuantosTL; i++){
		document.form1.elements["tl[]"][i].checked=que;
	}
	
}

function seleccionarCasillero(cual){
	for(i=document.form1.ID_casillero.options.length-1; i>=0; i--){
		if(cual==document.form1.ID_casillero[i].value){
			document.form1.ID_casillero[i].selected = true;
		}
	}	
}
function noAprobado(cual){
	if(cual==1){
	alert("Este trabajo esta UBICADO en el programa,\npero todavia no esta APROBADO.");
	}
	else if(cual==2){
	alert("Este trabajo esta APROBADO \npero todavia no esta UBICADO en el programa.");
	}
}

function mostrarDiv(cual) {
	document.getElementById(cual).style.display='block';
}
function ocultarDiv(cual) {
	document.getElementById(cual).style.display='none';
	/*document.form1.quePremio.value = '(Seleccione)';*/
}



