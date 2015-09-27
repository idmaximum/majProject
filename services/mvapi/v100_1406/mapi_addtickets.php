<?php

$connection = mysql_connect("10.121.128.10", "embassy", "embassy@2014");
mysql_query("SET NAMES 'utf8'");

$logExists = false;
$logTable = "";

if ($connection)
{
  $logTable = "log_vistaws_" . date('Y_m');

  $db = mysql_select_db("www_embassycineplex_com");
  $tableList = mysql_query("SHOW TABLES FROM www_embassycineplex_com WHERE Tables_in_www_embassycineplex_com LIKE '$logTable'");

  if (mysql_num_rows($tableList))
  {
  	$logExists = true;
  }
  else
  {
  	$createQuery = "CREATE TABLE  	`$logTable` (
								  `log_id` INT NOT NULL AUTO_INCREMENT ,
								  `date_time` DATETIME NOT NULL ,
								  `soap_process` VARCHAR( 100 ) DEFAULT NULL ,
								  `pincode` VARCHAR( 10 ) DEFAULT NULL ,
								  `transaction_ref_no` VARCHAR( 40 ) DEFAULT NULL ,										
								  `decision` VARCHAR( 20 ) DEFAULT NULL ,
								  `reason_code` VARCHAR( 5 ) DEFAULT NULL , 								  
								  `order_payment` VARCHAR( 20 ) DEFAULT NULL , 
								  `order_status` VARCHAR( 20 ) DEFAULT NULL ,
								  `cname` VARCHAR( 255 ) DEFAULT NULL ,
								  `email` VARCHAR( 100 ) DEFAULT NULL ,
								  `phone` VARCHAR( 15 ) DEFAULT NULL ,
								  `channel` VARCHAR( 5 ) DEFAULT NULL ,
								  `status` VARCHAR( 20 ) DEFAULT NULL ,								  
								  `addticket_status` VARCHAR( 20 ) DEFAULT NULL ,
								  `getsessionseat_status` VARCHAR( 20 ) DEFAULT NULL ,
								  `setselectedseat_status` VARCHAR( 20 ) DEFAULT NULL ,
								  `cancelorder_status` VARCHAR( 20 ) DEFAULT NULL ,
								  `payment_status` VARCHAR( 20 ) DEFAULT NULL ,
								  `completeorder_status` VARCHAR( 20 ) DEFAULT NULL ,								  
								  `amount` INT DEFAULT NULL ,
								  `theater` VARCHAR( 20 ) DEFAULT NULL ,
								  `movie` VARCHAR( 200 ) DEFAULT NULL ,
								  `show_time` DATETIME DEFAULT NULL ,
								  `session_id` VARCHAR( 15 ) DEFAULT NULL ,
								  `seat` VARCHAR( 100 ) DEFAULT NULL ,
								  `merchance_id` VARCHAR( 30 ) DEFAULT NULL ,
								  `user_session_id` VARCHAR( 30 ) DEFAULT NULL ,
								  `addticket_request` LONGTEXT DEFAULT NULL ,
								  `addticket_response` LONGTEXT DEFAULT NULL ,
								  `getsessionseat_request` LONGTEXT DEFAULT NULL ,
								  `getsessionseat_response` LONGTEXT DEFAULT NULL ,
								  `setselectedseat_request` LONGTEXT DEFAULT NULL ,
								  `setselectedseat_response` LONGTEXT DEFAULT NULL ,
								  `cancelorder_request` LONGTEXT DEFAULT NULL ,
								  `cancelorder_response` LONGTEXT DEFAULT NULL ,
								  `payment_request` LONGTEXT DEFAULT NULL ,
								  `payment_response` LONGTEXT DEFAULT NULL ,
								  `completeorder_request` LONGTEXT DEFAULT NULL ,
								  `completeorder_response` LONGTEXT DEFAULT NULL ,
								  `getprintstream_request` LONGTEXT DEFAULT NULL ,
								  `getprintstream_response` LONGTEXT DEFAULT NULL ,
								  PRIMARY KEY (`log_id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8";				
    
    $createSuccess = mysql_query($createQuery);

  	if ($createSuccess) 
  	{
  		$logExists = true;
  	}
  }
}

//mysql_close($connection);

$session_id = "";
$ticket_type = "";

$deviceOS = "";

//$clientClass = "WWW";
//$clientID = "111.111.111.112";
//$clientName = "WEB";

$clientClass = "WWW";
$clientID = "111.111.111.112";
$clientName = "WEB";

$userSessionClient = "WWW";

if ($_POST['session_id']) 
{
	$session_id = $_POST['session_id'];
}

if ($_GET['session_id']) 
{
	$session_id = $_GET['session_id'];
}

if ($_POST['ticket_type_list']) 
{
	$ticket_type = $_POST['ticket_type_list'];
}

if ($_GET['ticket_type_list']) 
{
	$ticket_type = $_GET['ticket_type_list'];
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

$ticketTypeArray = json_decode($ticket_type, true);
$ticketTypes = array();

foreach ($ticketTypeArray as $eachTicket) 
{
	$ticketTypes['TicketType'][] = array(	'TicketTypeCode'			=> $eachTicket['ticket_type_code'],
											'Qty'						=> $eachTicket['qty'],
											'PriceInCents'				=> $eachTicket['ticket_price'],
											'OptionalAreaCatSequence'	=> $eachTicket['areacat_code'],
											'BookingFeeOverride'		=> null,
											'LoyaltyRecognitionSequence'=> 0);
}

$wsdl = "http://10.121.130.25/WSVistaWebClient/TicketingService.asmx?WSDL"; 
$client = new SoapClient($wsdl, array('trace' => true)); 
	
list($usec, $sec) = explode(" ", microtime());

$userSessionID  = strval("01" . $userSessionClient . date('ymdHis', $sec) . str_pad(intval($usec * 1000), 3, '0', STR_PAD_LEFT) . str_pad(rand()%100000, 5, '0', STR_PAD_LEFT));
	
//echo "User Session ID : " . $userSessionID . "<br />";

$params = array(	'OptionalClientClass'			=> $clientClass,
					'OptionalClientId' 				=> $clientID, 
					'OptionalClientName'			=> $clientName,
					'UserSessionId'					=> $userSessionID,
					'CinemaId' 						=> "0000008001", 
					'SessionId'						=> $session_id,
					'TicketTypes'					=> $ticketTypes,
					'ReturnOrder'					=> true,
					'ReturnSeatData'				=> false,
					'ProcessOrderValue'				=> false,
					'UserSelectedSeatingSupported'	=> true,
					'SkipAutoAllocation'			=> false,
					'IncludeAllSeatPriorities'		=> false,
					'IncludeSeatNumbers' 			=> true,
					'ExcludeAreasWithoutTickets'	=> false,
					'ReturnDiscountInfo'			=> false,
					'BookingFeeOverride' 			=> null,
					'BookingMode'					=> 1,
					'ReorderSessionTickets'			=> false);

$result = $client->__soapCall('AddTickets', array($params));

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
$resultJSON['data']['input_string'] = $ticket_type;
$resultJSON['data']['input_json'] = $ticketTypeArray;
$resultJSON['data']['result'] = $result->Order;

echo json_encode($resultJSON);

//-------- -------- -------- -------- -------- -------- -------- --------

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
$addTicketResult = $result->Result;
$addTicketValueCents = strval(intval($result->Order->TotalValueCents)/100);
$addTicketRequest = json_encode($params);
$addTicketResponse = json_encode($result->Order->Sessions->Session->Tickets->Ticket);

if ($_POST['os']) 
{
	$clientName = strtoupper($_POST['os']);
}

if ($_GET['os']) 
{
	$clientName = strtoupper($_GET['os']);
}

if ($connection && $logExists) 
{
	$selectQuery = "SELECT showtime_Movie_strName AS movie, showtime_dtmDate_Time AS showtime, showtime_strName AS theatre FROM `www_embassycineplex_com`.`movie_showtimes` WHERE showtime_Session_strID = '$session_id'";
	$resultQuery = mysql_query($selectQuery);
	
	$resultMovie = "";
	$resultShowtime = "";
	$resultTheatre = "";

	while ($result = mysql_fetch_assoc($resultQuery))
	{
		$resultMovie = $result['movie'];
		$resultShowtime = $result['showtime'];
		$resultTheatre = $result['theatre'];
	}

	$insertQuery = "INSERT INTO  `www_embassycineplex_com`.`$logTable` (
					`log_id` ,
					`date_time` ,
					`soap_process` ,
					`pincode` ,
					`order_payment` , 
					`order_status` ,
					`cname` ,
					`email` ,
					`phone` ,
					`channel` ,
					`status` ,
					`amount` ,
					`theater` ,
					`movie` ,
					`show_time` ,
					`session_id` ,
					`seat` ,
					`merchance_id` ,
					`user_session_id` ,
					`addticket_request` ,
					`addticket_response` ,
					`getsessionseat_request` ,
					`getsessionseat_response` ,
					`setselectedseat_request` ,
					`setselectedseat_response` ,
					`cancelorder_request` ,
					`cancelorder_response` ,
					`payment_request` ,
					`payment_response` ,
					`completeorder_request` ,
					`completeorder_response`
					)
					VALUES (
					NULL ,  
					NOW(),  
					'AddTickets',  
					NULL,
					NULL,
					NULL,
					NULL,
					NULL,  
					NULL,  
					'$clientName',  
					'$addTicketResult',  
					'$addTicketValueCents',  
					'$resultTheatre',  
					'$resultMovie',  
					'$resultShowtime',  
					'$session_id',  
					'$ticketLists',  
					NULL,  
					'$userSessionID',  
					'$addTicketRequest',  
					'$addTicketResponse',  
					NULL,  
					NULL,  
					NULL,  
					NULL,  
					NULL,  
					NULL,  
					NULL,   
					NULL,  
					NULL,  
					NULL)";

	mysql_query($insertQuery);
}

mysql_close($connection);

?>