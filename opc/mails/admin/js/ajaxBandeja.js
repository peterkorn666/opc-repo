function nuevoAjax(){ 
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

function peticion(pag, enDiv, metodo, parametros){
	
	document.getElementById(enDiv).innerHTML = "<div style='background:#ff0000; color=#ffffff;padding:4px; font-size:12;font-weight:bold;width:100%; '>Procesando su consulta . . .</div>";
	
	var ajax = new nuevoAjax();	
	ajax.open(metodo, pag, true);	
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4){ 
		 	if (ajax.status == 200){ 
					xmlDoc = ajax.responseText;
					document.getElementById(enDiv).innerHTML = xmlDoc;					
			 }else{
				return;
			 }
		}else{
		 	return;
		}	
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//	ajax.setRequestHeader("Content-Type", "text/xml; charset=ISO-8859-1");
	ajax.send(parametros);
}
function detener_ajax(){
	ultimo_ajax.abort()
}
//


