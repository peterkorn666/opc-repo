
function verDatos(elDiv, idusuario){
	//
	//

	document.getElementById('div_ctp').style.display='none';
	document.getElementById('div_ctf').style.display='none';
	document.getElementById('div_escaner').style.display='none';
	document.getElementById('div_prueba_color').style.display='none';
	document.getElementById('div_otros').style.display='none';
	
	document.getElementById(elDiv).style.display='block';
	
 	peticion("arma_tabla_ajax.php", elDiv, "POST", "cual_muestro=" + elDiv + "&idusu=" + idusuario);	
	
}
function altaOT(cualID, cualTab, idusuario){

//window.location.href = "http://192.168.1.100/TypeWorks/pasarOrden/para_typeworks.php?id="+ cualID +"&tabla=" + cualTab;
//window.open("para_typeworks.php?id="+ cualID +"&tabla=" + cualTab + "&idUsuario=" + idusuario  );
//peticion("para_typeworks.php", "DivArmadoContenidos", "GET", "id="+ cualID +"&tabla=" + cualTab + "&idUsuario=" + idusuario);
document.location.href="../sistema/para_typeworks.php?id="+ cualID +"&tabla=" + cualTab + "&idUsuario=" + idusuario ;
//document.location.href="../sistema/preordenes_web.php";
}

function despintar(cual){
	document.getElementById(cual).style.background = "#ffffff"
}

function pintar(cual){
	document.getElementById(cual).style.background = "#ffffcc"
}

function ocultarDiv(cualDiv){
	document.getElementById(cualDiv).style.display = "none";
}
function mostrarDiv(cualDiv){
	document.getElementById(cualDiv).style.display = "inline";
}

function abrirArch(archivo){
	window.open(archivo)	
}