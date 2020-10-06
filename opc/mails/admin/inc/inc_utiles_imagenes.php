<?PHP
include("lib-swf.inc.php");

function mostrarImagen($imagen,$anchoMaximo,$altoMaximo,$anchoActual=0,$altoActual=0,$border=0,$otrosAtributos="")
{
        $resultado="";
        if (file_exists($imagen)) {
                $tip = strtolower(substr($imagen, -3));
                $medidas=resize($imagen,$anchoMaximo,$altoMaximo,$anchoActual,$altoActual);
                if ($medidas) {
                        switch($tip){
                                case "gif":
                                        $resultado = '<img src="'.$imagen.'" border="'. $border . '" width="' . $medidas[0]. '" height="' . $medidas[1]. '"' .$otrosAtributos . '>';
                                        break;
                                case "jpg":
                                        $resultado = '<img src="'.$imagen.'" border="'. $border . '" width="' . $medidas[0]. '" height="' . $medidas[1]. '"' .$otrosAtributos . '>';
                                        break;
                                case "swf":
                                        $resultado = mostrarFlash($imagen,$medidas[0],$medidas[1]);
                                        break;
                        } // switch)
                }
        }
        return $resultado;
}

function mostrarFlash($swf,$width,$height) {
                        if ($fp = @fopen($swf, "rb"))
                        {
                                $archivoSWF = @fread($fp, @filesize($swf));
                                @fclose ($fp);
                                $medidas = phpAds_SWFDimensions($archivoSWF);
                                $version= phpAds_SWFVersion($archivoSWF);
                        }
                  $rflash="";
          $rflash.="\n<OBJECT ID=1  classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://active.macromedia.com/flash2/cabs/swflash.cab#version=4,0,0,0\" WIDTH=$width HEIGHT=$height>";
          $rflash.= "<PARAM NAME=movie VALUE=$swf> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#FFFFFF>";
          $rflash.= "<EMBED $swf quality=high bgcolor=#FFFFFF WIDTH=$width HEIGHT=$height swLiveConnect=true  TYPE=\"application/x-shockwave-flash\" PLUGINSPAGE=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\"></EMBED>";
          $rflash.= "</OBJECT>";
          return $rflash;
}

function medir($imagen) {
        $medidas=false;
        $tip = strtolower(substr($imagen, -3));
        if ($tip == "swf") {
                if ($fp = @fopen($imagen, "rb"))
                {
                        $archivoSWF = @fread($fp, @filesize($imagen));
                        @fclose ($fp);
                        $medidas = phpAds_SWFDimensions($archivoSWF);
                }
        }
        else
        {
		$imgg=null;
                if ($tip == "gif")
			if (function_exists("imagecreatefromgif")) {
	                        $imgg = @imagecreatefromgif($imagen);
			}
                elseif ($tip == "jpg")
			if (function_exists("imagecreatefromjpeg")) {
	                        $imgg = @imagecreatefromjpeg($imagen);
			}
                if ($imgg)
                {
                        $ancho = imagesx($imgg);
                        $alto  = imagesy($imgg);
                        $medidas=array($ancho,$alto);
                }
        }
        return $medidas;
}

function resize($imagen,$anchoMaximo,$altoMaximo,$anchoActual=0,$altoActual=0)
{
        if ($anchoActual*$altoActual==0) {
                $medidas=medir($imagen);
        }
        else
        {
                $medidas=array($anchoActual,$altoActual);
        }

        if ($medidas) {
                $rWidth=$medidas[0];
                $rHeight=$medidas[1];
                if ($anchoMaximo*$altoMaximo!=0) {
                     $escala = min($anchoMaximo/$rWidth, $altoMaximo/$rHeight);
                } elseif ($anchoMaximo!=0) {
                     $escala = $anchoMaximo/$rWidth;
                } elseif ($altoMaximo!=0) {
                     $escala = $altoMaximo/$rHeight;
                } else {
                     $escala = 0;
                }
                if ($escala < 1)
                {
                        $rWidth = floor($escala*$rWidth);
                        $rHeight = floor($escala*$rHeight);
                }
                return array($rWidth,$rHeight);
        }
        else
        {
                return array($anchoMaximo,$altoMaximo);
        }
}

?>