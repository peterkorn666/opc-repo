var arrayCargos = new Array(new Array(" ",""));

function llenarCargos(){			
	
	//borrro combo
	for(i=document.form1.cargo_.options.length-1; i>=0; i--){
		document.form1.cargo_.remove(i);
	}	
					
	//ordeno array
	arrayCargos.sort();
					
	//lleno el combo (cual, texto, valor)
	for(i=0;i<arrayCargos.length; i++){
		agregarItem(document.form1.cargo_, arrayCargos[i][1], arrayCargos[i][1]);
	}
					
}
			
function llenarArrayCargos(elemento){
	
	arrayCargos.push(new Array(elemento.toUpperCase(), elemento))
}

function seleccionarCargos (cual){
	for(i=document.form1.cargo_.options.length-1; i>=0; i--){
		if(cual==document.form1.cargo_[i].value){
			document.form1.cargo_[i].selected = true;
		}
	}	
}

///ALTA
arrayCargoNuevo = new Array();
  
    function Validar(){
		for(i=0;i<arrayCargoNuevo.length; i++){
			
				if(form1.cargo_.value == arrayCargoNuevo[i]){
					alert("Ya existe un Cargo con igual valor.");
					form1.cargo_.focus();
					return;
				}
				
		  }
	  if(form1.cargo_.value==""){alert("Por Favor, Ingrese un Cargo.");form1.cargo_.focus();return;}
	  form1.submit();
	}
	
	function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar este cargo?");
		
		 if ( return_value == true ) {
			 document.location.href = "gestionCargo.php?id=" + cual;
		 }
		 
	 }