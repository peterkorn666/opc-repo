var arrayPaises = new Array(new Array(" ",""));

function llenarPaises(){			
	
	//borrro combo
	for(i=document.form1.pais_.options.length-1; i>=0; i--){
		document.form1.pais_.remove(i);
	}	
					
	//ordeno array
	arrayPaises.sort();
					
	//lleno el combo (cual, texto, valor)
	for(i=0;i<arrayPaises.length; i++){
		agregarItem(document.form1.pais_, arrayPaises[i][1], arrayPaises[i][1]);
	}
					
}
			
function llenarArrayPaises(elemento){
	arrayPaises.push(new Array(elemento.toUpperCase(), elemento))
}

//

function seleccionarPaises(cual){
	for(i=document.form1.pais_.options.length-1; i>=0; i--){
		if(cual==document.form1.pais_[i].value){
			document.form1.pais_[i].selected = true;
		}
	}	
}

///ALTA
arrayPaisNuevo = new Array();

	function Validar(){
		
	for(i=0;i<arrayPaisNuevo.length; i++){
			
				if(form1.pais_.value == arrayPaisNuevo[i]){
					alert("Ya existe un Pais con igual valor.");
					form1.pais_.focus();
					return;
				}
				
		  }
	  if(form1.pais_.value==""){alert("Por Favor, Ingrese un nombre de País.");form1.pais_.focus();return;}
	  form1.submit();
	}
	function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar este País?");
		 if ( return_value == true ) {
			 document.location.href = "gestionPais.php?id=" + cual;
		 }
		 
	 }