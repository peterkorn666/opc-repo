<?PHP
//PHP 4.2.x Compatibility function
if (!function_exists('file_get_contents')) {
      function file_get_contents($filename, $incpath = false, $resource_context = null)
      {

          if (false === $fh = fopen($filename, 'rb', $incpath)) {
              echo('file_get_contents() failed to open stream: No such file or directory ' . $filename);
              return false;
          }
 
          if ($fsize = @filesize($filename)) {
              $data = fread($fh, $fsize);
          } else {
              $data = '';
              while (!feof($fh)) {
                  $data .= fread($fh, 8192);
              }
          }
  
          fclose($fh);

          return $data;
      }
  }
  
      
if (!function_exists('file_put_contents')) {
    function file_put_contents($filename, $data) {
        $f = fopen($filename, 'w');
        if (!$f) {
            return false;
        } else {
            $bytes = fwrite($f, $data);
            fclose($f);
            return $bytes;
        }
    }
}

if (!function_exists('set_include_path'))
{
    function set_include_path($new_include_path)
    {
        return ini_set('include_path', $new_include_path);
    }
}


if (!function_exists('get_include_path'))
{
    function get_include_path()
    {
        return ini_get('include_path');
    }
}


?>