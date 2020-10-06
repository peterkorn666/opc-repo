var ir_A_tl = 1;

function pintar(cual){
	if(ir_A_tl==1){
	document.getElementById(cual).style.background="#ffffff";
	document.getElementById(cual).style.cursor="hand";
	}
}

function desPintar(cual, color){
		document.getElementById(cual).style.background=color;
}

function buscar(cual){
	if(ir_A_tl==1){
		document.location.href="buscar.php?id="+cual;
	}
		
}
function buscarTL(cual){
	if(ir_A_tl==1){
		document.location.href="buscar.php?id_tl="+cual;
	}
}

function actualizarInscripto(donde, cual, chq, cualDiv){
	
	document.getElementById('Guardando').style.visibility='visible'
	document.form1.target= "guardarInscripcion";

	if(donde=="tl"){
		
		
		if(chq.checked==true){
			document.getElementById(cualDiv).style.background = "#009900";
			document.form1.action="inc/inscribirPersona.inc.php?tabla=personas_trabajos_libres&id=" + cual + "&tipo=1"
		
		}else{
			document.getElementById(cualDiv).style.background = "#ff0000";
			document.form1.action="inc/inscribirPersona.inc.php?tabla=personas_trabajos_libres&id=" + cual + "&tipo=0"
		
		}
		
		
		
	}else{
		
		if(chq.checked==true){
			document.getElementById(cualDiv).style.background = "#009900";
			document.form1.action="inc/inscribirPersona.inc.php?tabla=personas&id=" + cual + "&tipo=1"
		
		}else{
			document.getElementById(cualDiv).style.background = "#ff0000";
			document.form1.action="inc/inscribirPersona.inc.php?tabla=personas&id=" + cual + "&tipo=0"
		
		}
		
		
		
	}
	
	document.form1.submit();
		
}


function setIR_A(cual){
	ir_A_tl = cual;
}