<?php
if(!defined('INITIALIZED'))
 exit;
$paypal_report_url = 'http://www.ternya.net/paypal_report.php';
$paypal_return_url = 'http://www.ternya.net/?subtopic=shopsystem';
$paypal_image = 'https://www.ternya.net/en_US/i/btn/btn_donate_LG.gif';
$paypal_payment_type = '_xclick'; // '_xclick' (Buy Now) or '_donations'

$paypals[0]['mail'] = 'santarepara@gmail.com'; // your paypal login
$paypals[0]['name'] = '25 premium points on server www.ternya.net for 5.00 EURO';
$paypals[0]['money_amount'] = '5.00';
$paypals[0]['money_currency'] = 'EUR'; // USD, EUR, more codes: https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_currency_codes
$paypals[0]['premium_points'] = 33;

$paypals[1]['mail'] = 'santarepara@gmail.com'; // your paypal login
$paypals[1]['name'] = '50 premium points on server www.ternya.net for 10.00 EUR';
$paypals[1]['money_amount'] = '10.00';
$paypals[1]['money_currency'] = 'EUR'; // USD, EUR, more codes: ...
$paypals[1]['premium_points'] = 65;

$paypals[2]['mail'] = 'santarepara@gmail.com'; // your paypal login
$paypals[2]['name'] = '100 premium points on server www.ternya.net for 20.00 EUR';
$paypals[2]['money_amount'] = '20.00';
$paypals[2]['money_currency'] = 'EUR'; // USD, EUR, more codes: ...
$paypals[2]['premium_points'] = 130;