<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $tpl->GetVar('page_title')?></title>
    <?php echo  $tpl->setHeaders($tpl->GetVar('headers'),"css");?>
</head>
<body>
<div id="container">
	<div id="banner"><img src="http://pediatria.gegamultimedios.net/images/banner.jpg" /></div>
    <div id="menu"></div>
<?php
	echo $data;
?>
</div>
<?php
echo $tpl->setHeaders($tpl->GetVar('headers'),"js");
?>
</body>
</html>