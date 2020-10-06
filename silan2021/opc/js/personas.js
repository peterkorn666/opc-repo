var arrayPersonas = new Array(new Array(" ","",""));

function llenarPersonas(){			
	

	//borrro combo
	for(u=0; u<=cantTrab-1; u++){
		for(i=document.form1.elements['persona[]'][u].options.length-1; i>=0; i--){
			document.form1.elements['persona[]'][u].remove(i);
		}
	}
				
	//ordeno array
	arrayPersonas.sort();
		
	
	//lleno el combo (cual, texto, valor)
	for(u=0; u<=cantTrab-1; u++){
		
		for(i=0;i<arrayPersonas.length; i++){
			
			agregarItem(document.form1.elements["persona[]"][u], arrayPersonas[i][1], arrayPersonas[i][2]);
		
		}
		
	}
			
}
			
function llenarArrayPersonas(elemento,elemento1){
	arrayPersonas.push(new Array(elemento.toUpperCase(), elemento, elemento1));
	
}

function tempSeleccion(){
	
	arraySeleccion = new Array();
	
	for(u=0; u<=cantTrab-1; u++){
	
		arraySeleccion.push(document.form1.elements['persona[]'][u].value)
	
	}

	
}


function seleccionarPersonas(cual, cualCombo){
	
	for(u=0; u<=cantTrab-1; u++){
		for(i=document.form1.elements['persona[]'][u].options.length-1; i>=0; i--){
		
			if(u!=cualCombo){
				if(arraySeleccion[u]==document.form1.elements['persona[]'][u][i].value){
						document.form1.elements['persona[]'][u][i].selected = true;
				}
			}else{
				if(cual==document.form1.elements['persona[]'][u][i].value){
						document.form1.elements['persona[]'][u][i].selected = true;
				}
			}
			
			
		}	
	}
}
//*****altas y modificaciones
//
//
//
  
  arrayApellidoExisten = new Array();
  arrayNombreExisten = new Array(); 
 
 
 function ValidarPersona(){
	
  encontrados = new Array();
  var personas = "";
  
	for(i=0;i<arrayApellidoExisten.length; i++)
    {
		if(form1.apellidos_.value == arrayApellidoExisten[i])
		{
			encontrados.push(new Array(arrayApellidoExisten[i],arrayNombreExisten[i]));
		}
    }
		   
	for(i=0;i<encontrados.length;i++){
		personas += encontrados[i][1] + " " +  encontrados[i][0] + "\n";
	}
	
						
	if(encontrados.length>0){
		
		var return_value = confirm("Se han encontrado las siguientes coincidencias: \n\n" + personas + " \n\nSi la persona no esta en la lista o igual quiere agregarla presione Aceptar.");
		
		if (return_value == false){
			return; 
		}
		
	}
	personas="";
	
	 if(form1.nombre_.value==""){alert("Por Favor, Ingrese un nombre.");form1.nombre_.focus();return;}
	 if(form1.apellidos_.value==""){alert("Por Favor, Ingrese uno o m�s apellidos");form1.apellidos_.focus();return;}
	
	  form1.submit();
	}
	
	function eliminar_persona(cual){
 		
		var return_value = confirm("�Esta seguro que desea eliminar esta persona?");
		 if ( return_value == true ) {
			 document.location.href = "eliminarPersona.php?id=" + cual;
		 }
		 
	 }
	 function eliminar_personaTL(cual){
 		
		var return_value = confirm("�Esta seguro que desea eliminar esta persona?");
		 if ( return_value == true ) {
			 document.location.href = "eliminarPersonaTL.php?id=" + cual;
		 }
		 
	 }
	 
	function popup(cual, width, height, param1){
	
		window.open(cual + '&p=1','popup','width='+width+',height=' + height + ',toolbar=no,directories=no,status=no,menubar=no,modal=yes');
	
	}
	
	function agregarItem(cual_, txt, valor, param3){
	var oOption = document.createElement("OPTION");

	oOption.text = txt;

	oOption.value = valor;

	if(param3!=undefined){
		if(param3.substring(0,1) == "#"){
			oOption.style.background = param3;
		}else{
			oOption.style.background = "url('img/patrones/"+param3+"')";
		}
	}

	cual_.options.add(oOption);
	}
		
function abrir_cerrar_div(cual){

	if(document.getElementById(cual).style.display == "none"){
		
		document.getElementById(cual).style.display = "block";
		//document.getElementById(cual).innerHTML = "";
		
	}else{
		
		document.getElementById(cual).style.display = "none";
	
	}
	
	return
}

function pintar(cual, color){

	document.getElementById(cual).style.background=color;
	document.getElementById(cual).style.cursor="pointer";
}
function despintar(cual, color){
	document.getElementById(cual).style.background=color;
}
// ajax y buscador para personas en alta y medificacion de Congreso////////////////////////////////////////
function buscando_personasCongreso(valor){
	if(valor!="")
	{
		$.ajax({
		  type: 'POST',
		  dataType:"json",
		  url: 'ajax/buscarPersonasCongreso_ajax.php',
		  data: "str_persona="+valor,
		  success:function(data){
			var htmls = "";
			if(data.cantidad>0)
			{
				for(i=0;i<data.cantidad;i++)
				{
					htmls += "<div id='div_persona_"+data[i].id_persona+"' class='conferencista_helper' onclick='cargar_persona_buscadaCongreso("+data[i].id_persona+")'>";
						htmls += "<b>"+data[i].apellido+" "+data[i].nombre+"</b>";
					htmls += "</div>";
				}
			}
			$("#txt_persona_search").html(htmls);
		  },
		  error:function(err){
			// failed request; give feedback to user
			//alert(err.responseText);
		  }
		});
	}else
		$("#txt_persona_search").html("");
}

