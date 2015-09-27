<?php

$connection = mysql_connect("10.100.101.236", "embassy", "embassy@2014");
mysql_query("SET NAMES 'utf8'");

if ($connection)
{
  $db = mysql_select_db("www_embassycineplex_com");
  
  $sessionList = mysql_query("SELECT SESSION_STRID FROM `www_embassycineplex_com`.`raw_GetMovieShowTimes`");
  
  $sessions = array();
  
  while ($eachSession = mysql_fetch_assoc($sessionList))
  {
  	$sessions[] = $eachSession;
  }

  foreach ($sessions as $session)
  {
  
  	echo $session['SESSION_STRID'] . "<br />";
  
	$wsdl = "http://10.100.101.146/WSVistaWebClient/DataService.asmx?WSDL"; 
	$client = new SoapClient($wsdl, array('trace' => true)); 

	$params = array('CinemaId' 									=> "0000000003", 
					'SessionId'									=> $session['SESSION_STRID'],
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
	$nMovie = 0;
	$movies = array();

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
		  $nMovie++;
		}
	
		if ($isInTable && $value['tag'] != 'TABLE')
		{
			if (array_key_exists('value', $value))
			{
			  $movies[$nMovie][$value['tag']] = $value['value'];
			}
			else
			{
			  $movies[$nMovie][$value['tag']] = $value['tag'];
			}
		}
	  }
	}
	
	foreach ($movies as $movie)
	{
	  echo $movie['PRICE_STRTICKET_TYPE_DESCRIPTION'] . "<br />";
	}
	//echo json_encode($movies);
	echo "<br /><br />";
  }
  
  mysql_close($connection);
}

?>
