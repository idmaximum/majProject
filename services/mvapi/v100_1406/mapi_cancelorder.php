<?php

$user_session_id = "";

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

$params = array(	'OptionalClientClass'	=> $clientClass,
					'OptionalClientId' 		=> $clientID, 
					'OptionalClientName'	=> $clientName,
					'UserSessionId'			=> $user_session_id);

$wsdl = "http://10.121.130.25/WSVistaWebClient/TicketingService.asmx?WSDL"; 
$client = new SoapClient($wsdl, array('trace' => true)); 

$result = $client->__soapCall('CancelOrder', array($params));

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
//$resultJSON['data']['result'] = $result;

echo json_encode($resultJSON);

$cancelResult = $result->Result;
$cancelRequest = json_encode($params);
$cancelResponse = json_encode($result);

$connection = mysql_connect("10.121.128.10", "embassy", "embassy@2014");
mysql_query("SET NAMES 'utf8'");

$logExists = false;
$logTable = "";

if ($connection)
{
	$logTable = "log_vistaws_20" . substr($user_session_id, 5, 2) . "_" . substr($user_session_id, 7, 2);

  	$db = mysql_select_db("www_embassycineplex_com");
  	$updateQuery = "UPDATE `www_embassycineplex_com`.`$logTable` SET `soap_process` = CONCAT(`soap_process`, ', CancelOrder'),
  																`status` = '$cancelResult',
  																`cancelorder_request` = '$cancelRequest',
  																`cancelorder_response` = '$cancelResponse' 
  																WHERE user_session_id = '$user_session_id'";
	mysql_query($updateQuery);
}

mysql_close($connection);

?>