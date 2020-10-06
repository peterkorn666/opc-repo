<?php
class Lang
{
	var $lang;
	function __construct($idioma)
	{
		if($idioma=="")
			$this->lang = "es";
		else
			$this->lang = $idioma;
		return $this->setLang();
	}
	
	function setLang()
	{
		return $this->lang;
	}
	
	
}
?>