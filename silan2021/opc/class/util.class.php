<?php
class Util{
	public function isLogged(){
		if(!$_SESSION["usuario"]){
			header("Location: /opc/");
			die();
		}
	}
}
?>