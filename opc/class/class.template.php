<?php
/*
*	ChangeLog:
*		:: Date Tue Apr 28, 2009
*		===========================================
*			:: The new property ($defaultCacheExpiryTime) has been added and represent the default expiry time to set
*				when caching templates.
*			:: A new parameter ($defaultExpiryTime) has been added to the constructor
*			:: A new public method (SetDefaultExpiryTime) has been added to this class and will set the default expiry time
*
*
*/
/**
* class AbsTemplate
*
* The Template Engine's base class.
*
* Features:
*     - set your own custom delimiters for variables to use inside template files,
*     - use any type of templates you want, that is, the template files can have any extension you want(be it .php, .inc, .tpl, etc...),
*     - display multiple templates per page,
*     - cache templates,
*     - assign the content of a template to a variable and, when appropriate, just display its content.
* 
* @package    AbsTemplate
* @category   Cache, Templates
* @author     Costin Trifan <costintrifan@yahoo.com>
* @copyright  2009 Costin Trifan
* @licence    MIT License http://en.wikipedia.org/wiki/MIT_License
* @version    1.0
* 
* Copyright (c) 2009 Costin Trifan <http://june-js.com/>
* 
* Permission is hereby granted, free of charge, to any person
* obtaining a copy of this software and associated documentation
* files (the "Software"), to deal in the Software without
* restriction, including without limitation the rights to use,
* copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the
* Software is furnished to do so, subject to the following
* conditions:
* 
* The above copyright notice and this permission notice shall be
* included in all copies or substantial portions of the Software.
* 
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
* OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
* FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
* OTHER DEALINGS IN THE SOFTWARE.
*/
class AbsTemplate 
{
	private function __clone(){}

# PROTECTED PROPERTIES
#======================

	protected 
		$tpl_dir = '',			# The name of the folder where the template files are supposed to be stored.
		$cache_dir = '',		# The name of the folder where the cached template files are supposed to be stored.
		$left_delimiter = '{',	# The left delimiter to use in the templates files to mark a template variable.
		$right_delimiter = '}',	# The right delimiter to use in the templates files to mark a template variable.
		$vars = array(),		# The class's variables array.
		$defaultCacheExpiryTime = 1; # Set the default templates' cache expiry time to 1 hour


# PUBLIC METHODS
#======================

	/**
	* Constructor. Setup class's variables.
	*
	* @param string $tplDir  The path to the templates folder.
	* @param string $cacheDir  The path to the folder that stores the cached files
	* @param string $lDelim  The left delimiter to use in the templates files to mark a template variable.
	* @param string $rDelim  The right delimiter to use in the templates files to mark a template variable.
	* @param int $defaultExpiryTime  The default templates' cache expiry time.
	* @return void
	*/
	public function __construct( $tplDir, $cacheDir, $lDelim='', $rDelim='', $defaultExpiryTime = NULL )
	{
		if (is_null($tplDir) or strlen($tplDir) < 1)
			exit('Error in <strong>'.__CLASS__.'::'.__FUNCTION__.'</strong> function. The path to the templates\' directory is missing!');

		if (is_null($cacheDir) or strlen($cacheDir) < 1)
			exit('Error in <strong>'.__CLASS__.'::'.__FUNCTION__.'</strong> function. The path to the templates\' cache directory is missing!');
		
		$this->SetTemplatesDirectory($tplDir);
		$this->SetCacheDirectory($cacheDir);
		$this->SetLeftDelimiter($lDelim);
		$this->SetRightDelimiter($rDelim);
		$this->SetDefaultExpiryTime($defaultExpiryTime);
	}

	public function SetDefaultExpiryTime( $defaultCacheExpiryTime = NULL )
	{
		if ( !is_null($defaultCacheExpiryTime) and is_int($defaultCacheExpiryTime) and $defaultCacheExpiryTime > 0)
			$this->defaultCacheExpiryTime = $defaultCacheExpiryTime;
	}

	/**
	* Set the path to the templates directory.
	*
	* @param string $tplDir  The path to the templates folder.
	* @return void
	*/
	public function SetTemplatesDirectory( $tplDir )
	{
		$this->tpl_dir = $tplDir;

		if (is_null($this->tpl_dir) or strlen($this->tpl_dir) < 1)
			exit('Error in <strong>'.__CLASS__.'::'.__FUNCTION__.'</strong> function. The path to the templates\' directory is missing!');

		if ( ! @is_dir($this->tpl_dir)) {
			exit('The specified template directory <strong>'.$this->tpl_dir.'</strong> was not found!');
			$this->tplDir = NULL;
		}
	}

	/**
	* Set the path to the templates' cache directory.
	*
	* @param string $cacheDir  The path to the templates' cache directory.
	* @return void
	*/
	public function SetCacheDirectory( $cacheDir )
	{
		$this->cache_dir = $cacheDir;

		if (is_null($this->cache_dir) or strlen($this->cache_dir) < 1)
			exit('Error in <strong>'.__CLASS__.'::'.__FUNCTION__.'</strong> function. The path to the templates\' cache directory is missing!');
		
		if ( ! @is_dir($this->cache_dir)) {
			exit('The specified cache directory <strong>'.$this->cache_dir.'</strong> was not found!');
			$this->cache_dir = NULL;
		}
	}

