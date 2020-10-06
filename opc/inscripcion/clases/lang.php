<?php

class Language{

	private $UserLng;
	private $langSelected;
	public $set = array();

	public function __construct($userLanguage){
		$this->UserLng = $userLanguage;
		$langFile = dirname(__DIR__).'/langs/'. $this->UserLng . '.ini';
		if(!file_exists($langFile)){
			$langFile =  dirname(__DIR__).'/inscripcion/langs/es.ini';
		}
	
		$this->set = parse_ini_file($langFile, true);
	}

	public function userLanguage(){
		return $this->set;
	}
	
	public function getValue($txt,$pos=0)
	{
		$txt = explode("=>",$txt);
		return trim($txt[$pos]);
	}
	
	public function generarClave($cantidad){
		$pattern = "123456789123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		for($i=0;$i<$cantidad;$i++){
			$pass .= $pattern{rand(0,35)};
		}
		return $pass;
	}

}
?>