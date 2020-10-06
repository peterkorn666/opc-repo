function alterNameAutors(){
	jQuery(".table_autores").each(function(index, element) {
		jQuery(".table_autores:eq("+index+") input, .table_autores:eq("+index+") select").each(function() {
			if(!jQuery(this).hasClass("nochange")){
				var getName = jQuery(this).prop("name").split("_");
					getName = getName[0]+"_"+index;
				jQuery(this).prop("name",getName);
			}
		})
		numAut = parseInt(index+1);
		jQuery(".numero_autor:eq("+index+")").html(numAut);
		jQuery("[name='total_autores']").val(numAut);
		
    });
}

function ScrollBottonAutores(){
	//Mover scroll al final
	var $box = jQuery('#div_autores'); 
	var height = $box.get(0).scrollHeight;
	$box.scrollTop(height);
}

function SaveTiny(){
	/*jQuery(".tiny").each(function(index, element) { 
		tinyMCE.get(jQuery(this).prop("id")).save();
	});*/
	jQuery(".tiny").each(function(index, element) { 
		id = jQuery(element).prop("id");
		//alert(id);
		CKEDITOR.instances[id].updateElement();
	});
}

function effect_one(){
	//alert(animation);
	if(animation=="ocultar"){
		jQuery("#effect_one p").each(function(index, element) {
			jQuery(this).hide().delay(index * 3000).fadeIn("slow");
		}).promise().done( function(){ jQuery("#mod_step1").delay(3000).fadeIn("slow"); } );
	}
	
}

function initEffect(){
	effect_one()
}

function setAutores(){
	
}

function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

function getStats(id) {
    var body = tinymce.get(id).getBody(), text = tinymce.trim(body.innerText || body.textContent);
    //text = text.split(/[\w\u2019\'-]+/)
    text = text.replace(/[\s]+/ig,' ');
    return {
        chars: text.length,
        words: text.split(' ').length
    };
}

