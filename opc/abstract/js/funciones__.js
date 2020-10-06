// JavaScript Document
var nchars =[["&#160","no-break space"],["&#38","ampersand"],["&#34","quotation mark"],["&#162","cent sign"],["&#8364","euro sign"],["&#163","pound sign"],["&#165","yen sign"],["&#169","copyright sign"],["&#174","registered sign"],["&#8482","trade mark sign"],["&#8240","per mille sign"],["&#181","micro sign"],["&#183","middle dot"],["&#8226","bullet"],["&#8230","three dot leader"],["&#8242","minutes / feet"],["&#8243","seconds / inches"],["&#167","section sign"],["&#182","paragraph sign"],["&#223","sharp s / ess-zed"],["&#8249","single left-pointing angle quotation mark"],["&#8250","single right-pointing angle quotation mark"],["&#171","left pointing guillemet"],["&#187","right pointing guillemet"],["&#8216","left single quotation mark"],["&#8217","right single quotation mark"],["&#8220","left double quotation mark"],["&#8221","right double quotation mark"],["&#8218","single low-9 quotation mark"],["&#8222","double low-9 quotation mark"],["&#60","less-than sign"],["&#62","greater-than sign"],["&#8804","less-than or equal to"],["&#8805","greater-than or equal to"],["&#8211","en dash"],["&#8212","em dash"],["&#175","macron"],["&#8254","overline"],["&#164","currency sign"],["&#166","broken bar"],["&#168","diaeresis"],["&#161","inverted exclamation mark"],["&#191","turned question mark"],["&#710","circumflex accent"],["&#732","small tilde"],["&#176","degree sign"],["&#8722","minus sign"],["&#177","plus-minus sign"],["&#247","division sign"],["&#8260","fraction slash"],["&#215","multiplication sign"],["&#185","superscript one"],["&#178","superscript two"],["&#179","superscript three"],["&#188","fraction one quarter"],["&#189","fraction one half"],["&#190","fraction three quarters"],["&#402","function / florin"],["&#8747","integral"],["&#8721","n-ary sumation"],["&#8734","infinity"],["&#8730","square root"],["&#8764","similar to"],["&#8773","approximately equal to"],["&#8776","almost equal to"],["&#8800","not equal to"],["&#8801","identical to"],["&#8712","element of"],["&#8713","not an element of"],["&#8715","contains as member"],["&#8719","n-ary product"],["&#8743","logical and"],["&#8744","logical or"],["&#172","not sign"],["&#8745","intersection"],["&#8746","union"],["&#8706","partial differential"],["&#8704","for all"],["&#8707","there exists"],["&#8709","diameter"],["&#8711","backward difference"],["&#8727","asterisk operator"],["&#8733","proportional to"],["&#8736","angle"],["&#180","acute accent"],["&#184","cedilla"],["&#170","feminine ordinal indicator"],["&#186","masculine ordinal indicator"],["&#8224","dagger"],["&#8225","double dagger"],["&#192","A - grave"],["&#193","A - acute"],["&#194","A - circumflex"],["&#195","A - tilde"],["&#196","A - diaeresis"],["&#197","A - ring above"],["&#198","ligature AE"],["&#199","C - cedilla"],["&#200","E - grave"],["&#201","E - acute"],["&#202","E - circumflex"],["&#203","E - diaeresis"],["&#204","I - grave"],["&#205","I - acute"],["&#206","I - circumflex"],["&#207","I - diaeresis"],["&#208","ETH"],["&#209","N - tilde"],["&#210","O - grave"],["&#211","O - acute"],["&#212","O - circumflex"],["&#213","O - tilde"],["&#214","O - diaeresis"],["&#216","O - slash"],["&#338","ligature OE"],["&#352","S - caron"],["&#217","U - grave"],["&#218","U - acute"],["&#219","U - circumflex"],["&#220","U - diaeresis"],["&#221","Y - acute"],["&#376","Y - diaeresis"],["&#222","THORN"],["&#224","a - grave"],["&#225","a - acute"],["&#226","a - circumflex"],["&#227","a - tilde"],["&#228","a - diaeresis"],["&#229","a - ring above"],["&#230","ligature ae"],["&#231","c - cedilla"],["&#232","e - grave"],["&#233","e - acute"],["&#234","e - circumflex"],["&#235","e - diaeresis"],["&#236","i - grave"],["&#237","i - acute"],["&#238","i - circumflex"],["&#239","i - diaeresis"],["&#240","eth"],["&#241","n - tilde"],["&#242","o - grave"],["&#243","o - acute"],["&#244","o - circumflex"],["&#245","o - tilde"],["&#246","o - diaeresis"],["&#248","o slash"],["&#339","ligature oe"],["&#353","s - caron"],["&#249","u - grave"],["&#250","u - acute"],["&#251","u - circumflex"],["&#252","u - diaeresis"],["&#253","y - acute"],["&#254","thorn"],["&#255","y - diaeresis"],["&#913","Alpha"],["&#914","Beta"],["&#915","Gamma"],["&#916","Delta"],["&#917","Epsilon"],["&#918","Zeta"],["&#919","Eta"],["&#920","Theta"],["&#921","Iota"],["&#922","Kappa"],["&#923","Lambda"],["&#924","Mu"],["&#925","Nu"],["&#926","Xi"],["&#927","Omicron"],["&#928","Pi"],["&#929","Rho"],["&#931","Sigma"],["&#932","Tau"],["&#933","Upsilon"],["&#934","Phi"],["&#935","Chi"],["&#936","Psi"],["&#937","Omega"],["&#945","alpha"],["&#946","beta"],["&#947","gamma"],["&#948","delta"],["&#949","epsilon"],["&#950","zeta"],["&#951","eta"],["&#952","theta"],["&#953","iota"],["&#954","kappa"],["&#955","lambda"],["&#956","mu"],["&#957","nu"],["&#958","xi"],["&#959","omicron"],["&#960","pi"],["&#961","rho"],["&#962","final sigma"],["&#963","sigma"],["&#964","tau"],["&#965","upsilon"],["&#966","phi"],["&#967","chi"],["&#968","psi"],["&#969","omega"],["&#8501","alef symbol"],["&#982","pi symbol"],["&#8476","real part symbol"],["&#978","upsilon - hook symbol"],["&#8472","Weierstrass p"],["&#8465","imaginary part"],["&#8592","leftwards arrow"],["&#8593","upwards arrow"],["&#8594","rightwards arrow"],["&#8595","downwards arrow"],["&#8596","left right arrow"],["&#8629","carriage return"],["&#8656","leftwards double arrow"],["&#8657","upwards double arrow"],["&#8658","rightwards double arrow"],["&#8659","downwards double arrow"],["&#8660","left right double arrow"],["&#8756","therefore"],["&#8834","subset of"],["&#8835","superset of"],["&#8836","not a subset of"],["&#8838","subset of or equal to"],["&#8839","superset of or equal to"],["&#8853","circled plus"],["&#8855","circled times"],["&#8869","perpendicular"],["&#8901","dot operator"],["&#8968","left ceiling"],["&#8969","right ceiling"],["&#8970","left floor"],["&#8971","right floor"],["&#9001","left-pointing angle bracket"],["&#9002","right-pointing angle bracket"],["&#9674","lozenge"],["&#9824","black spade suit"],["&#9827","black club suit"],["&#9829","black heart suit"],["&#9830","black diamond suit"],["&#8194","en space"],["&#8195","em space"],["&#8201","thin space"],["&#8204","zero width non-joiner"],["&#8205","zero width joiner"],["&#8206","left-to-right mark"],["&#8207","right-to-left mark"],["&#173","soft hyphen"]];

