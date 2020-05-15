<?php

# Required File Includes
include "../../../init.php";
include("../../../includes/functions.php");
include("../../../includes/gatewayfunctions.php");
include("../../../includes/invoicefunctions.php");

$gatewaymodule = "webcash"; # Enter your gateway module name here replacing template
$yourdomain = "https://*****/clientarea.php?action=invoices"; # Replace **** with your domain name

$GATEWAY = getGatewayVariables($gatewaymodule);

$gatewaymcode = $params['mcode'];
$gatewaymkey = $params['mkey'];
if (!$GATEWAY["type"]) die("Module Not Activated"); # Checks gateway module is active before accepting callback

# Get Returned Variables
$status = $_REQUEST["returncode"];
$invoiceid = $_REQUEST["ord_mercref"];
$transid = $_REQUEST["wcID"];
$amount = $_REQUEST["ord_totalamt"];
$fee = 0 ;

$MerchantCode = $_POST["MerchantCode"];
$RefNo = $_POST["RefNo"];
$Amount = $_POST["Amount"];

  if($transid != ''){
  checkCbTransID($transid); # Checks transaction number isn't already in the database and ends processing if it does  */
  }

$returncode = $_REQUEST['returncode'];

$HashAmount = str_replace(".","",str_replace(",","",$_REQUEST['ord_totalamt']));
$returnHashKey = sha1($GATEWAY['mkey'] . $_REQUEST['ord_mercID'] . $_REQUEST['ord_mercref'] . $HashAmount . $returncode);

if($returncode=='100' && $_REQUEST['ord_key'] == $returnHashKey && $transid != ''){
  # Successful
  addInvoicePayment($invoiceid,$transid,$amount,$fee,$gatewaymodule);
  logTransaction($GATEWAY["name"],$_POST,"Successful");
  echo '<p>Payment success ! redirecting to home page ....</p>';
}	else if($returncode=='E1' || $returncode=='E2' || $transid = ''){
    # Unsuccessful
    logTransaction($GATEWAY["name"],$_POST,"Unsuccessful");
	 echo '<p>Payment failed or aborted ! redirecting to home page ....</p>';
} else {
  # Unsuccessful
  logTransaction($GATEWAY["name"],$_POST,"Unsuccessful");
  echo '<p>Payment failed ! redirecting to home page ....</p>';
}
?>
<script>
function gogo(){
  window.location.href="<?php echo $yourdomain ?>"; 
}
setTimeout("gogo()",3000);
</script>