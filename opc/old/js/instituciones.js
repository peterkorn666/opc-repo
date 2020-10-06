var arrayInstituciones = new Array(new Array(" ",""));

function llenarInstituciones(){			
	
	//borrro combo
	for(i=document.form1.institucion_.options.length-1; i>=0; i--){
		document.form1.institucion_.remove(i);
	}	
					
	//ordeno array
	arrayInstituciones.sort();
					
	//lleno el combo (cual, texto, valor)
	for(i=0;i<arrayInstituciones.length; i++){
		agregarItem(document.form1.institucion_, arrayInstituciones[i][1], arrayInstituciones[i][1]);
	}
					
}
//		
function llenarArrayInstituciones(elemento){
	arrayInstituciones.push(new Array(elemento.toUpperCase(), elemento))
}
//
function seleccionarInstituciones(cual){
	for(i=document.form1.institucion_.options.length-1; i>=0; i--){
		//alert(cual);
		if(cual==document.form1.institucion_[i].value){
			document.form1.institucion_[i].selected = true;
		}
	}	
}

////ALTA

arrayInstitucionNuevo = new Array();
   function Validar(){
	   
	   for(i=0;i<arrayInstitucionNuevo.length; i++){
			
				if(form1.institucion_.value == arrayInstitucionNuevo[i]){
					alert("Ya existe una Institución con igual valor.");
					form1.institucion_.focus();
					return;
				}
				
		  }
	  if(form1.institucion_.value==""){alert("Por Favor, Ingrese una institución.");form1.institucion_.focus();return;}
	  form1.submit();
	}
	
	function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar esta institución?");
		
		 if ( return_value == true ) {
			 document.location.href = "gestionInstitucion.php?id=" + cual;
		 }
		 
	 }
	