var specialchars = '<table class="table table-bordered">';
p = 0;
for(c=0;c<nchars.length;c++){
	if(p==0){
		specialchars += '<tr>';
	}
		specialchars += '<td title="'+nchars[c][1]+'" style="text-align:center;padding:0px;cursor:pointer;font-weight:bold;color:#0088cc" class="classChars">'+nchars[c][0]+'</td>';
	p++;
	if((p==14) || ((nchars.length-1)==c)){
		specialchars += '</tr>';
		p = 0;
	}
}
specialchars += '</table>';


function alterNameAutors(){
	jQuery(".table_autores").each(function(index, element) {
		jQuery(".table_autores:eq("+index+") input, .table_autores:eq("+index+") select").each(function() {
			if(!jQuery(this).hasClass("nochange")){
				var getName = jQuery(this).prop("name").split("_");
					getName = getName[0]+"_"+index;
				jQuery(this).prop("name",getName);
			}
		})
		var numAut = parseInt(index+1);
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
	
	/*mostrarTematicas();
	$("select[name='area_tl']").change(function(){
		mostrarTematicas();
	});*/

    /*
    $("input[name='reglamento']").click(function(){
        conflicto();
    });*/

    //$(".profesion").change(function(e){

	$(".profesion").each(function(){
        profesionOtro($(this));
	});
    $(".institucion").each(function(){
        institucionOtro($(this));
	});
	var div_agregar_autores = $("#div_agregar_autores");
    div_agregar_autores.on('change', '.profesion', function(){
        profesionOtro($(this));
	});
    div_agregar_autores.on('change', '.institucion', function(){
        institucionOtro($(this));
    });

    $("select[name='modalidad']").change(function(){
		tieneEje();
	});

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

    //Archivo CV

    $('#add_more_cv').click(function () {
        var clones = $(".templatecv:eq(0)").clone();
            clones = clones.find('span:eq(0)').html('<img src="img/cross.png" width="16" height="16"  alt="" title="No subir archivo" class="remove_cv" style="margin-top:-12px"/>').end();
            clones = clones.find("input[type='file']").val('').end();
        $(".templatecv:last").after(clones);
    });

    $(document).on('click', '.remove_cv', function(){
        $(this).closest('.templatecv').remove();
    })
    /*$("#link_cv").click(function(e)
    {
        e.preventDefault();
        $("input[name='archivo_cv[]']").click();
    })

    $("input[name='archivo_cv[]']").change(function()
    {
        alert($("input[name='archivo_cv[]']").val());
        $("#txt_cv span").html($("input[name='archivo_cv[]']").val());
        $("#txt_cv").show();
    })

    $("#txt_cv img").click(function()
    {
        $("input[name='archivo_cv[]']").val("");
        $("#txt_cv").hide();
        $("#txt_cv span").html("");
    }).css("cursor","pointer")*/
	
	if(animation=="ocultar"){
		$("#mod_step1").hide();
		$("#div_autores").hide();
		if($("select[name='pais_0'] option:selected").val()=="")
			$("#second_step").hide();
	}else{
		$(".hide_titulo").hide();
	}

	//var tipo_tl = $("input[name='abstracts_tipo_tl']").val();
	
	//var alertas = "Todos los campos son obligatorios";
	//Nuevo autor
	$(document).on("click",".nuevo_autor",function(e){
		e.preventDefault();
    	var clones = $(".table_autores:first").clone();
		$("#div_agregar_autores").append(clones);
		clones.find("input:text").val("").end();
		clones.find("input:hidden").val("").end();
		clones.find("input:checkbox").prop("checked",false).end();
        //clones.find("select option:eq(0)").prop('selected', true).end();
		clones.find("select").each(function(){
            $(this).each(function(index, options){
                $(options[0]).prop('selected', true).end();
            });
		});
        clones.find(".columna_profesion").hide();
        clones.find(".columna_institucion").hide();
        clones.find(".div_persona_ya_registrada").empty();
		
		alterNameAutors();		
		//ScrollBottonAutores();
	})
	//var alerta = "Debe completar todos los campos obligatorios.";
	$(document).on("click",".eliminar_autor",function(e){
		e.preventDefault();
		if($(".table_autores").length>1){
			$(".table_autores:last").remove();
			alterNameAutors();
			//ScrollBottonAutores();
		}
	})
	
	//var tipo_tl = $("input[name='tipo_tl']").val();
	$(document).on("click","#step1",function(e){
		SaveTiny();
		var check = false;
		$("#obg").hide();
		//var titulo = tinyMCE.get('titulo_tl').getContent();	
		var titulo = $("#titulo_tl").val();
		if(titulo==""){
			alert(alertas);
			return true;
		}
		if($(".lee").length==1)
		{
			$(".lee").eq(0).prop("checked", true);
		}
		if($(".lee:checked").length==0)
		{
			alert(TXT_CHECK_PRESENTADOR);
			return false;
		}

		var prof, inst;
		$(".table_autores").each(function(index, element) {
			$(".table_autores:eq("+index+") input:not(:disabled), .table_autores:eq("+index+") select:not(:disabled)").each(function() {
				if(!$(this).hasClass("nochange") && $(this).prop("name")!="apellido_"+index && $(this).prop("name")!="pasaporte_"+index && $(this).prop("name") != "rol_"+index && $(this).prop("name")!="profesion-txt_"+index && $(this).prop("name")!="institucion-txt_"+index){
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

					if($(this).prop("name") == "profesion_"+index){
						prof = $(this).val();
						console.log(prof);
					}
                    if($(this).prop("name") == "institucion_"+index){
                        inst = $(this).val();
                    }
				}

				if($(this).prop("name") == "profesion-txt_"+index){
					if((prof == 'Otro' || prof == 'Outros') && $(this).val() == ""){
                        check = $(this);
                        $(this).focus();
                        return false;
					}
				}
                if($(this).prop("name") == "institucion-txt_"+index){
                    if(inst == 'Otra' && $(this).val()==""){
                        check = $(this);
                        $(this).focus();
                        return false;
                    }
                }
			});			
		});
		
		$(".searchAutor").each(function(index, element) {
			if($("input[name='apellido_"+index+"']").val()==""){
				$(this).focus();
				check = $(this);				
				return false;
			}
		});

		
		/*
		//var resumen_tl = tinyMCE.get('resumen_tl').getContent();
		var resumen_tl = $("#resumen_tl").val();
		if(resumen_tl==""){
			check = true;
		}*/
		
		var es_admin = $("input[name='es_admin']").val();
		if(es_admin == false){
			/*
			//var resumen_tl2 = tinyMCE.get('resumen_tl2').getContent();
			var resumen_tl = $("#resumen_tl2").val();
			if(resumen_tl2==""){
				check = true;
			}*/
		}
		/*var resumen_tl3 = tinyMCE.get('resumen_tl3').getContent();
		if(resumen_tl3==""){
			check = true;
		}*/
		
		if(check){
			alert(alertas);
			console.log(check);
			return false;
		}
		
		/*if (getStats('resumen_tl').words > 501) {
			alert("El resumen no puede superar las 500 palabras.");
			return false;
		}*/
		
		if(parseInt($("[name='words_total']").val())>210)
		{
			alert("El total de palabras no puede ser mayor a 200");
			return false;
		}
		
		/*if($("input[name='palabra_clave1']").val()=="" || $("input[name='palabra_clave2']").val()=="" ||
		 $("input[name='palabra_clave3']").val()==""){
			alert(TXT_CHECK_KEYWORDS);
			return false;
		}*/

		/*if ($("select[name='tipo_tl']").val() == "") {
			alert("Seleccione el Tipo de trabajo");
			return false;
		}*/

		/*if ($("select[name='area_tl']").val() == "") {
			alert("Seleccione el Area");
			return false;
		}*//*else{
			var area_trabajo_libre = $("select[name='area_tl']").val();
			if(area_trabajo_libre === '1' || area_trabajo_libre === '2' || area_trabajo_libre === '3'){
				if($("select[name='tematica_tl"+area_trabajo_libre+"']").val() == ""){
					alert("Seleccione la Temática");
					return false;
				}
			}
		}*/
		var select_modalidad = $("select[name='modalidad'] option:selected");
		if(select_modalidad.val() === "" || select_modalidad.val() == undefined){
			alert(TXT_CHECK_MODALIDAD);
			$("select[name='modalidad']").focus();
			return false;
		} else {
			var tiene_eje = select_modalidad.data('tiene_eje');
			if(tiene_eje === 1){
				var select_area_tl = $("select[name='area_tl'] option:selected");
				if (select_area_tl.val() === "" || select_area_tl.val() == undefined) {
					alert(TXT_CHECK_AREA);
					return false;
				}
				var select_linea_transversal = $("select[name='linea_transversal'] option:selected");
				if(select_linea_transversal.val() === "" || select_linea_transversal.val() == undefined){
					alert(TXT_CHECK_LINEA_TRANSVERSAL);
					$("select[name='linea_transversal']").focus();
					return false;
				}
			}
		}
        /*if ($("select[name='modalidad']").val() == "") {
            alert("Seleccione la Modalidad");
            return false;
        }*/

        /*var input_reglamento = $("input[name='reglamento']");
        if(!input_reglamento.is(':checked')){
            alert(alertas);
            input_reglamento.eq(0).focus();
            return false;
        } else {
            var reglamento = $("input[name='reglamento']:checked");
            if(reglamento.val() == 2){
                var conflicto_descripcion = $("textarea[name='conflicto_descripcion']");
                if(conflicto_descripcion.val()==""){
                    alert(alertas);
                    conflicto_descripcion.focus();
                    return false;
                }
            }
        }*/

        /*var palabra_clave1 = $("select[name='palabra_clave1'] option:selected");
        if(palabra_clave1.val() === "" || palabra_clave1.val() == undefined){
            alert(alertas);
            $("select[name='palabra_clave1']").focus();
            return false;
        }
        var palabra_clave2 = $("select[name='palabra_clave2'] option:selected");
        if(palabra_clave2.val() === "" || palabra_clave2.val() == undefined){
            alert(alertas);
            $("select[name='palabra_clave2']").focus();
            return false;
        }
        var palabra_clave3 = $("select[name='palabra_clave3'] option:selected");
        if(palabra_clave3.val() === "" || palabra_clave3.val() == undefined){
            alert(alertas);
            $("select[name='palabra_clave3']").focus();
            return false;
        }
        var palabra_clave4 = $("select[name='palabra_clave4'] option:selected");
        if(palabra_clave4.val() === "" || palabra_clave4.val() == undefined){
            alert(alertas);
            $("select[name='palabra_clave4']").focus();
            return false;
        }
        var palabra_clave5 = $("select[name='palabra_clave5'] option:selected");
        if(palabra_clave5.val() === "" || palabra_clave5.val() == undefined){
            alert(alertas);
            $("select[name='palabra_clave5']").focus();
            return false;
        }*/
		
		/*if($("input[name='idioma_tl']:checked").val()===undefined){
			alert("Seleccione el Idioma");
			return false;
		}*/
		
		/*if($("input[name='modalidad']:checked").val()===undefined){
			alert("Seleccione la Modalidad");
			return false;
		}
		
		if($("input[name='idioma_tl']:checked").val()===undefined){
			alert("Seleccione el Idioma");
			return false;
		}
		
		if(parseInt($("[name='words_total']").val())<295 || parseInt($("[name='words_total']").val())>355)
		{
			alert("El total de palabras no puede ser menor de 300 ni mayor a 350");
			return false;
		}*/
		
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
	//$(document).on("click","#step2",function(e){
	$(document).on("submit","form[name='peview']",function(e){
	//	SaveTiny();
		
		var check = true;
		
		//var resumen_tl = tinyMCE.get('resumen_tl').getContent();	
		/*var resumen_tl = $("#resumen_tl").val();	
		if(resumen_tl==""){
			alert("Ingrese su resumen.");
			check = false;
		}
		if(!check){
			return false;
		}*/
		
		var check2 = true;
		
		//var resumen_tl2 = tinyMCE.get('resumen_tl2').getContent();	
		/*var resumen_tl2 = $("#resumen_tl2").val();

		if(resumen_tl2==""){
			alert(alertas);
			check2 = false;
		}
		if(!check2){
			return false;
		}
		
		var check3 = true;
		
		//var resumen_tl3 = tinyMCE.get('resumen_tl3').getContent();	
		var resumen_tl3 = $("#resumen_tl3").val();

		if(resumen_tl3==""){
			alert(alertas);
			check3 = false;
		}
		if(!check3){
			return false;
		}*/
		
		/*if($("input[name='words_total']").val()>=330)
		{
			alert("El resumen es demasiado largo.");
			return false;
		}*/
		
		//tipo_modalidad = $("input[name='tipo_tl']:checked").val();
		
		/*if(tipo_modalidad == '5' && jQuery("input[name='t']").val() == '') {
			if($("input[name='archivo_tl']").val()=="")
			{
				alert("Debe seleccionar un archivo para cargar.");
				return false;
			}
		}*/
		
		/*if(!$("input[name='tipo_tl']").is(":checked"))
		{
			alert("Seelccione la modalidad de su trabajo");
			return false;
		}*/
		if($("[name='contacto_mail']").val()==""){
			alert(TXT_CHECK_CONTACT_EMAIL);
			return false;
		}
		
		if($("[name='contacto_mail2']").val()==""){
			alert(TXT_CHECK_ALTERNATIVE_EMAIL);
			return false;
		}
		
		if($("[name='contacto_nombre']").val()==""){
			alert(TXT_CHECK_CONTACT_NAME);
			return false;
		}
		
		
		if($("[name='contacto_apellido']").val()==""){
			alert(TXT_CHECK_CONTACT_SURNAME);
			return false;
		}
		
		
		if($("[name='contacto_institucion']").val()==""){
			alert(TXT_CHECK_CONTACT_INSTITUTION);
			return false;
		}
		
		if($("[name='contacto_pais']").val()==""){
			alert(TXT_CHECK_CONTACT_COUNTRY);
			return false;
		}
		
		if($("[name='contacto_ciudad']").val()==""){
			alert(TXT_CHECK_CONTACT_CITY);
			return false;
		}
		
		if($("[name='contacto_telefono']").val()==""){
			alert(TXT_CHECK_CONTACT_PHONE);
			return false;
		}
		
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		if(!emailReg.test($("[name='contacto_mail']").val())) {
			alert(TXT_CHECK_CONTACTO_EMAIL_NO_VALID);
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
		//SaveTiny();
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
		//SaveTiny();
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
	
	
	$(document).on("keyup","input[name^='nombre_'],input[name^='nombre2_'],input[name^='apellido_']",function(){
		invitacion();
	})
	//setTimeout(function(){$("#step1").click();},2000);
	$(document).on("keyup", "input[name^='pasaporte_']", function(e){
		checkPasaporte(this)
	})
	$(document).on("paste", "input[name^='pasaporte_']", function(e){
		checkPasaporte(this)
	})
	
	/*setInterval(function(){
		wordsCount();
	},1200)*/
	
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
		var palabras = jQuery(this).html().split(": ");

		suma += parseInt(palabras[0].replace(" words",""));
	})	
	var color = ";color:green";
	/*if(suma>200)
		color = ";color:red";*/
	jQuery("[name='words_total']").val(suma);
	jQuery("#txt_words_total").html("<span style='font-size:14px"+color+";font-weight:bold'><strong>Total Palabras: "+suma+"</strong></span>");
}

function setTotalWords(){
	setTimeout(function(){
		var totalWords = 0;
		/*jQuery(".cke_wordcount span").each(function(index, element) {
			if(jQuery(element).html())//index!=0
			{
				totalWords += parseInt(jQuery(element).html().split(" ")[3]);
			}
		});*/
		var count;
		jQuery(".cke_wordcount span").each(function(index, element) {
			if(jQuery(element).html())//index!=0
			{
				count = parseInt(jQuery(element).html().split(" ")[3]);
				if (count > totalWords){
					totalWords = count;
				}
			}
		});
		var type = (totalWords>200 ? 'red' : 'green');
		//type = 'green';
		jQuery("#totalwords").html("<b style='color:"+type+"'>"+totalWords+"</b><b>/200</b>");//<b>/350</b>
		jQuery("input[name='words_total']").val(totalWords);
	},1000);
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
	tieneEje();
}

function datosContacto(){
    var radioButtons = jQuery(".lee");
	//var type_tl = jQuery("input[name='abstracts_tipo_tl']").val();
    var selectedIndex = radioButtons.index(radioButtons.filter(':checked'));
    if(selectedIndex==null)
        return false;
    if(jQuery("input[name='contacto_mail']").val()!='')
        return false;
		
	jQuery("[name='contacto_nombre']").val(jQuery("[name='nombre_"+selectedIndex+"']").val());
	jQuery("[name='contacto_apellido']").val(jQuery("[name='apellido_"+selectedIndex+"']").val());
	var institucion = jQuery("[name='institucion_"+selectedIndex+"']").val();
	if(institucion == "Otra"){
        jQuery("[name='contacto_institucion']").val(jQuery("[name='institucion-txt_"+selectedIndex+"']").val());
	} else {
        jQuery("[name='contacto_institucion']").val(institucion);
	}
	jQuery("[name='contacto_mail']").val(jQuery("[name='email_"+selectedIndex+"']").val());
}

function invitacion(){
	var n = "";
    var field = '';
	var t = jQuery("input[name='t']").val();
	for(var i=0;i<jQuery(".lee").length;i++)
	{
		field = jQuery("input[name='nombre_"+i+"']").val()+" "+jQuery("input[name='apellido_"+i+"']").val();
		key = jQuery("input[name='id_autor[]']").eq(i).val();
		n += "Descargar carta de invitación para: <a href='acp/descargar.php?t="+base64.encode(t)+"&k="+base64.encode(key)+"' target='_blank'>"+field+"</a>";
		n += "<br>";
	}
	jQuery("#div_invitacion").html(n);
}

function checkPasaporte(e){
	var str = jQuery(e).val();
	str = str.replace(/[^a-zA-Z 0-9]+/g, '');
	//console.log(str)
	jQuery(e).val(str);
}

function mostrarTematicas(){
	jQuery("#div_tematicas").hide();
	jQuery("#div_tematica_1").hide();
	jQuery("#div_tematica_2").hide();
	jQuery("#div_tematica_3").hide();
	var area_tl = jQuery("select[name='area_tl']").val();
	if(area_tl === '1' || area_tl === '2' || area_tl === '3'){
		jQuery("#div_tematicas").show();
		jQuery("#div_tematica_"+area_tl).show();
	}
	for(i=1;i<=3;i++){
		if(i != area_tl)
			jQuery("select[name='tematica_tl"+i+"']").val("");
	}
}

function conflicto(){
    var div_conflicto = $("#conflicto");
    div_conflicto.hide();
    var conflicto = false;
    var input_reglamento = $("input[name='reglamento']");
    if(input_reglamento.is(':checked')){
        var reglamento = $("input[name='reglamento']:checked");
        if(reglamento.val() == 2){
            div_conflicto.show();
            conflicto = true;
        }
    }
    if(conflicto === false){
        $("textarea[name='conflicto_descripcion']").val("");
    }
}

function profesionOtro(select){
	var col = select.parent();
    var columna_profesion = col.find(".columna_profesion");
    columna_profesion.hide();
    var es_otro = false;

    var option = '';
    select.each(function(index, options){
        option = options[options.selectedIndex];
    });
    if (option.value === 'Otro' || option.value === 'Outros'){
        columna_profesion.show();
        es_otro = true;
    }
    if(es_otro === false){
        var campo = columna_profesion.children();
        campo.val("");
    }
}

function institucionOtro(select){
    var col = select.parent();
    var columna_institucion = col.find(".columna_institucion");
    columna_institucion.hide();
    var es_otro = false;

    var option = '';
    select.each(function(index, options){
        option = options[options.selectedIndex];
    });
    if (option.value === 'Otra'){
        columna_institucion.show();
        es_otro = true;
    }
    if(es_otro === false){
        var campo = columna_institucion.children();
        campo.val("");
    }
}

function tieneEje(){
	var div_tiene_eje = jQuery(".div-tiene_eje");
	var div_no_tiene_eje = jQuery(".div-no_tiene_eje");
	var modalidad = jQuery("select[name='modalidad'] option:selected");
	if (modalidad.val() === undefined || modalidad.val() === null || modalidad.val() === ""){
		div_no_tiene_eje.hide();
		div_tiene_eje.show();
	} else {
		var tiene_eje = modalidad.data('tiene_eje');
		if(tiene_eje === 0){
			jQuery("select[name='area_tl']").val("");
			jQuery("select[name='linea_transversal']").val("");
			div_tiene_eje.hide();
			div_no_tiene_eje.show();
		} else {
			div_no_tiene_eje.hide();
			div_tiene_eje.show();
		}
	}
}