var arrayRubros= new Array();

function seleccionarRubros(cual){
	for(i=document.form1.elements["rubro_[]"].options.length-1; i>=0; i--){
		if(cual==document.form1.elements["rubro_[]"][i].value){
			document.form1.elements["rubro_[]"][i].selected = true;
		}
	}	
}

function llenarRubros(){			
	
	//borrro combo
	for(i=document.form1.rubro.options.length-1; i>=0; i--){
		document.form1.rubro.remove(i);
	}	
					
	//ordeno array
	arrayRubros.sort();
					
	//lleno el combo (cual, texto, valor)

	for(i=0;i<arrayRubros.length; i++){
		if (i==0){
				agregarItem(document.form1.rubro, "(Seleccione)", "(Seleccione)")
		}
		agregarItem(document.form1.rubro, arrayRubros[i][1], arrayRubros[i][1]);
	}
					
}
			
function llenarArrayRubros(elemento){
	arrayRubros.push(new Array(elemento.toUpperCase(), elemento))
}
/////ALTA Rubro
  arrayRubroNuevo = new Array();
  arrayRubroOrdenNuevo = new Array();
  
function Validar(){
	for(i=0;i<arrayRubroNuevo.length; i++){
			
				if(form1.rubro_.value == arrayRubroNuevo[i]){
					alert("Ya existe un Rubro con igual valor.");
					form1.rubro_.focus();
					return;
				}
				
		  }		
	
	  if(form1.rubro_.value==""){alert("Por Favor, Ingrese un nombre de Rubro.");form1.rubro_.focus();return;}
	
	form1.submit();
	}
	function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar este rubro?");
		 if ( return_value == true ) {
			 document.location.href = "gestionRubro.php?id=" + cual;
		 }
		 
	 }