jQuery(document).ready(function($) {
	setInterval(function(){setTotalWords()},2000);
    //Archivo TL
	$("#link_tl").click(function(e)
	{
		e.preventDefault();
		$("input[name='archivo_tl']").click();
	})
	
	$("input[name='archivo_tl']").change(function()
	{
		$("#txt_tl span").html($("input[name='archivo_tl']").val());
		$("#txt_tl").show();
	})
	
	$("#txt_tl img").click(function()
	{
		$("input[name='archivo_tl']").val("");
		$("#txt_tl").hide();
		$("#txt_tl span").html("");
	}).css("cursor","pointer")

	
	if(animation=="ocultar"){
		$("#mod_step1").hide();
		$("#div_autores").hide();
		if($("select[name='pais_0'] option:selected").val()=="")
			$("#second_step").hide();
	}else{
		$(".hide_titulo").hide();
	}

	
	
	var alertas = "Todos los campos son obligatorios";
	//Nuevo autor
	$(document).on("click",".nuevo_autor",function(e){
		e.preventDefault();
    	var clones = $(".table_autores:first").clone();
		$("#div_agregar_autores").append(clones);
		clones.find("input:text").val("").end();
		clones.find("input:hidden").val("").end();
		clones.find("input:checkbox").prop("checked",false).end();
		clones.find("select option:eq(0)").prop('selected', true).end();
		
		alterNameAutors();		
		//ScrollBottonAutores();
	})
	var alerta = "Debe completar todos los campos obligatorios.";
	$(document).on("click",".eliminar_autor",function(e){
		e.preventDefault();
		if($(".table_autores").length>1){
			$(".table_autores:last").remove();
			alterNameAutors();
			//ScrollBottonAutores();
		}
	})
	var tipo_tl = $("input[name='tipo_tl']").val();
	$(document).on("click","#step1",function(e){
		SaveTiny();
		var check = false;
		$("#obg").hide();
		if($("#titulo_tl").val()==""){
			alert(alerta);
			return true;
		}

		if($(".lee:checked").length==0)
		{
			alert("Debe seleccionar el presentador");
			return false;
		}
		
		$(".table_autores").each(function(index, element) {
			$(".table_autores:eq("+index+") input:not(:disabled), .table_autores:eq("+index+") select:not(:disabled)").each(function() {
				if(!$(this).hasClass("nochange")){
					if($(this).val()==""){
						check = $(this);
						$(this).focus();
						return false;
					}
					
					if($(this).prop("type")=="email")
					{
						if(!IsEmail($(this).val()))
						{
							check = $(this);
							$(this).focus();
							return false;
						}
					}
				}
			});			
		});
		
		$(".searchAutor").each(function(index, element) {
			if($("input[name='apellido_"+index+"']").val()=="" && $("input[name='apellido2_"+index+"']").val()==""){
				$(this).focus();
				check = $(this);				
				return false;
			}
		});

		if(check){
			alert(alertas);
			return false;
		}
		
		
		$("#effect_one").fadeOut("slow");
		$.ajax({
			url: "vista_previa.php",
			cache:false,
			type: 'POST',
			data: $("[name='peview']").serialize()+"&step=1",
			contentType: "application/x-www-form-urlencoded;charset=UTF-8",
			success: function(data) {
				$("#mod_step1").fadeOut("slow",function(){
					$("#preview_step1").html(data);
					$("#preview_step1").fadeIn("slow",function(){
                        $('.alert').hide();
						$("#mod_step2").fadeIn("slow");
						datosContacto();
					});
					
				})
			}
		})
		setTotalWords();		
	})
	$("#mod_step2").hide();
	$(document).on("click","#step2",function(e){
	//$(document).on("submit","form[name='peview']",function(e){
		SaveTiny();
		
		if($("select[name='area_tl'] option:selected").val()=="undefined" || $("select[name='area_tl'] option:selected").val()=="")
		{
			alert("Seleccione el Area.");
			$("select[name='area_tl']").focus();
			return false;
		}
		
		var tipo_tl_checked = $("input[name='tipo_tl']:checked").val();
		if(tipo_tl_checked==undefined || tipo_tl_checked=="")
		{
			alert("Seleccione la Modalidad.");
			$("input[name='tipo_tl']").focus();
			return false;
		}
		
		if($("input[name='premio']:checked").val()==undefined || $("input[name='premio']:checked").val()=="")
		{
			alert("Seleccione si postula o no a premio.");
			$("input[name='premio']").focus();
			return false;
		}
		
		if($("#resumen_tl").val()==""){
			alert("Ingrese su resumen.");
			return false;
		}	
		
		if($("#resumen_tl2").val()==""){
			alert("Ingrese su resumen.");
			return false;
		}	
		
		if($("#resumen_tl3").val()==""){
			alert("Ingrese su resumen.");
			return false;
		}
		
		if(tipo_tl_checked == 1){
			if($("#resumen_tl4").val()==""){
				alert("Ingrese su resumen.");
				return false;
			}
		}
		
		if($("#resumen_tl5").val()==""){
			alert("Ingrese su resumen.");
			return false;
		}
		
		/*if($("#resumen_tl6").val()==""){
			alert("Ingrese su resumen.");
			return false;
		}*/
		
		/*if(parseInt($("input[name='tw']").val())>360){
			alert("El total no debe superar las 350 palabras.");
			return false;
		}*/
		
		/*if($("input[name='palabra_clave1']").val()=="" || $("input[name='palabra_clave2']").val()=="" || $("input[name='palabra_clave3']").val()=="" || $("input[name='palabra_clave4']").val()=="" || $("input[name='palabra_clave5']").val()==""){
			alert("Ingrese las palabras claves");
			return false;
		}*/
		
		
		/*if($("input[name='archivo_tl']").val()=="")
		{
			alert("Debe seleccionar un archivo para cargar.");
			return false;
		}*/
		/*if(!$("input[name='tipo_tl']").is(":checked"))
		{
			alert("Seelccione la modalidad de su trabajo");
			return false;
		}*/
		if($("[name='contacto_mail']").val()==""){
			alert("Escriba el email de contacto");
			return false;
		}
		
		if($("[name='contacto_mail2']").val()==""){
			alert("Escriba el email alternativo de contacto");
			return false;
		}
		
		if($("[name='contacto_nombre']").val()==""){
			alert("Escriba el Nombre de Contacto");
			return false;
		}
		
		
		if($("[name='contacto_apellido']").val()==""){
			alert("Escriba el Apellido del Contacto");
			return false;
		}
		
		
		if($("[name='contacto_institucion']").val()==""){
			alert("Escriba la Institución del Contacto");
			return false;
		}
		
		if($("[name='contacto_pais']").val()==""){
			alert("Selecciona el Pais del Contacto");
			return false;
		}
		
		if($("[name='contacto_ciudad']").val()==""){
			alert("Escriba la Ciudad del Contacto");
			return false;
		}
		
		if($("[name='contacto_telefono']").val()==""){
			alert("Escriba el Telefono del Contacto");
			return false;
		}
		
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		if(!emailReg.test($("[name='contacto_mail']").val())) {
			alert("El correo no es valido.");
			return false;
		}
		
		$.ajax({
			url: "vista_previa.php",
			cache:false,
			type: 'POST',
			data: $("[name='peview']").serialize()+"&step=2",
			contentType: "application/x-www-form-urlencoded;charset=UTF-8",
			success: function(data) {
				$("#mod_step2").fadeOut("slow",function(){
					$("#preview_step2").fadeIn("slow");
					$("#preview_step2").html(data);
				})
			}
		})		
	})
	
	
	//Volver a autores
	$(document).on("click","#step2back",function(e){
		SaveTiny();
		$("#preview_step2").fadeOut("slow");	
		$("#mod_step1").fadeOut("slow",function(){
			$("#mod_step2").fadeOut("slow",function(){
				$("#preview_step1").fadeOut("slow",function(){
					$("#mod_step1").fadeIn("slow");
					$("#effect_one").fadeIn("slow");
				});
				
			});
			
			
		})	
	})
	
	//Volver a resumen
	$(document).on("click","#step3back",function(e){
		SaveTiny();
		$("#preview_step2").fadeOut("slow");	
		$("#mod_step1").fadeOut("slow",function(){
			$("#mod_step2").fadeIn("slow");
		})	
	})
	
	//Solo un autor presentador
	$(document).on("click",".lee",function(e){
		if($(".lee:checked").length>1){
			$(".lee").prop("checked",false);
			$(this).prop("checked",true);
		}
	})


	/*var ins = loadInst();
	$(document).on("focus",".autoins",function(){
		$(".autoins").autocomplete({
			source: ins,
			minLength: 3
		});
	})*/
	
	
	/*$(document).on("keyup",".searchAutor",function(){
		
		var apellido = $(this).val(),
			index = $(".searchAutor").index(this);
		/*if($("[name='nuevo_"+index+"']").val()!=0 && $("[name='nuevo_"+index+"']").val()!=""){
			$("[name='nuevo_"+index+"']").val(0);
			$("[name='nombre_"+index+"']").val("");
			$("[name='institucion_"+index+"']").val("");
			$("[name='email_"+index+"']").val("");
			$("[name='pais_"+index+"']").val("");
		}*/
		
		/*var autores = loadAutores(objeto);*/
	//	alert(autores);
		/*$(".searchAutor").autocomplete({
			source: "autocomplete_autores.php?apellido="+apellido,
			minLength: 3,
			select: function( event, ui ) {
				$("[name='nuevo_"+index+"']").val(ui.item.id);
				$("[name='nombre_"+index+"']").val(ui.item.nombre);
				$("[name='apellido_"+index+"']").val(ui.item.apellido);
				$("[name='institucion_"+index+"']").val(getInstitucionID(ui.item.institucion));
				$("[name='email_"+index+"']").val(ui.item.email);
				$("[name='pais_"+index+"']").val(ui.item.pais);
				return false;
			}
		});
	})*/
	
	$(".hide_titulo a").click(function(e){
			e.preventDefault();
			$(".hide_titulo").fadeOut("slow");
			$("#div_autores").fadeIn("slow");
			if($("select[name='pais_0'] option:selected").val()!="")
				$("#second_step").show();
	})
	
	$(document).on("change",".paisautor:eq(0)",function(){
		$("#second_step").fadeIn();
	})
	
	/*$(document).on("change",".paisautor:last",function(){
		$(".nuevo_autor:eq(0)").click();
	})*/
	
	
	$(".login .link_login").click(function(e){
		e.preventDefault();
		$(".login").slideToggle("fast");
	})
	
	//setTimeout(function(){$("#step1").click();},2000);
	hidden_clinico();
	$(document).on("click","input[name='tipo_tl']",function(){
		/*jQuery("textarea[name='resumen_tl']").val("");*/
		/*$("textarea#resumen_tl").val("");*/
		/*$("textarea#resumen_tl2").text("");
		$("textarea#resumen_tl3").text("");
		$("textarea#resumen_tl5").text("");
		if ($("input[name='tipo_tl']:checked").val()==1)
			$("textarea#resumen_tl4").text("");*/
		/*$("textarea[name='resumen_tl']").html("");
		$("textarea[name='resumen_tl2']").html("");
		$("textarea[name='resumen_tl3']").html("");
		$("textarea[name='resumen_tl5']").html("");
		if ($("input[name='tipo_tl']").val()==1)
			$("textarea[name='resumen_tl4']").html("");*/
		/*$("#div_resumen_tl textarea").text("");*/
		hidden_clinico();
	})
});

