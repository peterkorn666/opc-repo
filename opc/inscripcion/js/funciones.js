var array_hotel = new Array();

function validar_form(){	
	var check = false;
	
	if($("input[name='costos_inscripcion']:checked").val()=="" || $("input[name='costos_inscripcion']:checked").val()==undefined)
	{
		check = $("input[name='costos_inscripcion']:eq(0)");
	}else if($("input[name='costos_inscripcion']:checked").data('beca') === 0){
		if($("input[name='forma_pago']:checked").val()=="" || $("input[name='forma_pago']:checked").val()==undefined)
		{
			check = $("input[name='forma_pago']:eq(0)");
		}else if($("input[name='forma_pago']:checked").data('comprobante') === 1){
			if($("input[name='numero_comprobante']").val() == "" || $("input[name='numero_comprobante']").val() == undefined){
				check = $("input[name='numero_comprobante']");
			}
		}
	}
	
	var ignore = Array('grupo_check_comprobante', 'grupo_numero_comprobante', 'key_inscripto', 'nombre_inscripto_pagador', 'numero_comprobante', 'fecha_pago', 'descuento', 'codigo', 'key_codigo', 'forma_pago');//
	$("input:not(input[name='numero_tl']),select").each(function(index, element) {
        if($(this).val()=="" && $.inArray($(this).prop('name'), ignore)==-1)
		{
			check = $(this);
			//alert(check.prop('name'));
			return false;
		}
    });
	/*else { 
		if ($("input[name='forma_pago']:checked").val()=="1") {
			
		}
	}*/
	
	if(check){
		alert("Todos los campos son obligatorios");
		check.focus();
		//console.log(check.prop('name'));
		return false;
	}
	
	if(!validateEmail($("input[name='email']").val())){
		alert("El email no es correcto");
		$("input[name='email']").focus();
		return false;
	}
	/*var check_autores = false;
	$("input[name='input_selected_autor[]']").each(function(index, element) {
        if($(this).val()==""){
			check_autores = true;
			return false;
		}
    });
	if(check_autores){
		alert("Debe seleccionar al menos un autor por trabajo.");
		return false;
	}*/
	
	/*if($("input[name='grupo_check_comprobante']:checked").val() == undefined){
		if ($("input[name='numero_comprobante']").val()==''){
			alert("Debe escribir el comprobante");
			return false;
		}
	}*/
	
	/*if(($("input[name='forma_pago']:checked").val()=='2' || $("input[name='forma_pago']:checked").val()=='3' || $("input[name='forma_pago']:checked").val()=='4') && $("input[name='grupo_check_comprobante']:checked").val() == undefined){
		if ($("input[name='numero_comprobante']").val()==''){
			alert("Debe escribir el comprobante");
			return false;
		}
	}*/
	
<!-- Grupo check comprobante-->
	/*console.log('antes comprobante')
	func_comprobante = validarComprobanteServer();
	console.log(func_comprobante)
	if(!func_comprobante){
		return false;
	}
	console.log('despues comprobante')*/
		
	if($("input[name='grupo_check_comprobante']").is(":checked")){
		if($("input[name='grupo_numero_comprobante']").val()!=""){
			/*if($("input[name='key_inscripto']").val()==""){
				alert("Hubo un error al validar el comprobante, intente de nuevo o verifique que este escrito correctamente.");
				return false;
			}*/
		}else{
			alert("Escriba el comprobante de la persona que realizó el pago.");
			return false;
		}
	}
<!-- //end Check comprobante-->
	
	/*if ($("#result_trabajos table").length == 0) {
		if(!confirm("Usted no asoció ningún trabajo a su inscripción.\n Le recordamos que:\n - Para poder exponer, su ponencia debe estar asociada a este pago.\n - Culminado el congreso podrá descargar su diploma si está verificado su pago.")){
			return false;
		}
	}*/
	
	$("#buscar_trabajo").remove();
	/*$("#div_tarjeta").remove();*/
	
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}