	/**
	* Set the left delimiter to use in the templates files to mark a template variable.
	*
	* @param string $delim  The left delimiter to use in the templates files to mark a template variable.
	* @return void
	*/
	public function SetLeftDelimiter( $delim )
	{
		if ( ! empty($delim))
			$this->left_delimiter = $delim;
	}

	/**
	* Set the right delimiter to use in the templates files to mark a template variable.
	*
	* @param string $delim  The right delimiter to use in the templates files to mark a template variable.
	* @return void
	*/
	public function SetRightDelimiter( $delim )
	{
		if ( ! empty($delim))
			$this->right_delimiter = $delim;
	}

	/**
	* Add a variable to the vars array. This variable will be replaced in a template.
	*
	* @param string $name  The name of the variable to store in the vars array.
	* @param mixed $value  The value of the variable.
	* @return void
	*/
	public function SetVar( $name, $value )
	{
		$this->vars[$name] = $value;
	}

	/**
	* Get a variable from the vars array.
	*
	* @param string $name  The name of the variable to retrieve from the vars array.
	* @return mixed
	*/
	public function GetVar( $name )
	{
		if (isset($this->vars[$name]) and !empty($this->vars[$name]))
			return $this->vars[$name];
		else return '';
	}

	/**
	* Delete all variables from the vars array.
	*
	* @return void
	*/
	public function ClearVars()
	{
		$this->vars = array();
	}

	/**
	* Get all variables from the vars array.
	*
	* @return array
	*/
	public function GetAllVars()
	{
		return $this->vars;
	}

	/**
	* Retrieve the content of a template.
	*
	* @param string $template  The name of the template file to load.
	* @param int $expires  The length of time, in hours, a file should be cached.
	*	Set to 'nocache' when you don't want to cache a template,
	* @return string  The template's html content.
	*/
	public function GetPage( $page, $expires=NULL )
	{
		// if $expires == 'nocache' the template's content will not be cached
		if ( !is_null($expires) and $expires == 'nocache')
		{
			return $this->Parse($page);
		}

		// if $expires > 0 , it will override the default expiry time
		// if $expires == null , the template's content will be cached using the default expiry time
		else
		{
			if ($expires > 0) // overide the default expiry time
				$_expires = ($expires *60*60) + time();
			else // use default expiry time
				$_expires = ($this->defaultCacheExpiryTime *60*60) + time();

			if ($this->IsCached($page))
			{
				if ($this->HasCacheExpired($page))
				{
					// cache the template again
					$content = $this->Parse($page);
					$this->CachePage($page,$content,$_expires);
					return $content;
				}
				// get cached template
				else return $this->GetCachedFile($page);
			}
			else {
				// cache template
				$content = $this->Parse($page);
				$this->CachePage($page,$content,$_expires);
				return $content;
			}
		}
	}

	/**
	* Outputs the template's html content.
	*
	* @param string $template  The name of the template file to load.
	* @return string  The template file's content.
	*/
	public function Display( $page )
	{
		if (!$template) {
			throw new Exception($this->NotFound());
		}
		echo $this->GetPage($page.".php",'nocache');
	}
	
	/**
		Return a html page when the template not found.
	*/
	private function NotFound(){
		echo "<h1 align='center'>P&aacute;gina no encontrada.</h1>";
	}
	
	/**
		Outputs a formated headers style or scripts html.
		@headers array
		@file type file to load
	*/
	public function setHeaders($headers,$file)
	{
		$html = "";
		if($file=="css")
		{
			$html .= '<link type="text/css" rel="stylesheet" href="estilos/global.css">' . PHP_EOL;
			$html .= '<link type="text/css" rel="stylesheet" href="estilos/custom.css">' . PHP_EOL;
			$html .= '<link type="text/css" rel="stylesheet" href="estilos/topnav.css">' . PHP_EOL;
			$html .= '<link type="text/css" rel="stylesheet" href="bootstrap/css/bootstrap.min.css">' . PHP_EOL;
			$html .= '<link type="text/css" rel="stylesheet" href="estilos/font-awesome.min.css">' . PHP_EOL;
			$html .= '<link type="text/css" rel="stylesheet" href="estilos/alertify.min.css">' . PHP_EOL;
			$html .= '<link type="text/css" rel="stylesheet" href="estilos/themes/default.min.css">' . PHP_EOL;

		}
		if($file=="js") {
			$html .= '<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>' . PHP_EOL;
			$html .= '<script type="text/javascript" src="js/alertify.min.js"></script>' . PHP_EOL;
			$html .= '<script type="text/javascript" src="js/global.js"></script>' . PHP_EOL;

		}
		if(count($headers)>0 && !empty($headers)) {
			foreach ($headers as $h => $type) {
				if ($type == "css" && $file == "css")
					$html .= '<link type="text/css" rel="stylesheet" href="' . $h . '">' . PHP_EOL;
				else if ($type == "js" && $file == "js")
					$html .= '<script type="text/javascript" src="' . $h . '"></script>' . PHP_EOL;
			}
		}
		return $html;
	}



# CACHING METHODS
#======================

