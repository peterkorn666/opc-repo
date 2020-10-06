var arrayTipoTL = new Array(new Array(" ",""));

function llenarTipoTL(){			
	
	//borrro combo
	for(i=document.form1.tipo_de_TL.options.length-1; i>=0; i--){
		document.form1.tipo_de_TL.remove(i);
	}	
					
	//ordeno array
	 arrayTipoTL.sort();
					
	//lleno el combo (cual, texto, valor)
	for(i=0;i<arrayTipoTL.length; i++){
		agregarItem(document.form1.tipo_de_TL, arrayTipoTL[i][1], arrayTipoTL[i][1]);
	}
					
}
			
function llenarArrayTipoTL(elemento){
	arrayTipoTL.push(new Array(elemento.toUpperCase(), elemento))
}

function seleccionarTipoTL(cual){
	for(i=document.form1.tipo_de_TL.options.length-1; i>=0; i--){
		if(cual==document.form1.tipo_de_TL[i].value){
			document.form1.tipo_de_TL[i].selected = true;
		}
	}	
}
////alta

arrayTipoTLNuevo = new Array();

 function Validar(){
	 
	 for(i=0;i<arrayTipoTLNuevo.length ; i++){
			
				if(form1.tipo_.value == arrayTipoTLNuevo[i]){
					alert("Ya existe un Tipo de Trabajo Libre con igua valor.");
					form1.tipo_.focus();
					return;
				}
				
		  }
	  if(form1.tipo_.value==""){alert("Por Favor, Ingrese una tipo de trabajo libre.");form1.tipo_.focus();return;}
	  form1.submit();
	}
	
	function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar esta tipo de trabajo libre?");
		
		 if ( return_value == true ) {
			 document.location.href = "eliminarTipoTL.php?id=" + cual;
		 }
		 
	 }