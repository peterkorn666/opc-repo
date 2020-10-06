var arrayTematicas = new Array(new Array(" ",""));

function llenarTematicasTL(){			
	
	//borrro combo
	for(i=document.form1.tematica_.options.length-1; i>=0; i--){
		document.form1.tematica_.remove(i);
	}	
					
	//ordeno array
	arrayTematicas.sort();
					
	//lleno el combo (cual, texto, valor)
	for(i=0;i<arrayTematicas.length; i++){
		agregarItem(document.form1.tematica_, arrayTematicas[i][1], arrayTematicas[i][1]);
	}
					
}
			
function llenarArrayTematicasTL(elemento){
	arrayTematicas.push(new Array(elemento.toUpperCase(), elemento))
}

function seleccionarTematicasTL(cual){
	for(i=document.form1.tematica_.options.length-1; i>=0; i--){
		if(cual==document.form1.tematica_[i].value){
			document.form1.tematica_[i].selected = true;
		}
	}
}
///alta
arrayTematicaTLNuevo = new Array();

 function Validar(){
	 
	 for(i=0;i<arrayTematicaTLNuevo.length; i++){
			
				if(form1.tematica_.value == arrayTematicaTLNuevo[i]){
					alert("Ya existe una Tematica con igual valor.");
					form1.tematica_.focus();
					return;
				}
				
		  }
	  if(form1.tematica_.value==""){
		  alert("Por Favor, Ingrese una temática.");
		  form1.tematica_.focus();return;
	  }
	  form1.submit();
	}
	
	function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar esta temática?");
		
		 if ( return_value == true ) {
			 document.location.href = "eliminarTematicaTL.php?id=" + cual;
		 }
		 
	 }