	/**
	* Delete all templates from the cache directory.
	*
	* @return void
	*/
	public function EmptyCacheDirectory()
	{
		$files = $this->GetCachedFiles();
		if (count($files) > 0) {
			foreach ($files as $file)
				@unlink($this->cache_dir.DIRECTORY_SEPARATOR.$file);
		}
	}

	/**
	* Delete a cached template.
	*
	* @param string $fileNames  The name(s) of the file(s) to delete.
	* @return void
	*/
	public function DeleteCached(/*$fileName, $fileName,...*/)
	{
		$files = func_get_args();
		if (count($files) > 1) {
			foreach ($files as $file) {
				$_file = $this->cache_dir.DIRECTORY_SEPARATOR.$this->SetCacheFileName($file);
				if (@file_exists($_file)) @unlink($_file);
			}
		}
	}

	/**
	* Check to see if the specified file exists in the cache directory.
	*
	* @param string $fileName  The name of the file to check for existance.
	* @return boolean
	*/
	public function IsCached( $fileName )
	{
		if (empty($fileName)) return FALSE;
		
		$file = $this->cache_dir.DIRECTORY_SEPARATOR.$this->SetCacheFileName($fileName);
		return (file_exists($file) ? TRUE : FALSE);
	}

	/**
	* Get the specified cached file's expire time.
	* <code>
	*	echo date("l F,Y h:i:s", $tpl->GetCacheExpireTime('header.php'));
	* </code>
	* @param string $fileName  The name of the file.
	* @return string
	*/
	public function GetCacheExpireTime( $fileName )
	{
		$content = '';
		$lines = file($this->cache_dir.DIRECTORY_SEPARATOR.$this->SetCacheFileName($fileName));
		$expire_date = trim($lines[0]);
		$expire_date = substr($expire_date,1,-1);
		return $expire_date;
	}



# PROTECTED METHODS
#======================

	/**
	* Replaces the variables from the specified template file.
	*
	* @param string $template  The name of the template file to load.
	* @return string  The template file's content.
	*/
	protected function Parse( $template )
	{
		if (!$template) {
			throw new Exception($this->NotFound());
		}
		ob_start();
			@include_once $this->tpl_dir.'/'.$template.".php";
			$content = ob_get_contents();
		ob_end_clean();

		if (count($this->vars) > 0)
		{
			foreach($this->vars as $name=>$value)
			{
				if (is_string($value))
				{
					$var = $this->left_delimiter.$name.$this->right_delimiter;
					$content = str_ireplace($var, $value, $content);
				}
			}
		}
		return $content;
	}

	/**
	* Cache a template.
	*
	* @access protected
	* @param string $fileName  The name of the template to cache.
	* @param string $fileContent  The html/text content of the template file.
	* @param integer $expires In hours, the length of time the cached template should be kept in the cache folder.
	* @return void
	*/
	protected function CachePage( $fileName, $fileContent, $expires )
	{
		// Create a new cache
		$name = $this->SetCacheFileName($fileName);
		$_expires = '['.$expires.']'."\n";
		$html_content = htmlentities($fileContent, ENT_QUOTES, 'UTF-8');

		$h = fopen($this->cache_dir.DIRECTORY_SEPARATOR.$name,'w');
		fwrite($h,$_expires.$html_content,strlen($_expires.$html_content));
		fclose($h);
	}

	/**
	* Check to see whether or not a specified cached file has expired.
	*
	* @access protected
	* @param string $fileName  The name of the file.
	* @return boolean
	*/
	protected function HasCacheExpired( $fileName )
	{
		$file_expire_date = (int) $this->GetCacheExpireTime($fileName);
		return ($file_expire_date >= time()) ? FALSE : TRUE;
	}

	/**
	* Set the name for the file to be cached.
	*
	* @access protected
	* @param string $file  The name of the template.
	* @return string
	*/
	protected function SetCacheFileName( $file )
	{
		return md5($file);
	}

	/**
	* Get all files from the cache directory.
	* @access protected
	* @return array
	*/
	protected function GetCachedFiles()
	{
		$fileList = array();
		$fileCount = 0;

		if ($dir = @opendir($this->cache_dir))
		{
			while ($file = @readdir($dir))
			{
				array_push($fileList, $file);
				$fileCount++;
			}
			@closedir($dir);
		}
		return $fileList;
	}

	/**
	* Get the content of a cached file
	*
	* @access protected
	* @param string $file  The name of the template.
	* @return string
	*/
	protected function GetCachedFile( $file )
	{
		$content = '';
		$lines = file($this->cache_dir.DIRECTORY_SEPARATOR.$this->SetCacheFileName($file));
		$all_lines = count($lines);
		for ($i=1; $i < $all_lines; $i++) // << except the first line that holds the file's expire time
		{
			$content .= html_entity_decode($lines[$i],ENT_QUOTES,'UTF-8');
		}
		return $content;
	}
}
// >> END class
?>