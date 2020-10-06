$(document).ready(function(e) {
	$(".tgl").eq(1).css("display","none");
	$(".tglbtn").click(function(){
    	$(".tgl").slideToggle("fast");
	})
	$("#loginbtn").click(function(){
        showLogin(false);
	})
    showLogin(true);
	
	$("#btn-reset-password").click(function(e){
		e.preventDefault()
		$(".tgl").hide();
		$("#reset-password").show();
	})
});

function showLogin(onload){
    var show = true;
    if(onload){
        show = true;
        if($('.alert').is(':visible'))
            show = false;
    }
    if(show) {
        $("#loginbtn").hide();
        $("#login-form").show();
        $("#loginsbm").show();
    }
}