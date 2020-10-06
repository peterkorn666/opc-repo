<?PHP
/*********************************************************************************
 *       Filename: template.php
 *       Generated with CodeCharge 2.0.0
 *       PHP 4.0 & Templates build 10/09/2001
 *
 *       Usage:
 *       $tpl = new Template($app_path);
 *       $tpl->load_file($template_filename, "main");
 *       $tpl->set_var("ID", 2);
 *       $tpl->set_var("Value", "Name");
 *       $tpl->parse("DynBlock", false); // true if you want to create a list
 *
 *       $tpl->pparse("main", false); // parse and output block
 *                 OR
 *       $tpl->parse("main", false); // parse block
 *       $tpl->print_var("main");    // output block
 *********************************************************************************/

class Template
{

  var $sTemplate;
  var $DBlocks = array();       // initial data:files and blocks
  var $ParsedBlocks= array();   // resulted data and variables
  var $LangBlocks= array();   // lang data and variables
  var $templates_root;

  var $comienzoBloquePre;
  var $comienzoBloquePost;
  var $finBloquePre;
  var $finBloquePost;
  var $comienzoVariable;
  var $finVariable;
  
 
  function Template($templates_root,$comienzoBloquePre="<!--Begin",$comienzoBloquePost="-->",$finBloquePre="<!--End",$finBloquePost="-->",$comienzoVariable="{",$finVariable="}")
  {
    $this->templates_root = $templates_root;
	$this->comienzoBloquePre=$comienzoBloquePre;
	$this->comienzoBloquePost=$comienzoBloquePost;
	$this->finBloquePre=$finBloquePre;
	$this->finBloquePost=$finBloquePost;
	$this->comienzoVariable=$comienzoVariable;
	$this->finVariable=$finVariable;
  }

  function load_file($filename, $sName)
  {
    $nName = "";
    $template_path = $this->templates_root . "/" . $filename;
    if (file_exists($template_path))
    {
      $this->DBlocks[$sName] = join('',file($template_path));
      $nName = $this->NextDBlockName($sName);
      while($nName != "")
      {
        $this->SetBlock($sName, $nName);
        $nName = $this->NextDBlockName($sName);
      }
    }
  }

  function NextDBlockName($sTemplateName)
  {
    $sTemplate = $this->DBlocks[$sTemplateName];
    $BTag = strpos($sTemplate, $this->comienzoBloquePre);
    if($BTag === false)
    {
      return "";
    }
    else
    {
      $ETag = strpos($sTemplate, $this->comienzoBloquePost, $BTag);
      $sName = substr($sTemplate, $BTag + strlen($this->comienzoBloquePre), $ETag - ($BTag + strlen($this->comienzoBloquePre)));
      if(strpos($sTemplate, $this->finBloquePre . $sName . $this->finBloquePost) > 0)
      {
        return $sName;
      }
      else
      {
        return "";
      }
    }
  }


  function SetBlock($sTplName, $sBlockName)
  {  
    if(!isset($this->DBlocks[$sBlockName]))
      $this->DBlocks[$sBlockName] = $this->getBlock($this->DBlocks[$sTplName], $sBlockName);

    $this->DBlocks[$sTplName] = $this->replaceBlock($this->DBlocks[$sTplName], $sBlockName);

    $nName = $this->NextDBlockName($sBlockName);
    while($nName != "")
    {
      $this->SetBlock($sBlockName, $nName);
      $nName = $this->NextDBlockName($sBlockName);
    }
  }

  function getBlock($sTemplate, $sName)
  {
    $alpha = strlen($sName) + 12;

    $BBlock = strpos($sTemplate, $this->comienzoBloquePre . $sName . $this->comienzoBloquePost);
    $EBlock = strpos($sTemplate, $this->finBloquePre . $sName .  $this->finBloquePost);
    if($BBlock === false || $EBlock === false)
      return "";
    else
      return substr($sTemplate, $BBlock + $alpha, $EBlock - $BBlock - $alpha);
  }


  function replaceBlock($sTemplate, $sName)
  {
    $BBlock = strpos($sTemplate, $this->comienzoBloquePre . $sName .  $this->comienzoBloquePost);
    $EBlock = strpos($sTemplate, $this->finBloquePre . $sName . $this->finBloquePost);
    if($BBlock === false || $EBlock === false)
      return $sTemplate;
    else
      return substr($sTemplate,0,$BBlock) . $this->comienzoVariable . $sName . $this->finVariable . substr($sTemplate, $EBlock + strlen($this->finBloquePre . $sName . $this->finBloquePost));
  }

  function GetVar($sName)
  {
    return $this->DBlocks[$sName];
  }

  function set_var($sName, $sValue)
  {
    $this->ParsedBlocks[$sName] = $sValue;
  }
  
  function set_lang($sName, $sValue)
  {
    $this->LangBlocks[$sName] = $sValue;
  }

