/**
 * Created by Cristian on 28/03/2016.
 */

$(document).ready(function(){
    $(".uploadFile").click(function(e){
        e.preventDefault();
        var target = $(this).data("target");
        if(target!=null)
            $("input[name='"+target+"']").click();
    })
    $("input[name='foto_conferencista']").change(function(){
        $(this).parent().find("a").last().html("Cargará el archivo<br><b>"+$(this).val()+"</b> (haga click aquí para cambiar de archivo)");
    })
    $("input[name='presentacion']").change(function(){
        $(this).parent().find("a").last().html("Cargará el archivo <b>"+$(this).val()+"</b> (haga click aquí para cambiar de archivo)");
    })
	
	$("input[name='archivo_cv']").change(function(){
        $(this).parent().find("a").last().html("Cargará el archivo <b>"+$(this).val()+"</b> (haga click aquí para cambiar de archivo)");
    })
	$(".eliminar_presentacion").click(function(e){
		e.preventDefault();
		$("input[name='presentacion_viejo']").val("");
		alert("Guarde para completar");
		$(this).remove();
	})
	
	$(".eliminar_cv").click(function(e){
		e.preventDefault();
		$("input[name='archivo_cv_viejo']").val("");
		alert("Guarde para completar");
		$(this).remove();
	})
	$("#nuevo-conferencista").click(function(){
		$("#div-conferencista input:not([type='submit']):not([type='radio']):not([type='checkbox']), select").val('');
		$("#div-conferencista").show();
	})
})