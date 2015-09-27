<?php

$user_session_id = "";
$value_in_cents = 0;
$email = "user@mail.com";
$phone = "0123456789";
$name = "user";

$deviceOS = "";

$clientClass = "WWW";
$clientID = "111.111.111.112";
$clientName = "WEB";

if ($_POST['user_session_id']) 
{
	$user_session_id = $_POST['user_session_id'];
}

if ($_GET['user_session_id']) 
{
	$user_session_id = $_GET['user_session_id'];
}

if ($_POST['value_in_cents']) 
{
	$value_in_cents = intval($_POST['value_in_cents']);
}

if ($_GET['value_in_cents']) 
{
	$value_in_cents = intval($_GET['value_in_cents']);
}

if ($_POST['email']) 
{
	$email = $_POST['email'];
}

if ($_GET['email']) 
{
	$email = $_GET['email'];
}

if ($_POST['phone']) 
{
	$phone = $_POST['phone'];
}

if ($_GET['phone']) 
{
	$phone = $_GET['phone'];
}

if ($_POST['name']) 
{
	$name = $_POST['name'];
}

if ($_GET['name']) 
{
	$name = $_GET['name'];
}

//-------- -------- -------- -------- -------- -------- -------- --------

if ($_POST['os']) 
{
	$deviceOS = $_POST['os'];
}

if ($_GET['os']) 
{
	$deviceOS = $_GET['os'];
}

$deviceOS = "";

if (strlen($deviceOS) > 0) 
{
	if (strtolower($deviceOS) == "ios") 
	{
		$clientClass = "Cell";
		$clientID = "111.111.111.152";
		$clientName = "IOS";
		$userSessionClient = "IOS";
	}
	else
	{
		$clientClass = "Cell";
		$clientID = "111.111.111.133";
		$clientName = "ANDROID";
		$userSessionClient = "AND";
	}
}

$paymentInfo = array(	'PaymentValueCents'			=> $value_in_cents,
						'BillFullOutstandingAmount'	=> false,
						'UseAsBookingRef'			=> false,
						'PaymentStatus'				=> "Y",
						'BillingValueCents'			=> $value_in_cents,
						'CardBalance'				=> 0,
						'SaveCardToWallet'			=> false);

$paymentInfoCollection = array();

$paymentInfoCollection['PaymentInfo'][] = array(	'CardNumber'				=> "1234567890",
													'CardType'					=> "Credit",
													'PaymentValueCents'			=> $value_in_cents,
													'PaymentTenderCategory'		=> "CREDIT",
													'BillFullOutstandingAmount'	=> false,
													'UseAsBookingRef'			=> false,
													'PaymentStatus'				=> "Y",
													'BillingValueCents'			=> $value_in_cents,
													'CardBalance'				=> 0,
													'BankReference'				=> "7778888",
													'SaveCardToWallet'			=> false);

$passTypeRequest = array(	'IncludeApplePassBook'	=> false,
							'IncludeICal'			=> false);

$params = array(	'OptionalClientClass'					=> $clientClass,
					'OptionalClientId' 						=> $clientID, 
					'OptionalClientName'					=> $clientName,
					'UserSessionId'							=> $user_session_id,
					'PaymentInfo'							=> $paymentInfo,
					'PaymentInfoCollection'					=> $paymentInfoCollection,
					'PerformPayment'						=> false,
					'CustomerEmail'							=> $email,
					'CustomerPhone'							=> $phone,
					'CustomerName'							=> $name,
					'GeneratePrintStream'					=> false,
					'ReturnPrintStream' 					=> true,
					'UnpaidBooking'							=> true,
					'PrintTemplateName'						=> "INTERMEC-PF8T",
					'OptionalReturnMemberBalances'			=> false,
					'BookingMode'							=> 1,
					'PrintStreamType'						=> null,
					'GenerateConcessionVoucherPrintStream'	=> false,
					'PassTypesRequestedForOrder'			=> $passTypeRequest,
					'UseAlternateLanguage'					=> false);

$wsdl = "http://10.121.130.25/WSVistaWebClient/TicketingService.asmx?WSDL"; 
$client = new SoapClient($wsdl, array('trace' => true)); 

$result = $client->__soapCall('CompleteOrder', array($params));

if ($result->Result == "OK") 
{
$resultJSON['result'] = "OK";
$resultJSON['code'] = "000";
}
else
{
$resultJSON['result'] = "ERROR";
$resultJSON['code'] = "002";
}

$resultJSON['version'] = "1.00";
$resultJSON['date_time'] = date('Y-m-d H:i:s');
$resultJSON['data']['result'] = $result;

echo json_encode($resultJSON);

$completeOrderData = json_decode(json_encode($result), true);
unset($completeOrderData['PrintStream']);
unset($completeOrderData['PrintStreamCollection']);

$completeOrderResult = $result->Result;
$completeOrderPinCode = $result->VistaBookingNumber;
$completeOrderRequest = json_encode($params);
$completeOrderResponse = json_encode($completeOrderData);

$connection = mysql_connect("10.121.128.10", "embassy", "embassy@2014");
mysql_query("SET NAMES 'utf8'");

$logExists = false;
$logTable = "";

if ($connection)
{
	$logTable = "log_vistaws_20" . substr($user_session_id, 5, 2) . "_" . substr($user_session_id, 7, 2);

  	$db = mysql_select_db("www_embassycineplex_com");
  	$updateQuery = "UPDATE `www_embassycineplex_com`.`$logTable` SET `soap_process` = CONCAT(`soap_process`, ', GetSessionSeatData'),
  																`pincode` = $completeOrderPinCode,
  																`order_payment` = 'BOOKING',
  																`order_status` = 'SUCCESS',
  																`cname` = '$name',
  																`email`	= '$email',
  																`phone` = '$phone',
  																`status` = '$completeOrderResult',
  																`completeorder_request` = '$completeOrderRequest',
  																`completeorder_response` = '$completeOrderResponse' 
  																WHERE user_session_id = '$user_session_id'";
	mysql_query($updateQuery);

	$homepage = file_get_contents('http://10.121.128.11/getUserIDToSendMail?user_session_id=' . $user_session_id);
}

mysql_close($connection);

?>