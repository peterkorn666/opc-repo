var arrayPersonas = new Array(new Array(" ","",""));

function llenarPersonas(){			
	

	//borrro combo
	for(u=0; u<=cantTrab-1; u++){
		for(i=document.form1.elements['persona[]'][u].options.length-1; i>=0; i--){
			document.form1.elements['persona[]'][u].remove(i);
		}
	}
				
	//ordeno array
	arrayPersonas.sort();
		
	
	//lleno el combo (cual, texto, valor)
	for(u=0; u<=cantTrab-1; u++){
		
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
	
	for(u=0; u<=cantTrab-1; u++){
	
		arraySeleccion.push(document.form1.elements['persona[]'][u].value)
	
	}

	
}


function seleccionarPersonas(cual, cualCombo){
	
	for(u=0; u<=cantTrab-1; u++){
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
  

  
 
 
 function ValidarPersona(){
	
  encontrados = new Array();
  var personas = "";
  
	for(i=0;i<arrayApellidoExisten.length; i++)
		  {
			if(form1.apellidos_.value == arrayApellidoExisten[i])
			 	{
				encontrados.push(new Array(arrayApellidoExisten[i],arrayNombreExisten[i]));
				}
		   }
		   
	for(i=0;i<encontrados.length;i++){
		personas += encontrados[i][1] + " " +  encontrados[i][0] + "\n";
	}
	
						
	if(encontrados.length>0){
		
		var return_value = confirm("Se han encontrado las siguientes coincidencias: \n\n" + personas + " \n\nSi la persona no esta en la lista o igual quiere agregarla presione Aceptar."); 								 					
	
		if (return_value == false){
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
	
		window.open(cual + "?sola=1&combo=" + param1 , '','width=380,height=' + medidas + ',toolbar=no,directories=no,status=no,menubar=no,modal=yes');
	
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
		
function abrir_cerrar_div(cual){

	if(document.getElementById(cual).style.display == "none"){
		
		document.getElementById(cual).style.display = "block";
		//document.getElementById(cual).innerHTML = "";
		
	}else{
		
		document.getElementById(cual).style.display = "none";
	
	}
	
	return
}

function pintar(cual, color){

	document.getElementById(cual).style.background=color;
	document.getElementById(cual).style.cursor="pointer";
}
function despintar(cual, color){
	document.getElementById(cual).style.background=color;
}
// ajax y buscador para personas en alta y medificacion de Congreso////////////////////////////////////////
function buscando_personasCongreso(cual, valor, en_campo, form_id){
	
//	document.getElementById(form_id).style.color = "#000000";

	if(valor==""){
		$("#"+cual).css("display","none");	
	}else{
		$("#"+cual).css("display","");
	}
	petision("buscarPersonasCongreso_ajax.php", cual, "POST", "str_persona=" + valor + "&en_campo="+en_campo)
}

function cargar_persona_buscadaCongreso(en_campo_param, id_persona, valor_completo){
	
	if(id_persona !=0){
		document.getElementById("txt_persona_" + en_campo_param).style.display = "inline";
		$("#txt_buscar_persona_"+en_campo_param).css("visibility","hidden");
		$("#txt_agregar_persona_"+en_campo_param).css("visibility","hidden");

	}else{
		document.getElementById("txt_persona_" + en_campo_param).style.display = "none";
		$("#txt_buscar_persona_"+en_campo_param).css("visibility","visible");
		$("#txt_agregar_persona_"+en_campo_param).css("visibility","visible");
	}
	
	//alert(id_persona)
	//if(id_persona

	$('#id_persona_'+en_campo_param).val(id_persona);
	
	
	document.getElementById('txt_persona_'  + en_campo_param).innerHTML = valor_completo + " <font style=' font-size:10px' color='#ff0000'><a href=\"javascript:cargar_persona_buscadaCongreso('" + en_campo_param + "', '', '');HabilitarCampo('" + en_campo_param + "')\">[cambiar]</a></font>";
	
	document.form1.elements['persona_'+ en_campo_param].value = "";
	document.getElementById('persona_'  + en_campo_param).style.display = "none";
	document.getElementById('persona'  + en_campo_param).style.display = "none";
	
	
}

function HabilitarCampo(cual){
	document.getElementById('persona_'  + cual).style.display = "block";
}
//FIN ajax y buscador para personas en alta y medificacion  Congreso////////////////////////////////////////

