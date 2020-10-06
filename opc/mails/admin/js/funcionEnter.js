// JavaScript Document
function EnterPulsado(e){
	var characterCode
	if(e && e.which){
		e = e
		characterCode = e.which
	}else{
		characterCode = e.keyCode
	}
	if(characterCode == 13){		
		return true;
	}else{
		return false;
	}
}