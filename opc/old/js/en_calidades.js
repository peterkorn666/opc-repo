var ArrayEnCalidades = new Array(new Array(" "));
var ArrayEnCalidadesNuevo = new Array();

function llenarEnCalidades(){			
	

	//borrro combo
	for(u=0; u<=cantTrab-1; u++){
		for(i=document.form1.elements['en_calidad[]'][u].options.length-1; i>=0; i--){
			document.form1.elements['en_calidad[]'][u].remove(i);
		}
	}
				
	//ordeno array
	ArrayEnCalidades.sort();
		
	
	//lleno el combo (cual, texto, valor)
	for(u=0; u<=cantTrab-1; u++){
		
		for(i=0;i<ArrayEnCalidades.length; i++){
			
			agregarItem(document.form1.elements["en_calidad[]"][u], ArrayEnCalidades[i][1], ArrayEnCalidades[i][1]);
		
		}
		
	}
			
}
			
function llenarArrayEnCalidades(elemento){
	ArrayEnCalidades.push(new Array(elemento.toUpperCase(), elemento));
}

function llenarArrayEnCalidadesNuevo(elemento){
	ArrayEnCalidadesNuevo.push(new Array(elemento));
}



function tempSeleccionCalidades(){
	
	arraySeleccionCalidad = new Array();
	
	for(u=0; u<=cantTrab-1; u++){
	
		arraySeleccionCalidad.push(document.form1.elements['en_calidad[]'][u].value)
	
	}

	
}


function seleccionarEnCalidades(cual, cualCombo){
	
	for(u=0; u<=cantTrab-1; u++){
		for(i=document.form1.elements['en_calidad[]'][u].options.length-1; i>=0; i--){
		
			if(u!=cualCombo){
				if(arraySeleccionCalidad[u]==document.form1.elements['en_calidad[]'][u][i].value){
						document.form1.elements['en_calidad[]'][u][i].selected = true;
				}
			}else{
				if(cual==document.form1.elements['en_calidad[]'][u][i].value){
						document.form1.elements['en_calidad[]'][u][i].selected = true;
				}
			}
			
			
		}	
	}
}


///alta
arrayCalidadNuevo = new Array();
   function Validar(){
	   for(i=0;i<arrayCalidadNuevo.length; i++){
			
				if(form1.calidad_.value == arrayCalidadNuevo[i]){
					alert("Ya existe una Calidad con igual valor.");
					form1.calidad_.focus();
					return;
				}
				
		  }
	  if(form1.calidad_.value==""){alert("Por Favor, Ingrese una calidad.");form1.calidad_.focus();return;}
	  form1.submit();
	}
	
	function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar esta calidad?");
		
		 if ( return_value == true ) {
			 document.location.href = "gestionCalidad.php?id=" + cual;
		 }
		 
	 }
	 
function updateEnCalidad(calidad,cual){
	/*var selects = $('.en_calidad');
	selects.append("<option value='"+calidad+"'>"+calidad+"</option>");*/
	
	var selects = $('.en_calidad');
	selects.append($("<option>").attr("value",calidad).text(calidad));
	$(".en_calidad:eq("+cual+")").val(calidad);

}		 