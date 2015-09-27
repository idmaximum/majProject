<?php

$session_id = "";

if ($_POST['session_id']) 
{
	$session_id = $_POST['session_id'];
}

if ($_GET['session_id']) 
{
	$session_id = $_GET['session_id'];
}

$wsdl = "http://10.121.130.25/WSVistaWebClient/DataService.asmx?WSDL"; 
$client = new SoapClient($wsdl, array('trace' => true)); 

$params = array('CinemaId' 									=> "0000008001", 
				'SessionId'									=> $session_id,
				'OptionalLoyaltyTicketMatchesHOCode'		=> false,
				'OptionalShowNonATMTickets'					=> false,
				'OptionalReturnAllRedemptionAndCompTickets'	=> false,
				'OptionalReturnAllLoyaltyTickets'			=> false,
				'OptionalReturnLoyaltyRewardFlag'			=> false,
				'OptionalSeparatePaymentBasedTickets'		=> false,
				'OptionalShowLoyaltyTicketsToNonMembers' 	=> false,
				'OptionalEnforceChildTicketLogic'			=> false,
				'OptionalIncludeZeroValueTickets'			=> false);

$result = $client->__soapCall('GetTicketTypeList', array($params));

$parser = xml_parser_create();
xml_parse_into_struct($parser, $result->DatasetXML, $values, $index);
xml_parser_free($parser);

$isInTable = false;
$nTicket = 0;
$tickets = array();

foreach ($values as $value)
{
	if ($value['type'] == 'open' || $value['type'] == 'close' || $value['type'] == 'complete')
	{
		if ($value['tag'] == 'TABLE' && $value['type'] == 'open')
		{
			$isInTable = true;
		}
		if ($value['tag'] == 'TABLE' && $value['type'] == 'close')
		{
		  	$isInTable = false;
		  	$nTicket++;
		}

		if ($isInTable && $value['tag'] != 'TABLE')
		{
			if (array_key_exists('value', $value))
			{
				$tickets[$nTicket][$value['tag']] = $value['value'];
			}
			else
			{
				$tickets[$nTicket][$value['tag']] = $value['tag'];
			}
		}
	}
}

$ticketTypes = array();

foreach ($tickets as $ticket) 
{
	$ticketType['areacat_code'] = $ticket['AREACAT_STRCODE'];
	$ticketType['areacat_description'] = $ticket['AREACAT_STRDESC'];
	$ticketType['ticket_type_code'] = $ticket['PRICE_STRTICKET_TYPE_CODE'];
	$ticketType['ticket_description'] = $ticket['PRICE_STRTICKET_TYPE_DESCRIPTION'];
	$ticketType['ticket_price'] = $ticket['PRICE_INTTICKET_PRICE'];
	$ticketType['ticket_category'] = $ticket['TICKETCATEGORY'];

	preg_match('/\d+/', $ticket['PRICE_STRTICKET_TYPE_DESCRIPTION'], $matches);

	if ($matches) 
	{
		$ticketType['number_of_seat'] = $matches[0];
	}	
	else
	{
		$ticketType['number_of_seat'] = "1";
	}

	$ticketTypes[] = $ticketType;
}

if (sizeof($tickets) > 0) 
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
$resultJSON['data']['ticket_type'] = $ticketTypes;

echo json_encode($resultJSON);

?>