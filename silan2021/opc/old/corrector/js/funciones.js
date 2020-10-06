function habilitarOtro(cual){
	if(cual == "Otro"){
		document.getElementById("DIVOtroTema").style.display = "block";
	}else{
		document.getElementById("DIVOtroTema").style.display = "none";
		document.form0.OtroTema.value = "";
	}
}
function abrir_carga(){
	document.getElementById("carga").style.display = "block";
	return
}
function cerrar_carga(){
	document.getElementById("carga").style.display = "none";
	return
}
function publicar(id, valor){
	if(valor==true){
		val = 1
		document.getElementById("publicar"+id).style.background="#00FF00"
	}else{
		val = 0
	    document.getElementById("publicar"+id).style.background="#ffffff"
	}
	
	petision('publicar.php', 'carga_publicar', 'POST', 'id='+id+'&val='+val)
	return
}

function eliminarFoto(id){
	var conf = confirm("Estas seguro de eliminar esa foto");
	
	if(conf){
		form_evento.target = "subiendo";
		form_evento.action = "eliminar_foto.php?id=" + id;
		form_evento.submit();
		
	}

}
function subirFoto(){

	document.getElementById("carga_foto").style.display = "inline";

	form_evento.target = "subiendo";
	form_evento.action = "subir_foto.php";
	form_evento.submit();
	form_evento.submit();

	return
	
}
function redir(){
	document.location.href = "index.php?pag=listaEvento.php";
}
/*valor1 = 0;valor2 = 0;valor3 = 0;valor4 = 0;valor5 = 0;valor6 = 0;
function calcular1(valor){valor1 = valor; total(); parcial();}
function calcular2(valor){valor2 = valor; total(); parcial();}
function calcular3(valor){valor3 = valor; total(); parcial();}
function calcular4(valor){valor4 = valor; total(); parcial();}
function calcular5(valor){valor5 = valor; total(); parcial();}
function calcular6(valor){valor6 = valor; total(); parcial();}*/
function total(){
	var valor1 = document.form0["nota1"].value;
	var valor2 = document.form0["nota2"].value;
	var valor3 = document.form0["nota3"].value;
	var valor4 = document.form0["nota4"].value;
	/*var valor5 = document.form0["nota5"].value;
	var valor6 = document.form0["nota6"].value;
	var valor7 = document.form0["nota7"].value;*/
	
	valorTotal = parseInt(valor1)+parseInt(valor2)+parseInt(valor3)+parseInt(valor4);
	document.getElementById('total_puntaje').innerHTML = "<b>"+valorTotal+"/100</b>";
	//document.form0["total_puntaje"].value = valorTotal;
}
function parcial(){
	var valor1 = document.form0["nota1"].value;
	var valor2 = document.form0["nota2"].value;
	var valor3 = document.form0["nota3"].value;
	var valor4 = document.form0["nota4"].value;
	var valor5 = document.form0["nota5"].value;
	var valor6 = document.form0["nota6"].value;
	var valor6 = document.form0["nota7"].value;
	
	document.getElementById("span1").innerHTML = valor1;
	document.getElementById("span2").innerHTML = valor2;
	document.getElementById("span3").innerHTML = valor3;
	document.getElementById("span4").innerHTML = valor4;
	document.getElementById("span5").innerHTML = valor5;
	document.getElementById("span6").innerHTML = valor6;
	document.getElementById("span7").innerHTML = valor7;
}