function getInstitucionID(ins){
	var institucion = "";
	//alert(ins);
	jQuery.ajax({
		url: 'autocomplete_institucion.php',
		type: "POST",
		data:"id="+ins,
		async: false
	}).done(function(data){
		institucion = data;
	});
	
	return institucion;
}

function wordsCount(){
	var suma = 0;
	jQuery(".mce-wordcount").each(function(index){
		var palabras = $(this).html().split(": ");
		
		if(index!=0){
			suma += parseInt(palabras[1]);
		}
	})	
	//jQuery("[name='wordstotal']").val(suma);
	jQuery("#txt_words_total").html("<span style='font-size:14px'><strong>Total Palabras: "+suma+"</strong></span>");
}



function loadInst(){
	//Gets the name of the sport entered.
	var insList = "";
	jQuery.ajax({
		url: 'autocomplete_institucion.php',
		type: "POST",
		async: false
	}).done(function(teams){
	//	teamList = teams.split(',');
		insList = teams.split(',');
	});
	//Returns the javascript array of sports teams for the selected sport.
	return insList;
}

function loadAutores(objeto){
	var apellido = objeto.val();
	//Gets the name of the sport entered.
	var autoresList = "";
	jQuery.ajax({
		url: 'autocomplete_autores.php',
		type: "POST",
		data: "apellido="+apellido,
		async: false
	}).done(function(autores){
	//	teamList = teams.split(',');
		//autoresList = autores.split(',');
		autoresList = autores;
	});
	//Returns the javascript array of sports teams for the selected sport.
	return autoresList;
}



