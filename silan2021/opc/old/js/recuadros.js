function Validar(){
	
	  if(form1.hora_.value==""){alert("Por Favor, Ingrese un numero para la hora.");form1.hora_.focus();return;}
	  if(form1.min_.value==""){alert("Por Favor, Ingrese un numero para los minutos");form1.min_.focus();return;}
	
	form1.submit();
	}
function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar este Recuadro?");
		 if ( return_value == true ) {
			 document.location.href = "eliminarRecuadro.php?id=" + cual;
		 }
		 
	 }	
