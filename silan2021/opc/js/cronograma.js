$(document).ready(function(e) {
    $(".div_casillero").click(function(event){
		input = $(this).find("a");
		if( input.not( event.target ).length ) {
        	input.trigger("click");
		}
	}).css("cursor","pointer");
});
