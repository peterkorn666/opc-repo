var arrayPersonas = new Array(new Array(" ","",""));
var arrayDias= new Array();

function agregarItem(cual_, txt, valor, param3){
	var oOption = document.createElement("OPTION");
	oOption.text = txt;
	oOption.value = valor;
	
	if(param3!=undefined){
		if(param3.substring(0,1) == "#"){
			oOption.style.background = param3;
		}else{
			oOption.style.background = "url('img/patrones/"+param3+"')";
		}
	}

	cual_.options.add(oOption);
	}


function ValidarGestion(){
	
  encontrados = new Array();
  var gestion = "";

	/*if(form1.sala.value=="" || form1.sala.value=="(Seleccione)" ){
		alert("Por Favor, seleccione una sala");
		form1.sala.focus();
		return;
	}*/
	
	if(form1.rubro.value=="" || form1.rubro.value=="(Seleccione)" ){
		alert("Por Favor, seleccione un rubro");
		form1.rubro.focus();
		return;
	}
	
	if(form1.staff.value=="" || form1.staff.value=="(Seleccione)" ){
		alert("Por Favor, seleccione un staff");
		form1.staff.focus();
		return;
	}
	
	 form1.submit();
}
//FIN ajax y buscador para personas en alta y medificacion  Congreso////////////////////////////////////////
function eliminar_gestion(cual){	
	var return_value = confirm("¿Esta seguro que desea eliminar los datos?");
	 if ( return_value == true ) {
		 document.location.href = "gestionGestionSala.php?id=" + cual;
	 }
		 
}

function llenarDias(cual){
	cual = "dia"+cual;
	document.getElementById(cual).checked=true;
}

function llenarSalas(cual){	
	cual = "sala"+cual;
	document.getElementById(cual).checked=true;	 
}

function llenarDias_combo(){			
	//borrro combo
	for(i=document.form_filtro.filtro_dia.options.length-1; i>=0; i--){
		document.form_filtro.filtro_dia.remove(i);
	}	
					
	//ordeno array
	//arrayDias.sort();
					
	//lleno el combo (cual, texto, valor)

	for(i=0;i<arrayDias.length; i++){
		if (i==0){
				agregarItem(document.form_filtro.filtro_dia, "(Todos)", "(Todos)")
		}
		agregarItem(document.form_filtro.filtro_dia, arrayDias[i][1], arrayDias[i][1]);
	}
					
}
			
function llenarArrayDias(elemento){
	arrayDias.push(new Array(elemento.toUpperCase(), elemento))
}

function filtrar(){
	document.form_filtro.submit();	
}





