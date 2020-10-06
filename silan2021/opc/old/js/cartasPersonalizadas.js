function validar(){
	if (document.form1.titulo.value == ""){
		alert("Indique un titulo por favor");
		document.form1.titulo.focus();
		return;		
	}
	if (document.form1.subtitulo.value == ""){
		alert("Indique un subtitulo por favor");
		document.form1.subtitulo.focus();
		return;		
	}
	/*if (document.form1.asunto.value == ""){
		alert("Indique un asunto por favor");
		document.form1.asunto.focus();
		return;		
	}*/
	if (document.form1.destinatarios.value == ""){
		alert("Indique a quien va destinado por favor");
		document.form1.destinatarios.focus();
		return;		
	}
	
	
	document.form1.submit();
	
}

