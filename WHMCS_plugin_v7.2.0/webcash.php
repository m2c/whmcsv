<?php

function webcash_config() {
    $configarray = array(
     "FriendlyName" => array("Type" => "System", "Value"=>"Webcash"),
     "mcode" => array("FriendlyName" => "Merchant Code", "Type" => "text", "Size" => "20", ),
     "mkey" => array("FriendlyName" => "Merchant Key", "Type" => "text", "Size" => "20", ),
     "instructions" => array("FriendlyName" => "Payment Instructions", "Type" => "textarea", "Rows" => "5", "Description" => "Webcash", ),
     "testmode" => array("FriendlyName" => "Test Mode", "Type" => "yesno", "Description" => "Tick this to test", ),
    );
	return $configarray;
}

function webcash_link($params) {

	# Gateway Specific Variables
	$gatewaymcode = $params['mcode'];
	$gatewaymkey = $params['mkey'];
	$gatewaytestmode = $params['testmode'];

	# Invoice Variables
	$invoiceid = $params['invoiceid'] . '-' . uniqid();
	$description = $params["description"];
    $amount = $params['amount']; # Format: ##.##
    $currency = $params['currency']; # Currency Code

	# Client Variables
	$firstname = $params['clientdetails']['firstname'];
	$lastname = $params['clientdetails']['lastname'];
	$email = $params['clientdetails']['email'];
	$address1 = $params['clientdetails']['address1'];
	$address2 = $params['clientdetails']['address2'];
	$city = $params['clientdetails']['city'];
	$state = $params['clientdetails']['state'];
	$postcode = $params['clientdetails']['postcode'];
	$country = $params['clientdetails']['country'];
	$phone = $params['clientdetails']['phone'];

	# System Variables
	$companyname = $params['companyname'];
	$systemurl = $params['systemurl'];
	$currency = $params['currency'];
	
	# Payment Live URL or Test Mode URL
	if($gatewaytestmode){
		$payment_url = "https://uat.kiplepay.com/wcgatewayinit.php";
	} else {
		$payment_url = "https://kiplepay.com/wcgatewayinit.php";
	}

	# Enter your code submit to the gateway...

$strToHash = sha1($gatewaymkey . $gatewaymcode . $invoiceid . str_replace('.','',str_replace(',','',$amount)));
$today = date("F j, Y, g:i a");

$code = '
	<br><br><center>
<FORM method="post" name="ePayment" action="'. $payment_url .'">
  <INPUT type="hidden" name="ord_mercID" value="' . $gatewaymcode . '">
  <INPUT type="hidden" name="ord_date" value="' . $today . '">
  <INPUT type="hidden" name="ord_shipcountry" value="' . $country . '">
  <INPUT type="hidden" name="ord_mercref" value="' . $invoiceid . '">
  <INPUT type="hidden" name="ord_totalamt" value="' . $amount . '">  
  <input type="hidden" name="ord_gstamt" value="0.00" />  
  <INPUT type="hidden" name="Currency" value="MYR">
  <INPUT type="hidden" name="ProdDesc" value="' . $description . '">
  <INPUT type="hidden" name="ord_shipname" value="'. $firstname . ' ' . $lastname .'">
  <INPUT type="hidden" name="ord_email" value="' . $email . '">
  <INPUT type="hidden" name="ord_telephone" value="' . $phone . '">
  <INPUT type="hidden" name="Remark" value="' . $description . '">
  <INPUT type="hidden" name="Lang" value="UTF-8">
  <INPUT type="hidden" name="merchant_hashvalue" value="' . $strToHash . '">
  <INPUT type="hidden" name="ord_returnURL" value="http://*****/modules/gateways/callback/wccallback.php">
  <INPUT type="submit" value="Proceed with Payment" name="Submit">
</FORM><center>';

	return $code;
}




?>