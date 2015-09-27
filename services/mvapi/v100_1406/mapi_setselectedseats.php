<?php

$session_id = "";
$user_session_id = "";
$selected_seats = "";

$deviceOS = "";

$clientClass = "WWW";
$clientID = "111.111.111.112";
$clientName = "WEB";

if ($_POST['session_id']) 
{
	$session_id = $_POST['session_id'];
}

if ($_GET['session_id']) 
{
	$session_id = $_GET['session_id'];
}

if ($_POST['user_session_id']) 
{
	$user_session_id = $_POST['user_session_id'];
}

if ($_GET['user_session_id']) 
{
	$user_session_id = $_GET['user_session_id'];
}

if ($_POST['selected_seats']) 
{
	$selected_seats = $_POST['selected_seats'];
}

if ($_GET['selected_seats']) 
{
	$selected_seats = $_GET['selected_seats'];
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

$selectedSeatsArray = json_decode($selected_seats, true);
$selectedSeats = array();

foreach ($selectedSeatsArray as $seat) 
{
	$selectedSeats['SelectedSeat'][] = array(	'AreaCategoryCode'	=> $seat['areacat_code'],
												'AreaNumber'		=> $seat['area_number'],
												'RowIndex'			=> $seat['row_index'],
												'ColumnIndex'		=> $seat['column_index']);
}

$params = array(	'OptionalClientClass'			=> $clientClass,
					'OptionalClientId' 				=> $clientID, 
					'OptionalClientName'			=> $clientName,
					'CinemaId'						=> "0000008001",
					'SessionId'						=> $session_id,
					'UserSessionId'					=> $user_session_id,
					'ReturnOrder'					=> true,
					'SelectedSeats'					=> $selectedSeats);

$wsdl = "http://10.121.130.25/WSVistaWebClient/TicketingService.asmx?WSDL"; 
$client = new SoapClient($wsdl, array('trace' => true)); 

$result = $client->__soapCall('SetSelectedSeats', array($params));

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
$resultJSON['data']['input_string'] = $selected_seats;
$resultJSON['data']['input_json'] = $selectedSeatsArray;
$resultJSON['data']['result'] = $result->Order;

echo json_encode($resultJSON);

$bestSeats = $result->Order->Sessions->Session->Tickets->Ticket;
$ticketList = array();

if (sizeof($bestSeats) > 1) 
{
	foreach ($bestSeats as $bestSeat) 
	{
		if (strlen($bestSeat->SeatData) > 0) 
		{
			$ticketList[] = $bestSeat->SeatData;
		}
	}
}
else
{
	$bestSeat = $bestSeats;

	if (strlen($bestSeat->SeatData) > 0) 
	{
		$ticketList[] = $bestSeat->SeatData;
	}
}

$ticketLists = implode(', ', $ticketList);

$setSeatResult = $result->Result;
$setSeatRequest = json_encode($params);
$setSeatResponse = json_encode($result->Order->Sessions->Session->Tickets->Ticket);

$connection = mysql_connect("10.121.128.10", "embassy", "embassy@2014");
mysql_query("SET NAMES 'utf8'");

$logExists = false;
$logTable = "";

if ($connection)
{
	$logTable = "log_vistaws_20" . substr($user_session_id, 5, 2) . "_" . substr($user_session_id, 7, 2);

  	$db = mysql_select_db("www_embassycineplex_com");
  	$updateQuery = "UPDATE `www_embassycineplex_com`.`$logTable` SET `soap_process` = CONCAT(`soap_process`, ', SetSelectedSeats'),
  																`status` = '$setSeatResult',
  																`seat` = '$ticketLists',
  																`setselectedseat_request` = '$setSeatRequest',
  																`setselectedseat_response` = '$setSeatResponse' 
  																WHERE user_session_id = '$user_session_id'";
	mysql_query($updateQuery);
}

mysql_close($connection);

?>