function cargar_persona_buscadaCongreso(id_persona){
	/*if(id_persona !=0){
		document.getElementById("txt_persona_" + en_campo_param).style.display = "inline";
		$("#txt_buscar_persona_"+en_campo_param).css("visibility","hidden");
		$("#txt_agregar_persona_"+en_campo_param).css("visibility","hidden");

	}else{
		document.getElementById("txt_persona_" + en_campo_param).style.display = "none";
		$("#txt_buscar_persona_"+en_campo_param).css("visibility","visible");
		$("#txt_agregar_persona_"+en_campo_param).css("visibility","visible");
	}*/
	
	//if(id_persona
	agregarTrabajo();
	var conf = "";
	getConfData(id_persona,function(data){
		conf = "<img src='imagenes/list.png'> "+data.apellido+", "+data.nombre;
		if(data.pais)
			conf += " ("+getInsPais(data.pais,'pais')+")";
		if(data.institucion)
			conf += " - "+getInsPais(data.institucion,'institucion');
		$('.persona_txt:last').html(conf);
		
	  // here you use the output
	});
	$("#txt_persona_search").html("");
	$("input[name='search_conf']").val("");
	$('input[name="persona[]"]:last').val(id_persona);
}

function LoaderCalidades(){
	allCalidades = document.getElementsByName("en_calidad_conf[]");	
	var addOption = false;
	for(q=0;q<allCalidades.length;q++)
	{
		x = document.getElementById("en_calidad_conf_"+q+"");
		addOption = false;
		for(i=0;i<arrayCalidades.length;i++)
		{			
			for(o=0;o<x.options.length;o++)
			{
				if((x[o].value!=arrayCalidades[i].id) && x[o].value!="")			
				{
					addOption = true;
				}
			}
			if(addOption)
			{
				option = document.createElement("option");
				option.value = arrayCalidades[i].id;
				option.text = arrayCalidades[i].calidad;
				x.add(option);
			}
		}
	}
}

function LoaderCalidad(index){
	var x = document.getElementById("en_calidad_conf_"+index+"");	
	for(i=0;i<arrayCalidades.length;i++)
	{			
		option = document.createElement("option");
		option.value = arrayCalidades[i].id;
		option.text = arrayCalidades[i].calidad;
		x.add(option);
	
	}
}

function cargarPersonaStatic(index,data)
{

	$("#txt_persona_" + index).css("display","block");
	$("#txt_buscar_persona_"+index).css("visibility","block");
	$("#txt_agregar_persona_"+index).css("visibility","block");
	
	//Datos
	$(".titulo_conferencista").eq(index).val(data.titulo_conf);
	//Cargar calidades
	if(arrayCalidades.length>0)
	{
		LoaderCalidad(index);
	}
	$(".en_calidad").eq(index).val(data.en_calidad);
	$(".observaciones_conf").eq(index).val(data.observaciones_conf);
	if(data.mostrar_ponencia==1)
		$(".mostrar_ponencia").eq(index).prop("checked",true);
	if(data.en_crono==1)
		$(".en_crono").eq(index).prop("checked",true);

	var conf = "";
	conf = "<img src='imagenes/list.png'> "+data.apellido+", "+data.nombre;
	if(data.pais && data.pais!=247)
		conf += " ("+getInsPais(data.pais,'pais')+")";
	if(data.institucion)
		conf += " - "+getInsPais(data.institucion,'institucion');
	$('.persona_txt').eq(index).html(conf);
  // here you use the output
	$('#id_conf_prim_'+index).val(data.id);
	$('#id_persona_'+index).val(data.id_conf);
	
	$('#persona_'  + index).css("display","none");
	$('#persona'  + index).css("display","none");
}

function getConfData(id_conf,handleData)
{
	$.ajax({
	  type: 'POST',
	  dataType:"json",
	  url: 'ajax/dataConf_ajax.php',
	  data: "id="+id_conf,
	  success:function(data){
		handleData(data)
	  },
	  error:function(err){
		// failed request; give feedback to user
		//alert(err.responseText);
	  }
	});
}

function getInsPais(id,type)
{
	return "";
	a = null
	$.ajax({
	  type: 'POST',
	  async: false,
	  url: 'ajax/dataInsPais.php',
	  data: "id="+id+"&type="+type,
	  success:function(data){
		a = data
	  },
	  error:function(err){
		// failed request; give feedback to user
		//alert(err.responseText);
	  }
	});
	return a;
}


function HabilitarCampo(cual){
	document.getElementById('persona_'  + cual).style.display = "block";
}

$(document).ready(function(e) {
    $(document).on("click",".persona_txt",function(){
		var pos = $(".persona_txt").index(this);
		//reset
		if ($('.conf_options').eq(pos).is(':hidden'))
		{
			$(".conf_options").stop(true,true).slideUp("fast");
			$(".persona_txt img").attr("src","imagenes/list.png");
		}
		$(".conf_options").eq(pos).stop(true,true).slideToggle("slow",function(){
			if ($('.conf_options').eq(pos).is(':hidden'))
			{
				$(".persona_txt img").eq(pos).attr("src","imagenes/list.png");
			}
			else
			{
				$(".persona_txt img").eq(pos).attr("src","imagenes/list-open.png");				
			}
		})
	}).css("cursor","pointer");
});