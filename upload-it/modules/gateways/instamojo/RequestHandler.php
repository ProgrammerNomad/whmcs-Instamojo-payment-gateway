<?php
/**
# WHMCS Instamojo Module - Developed by Shiv Singh
# Author: Shiv Singh
# Email: shivsingh7150@hotmail.com
# Website: https://www.facebook.com/joinshiv
# Version: 1.1
**/

# Required File Includes
include("../../../init.php");
include("../../../includes/functions.php");
include("../../../includes/gatewayfunctions.php");
include("instamojo.php");     
$data = $_POST;
//print_r($data);
//echo "<br/>";
//error_reporting(0);
$gatewaymodule = "instamojo";
$gateway = getGatewayVariables($gatewaymodule);
//print_r($gateway);
//die();
$api_key = $gateway['privateapikey'];
$auth_token = $gateway['privateauthtoken'];
$purpose = $_POST['description'];
$amount = $_POST['amount'];
$buyer_name = $_POST['first_name'] . " " . $_POST['last_name'];
$email = $_POST['email'];
$phone = trim($_POST['phone']);
$send_email = $gateway['send_email'];
$redirect_url = $_POST['return_url'];
$webhook = $_POST['callback_url'];

//////////////////Payment Request//////////////

$api = new Instamojo($api_key, $auth_token);

try {
    $response = $api->paymentRequestCreate(array(
        "purpose" => $purpose,
        "amount" => $amount,
        "send_email" => $send_email,
		"buyer_name" => $buyer_name,
		"email" => $email,
		"phone" => "9999999999", // You can use $phone phone number should be only 10 digites
        "redirect_url" => $redirect_url,
		"webhook" => $webhook
        ));
   // print_r($response); //It can print all response of payment request
}
catch (Exception $e) {
    print('Error: ' . $e->getMessage()); ///Whos error if any
}
$get_url = $response['longurl'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="https://www.ruralserver.com/template/js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    window.setTimeout(function () {
        location.href = "<?=$get_url;?>?embed=form";
    }, 1000);
});
</script>
<title>Secure Checkout - Processing...</title>
<style type="text/css">
body {
	margin:0px;
	padding:0px;
	font-family:Verdana;
	font-size:13px;
	font-weight:normal;
	color:#333;
}
.main-content {
	margin-top:200px;
	text-align:center;
	font-weight:normal;
	font-size:14px;
}
a {
text-decoration:none;}
</style>
</head>
<body>
<div class="main-content">
  <p><img src="https://www.ruralserver.com/client/templates/six/img/logo.png" height="50" alt="Processing" border="0" /></p>
  <p><b>Please be patient while we are redirecting you to Payment Gateway.</b></p>
  <p><a href="<?=$get_url;?>?embed=form">Click Here</a> if not redirecting </p>
  <p>Do not "close the window" or press "refresh" or "browser back button".</p>
</div>
</body>
</html>
