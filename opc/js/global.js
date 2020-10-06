/**
 * Created by Hansz on 1/4/2016.
 */
$(document).ready(function(){
    $('#topmenu').click(function(e){
        e.preventDefault();
        $('#panel').slideToggle('fast');
    })
    $('.delete').click(function(){
        if(!confirm('Desea eliminar este registro? Se eliminarán todos los datos asociados a este.'))
            return false;
    })
})

function selectOption(name, value){
	$(name).filter(function(i, e) { return $(this).text() == value}).prop('selected', true);
}

function limpiarCampos(){
	$(".divTrabajos:last input[type='text'],.divTrabajos:last input[type='select']").val("");
	$(".divTrabajos:last input[type='checkbox']").attr("checked",false);
	$(".divTrabajos:last input[type='radio']").attr("checked",false);
}

$(document).ready(function(e) {
	$(".limpiar").click(function(){
		$("input[type='text'],input[type='select']").val("");
		$("input[type='checkbox']").attr("checked",false);
		$("input[type='radio']").attr("checked",false);
	})
	
	$(".btnlogin a").click(function(e){
		e.preventDefault();
		$(".lgnhidden").show();
		$(".btnlogin").hide();
	})
});