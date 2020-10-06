<?php
session_start();
?>
<h1 align="center">Redirecting to Paypal.com</h1>
<form name="pform" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">

<input type="hidden" name="cmd" value="_xclick">

<input type="hidden" name="business" value="">

<input type="hidden" name="lc" value="AL">

<input type="hidden" name="item_name" value="SUL 2016 Registration">

<input type="hidden" name="button_subtype" value="services">

<input type="hidden" name="no_note" value="0">

<input type="hidden" name="cn" value="Dar instrucciones especiales al vendedor:">

<input type="hidden" name="no_shipping" value="1">

<input type="hidden" name="rm" value="1">

<input type="hidden" name="return" value="http://ovinos.congresos-rohr.info/psuccess.php">

<input type="hidden" name="cancel_return" value="http://ovinos.congresos-rohr.info/pcancel.php">

<input type="hidden" name="currency_code" value="USD">
<input type="hidden" id="custom" name="custom" value="<?=base64_encode($_SESSION["inscripcion"]["id_inscripto"])?>"/>
<input type="hidden" value="<?=str_pad($_SESSION["inscripcion"]["inp_valor_total"], strlen($_SESSION["inscripcion"]["inp_valor_total"])+3, ".00")?>" name="amount">

<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">

</form>
<!--
<form name="pform" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">

<input type="hidden" name="cmd" value="_xclick">

<input type="hidden" name="business" value="gabrielarohr1@gmail.com">

<input type="hidden" name="lc" value="AL">

<input type="hidden" name="item_name" value="ICRAV Registration">

<input type="hidden" name="button_subtype" value="services">

<input type="hidden" name="no_note" value="0">

<input type="hidden" name="cn" value="Dar instrucciones especiales al vendedor:">

<input type="hidden" name="no_shipping" value="1">

<input type="hidden" name="rm" value="1">

<input type="hidden" name="return" value="http://gegamultimedios.net/icrav/psuccess.php">

<input type="hidden" name="cancel_return" value="http://gegamultimedios.net/icrav/pcancel.php">

<input type="hidden" name="currency_code" value="USD">
<input type="hidden" id="custom" name="custom" value="<?=base64_encode($_SESSION["inscripcion"]["id_inscripto"])?>"/>
<input type="hidden" value="<?=str_pad($_SESSION["inscripcion"]["inp_valor_total"], strlen($_SESSION["inscripcion"]["inp_valor_total"])+3, ".00")?>" name="amount">

<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">

</form>-->


<script type="text/javascript">
window.onload=function(){
document.forms["pform"].submit();
}
</script>