  function set_vars($arrNameValues)
  {
	foreach ( arrNameValues as $sName => $sValue ){
		$this->ParsedBlocks[$sName] = $sValue;
	}
  }
  
  function set_langs($arrNameValues)
  {
	foreach ( arrNameValues as $sName => $sValue ){
		$this->LangBlocks[$sName] = $sValue;
	}
  }

  function print_var($sName)
  {
    echo $this->ParsedBlocks[$sName];
  }

  function print_lang($sName)
  {
    echo $this->LangBlocks[$sName];
  }
  
  function parse($sTplName, $bRepeat)
  {
    if(isset($this->DBlocks[$sTplName]))
    {
      if($bRepeat && isset($this->ParsedBlocks[$sTplName]))
        $this->ParsedBlocks[$sTplName] = $this->ParsedBlocks[$sTplName] . $this->ProceedTpl($this->DBlocks[$sTplName]);
      else
        $this->ParsedBlocks[$sTplName] = $this->ProceedTpl($this->DBlocks[$sTplName]);
    }
    else
    {
      echo "<br/><b>El bloque <u><font color=\"red\">$sTplName</font></u> no existe</b><br/>";
    }
  }

  function pparse($block_name, $is_repeat)
  {
    $this->parse($block_name, $is_repeat);
    echo $this->ParsedBlocks[$block_name];
  }

  function rparse($block_name, $is_repeat)
  {
    $this->parse($block_name, $is_repeat);
    return $this->ParsedBlocks[$block_name];
  }

  function blockVars($sTpl,$beginSymbol,$endSymbol)
  {
    if(strlen($beginSymbol) == 0) $beginSymbol = $this->comienzoVariable;
    if(strlen($endSymbol) == 0) $endSymbol = $this->finVariable;
    $beginSymbolLength = strlen($beginSymbol);
    $endTag = 0;
    while (($beginTag = strpos($sTpl,$beginSymbol,$endTag)) !== false)
    {
      if (($endTag = strpos($sTpl,$endSymbol,$beginTag)) !== false)
      {
        $vars[] = substr($sTpl, $beginTag + $beginSymbolLength, $endTag - $beginTag - $beginSymbolLength);
      }
    }
    if(isset($vars)) return $vars;
    else return false;
  }

  function ProceedTpl($sTpl)
  {
    $vars = $this->blockVars($sTpl,$this->comienzoVariable,$this->finVariable);
    if($vars)
    {
      reset($vars);
      while(list($key, $value) = each($vars))
      {
        if(preg_match("/^[\w\.\_][\w\.\_]*$/",$value)) { // if(preg_match("/^[\w\_][\w\_]*$/",$value)) {
          if(isset($this->ParsedBlocks[$value]))
            $sTpl = str_replace($this->comienzoVariable.$value.$this->finVariable,$this->ParsedBlocks[$value],$sTpl);
          else if(isset($this->DBlocks[$value]))
            $sTpl = str_replace($this->comienzoVariable.$value.$this->finVariable,$this->DBlocks[$value],$sTpl);
          else
            $sTpl = str_replace($this->comienzoVariable.$value.$this->finVariable,"",$sTpl);
		} 
      } 
    }
	
    $vars = $this->blockVars($sTpl,"#.",".#");
    if($vars)
    {
      reset($vars);
      while(list($key, $value) = each($vars))
      {
        if(preg_match("/^[\w\.\_][\w\.\_]*$/",$value)) { // if(preg_match("/^[\w\_][\w\_]*$/",$value)) {
          if(isset($this->LangBlocks[$value]))
            $sTpl = str_replace("#.".$value.".#",$this->LangBlocks[$value],$sTpl);          
		  else
            $sTpl = str_replace("#.".$value.".#","",$sTpl);
		} 
      } 
    }
    return $sTpl;
  }


  function PrintAll()
  {
    $res = "<table border=\"1\" width=\"100%\">";
    $res .= "<tr bgcolor=\"#C0C0C0\" align=\"center\"><td>Key</td><td>Value</td></tr>";
    $res .= "<tr bgcolor=\"#FFE0E0\"><td colspan=\"2\" align=\"center\">ParsedBlocks</td></tr>";
    reset($this->ParsedBlocks);
    while(list($key, $value) = each($this->ParsedBlocks))
    {
      $res .= "<tr><td><pre>" . htmlspecialchars($key) . "</pre></td>";
      $res .= "<td><pre>" . htmlspecialchars($value) . "</pre></td></tr>";
    }
    $res .= "<tr bgcolor=\"#E0FFE0\"><td colspan=\"2\" align=\"center\">DBlocks</td></tr>";
    reset($this->DBlocks);
    while(list($key, $value) = each($this->DBlocks))
    {
      $res .= "<tr><td><pre>" . htmlspecialchars($key) . "</pre></td>";
      $res .= "<td><pre>" . htmlspecialchars($value) . "</pre></td></tr>";
    }
    $res .= "</table>";
    return $res;
  }

}

?>