$(document).ready(function(e) {	

	//if($("input[name='numero_pasaporte']").val()=="")
		//$("#tabla_inscripcion").css("display","none");
	$("#tabla_documento").css("display","none");
	$("#tabla_documento input[type='button']").click(function(){
		 $.ajax({
			type: "POST",
			url: "verificar_documento.php", //Relative or absolute path to response.php file
			data: "doc="+$("input[name='ver_documento']").val(),
			beforeSend: function(){
				$("#tabla_documento input[type='button']").val("VERIFICANDO DOCUMENTO...");
			},
			success: function(status) {
				$("#tabla_documento input[type='button']").val("Verificar Documento");
				if(status=="")
				{
					alert("Write your passaport number.");
					return false;
				}
				if(status==0)
					$("#tabla_documento_alert").css("display","");
				else
				{
					$("#tabla_documento").css("display","none");
					$("#tabla_documento_alert").css("display","none");
					$("#tabla_inscripcion").css("display","");
					$("input[name='numero_pasaporte']").val($("input[name='ver_documento']").val());
				}
			}
		});
	})

    $(document).on("click","input[name='costos']",function(){
		code();	
	})
	
	$("input[name='numero_pasaporte']").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			var regex = new RegExp("^[a-zA-Z0-9]+$");
			var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			if (regex.test(str)) {
				return true;
			}
		
			e.preventDefault();
			return false;
		}
	});
	
	
	
	$(document).on("click",".limpiar_radio",function(e){
		e.preventDefault();
		cual = $(this).data("radio");
		if(cual!="")
		{
			$("input[name='"+cual+"']").prop("checked",false);
			calcularPrecio();
		}
	})
	//$('.datefield input').autotab_magic().autotab_filter('numeric');
	$("input[name='grupo_check_comprobante']").click(function(){
		/*checkFormaPago();*/
		GrupoComprobante();
	});
	
	GrupoComprobante();
	$("input[name='grupo_numero_comprobante']").change(function(){
		//$("input[name='key_cuenta']").val("");
		$("input[name='key_inscripto']").val("");
		$("input[name='nombre_inscripto_pagador']").val("");
		$("#div_grupo_comprobante_status").html("");
	});
	
	$("input[name='grupo_numero_comprobante']").keyup(function (e) {
		checkComprobante(this);
	});
	$(document).on("paste","input[name='grupo_numero_comprobante']",function (e) {
		checkComprobante(this);
	});
	
	numeroComprobante();
	/*$("input[name='forma_pago']").click(function(){
		numeroComprobante();
	});*/
	$(document).on("click", "input[name='grupo_check_comprobante']",function(){
		numeroComprobante();
	});
	
	$("input[name='numero_comprobante']").keyup(function (e) {
		checkComprobante(this);
	});
	$(document).on("paste","input[name='numero_comprobante']",function (e) {
		checkComprobante(this);
	});
	
	divWesterUnion();
	$("input[name='forma_pago']").change(function(){
		divWesterUnion();
	});
	
	/*$("input[name='credit_card_expire']").focusout(function(){
		if(isValidDate($(this).val())===false){
			alert("Fecha invalida");
			$(this).val("");
		}
	})*/
	
});

function validarComprobanteServer(){
	if($("input[name='grupo_numero_comprobante']").val()!=""){	
		var next = true;
		 $.ajax({
			type: "POST",
			url: "validarNumeroComprobante.php", //Relative or absolute path to response.php file
			data: {"num":$("input[name='grupo_numero_comprobante']").val()},
			dataType:"json",
			async:false,
			success: function(status) {
				if(status.code=="")
				{
					alert("Escriba el comprobante");
					next = false;
				}
				if(status.code=='1'){
					$("#div_grupo_comprobante_status").html("<b class='alert alert-success'>Comprobante válido.</b>");
					//$("input[name='key_cuenta']").val(status.key);
					$("input[name='key_inscripto']").val(status.key_inscripto);
					$("input[name='nombre_inscripto_pagador']").val(status.nombre_inscripto);
					$("input[name='forma_pago'][value=" + status.fp + "]").prop("checked", true);
					next = true;
				}else if(status.code=='2')
				{
					$("#div_grupo_comprobante_status").html("<b class='alert alert-warning'>El comprobante no es válido.</b>");
					next = false;
				}else{
					$("#div_grupo_comprobante_status").html("<b class='alert alert-danger'>Hubo un error al procesar el comprobante.</b>");
					next = false;
				}
			}
		});
		if(!next)
			return false;
		else
			return true;
	}
	return true;
}

