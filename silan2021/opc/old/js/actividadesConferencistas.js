var arrayActividades_Conferencistas = new Array(new Array(" ","",""));

function llenarActividades_Conferencistas(){			
	

	//borrro combo
	for(u=0; u<=cantTrab-1; u++){
		for(i=document.form1.elements['actConf_[]'][u].options.length-1; i>=0; i--){
			document.form1.elements['actConf_[]'][u].remove(i);
		}
	}
				
	//ordeno array
	arrayActividades_Conferencistas.sort();
		
	
	//lleno el combo (cual, texto, valor)
	for(u=0; u<=cantTrab-1; u++){
		
		for(i=0;i<arrayActividades_Conferencistas.length; i++){
			
			agregarItem(document.form1.elements["actConf_[]"][u], arrayActividades_Conferencistas[i][1], arrayActividades_Conferencistas[i][2]);
		
		}
		
	}
			
}
			
function llenarArrayActividades_Conferencistas(elemento,elemento1){
	alert(elemento);
	alert(elemento1);
	arrayActividades_Conferencistas.push(new Array(elemento.toUpperCase(), elemento, elemento1));
	
}

/*function tempSeleccion(){
	
	arraySeleccion = new Array();
	
	for(u=0; u<=cantTrab-1; u++){
	
		arrayActividades_Conferencistas.push(document.form1.elements['persona[]'][u].value)
	
	}

	
}


function seleccionarPersonas(cual, cualCombo){
	
	for(u=0; u<=cantTrab-1; u++){
		for(i=document.form1.elements['persona[]'][u].options.length-1; i>=0; i--){
		
			if(u!=cualCombo){
				if(arrayActividades_Conferencistas[u]==document.form1.elements['persona[]'][u][i].value){
						document.form1.elements['persona[]'][u][i].selected = true;
				}
			}else{
				if(cual==document.form1.elements['persona[]'][u][i].value){
						document.form1.elements['persona[]'][u][i].selected = true;
				}
			}
			
			
		}	
	}
}*/
//*****altas y modificaciones
//
//
//
  
 
//FIN ajax y buscador para personas en alta y medificacion  Congreso////////////////////////////////////////

