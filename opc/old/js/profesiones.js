var arrayProfesiones = new Array(new Array(" ",""));

function llenarProfesiones(){			
	//borrro combo
	for(i=document.form1.profesion_.options.length-1; i>=0; i--){
		document.form1.profesion_.remove(i);
	}	
					
	//ordeno array
	arrayProfesiones.sort();

	//lleno el combo (cual, texto, valor)
	for(i=0;i<arrayProfesiones.length; i++){
		agregarItem(document.form1.profesion_, arrayProfesiones[i][1], arrayProfesiones[i][1]);
	}
					
}
			
function llenarArrayProfesiones(elemento){
	
	arrayProfesiones.push(new Array(elemento.substring(0,1).toUpperCase(), elemento))
}
//
function seleccionarProfesiones (cual){
	
	for(i=document.form1.profesion_.options.length-1; i>=0; i--){
		if(cual==document.form1.profesion_[i].value){
			document.form1.profesion_[i].selected = true;
		}
	}	
	
}

///ALTA
arrayProfesionNuevo = new Array();
 function Validar(){
	 
	 for(i=0;i<arrayProfesionNuevo.length; i++){
			
				if(form1.profesion_.value == arrayProfesionNuevo[i]){
					alert("Ya existe una Profesión con igual valor.");
					form1.profesion_.focus();
					return;
				}
				
		  }
	  if(form1.profesion_.value==""){alert("Por Favor, Ingrese una profesión.");form1.profesion_.focus();return;}
	  form1.submit();
	}
	
	function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar esta profesión?");
		
		 if ( return_value == true ) {
			 document.location.href = "gestionProfesion.php?id=" + cual;
		 }
		 
	 }