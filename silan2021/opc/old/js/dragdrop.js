// JavaScript Document
var capa = null; // Almacena la capa que se mueve 
var _IE_ = navigator.userAgent.indexOf("MSIE") != -1; // Si es IE  
/* 
 * Libera la capa del movimiento 
 */ 
function liberaCapa() { 
capa = null; 
}  
/* 
 * Cuando se pincha en la barra de la capa 
 * se almacena la capa y se guarda la posición 
 * del ratón respecto a la esquina superior 
 * izquierda de la capa, para así mover la capa 
 * desde el punto pichado y no desde la equina 
 */ 
function clickCapa(e, obj) { 
capa = obj.parentNode;  
// En IE y Opera se usa otra propiedad del evento 
if (_IE_) { 
	difX = e.offsetX; 
	difY = e.offsetY + 3; 
	} else { 
	difX = e.layerX; 
	difY = e.layerY + 3; 
	} 
}  
/* 
 * Mientras se mueva el ratón por el 
 * body se mueve la capa 
 */ 
function mueveCapa(e) { 
	if (capa != null) { 
	capa.style.top = (e.clientY-difY-4)+"px"; 
	capa.style.left = (e.clientX-difX-4)+"px"; 
	} 
} 