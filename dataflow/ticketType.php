<html>
<head></head>
<body>

<?php 

echo "Movie : " . $_POST['movie_name'] . "<br />";
echo "Time : " . date('d M Y, H:i:s', strtotime($_POST['date_time'])) . "<br />";
echo "Session : " . $_POST['session_id'] . "<br />";
echo $_POST['theatre'] . "<br />--------------------------------<br /><br />";

$wsdl = "http://10.100.101.146/WSVistaWebClient/DataService.asmx?WSDL"; 
$client = new SoapClient($wsdl, array('trace' => true)); 

$params = array('CinemaId' 									=> "0000000003", 
				'SessionId'									=> $_POST['session_id'],
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

echo "<form action='getSeats.php' method='post'>";
echo "<input type='hidden' name='movie_name' value='" . $_POST['movie_name'] . "'>";
echo "<input type='hidden' name='session_id' value='" . $_POST['session_id'] . "'>";
echo "<input type='hidden' name='theatre' value='" . $_POST['theatre'] . "'>";

$typeCodes = "";

function compareSeatPackage($a, $b)
{
    if (intval($a['PRICE_INTTICKET_PRICE']) == intval($b['PRICE_INTTICKET_PRICE'])) 
    {
        return 0;
    }
    return (intval($a['PRICE_INTTICKET_PRICE']) < intval($b['PRICE_INTTICKET_PRICE'])) ? 1 : -1;
}

usort($tickets, 'compareSeatPackage');

foreach ($tickets as $ticket)
{
	echo "<img src='" . $ticket['PRICE_STRTICKET_TYPE_CODE'] . ".png'><br />";
  	echo "Type : " . $ticket['PRICE_STRTICKET_TYPE_DESCRIPTION'] . " : " . $ticket['PRICE_STRTICKET_TYPE_CODE'] . "<br />";
  	echo "Price : " . $ticket['PRICE_INTTICKET_PRICE'] . "<br />";
  	echo "<input type='hidden' name='desc" . $ticket['PRICE_STRTICKET_TYPE_CODE'] . "' value='" . $ticket['PRICE_STRTICKET_TYPE_DESCRIPTION'] . "'>";
  	echo "<input type='hidden' name='price" . $ticket['PRICE_STRTICKET_TYPE_CODE'] . "' value='" . $ticket['PRICE_INTTICKET_PRICE'] . "'>";
  	echo "<input type='number' name='nTicket" . $ticket['PRICE_STRTICKET_TYPE_CODE'] . "' value='0' min='0' max='10' style='width:100px;'>";
  	echo "<input type='hidden' name='areaCatIntSeq" . $ticket['PRICE_STRTICKET_TYPE_CODE'] . "' value='" . $ticket['AREACAT_INTSEQ'] . "'>";
  	echo "<input type='hidden' name='areaCatCode" . $ticket['PRICE_STRTICKET_TYPE_CODE'] . "' value='" . $ticket['AREACAT_STRCODE'] . "'>";

  	preg_match('/\d+/', $ticket['PRICE_STRTICKET_TYPE_DESCRIPTION'], $matches);
  	$seatsPerTicket = 1;

	if ($matches) 
	{
		$seatsPerTicket = $matches[0];
	}	

	echo "<input type='hidden' name='seatsPerTicket" . $ticket['PRICE_STRTICKET_TYPE_CODE'] . "' value='" . $seatsPerTicket . "'>";

  	echo "<br /><br /><br /><br />";

  	$typeCodes .= $ticket['PRICE_STRTICKET_TYPE_CODE'] . ",";
}

echo "<input type='hidden' name='ticket_code' value='" . $typeCodes . "'>";
echo "<input type='submit' value='Submit'>";
echo "</form>";

echo "<br /><br />";

echo "<div style='display: none'>";
echo json_encode($tickets);
echo "</div>";

?>

</body>
</html>