function checkComprobante(e){
	var str = $(e).val();
	str = str.replace(/[^a-zA-Z 0-9]+/g, '');
	//console.log(str)
	$(e).val(str);
}

function code(){
	$("#otro_codigo").hide();
	if($("input[name='costos']:checked").val()==10){
		$("#otro_codigo").show();
		$("input[name='code']").val("");
	}
}


function GrupoComprobante(){
	$("#div_grupo_comprobante").addClass("hidden");
	if($("input[name='grupo_check_comprobante']").is(":checked")){
		$("#div_grupo_comprobante").removeClass("hidden");
	}else{
		$("input[name='grupo_numero_comprobante']").val("");
		//$("input[name='key_cuenta']").val("");
		$("input[name='key_inscripto']").val("");
		$("input[name='nombre_inscripto_pagador']").val("");
	}
}

function numeroComprobante(){
	$("#numero_comprobante").hide();
	if($("input[name='grupo_check_comprobante']:checked").val()==undefined){
		$("#numero_comprobante").show();
	}else{
		$("input[name='numero_comprobante']").val("");
	}
	//$("#cartel_tarjeta").hide();
	/*if (($("input[name='forma_pago']:checked").val()=='2' || $("input[name='forma_pago']:checked").val()=='3' || $("input[name='forma_pago']:checked").val()=='4') && $("input[name='grupo_check_comprobante']:checked").val()==undefined){
		$("#numero_comprobante").show();
	}else{
		if(($("input[name='forma_pago']:checked").val()=='1' || $("input[name='forma_pago']:checked").val()=='2') && $("input[name='grupo_check_comprobante']:checked").val()==undefined){
			$("#cartel_tarjeta").show();
		
		$("input[name='numero_comprobante']").val("");
	}}*/
}

function checkFormaPago(){
	$("#div_tarjeta").hide();
	if($("input[name='forma_pago']:checked").val()=="1"){
		if ($("input[name='grupo_check_comprobante']").is(":checked")) {
			$("#div_tarjeta input").val("");
			$("input[name='credit_card_type']").prop("checked",false);
		}else{
			$("#div_tarjeta").show();
		}
	}else{
		$("#div_tarjeta input:not(input[type='radio'])").val("");
		$("input[name='credit_card_type']").prop("checked",false);
	}
}

function isValidDate(s) {
    // format D(D)/M(M)/(YY)YY
    var dateFormat = /^\d{2,2}[\/]\d{4,4}$/;

    if (dateFormat.test(s)) {
        // remove any leading zeros from date values
        s = s.replace(/0*(\d*)/gi,"$1");
        var dateArray = s.split(/[\.|\/|-]/);
      
        // correct month value
        dateArray[0] = dateArray[0]-1;

        // correct year value
        if (dateArray[1].length<4) {
            // correct year value
            dateArray[1] = (parseInt(dateArray[1]) < 50) ? 2000 + parseInt(dateArray[1]) : 1900 + parseInt(dateArray[1]);
        }

        var testDate = new Date(dateArray[1], dateArray[0]);
        if (testDate.getMonth()!=dateArray[0] || testDate.getFullYear()!=dateArray[1]) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

function divWesterUnion(){
	$("#div_western_union").hide();
	if($("input[name='forma_pago']:checked").val() == 2)
		$("#div_western_union").show();
}