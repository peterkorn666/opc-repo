function nuevoAjax(){ 
   abrir_carga()  
	var xmlhttp=false; 
        
		try { 
             
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); 
            
			} catch (e) { 
            
			try { 
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 
            
			} catch (E) { 
              
			   xmlhttp = false; 
           } 
		   
        } 

         if (!xmlhttp && typeof XMLHttpRequest!='undefined') { 
			  xmlhttp = new XMLHttpRequest(); 
		 } 
		 
        return xmlhttp; 
         
} 

function petision(pag, enDiv, metodo, parametros){
	
	var ajax = new nuevoAjax();
	
	ajax.open(metodo, pag + "?nocahe=" + Math.random(), true);
	
	ajax.onreadystatechange = function() {

		if (ajax.readyState == 4){ 
		 	if (ajax.status == 200){ 

					xmlDoc = ajax.responseText;
					document.getElementById(enDiv).innerHTML = xmlDoc;
					
					
				
					
					cerrar_carga();
								
		
			 }else{
				return;
			 }
		
		}else{
		 	return;
		}
		
		
	
	}
	

		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	
	ajax.send(parametros);

}
