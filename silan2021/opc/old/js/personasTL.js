var arrayPersonas = new Array(new Array(" ","",""));

function llenarPersonas(){			
	

	//borrro combo
	for(u=0; u<=cantidadAutores-1; u++){
		for(i=document.form1.elements['persona[]'][u].options.length-1; i>=0; i--){
			document.form1.elements['persona[]'][u].remove(i);
		}
	}
				
	//ordeno array
	arrayPersonas.sort();
		
	
	//lleno el combo (cual, texto, valor)
	for(u=0; u<=cantidadAutores-1; u++){
		
		for(i=0;i<arrayPersonas.length; i++){
			
			agregarItem(document.form1.elements["persona[]"][u], arrayPersonas[i][1], arrayPersonas[i][2]);
		
		}
		
	}
			
}
			
function llenarArrayPersonas(elemento,elemento1){
	arrayPersonas.push(new Array(elemento.toUpperCase(), elemento, elemento1));
}

function tempSeleccion(){
	
	arraySeleccion = new Array();
	
	for(u=0; u<=cantidadAutores-1; u++){
	
		arraySeleccion.push(document.form1.elements['persona[]'][u].value)
	
	}

	
}


function seleccionarPersonas(cual, cualCombo){
	
	for(u=0; u<=cantidadAutores-1; u++){
		for(i=document.form1.elements['persona[]'][u].options.length-1; i>=0; i--){
		
			if(u!=cualCombo){
				if(arraySeleccion[u]==document.form1.elements['persona[]'][u][i].value){
						document.form1.elements['persona[]'][u][i].selected = true;
				}
			}else{
				if(cual==document.form1.elements['persona[]'][u][i].value){
						document.form1.elements['persona[]'][u][i].selected = true;
				}
			}
			
			
		}	
	}
}
//*****altas y modificaciones
//
//
//
  arrayApellidoExisten = new Array();
  arrayNombreExisten = new Array();

  
 
 
 function ValidarPersonaTL(){
	 
	   encontrados = new Array();
  var personas = "";
	 
		
	for(i=0;i<arrayApellidoExisten.length; i++)
		  {
			if(form1.apellidos_.value == arrayApellidoExisten[i])
			 	{
				encontrados.push(new Array(arrayApellidoExisten[i],arrayNombreExisten[i]));
				}
		   }
		   
	for(i=0;i<encontrados.length;i++)
	{
		personas += encontrados[i][1] + " " +  encontrados[i][0] + "\n";
	}
						
	if(encontrados.length>0)
	{			
		var return_value = confirm("Se han encontrado las siguientes coincidencias: \n\n" + personas + " \n\nSi la persona no esta en la lista o igual quiere agregarla presione Aceptar."); 								 					
	
		if (return_value == false) 
			{
				
			return; 
			}
	}
	personas="";
	
	 if(form1.nombre_.value==""){alert("Por Favor, Ingrese un nombre.");form1.nombre_.focus();return;}
	 if(form1.apellidos_.value==""){alert("Por Favor, Ingrese uno o más apellidos");form1.apellidos_.focus();return;}
	
	  form1.submit();
	}
	
	function eliminar_persona(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar esta persona?");
		 if ( return_value == true ) {
			 document.location.href = "eliminarPersona.php?id=" + cual;
		 }
		 
	 }
	 function eliminar_personaTL(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar esta persona?");
		 if ( return_value == true ) {
			 document.location.href = "eliminarPersonaTL.php?id=" + cual;
		 }
		 
	 }
	 
	function agregar(cual, medidas, param1){
		window.open(cual + "?sola=1&combo=" + param1,'','width=380,height='+medidas+',toolbar=no,directories=no,status=no,menubar=no,modal=yes');
	
	}
	
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
		
function unificarPersonas(){
	document.listado.formP.target = "_parent";
 	document.listado.formP.submit();
}

function pintar(cual, color){

	document.getElementById(cual).style.background=color;
	document.getElementById(cual).style.cursor="pointer";
}
function despintar(cual, color){
	document.getElementById(cual).style.background=color;
}

// ajax y buscador para personas en alta y medificacion de trabajos libres////////////////////////////////////////
function buscando_personas(cual, valor, en_campo, form_id){
	
	document.getElementById(form_id).style.color = "#000000";

	if(valor==""){
			document.getElementById(cual).style.display = "none";
			
		}else{
				document.getElementById(cual).style.display = "inline";
	}
	petision("buscarPersonas_ajax.php", cual, "POST", "str_persona=" + valor + "&en_campo="+en_campo)
}

function cargar_persona_buscada(en_campo_param, id_persona, valor_completo){

	if(id_persona !=0){
		document.getElementById("txt_persona_" + en_campo_param).style.display = "inline";

	}else{
		document.getElementById("txt_persona_" + en_campo_param).style.display = "none";
	}
	
	//alert(en_campo_param)
	//if(id_persona
		 
	document.form1.elements['persona[]'][en_campo_param].value = id_persona
	
	document.getElementById('txt_persona_'  + en_campo_param).innerHTML = valor_completo + " <font size='2' color='#ff0000'><a href=\"javascript:cargar_persona_buscada('" + en_campo_param + "', '', '')\"><img src='imagenes/quitar.png' width='10'></a></font>"
	
	document.form1.elements['persona_'+ en_campo_param].value = ""

	document.getElementById('persona'  + en_campo_param).style.display = "none";
	
}

function closePopup(estado){
	$("#state").fadeIn("slow");
	$("#state").html("");
	$("#state").removeClass();
	$("#iframeajax").attr("src","");
	$("#capa").fadeOut("slow");
	$("#boxajax").fadeOut("slow");
	$("#boxajax2").fadeOut("slow");
	
	if(estado==true){
		$("#state").html("Guardado correctamente.");
		$("#state").addClass("state_ok");
	}else if(estado==false){
		$("#state").html("Ha ocurrido un error.");
		$("#state").addClass("state_error");
	}
	
	$("#state").delay(10000).fadeOut("slow");
}

//FIN ajax y buscador para personas en alta y medificacion de trabajos libres////////////////////////////////////////
function abrir_cerrar_div(cual){

	if(document.getElementById(cual).style.display == "none"){
		
		document.getElementById(cual).style.display = "block";
		
	}else{
		
		document.getElementById(cual).style.display = "none";
	
	}
	
	return
}