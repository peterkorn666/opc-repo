$(document).ready(function(){
    $(".uploadFile").click(function(e){
        e.preventDefault();
        var target = $(this).data("target");
        if(target!=null)
            $("input[name='"+target+"']").click();
    })
    $("input[name='foto_inscripto']").change(function(){
        $(this).parent().find("a").html("Cargará el archivo<br><b>"+$(this).val()+"</b><br> (haga click aquí para cambiar de archivo)");
    })
	$("input[name='comprobante']").change(function(){
        $(this).parent().find("span").html("Tenga que en cuenta que si usted ya posee comprobante, lo sobreescribirá.<br> Cargará el archivo<br><b>"+$(this).val()+"</b>");
    })
})