function init(){
	alterNameAutors();
	invitacion();
}

function datosContacto(){
    var radioButtons = jQuery(".lee");
    var selectedIndex = radioButtons.index(radioButtons.filter(':checked'));
    if(selectedIndex==null)
        return false;
    if(jQuery("input[name='contacto_mail']").val()!='')
        return false;
	jQuery("[name='contacto_nombre']").val(jQuery("[name='nombre_"+selectedIndex+"']").val());
	jQuery("[name='contacto_apellido']").val(jQuery("[name='apellido_"+selectedIndex+"']").val());
	jQuery("[name='contacto_institucion']").val(jQuery("[name='institucion_"+selectedIndex+"']").val());
	jQuery("[name='contacto_mail']").val(jQuery("[name='email_"+selectedIndex+"']").val());
}

function invitacion(){
	var n = "";
    var field = '';
	var t = jQuery("input[name='t']").val();
	for(var i=0;i<jQuery(".lee").length;i++)
	{
		field = jQuery("input[name='nombre_"+i+"']").val()+" "+jQuery("input[name='apellido_"+i+"']").val()+" "+jQuery("input[name='apellido2_"+i+"']").val();
		n += "Descargar carta de invitación para: <a href='acp/descargar.php?t="+base64.encode(t)+"&k="+base64.encode(field)+"' target='_blank'>"+field+"</a>";
		n += "<br>";
	}
	jQuery("#div_invitacion").html(n);
}

function setTotalWords(){
	setTimeout(function(){
		totalWords = 0;
		var tipo_tl = jQuery("input[name='tipo_tl']:checked").val();
		jQuery(".cke_wordcount span").each(function(index, element) {
			if(jQuery(element).html() && index!=0)
			{
				totalWords += parseInt(jQuery(element).html().split(" ")[1]);
			}
		});
		//type = (totalWords>350 ? 'red' : 'green');
		type = 'green';
		jQuery("#totalwords").html("<b style='color:"+type+"'>"+totalWords+"</b>");
		jQuery("input[name='tw']").val(totalWords);
	},1000);
}

function scaleImage(ev) {
    // Maximum size allowed for images
    var maxX = 600;
    var maxY = 1000;

    var data = ev.data,
        editor = ev.editor;

    var img = data.image;
    var imgX = img.width;
    var imgY = img.height;

    if (imgX == 0 || imgY == 0) {
        alert('Ops, the image doesn\'t seem to be valid');
        ev.cancel();
        return;
    }

    // if it's smaller, get out
    if (imgX <= maxX && imgY <= maxY)
        return;

    var ratio = imgX / imgY;
    if ((maxX / maxY) > ratio)
        maxX = Math.round(maxY * (ratio));
    else
        maxY = Math.round(maxX / (ratio));

    var canvas = document.createElement('canvas');
    canvas.width = maxX;
    canvas.height = maxY;

    var ctx = canvas.getContext('2d');
    ctx.drawImage(img, 0, 0, maxX, maxY);

    if ( /\.jpe?g$/.test(data.name)) {
        // You could adjust here the quality of jpg
        data.file = canvas.toDataURL('image/jpeg', 0.9);
    }
    else
        data.file = canvas.toDataURL('image/png');
}

function hidden_clinico(){
	jQuery("#hidden_clinico").show();
	jQuery("#txt_clinico").html("Material y método");
	if(jQuery("input[name='tipo_tl']:checked").val()=="2")
	{
		/*jQuery("#div_resumen_tl textarea").val("");*/
		jQuery("#hidden_clinico").hide();
		jQuery("#txt_clinico").html("Caso(s) clínico(s)");
	}
}

