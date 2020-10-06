//--------------------------------------------------------------------
function comprebarHabilitado(){

	/*var altoTrabajo = document.getElementById("contedorTL").clientHeight;
	var altoScroll = document.getElementById("contedorTL").scrollHeight;
	
	if(altoScroll>altoTrabajo){
		if(vista!=1){
			document.form1.BTNaceptarEnviar.disabled = true;
			document.form1.BTNimprimirVistaPrevia.disabled = true;
		}
		document.getElementById("alertaMalTrabajo").style.display="block";
	}else{
		
		document.form1.BTNimprimirVistaPrevia.disabled = false;
		}*/
}
function VerCargando(){
	document.getElementById('bgEnabled').style.display='block';
	document.getElementById('ventanaDivs').style.display='block';	
}

function HabilitarAceptarVista(que, palabras){
	if((que == "")||(palabras > 350)){
		document.form1.BTNaceptarEnviar.disabled = true;
	}else{
		document.form1.BTNaceptarEnviar.disabled = false;
	}
}
function HabilitarBtnAceptar(que){
	if(que == ""){
		document.form1.BTNaceptarEnviar.disabled = true;
	}else{
		document.form1.BTNaceptarEnviar.disabled = false;
	}
}

//--------------------------------------------------------------------
function aceptarEnviar(){
	
	alert("enviar");
	/*document.getElementById("bgEnabled").style.display = "block";
	document.form1.action= "enviar.php";
	document.form1.submit();*/
	
}
//--------------------------------------------------------------------
function volverIndex(){	
	document.location.href = "index.php";	
}

//--------------------------------------------------------------------
function imprimirPrevia(){

	window.open('imprimirPrevia.php','','menubar=yes, width=375,height=480,scrollbars=yes,status=yes');

}
//
function cerraDiv(cual){
	document.getElementById(cual).style.display = "none";
	document.getElementById('cargando').style.display='block'
	document.form1.action = "cargando.htm";
	document.form1.submit();

}
function finalizar(){
	document.location.href="fin.php"
}
