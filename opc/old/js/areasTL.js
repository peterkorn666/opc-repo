var arrayAreas = new Array(new Array(" ",""));
var arrayAreasID = new Array(new Array(" ",""));

function llenarAreas(){			

	//borrro combo
	for(i=document.getElementById("area_").options.length-1; i>=0; i--){
		document.getElementById("area_").remove(i);
	}	
					
	//ordeno array
	/*arrayAreas.sort();
	arrayAreasID.sort();*/
					
	//lleno el combo (cual, texto, valor)
	guion = "";
	for(i=0;i<arrayAreas.length; i++){
		if(arrayAreas[i][1]!=""){
			guion = " - ";
		}
		agregarItem(document.getElementById("area_"), arrayAreasID[i][1]+guion+arrayAreas[i][1], arrayAreasID[i][1]);
		guion = "";
	}
					
}
			
function llenarArrayAreas(elemento){
	arrayAreas.push(new Array(elemento.toUpperCase(), elemento))
}

function llenarArrayAreasID(elemento){
	arrayAreasID.push(new Array(elemento.toUpperCase(), elemento))
}

function seleccionarAreas(cual){
	for(i=document.form1.area_.options.length-1; i>=0; i--){
		if(cual==document.form1.area_[i].value){
			document.form1.area_[i].selected = true;
		}
	}	
} 

function seleccionarPremio(cual){
	for(i=document.form1.quePremio.options.length-1; i>=0; i--){
		if(cual==document.form1.quePremio[i].value){
			document.form1.quePremio[i].selected = true;
		}
	}	
} 

////ALTA AREASTL
arrayAreasTL = new Array();

  function Validar(){
		
		  for(i=0;i<arrayAreasTL.length;i++){
			
				if(form1.area_.value == arrayAreasTL[i]){
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
			 document.location.href = "gestionAreaTL.php?id=" + cual;
		 }
		 
	 }