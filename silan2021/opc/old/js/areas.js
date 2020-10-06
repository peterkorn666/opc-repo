var arrayAreas = new Array(new Array(" ",""));

function llenarAreas(){			

	//borrro combo
	for(i=document.form1.area_.options.length-1; i>=0; i--){
		document.form1.area_.remove(i);
	}	
					
	//ordeno array
	arrayAreas.sort();
					
	//lleno el combo (cual, texto, valor)
	for(i=0;i<arrayAreas.length; i++){
		agregarItem(document.form1.area_, arrayAreas[i][1], arrayAreas[i][1]);
	}
					
}
			
function llenarArrayAreas(elemento){
	arrayAreas.push(new Array(elemento.toUpperCase(), elemento))
}

function seleccionarAreas(cual){
	for(i=document.form1.area_.options.length-1; i>=0; i--){
		if(cual==document.form1.area_[i].value){
			document.form1.area_[i].selected = true;
		}
	}	
}

//*** Altas

  arrayAreasNuevo = new Array();

  function Validar(){
		
		  for(i=0;i<arrayAreasNuevo.length; i++){
			
				if(form1.area_.value == arrayAreasNuevo[i]){
					alert("Ya existe un area con igua valor.");
					form1.area_.focus();
					return;
				}
				
		  }
		
	if(form1.area_.value==""){
		 alert("Por Favor, Ingrese una area.");
		 form1.area_.focus();
		 return;
	 }
	 
	  form1.submit();
	  
  }
	
	function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar esta area?");
		
		 if ( return_value == true ) {
			 document.location.href = "gestionArea.php?id=" + cual;
		 }
		 
	 }
	 
function updateArea(area){
	var selects = document.getElementById('area_');
	
	var opt = document.createElement('option');
	opt.value = area;
	opt.innerHTML = area;
	selects.appendChild(opt);
}	 