// JavaScript Document
var ArrayEnCalidades = new Array(new Array(" ",""));
var arrayTipo_de_actividades = new Array(new Array(" ","", ""));
var arrayPaises = new Array(new Array(" ",""));
var arrayAreas = new Array(new Array(" ",""));

//Funciones Generales
function marcar(que){	
	var elemntCasilla = document.form1.elements["ID_Casilla[]"];
	//alert(elemntCasilla)
	for(i=0; i<elemntCasilla.length; i++){
		elemntCasilla[i].checked=que;
	}
	
}
function agregarItem(cual,txt){	
	var oOption = document.createElement("OPTION");
	oOption.text = txt;
	oOption.value = txt;
	cual.options.add(oOption);
}

//***CALIDADES****///
function llenarArrayEnCalidades(elemento){
	ArrayEnCalidades.push(new Array(elemento.toUpperCase(), elemento));
}
function CargarCalidades(){
	//ordeno array
	ArrayEnCalidades.sort();	
	
	for(i=0;i<ArrayEnCalidades.length; i++){			
			agregarItem(document.form1.elements["calidad_[]"], ArrayEnCalidades[i][1], ArrayEnCalidades[i][1]);
		
		}

}
//***CALIDADES****///
//***ACTIVIDADES****///
function llenarArrayTipo_de_actividades(elemento, estilo){
	arrayTipo_de_actividades.push(new Array(elemento.toUpperCase(), elemento, estilo))
}
function CargarTiposActividades(){
	//ordeno array
	arrayTipo_de_actividades.sort();	
	
	for(i=0;i<arrayTipo_de_actividades.length; i++){
		agregarItem(document.form1.elements["tipo_de_actividad_[]"], arrayTipo_de_actividades[i][1], arrayTipo_de_actividades[i][1],arrayTipo_de_actividades[i][2]);
	}
}
//***ACTIVIDADES****///
//***PAISES****///
function llenarArrayPaises(elemento){
	arrayPaises.push(new Array(elemento.toUpperCase(), elemento));
}
function CargarPaises(){
	//ordeno array
	arrayPaises.sort();
	
	for(i=0;i<arrayPaises.length; i++){
			agregarItem(document.form1.elements["pais_[]"], arrayPaises[i][1], arrayPaises[i][1]);		
	}	
}
//***PAISES****///
//*AREAS*/
function llenarArrayAreas(elemento){
	arrayAreas.push(new Array(elemento.toUpperCase(), elemento))
}
function CargarAreas(){
	//ordeno array
	arrayAreas.sort();
	
	for(i=0;i<arrayAreas.length; i++){
			agregarItem(document.form1.elements["area_[]"], arrayAreas[i][0], arrayAreas[i][0]);
	}	
}
/**AREAS**/

function BuscarEn(){
	if(document.form1.chkAmbos.checked){		
		document.form1.elements["rbBuscarEn"][0].disabled="disabled";
		document.form1.elements["rbBuscarEn"][1].disabled="disabled";		
	}else{
		document.form1.elements["rbBuscarEn"][0].disabled="";
		document.form1.elements["rbBuscarEn"][1].disabled="";		
	}
}
//**LLENO ARRAYS PARA LA BUSQUEDA*/
function EnDondeBusco(){
	if(document.form1.chkAmbos.checked){		
		return "Ambos";		
	}else{
		if(document.form1.elements["rbBuscarEn"][0].checked){
			return "Participantes";
		}
		if(document.form1.elements["rbBuscarEn"][1].checked){
			return "Titulos";
		}	
	}
}

function MostrarRes(){
	if(document.form1.elements["rbMostrar"][0].checked){
		return "Individual";
	}
	if(document.form1.elements["rbMostrar"][1].checked){
		return "Completo";
	}	
}
function ACalidadesSel(){
	var arrayCalidadesSeleccionadas = new Array();
	var elementoCalidad = document.form1.elements["calidad_[]"];	
	for(i=0;i<elementoCalidad.length; i++){
		if(elementoCalidad[i].selected){
				arrayCalidadesSeleccionadas.push(elementoCalidad[i].value);
		}
	}
	return arrayCalidadesSeleccionadas;
}

function AActividadesSel(){
	var arrayActividadesSeleccionadas = new Array();
	for(i=0;i<document.form1.elements["tipo_de_actividad_[]"].length; i++){
		if(document.form1.elements["tipo_de_actividad_[]"][i].selected){		
				arrayActividadesSeleccionadas.push(document.form1.elements["tipo_de_actividad_[]"][i].value);
		}
	}
	return arrayActividadesSeleccionadas;
}
function APaisSel(){
	var arrayPaisSeleccionadas = new Array();
	for(i=0;i<document.form1.elements["pais_[]"].length; i++){
		if(document.form1.elements["pais_[]"][i].selected){		
				arrayPaisSeleccionadas.push(document.form1.elements["pais_[]"][i].value);
		}
	}
	return arrayPaisSeleccionadas;
}

function AAreasSel(){
	var arrayAreasSeleccionadas = new Array();
	for(i=0;i<document.form1.elements["area_[]"].length; i++){
		if(document.form1.elements["area_[]"][i].selected){		
				arrayAreasSeleccionadas.push(document.form1.elements["area_[]"][i].value);
		}
	}
	return arrayAreasSeleccionadas;
}

/////////
function ValidarBusqueda(palabra, dondeBusco, comoMuestro, calidades, actividades, paises, areas){
	
	if((palabra=='')&&(calidades=='')&&(actividades=='')&&(paises=='')&&(areas=='')&&(areas==' ')){
		alert("No ha ingresado ningun criterio para la búsqueda.");
		document.form1.txtPalabra.focus();
		return;
	}else{
		document.getElementById('DivResultadosMarcar').style.display = "block";
		petision('buscar_avanzada_ajax.php', 'DivResultadoBA', 'POST', '&palabra='+palabra+'&dondeBusco='+dondeBusco+'&comoMuestro='+comoMuestro+'&calidades='+calidades+'&actividades='+actividades+'&paises='+paises+'&areas='+areas);
	}
}

function envioCasillerosFiltrados(){
	/* alert("Función deshabilitada");*/
	 
	 document.form1.action = "envioMail_Casillero.php";
	 document.form1.submit();

}