function bajarTL(cual){
	document.location.href= "../bajando_tl.php?id=" + cual;
}
function bajarTLConcurso(cual){
	document.location.href= "../bajando_tl_concurso.php?id=" + cual;
}
function validarEvaluacion(){
	var alerta = "You must complete all fields. Thank you.";
	
	/*if(document.form0["evaluar_trabajo"].value==""){
		alert(alerta);
		return false;
	}*/
	
	if (!$("input[name='acepto_trabajo']").is(':checked')) {
		alert("Debe checkear el campo que indica que usted es o no autor del trabajo.");
		return false;
	}else if ($("input[name='acepto_trabajo']:checked").val() === 'No'){
		if(document.form0["estado"].value==""){
			alert("Debe evaluar el trabajo");
			return false;
		}
		
		if(document.form0["estado"].value=="Aceptado con modificaciones"){
			if(document.form0["comentarios"].value == ""){
				alert("Debe agregar las modificaciones correspondientes");
				return false;
			}
		}
	}
	
	/*var comment = false;
	var i = 1;
	for (i=1;i<=7;i++) {
		$("select[name='notai']").each(function(index, element) {
			if (parseInt($("option:selected", element).val()) >= 0 && parseInt($("option:selected", element).val()) <= 5) {
				$("textarea[name='comentarios_notai']").show();
				$("span[name='com_notai']").show();
			}
			else {
				$("textarea[name='comentarios_notai']").hide();
				$("span[name='com_notai']").hide();
			}
			if ((parseInt($("option:selected", element).val()) >= 0 && parseInt($("option:selected", element).val()) <= 5) && $("textarea[name='comentarios_notai']").val()=="") {
				comment = true;
			}
		});
	}*/
	
	var comment = false;
	/*$("select[name^='nota']").each(function(index, element) {
		if ((parseInt($("option:selected", element).val()) >= 0 && parseInt($("option:selected", element).val()) <= 5) && $("textarea[name='comentarios']").val()=="")
			comment = true;
	});*/
	
	/*if(comment)
	{
		alert("Tiene puntajes que van del 0 al 5, exprese brevemente los motivos para dicha calificación.");
		return false;
	}*/
	document.form0.submit();
}

function validarPremio(){
	if(document.form0["puntajeTotal"].value==""){
		alert("Escriba un puntaje.");		
		return false;
	}
	document.form0.submit();
}

function txtCor(cual){
	document.getElementById("divCorrecion").style.display = "none";
	if(cual=="Correccion"){
		document.getElementById("divCorrecion").style.display = "";
	}
}

function promedio(){
	var nota1 = $("select[name='nota1'] option:selected").val(),
		nota2 = $("select[name='nota2'] option:selected").val(),
		nota3 = $("select[name='nota3'] option:selected").val(),
		nota4 = $("select[name='nota4'] option:selected").val(),
		nota5 = $("select[name='nota5'] option:selected").val(),
		nota6 = $("select[name='nota6'] option:selected").val(),
		nota7 = $("select[name='nota7'] option:selected").val()
	if (nota1!="" && nota2!="" && nota3!="" && nota4!="" && nota5!="" && nota6!="" && nota7!="") {
		nota1 = parseInt($("select[name='nota1'] option:selected").val());
		nota2 = parseInt($("select[name='nota2'] option:selected").val());
		nota3 = parseInt($("select[name='nota3'] option:selected").val());
		nota4 = parseInt($("select[name='nota4'] option:selected").val());
		nota5 = parseInt($("select[name='nota5'] option:selected").val());
		nota6 = parseInt($("select[name='nota6'] option:selected").val());
		nota7 = parseInt($("select[name='nota7'] option:selected").val());
		/*if(isNaN(nota5))
			nota5 = 0;*/
		//var total_puntos = $("select[name^='nota']").length*12;
		total = ((nota1+nota2+nota3+nota4+nota5+nota6+nota7)/$("select[name^='nota']").length);
		//$("#txt_promedio").html('<b>'+Math.round(total)+'</b>')
		var promedio = Math.round(total*10)/10;
		$("#txt_promedio").html('<b>'+promedio+'</b>');
		if (promedio >= 3) {
			$("#estado").html("<strong>APTO</strong>");
			/*$("#estado")*/
			$("input[name='estado_ev']").val("APTO");
			$("#texto_recomendacion").html("Recomendaciones");
		}
		else {
			$("#estado").html("<strong>NO APTO</strong>");
			$("input[name='estado_ev']").val("NO APTO");
			$("#texto_recomendacion").html("Motivo del rechazo");
		}
	}
	else {
		$("#txt_promedio").html("");
		$("#estado").html("");
		$("input[name='estado_ev']").val("");
		$("#texto_recomendacion").html("Recomendaciones");
	}
}

$(document).ready(function(e) {
    /*promedio();
	$("select[name='nota1'], select[name='nota2'], select[name='nota3'], select[name='nota4'], select[name='nota5'], select[name='nota6'], select[name='nota7']").change(function(){
		promedio();
	})*/
	$("checkbox[name='acepto_trabajo']").click(function() {
		if ($("#acepto_trabajo").is(':checked')) {
			$("checkbox[name='acepto_trabajo']").attr('checked', false);
		}
		else {
			$("checkbox[name='acepto_trabajo']").attr('checked', true);
		}
	});
	
});