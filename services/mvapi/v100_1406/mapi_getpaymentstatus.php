<?php

$user_session_id = "";

if ($_POST['user_session_id']) 
{
	$user_session_id = $_POST['user_session_id'];
}

if ($_GET['user_session_id']) 
{
	$user_session_id = $_GET['user_session_id'];
}

//-------- -------- -------- -------- -------- -------- -------- --------

$connection = mysql_connect("10.121.128.10", "embassy", "embassy@2014"); //!Qq73q3n
mysql_query("SET NAMES 'utf8'");

if ($connection)
{
	$logTable = "log_vistaws_20" . substr($user_session_id, 5, 2) . "_" . substr($user_session_id, 7, 2);

  	$db = mysql_select_db("www_embassycineplex_com");

  	$checkStatusQuery = "SELECT decision, order_status, order_payment, payment_status, pincode FROM `www_embassycineplex_com`.`$logTable` WHERE user_session_id = '$user_session_id'";
  	
	$resultQuery = mysql_query($checkStatusQuery);

	$result = "";

	while ($eachResult = mysql_fetch_assoc($resultQuery))
	{
		$result = $eachResult;
	}

	if (sizeof($result) > 0) 
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
}

mysql_close($connection);

?>