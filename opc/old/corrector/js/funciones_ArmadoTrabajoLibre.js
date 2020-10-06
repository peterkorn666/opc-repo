//--------------------------------------------------------------------
function abrirAutores(){
cargarIframeAutores()
document.getElementById('cargaAutores').style.display='inline';
document.getElementById('elementosAutores').style.display='none';
document.getElementById('ventanaAutores').style.display='inline';
}
function cerrarVentanaAutores(){
document.getElementById('ventanaAutores').style.display='none';
}


//--------------------------------------------------------------------
function Cerrar(){
	document.getElementById('previa').style.display='none';
}
//--------------------------------------------------------------------
var Inetr;
function vistaPrevia(){
	document.getElementById('previa').style.display='inline';
	document.getElementById('previa').style.top = 140;
	
	document.form0.target= "marcoPrevia";
	document.form0.action = "vistaPrevia.php?vista=1";
	document.form0.submit();
	

	Inetr = setInterval(moverDiv,5);

	pos=-400
	document.getElementById('previa').style.left = pos
}

function moverDiv(){
	if (pos<=200){
		pos=pos +20;
		
		document.getElementById('previa').style.left = pos
	}else{
		clearInterval(Inetr)
		}
}
//--------------------------------------------------------------------
function cargarDivAutores(cual){
		
	document.getElementById('divAutores').innerHTML=cual
	
	if(cual!="<br><i></i>"){
		
		autorRegistrado = true;
		
	}
	
}
//--------------------------------------------------------------------
function guardadoAutomatico(){

	document.getElementById('Guardando').style.visibility='visible';
	document.form0.target= "guardar";
	document.form0.action = "inc.guardar.php";
	document.form0.submit();
	
}
//setInterval(guardadoAutomatico, 120000);
//--------------------------------------------------------------------
function vistaPrelimiar(){
	
	if (document.form0.emailContacto.value == "") {
		alert("Ingrese un mail para el contacto. Gracias");
		document.form0.emailContacto.focus();
		return;
	}
	if (document.form0.ApellidoContacto.value == "") {
		alert("Ingrese un apellido para el contacto. Gracias");
		document.form0.ApellidoContacto.focus();
		return;
	}
	/*
	if (document.form0.InstContacto.value == "") {
		alert("Ingrese una institucion para el contacto. Gracias");
		document.form0.InstContacto.focus();
		return;
	}
	if (document.form0.ciudadContacto.value == "") {
		alert("Please, write a City for the contact");
		document.form0.ciudadContacto.focus();
		return;
	}*/
	if (document.form0.NombreContacto.value == "") {
		alert("Ingrese un nombre para el contacto. Gracias");
		document.form0.NombreContacto.focus();
		return;
	}
	if (document.form0.paisContacto.value == "") {
		alert("Ingrese un país para el contacto. Gracias");
		document.form0.paisContacto.focus();
		return;
	}
	

	if (document.form0.emailContacto.value.indexOf('@', 0) == -1 || document.form0.emailContacto.value.indexOf('.', 0) == -1) {
		alert("Ingrese un mail válido para el contacto. Gracias");
		document.form0.emailContacto.focus();
		return;
	}
	if (document.form0.emailContacto2.value == "") {
		alert("Reingrese su mail para el contacto. Gracias");
		document.form0.emailContacto2.focus();
		return;
	}
	if (document.form0.emailContacto2.value.indexOf('@', 0) == -1 || document.form0.emailContacto2.value.indexOf('.', 0) == -1) {
		alert("Ingrese un mail válido para el contacto. Gracias");
		document.form0.emailContacto2.focus();
		return;
	}
	if(document.form0.emailContacto.value != document.form0.emailContacto2.value){
	alert("No coinciden los mails.");
	document.form0.emailContacto.focus();
	return;
	}
	if (document.form0.tipoTL.value == "Seleccione") {
		alert("Seleccione un tipo de presentacion para el trabajo. Gracias");
		document.form0.tipoTL.focus();
		return;
	}
	if (document.form0.idiomaTL.value == "Seleccione") {
		alert("Seleccione un idioma para el trabajo. Gracias");
		document.form0.idiomaTL.focus();
		return;
	}
	
	if(autorRegistrado == false){
		alert("Ingrese los participantes / autores.");
		return; 
	}
	
	if (document.form0.tema.value == "Seleccione un eje temático") {
		alert("Seleccione un tema para el trabajo. Gracias");
		document.form0.tema.focus();
		return;
	}
	/*if (document.form0.tema.value == "Otro") {
		if(document.form0.OtroTema.value==""){
			alert("Ingrese un tema para el trabajo. Gracias");
			document.form0.OtroTema.focus();
			return;
		}
	}*/
	
	
	document.form0.target= "_self";
	document.form0.action = "vistaPrevia.php";
	document.form0.submit();
	
}

function mostrarDiv(cual){
	document.getElementById(cual).style.display = "block";
}
function ocultarDiv(cual){
	document.getElementById(cual).style.display = "none";
}

//--------------------------------------------------------------------
function carrarRecomendaciones(){
	document.getElementById('Recomendaciones').style.visibility='hidden';
	document.getElementById('total').style.visibility='hidden';
}
function abrirRecomendaciones(){
	document.getElementById('Recomendaciones').style.visibility='visible';
	document.getElementById('total').style.visibility='visible';
}
//--------------------------------------------------------------------

function cargarIframeAutores(){
	
	//document.getElementById('iframeAutores').src = "autores.php";
	frames['iframeAutores'].location.href = "autores.php";
	}
	
	
function HabilitarAceptar(){
	if(document.form0.chkAcepto.checked == true){
		document.form0.btnAceptarYverificar.disabled = false;
	}else{
		document.form0.btnAceptarYverificar.disabled = true;
	}
}