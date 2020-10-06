// JavaScript Document
function formatConfsTxt(data)
{
	var template = "";
	if(data)
	{
		//alert(data.toSource());
		if(data.calidad)
			template += data.calidad+": ";
		if(data.apellido)
			template += "<b>"+data.apellido+", "+data.nombre+"</b>";
		if(data.pais && data.pais!=247)
			template += " ("+getInsPais(data.pais,'pais')+")";
		if(data.apellido)
			template += "<br>";
	}
	return template;
}

function formatTlTxt(data){
	var template = "";
	if(data.numero_tl)
		template += data.numero_tl;
	if(data.titulo_tl)
		template += " - "+data.titulo_tl;
	if(data.numero_tl)	
		template += "<br>";
		
	return template;
}

getLastConfs = function(id){
	$.ajax({
		url: "data/getLastConfs.php",
		type: "POST",
		cache: false, 
		async:false,
		data: "id="+id,
		dataType: "json",
		success: function(data){
			d = data
		}
	});
	return d;
}

geConfsID = function(id){
	if(id=="")
		return null;
	$.ajax({
		url: "ajax/getConfs.php",
		type: "POST",
		cache: false, 
		async: false,
		data: "id="+id+"&op=conf",
		dataType: "json",
		success: function(data){
			d = data
		},
		error:function(d){
			alert(d.toSource());
		}
	});

	return d;
}

getConfsEvent = function(id){
	//alert(id);
	if(id=="")
		return null;
	$.ajax({
		url: "ajax/getConfsEvent.php",
		type: "POST",
		cache: false, 
		async: false,
		data: "id="+id,
		dataType: "json",
		success: function(data){
			d = data
		},
		error:function(d){
			alert(d.toSource());
		}
	});

	return d;
}

getTLEvent = function(id)
{
	//alert(id);
	if(id=="")
		return null;
	$.ajax({
		url: "ajax/getTLEvent.php",
		type: "POST",
		cache: false, 
		async: false,
		data: "id="+id,
		dataType: "json",
		success: function(data){
			d = data
		},
		error:function(d){
			alert(d.toSource());
		}
	});

	return d;
}


function isEmptyObject(obj) {
  for (var key in obj) {
    if (Object.prototype.hasOwnProperty.call(obj, key)) {
      return false;
    }
  }
  return true;
}

$(document).ready(function(){
	/*$( "#nuevas_ponencias" ).sortable({
		placeholder: "ui-state-highlight"
	});*/
})
