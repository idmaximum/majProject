<html>
<head></head>
<body>

<?php 

$connection = mysql_connect("10.100.101.236", "embassy", "embassy@2014"); //!Qq73q3n
mysql_query("SET NAMES 'utf8'");

$logExists = false;
$logTable = "";

if ($connection)
{
  $logTable = "log_VistaWS_" . date('Y_m');

  $db = mysql_select_db("www_embassycineplex_com");
  $tableList = mysql_query("SHOW TABLES FROM www_embassycineplex_com WHERE Tables_in_www_embassycineplex_com LIKE '$logTable'");

  if (mysql_num_rows($tableList))
  {
  	$logExists = true;
  }
  else
  {
  	$createQuery = "CREATE TABLE  `$logTable` (
 									`log_id` INT NOT NULL AUTO_INCREMENT ,
								  	`date_time` DATETIME NOT NULL ,
								  	`soap_process` VARCHAR( 100 ) NOT NULL ,
								  	`pincode` VARCHAR( 10 ) NOT NULL ,
								  	`order_payment` VARCHAR( 20 ) NOT NULL , 
								 	`order_status` VARCHAR( 20 ) NOT NULL ,
								  	`cname` VARCHAR( 255 ) DEFAULT NULL ,
								  	`email` VARCHAR( 100 ) DEFAULT NULL ,
								  	`phone` VARCHAR( 15 ) DEFAULT NULL ,
								  	`channel` VARCHAR( 5 ) DEFAULT NULL ,
								  	`status` VARCHAR( 20 ) DEFAULT NULL ,
								  	`amount` INT DEFAULT NULL ,
								  	`theater` VARCHAR( 20 ) DEFAULT NULL ,
								  	`movie` VARCHAR( 200 ) DEFAULT NULL ,
								  	`show_time` DATETIME DEFAULT NULL ,
								  	`qty` INT DEFAULT NULL ,
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
								  	PRIMARY KEY (`log_id`) ) ENGINE=MYISAM DEFAULT CHARSET=utf8";				
    
    $createSuccess = mysql_query($createQuery);

  	if ($createSuccess) 
  	{
  		$logExists = true;
  	}
  }
}

//mysql_close($connection);

echo "Movie : " . $_POST['movie_name'] . "<br />";
echo "Session : " . $_POST['session_id'] . "<br />";
echo $_POST['theatre'] . "<br />--------------------------------<br /><br />";

$ticketCodes = split(",", $_POST['ticket_code']);

$ticketTypes = array();
$userTickets = array();

$ticketList = array();
$ticketName = array();
$ticketPrice = array();

for ($idx = 0; $idx < sizeof($ticketCodes)-1; $idx++) 
{ 
	echo "Type : " . $_POST["desc" . $ticketCodes[$idx]] . " : " . $ticketCodes[$idx] . "<br />";
	echo "Price : " . $_POST["price" . $ticketCodes[$idx]] . "<br />";
	echo "Amount : " . $_POST["nTicket" . $ticketCodes[$idx]] . "<br />";
	echo "AreaCat : " . $_POST["areaCatIntSeq" . $ticketCodes[$idx]] . "<br />";
	echo "SeatsPerTicket : " . $_POST["seatsPerTicket" . $ticketCodes[$idx]] . "<br />";
	echo "<br />";

	if ($_POST["nTicket" . $ticketCodes[$idx]] > 0) 
	{
		$ticketTypes['TicketType'][] = array(	'TicketTypeCode'			=> $ticketCodes[$idx],
												'Qty'						=> $_POST["nTicket" . $ticketCodes[$idx]],
												'PriceInCents'				=> $_POST["price" . $ticketCodes[$idx]],
												'OptionalAreaCatSequence'	=> $_POST["areaCatIntSeq" . $ticketCodes[$idx]],
												'BookingFeeOverride'		=> null,
												'LoyaltyRecognitionSequence'=> 0);

		$userTickets[] = array(	'TicketTypeCode'		=> $ticketCodes[$idx],
								'Qty'					=> $_POST["nTicket" . $ticketCodes[$idx]],
								'AreaCatCode'			=> $_POST["areaCatCode" . $ticketCodes[$idx]],
								'AreaNumber'			=> 0,
								'SeatsPerTicket'		=> $_POST["seatsPerTicket" . $ticketCodes[$idx]],
								'SeatsLeft'				=> $_POST["seatsPerTicket" . $ticketCodes[$idx]] * $_POST["nTicket" . $ticketCodes[$idx]]); 
	}
}

$wsdl = "http://10.100.101.146/WSVistaWebClient/TicketingService.asmx?WSDL"; 
$client = new SoapClient($wsdl, array('trace' => true)); 
	
list($usec, $sec) = explode(" ", microtime());
//$userSessionID  = strval("01WWW" . date('ymdHis', $sec) . str_pad(intval($usec * 1000), 3, '0', STR_PAD_LEFT) . str_pad(1, 5, '0', STR_PAD_LEFT));

$userSessionID  = strval("01WWW" . date('ymdHis', $sec) . str_pad(intval($usec * 1000), 3, '0', STR_PAD_LEFT) . str_pad(rand()%100000, 5, '0', STR_PAD_LEFT));
	
echo "User Session ID : " . $userSessionID . "<br />";

$params = array(	'OptionalClientClass'			=> "WWW",
					'OptionalClientId' 				=> "111.111.111.112", 
					'OptionalClientName'			=> "WEB",
					'UserSessionId'					=> $userSessionID,
					'CinemaId' 						=> "0000000003", 
					'SessionId'						=> $_POST['session_id'],
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

echo "<div style='display: none'>";
echo "<br /><br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** AddTickets Below ********" . "<br /><br />";
					
echo json_encode($params) . "<br /><br />";
echo "</div>";

$result = $client->__soapCall('AddTickets', array($params));

$valueInCents = $result->Order->TotalValueCents;

echo "<br />-------- -------- -------- -------- -------- -------- -------- --------<br />";
echo "<br />";

echo "Add Ticket : " . $result->Result . "<br />";
echo "Seat Allocated : " . json_encode(!$result->SeatsNotAllocated) . "<br /><br />";

$bestSeats = $result->Order->Sessions->Session->Tickets->Ticket;

if (sizeof($bestSeats) > 1) 
{
	foreach ($bestSeats as $bestSeat) 
	{
		echo "&nbsp;&nbsp;- " . $bestSeat->Description . " : " . $bestSeat->SeatData . "<br />";

		for ($idx = 0; $idx < sizeof($userTickets); $idx++) 
		{ 
			if ($userTickets[$idx]['TicketTypeCode'] == $bestSeat->TicketTypeCode) 
			{
				if (strlen($bestSeat->SeatData) > 0) 
				{
					$userTickets[$idx]['SeatsLeft'] -= $userTickets[$idx]['SeatsPerTicket'];
				}
			}
		}

		if (strlen($bestSeat->SeatData) > 0) 
		{
			$ticketList[] = $bestSeat->SeatData;
			$ticketName[] = $bestSeat->Description;
			$ticketPrice[] = $bestSeat->PriceCents;
		}
	}
}
else
{
	$bestSeat = $bestSeats;
	echo "&nbsp;&nbsp;- " . $bestSeat->Description . " : " . $bestSeat->SeatData . "<br />";

	for ($idx = 0; $idx < sizeof($userTickets); $idx++) 
	{ 
		if ($userTickets[$idx]['TicketTypeCode'] == $bestSeat->TicketTypeCode) 
		{
			if (strlen($bestSeat->SeatData) > 0) 
			{
				$userTickets[$idx]['SeatsLeft'] -= $userTickets[$idx]['SeatsPerTicket'];
			}
		}
	}

	if (strlen($bestSeat->SeatData) > 0) 
	{
		$ticketList[] = $bestSeat->SeatData;
		$ticketName[] = $bestSeat->Description;
		$ticketPrice[] = $bestSeat->PriceCents;
	}
}

//echo "<br /><br /><br /><br />";
//echo json_encode($result->Order);
//echo "<br /><br /><br /><br />";

//$parser = xml_parser_create();
//xml_parse_into_struct($parser, $result->Order, $values, $index);
//xml_parser_free($parser);

$addTicketResult = $result->Result;
$addTicketRequest = $client->__getLastRequest();
$addTicketResponse = $client->__getLastResponse();

if ($connection && $logExists) 
{
	$insertQuery = "INSERT INTO  `www_embassycineplex_com`.`$logTable` (
					`log_id` ,
					`date_time` ,
					`soap_process` ,
					`email` ,
					`phone` ,
					`channel` ,
					`status` ,
					`amount` ,
					`theater` ,
					`movie` ,
					`show_time` ,
					`qty` ,
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
					'$addTicketResult',  
					NULL,  
					NULL,  
					NULL,  
					NULL,  
					NULL,  
					NULL,  
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

echo "<div style='display: none'>";
echo $client->__getLastRequest();
echo "<br /><br />";
echo $client->__getLastResponse();
echo "<br /><br />";

echo "<br /><br />" . "******** AddTickets Above ********" . "<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "<br /><br />";
echo "</div>";

//******** ******** ******** ******** ******** ******** ******** ********
//******** ******** ******** ******** ******** ******** ******** ********
/*
echo "<div style='display: none'>";
echo "<br /><br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** Get Order Below ********" . "<br /><br />";
echo "</div>";

$params = array(	'OptionalClientClass'			=> "WWW",
					'OptionalClientId' 				=> "111.111.111.112", 
					'OptionalClientName'			=> "WEB",
					'UserSessionId'					=> $userSessionID,
					'ProcessOrderValue'				=> false,
					'BookingMode'					=> 1);

$result = $client->__soapCall('GetOrder', array($params));

echo "<div style='display: none'>";
echo json_encode($result);
echo "</div>";

echo "<div style='display: none'>";
echo "<br /><br />" . "******** Get Order Above ********" . "<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "<br /><br />";
echo "</div>";
*/
//******** ******** ******** ******** ******** ******** ******** ********
//******** ******** ******** ******** ******** ******** ******** ********

$params = array(	'OptionalClientClass'			=> "WWW",
					'OptionalClientId' 				=> "111.111.111.112", 
					'OptionalClientName'			=> "WEB",
					'CinemaId'						=> "0000000003",
					'SessionId'						=> $_POST['session_id'],
					'UserSessionId'					=> $userSessionID,
					'ReturnOrder'					=> true,
					'ExcludeAreasWithoutTickets'	=> false,
					'IncludeBrokenSeats'			=> true,
					'IncludeHouseSpecialSeats'		=> true,
					'IncludeGreyAndSofaSeats'		=> true,
					'IncludeAllSeatPriorities'		=> true,
					'IncludeSeatNumbers'			=> true);

echo "<div style='display: none'>";
echo "<br /><br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** GetSessionSeatData Below ********" . "<br /><br />";

echo json_encode($params) . "<br /><br />";
echo "</div>";

$result = $client->__soapCall('GetSessionSeatData', array($params));

echo "<div style='display: none'>";
echo "<br /><br /><br /><br />";
echo json_encode($result->Order) . "<br /><br />";
echo json_encode($result->SeatData) . "<br /><br />";
echo json_encode($result->SeatLayoutData) . "<br /><br />";
echo "</div>";

$seatLayout = $result->SeatLayoutData->Areas->Area;

echo "<br />-------- -------- -------- -------- -------- -------- -------- --------<br />";

$areaCount = 0;
$rowCount = 0;
$colCount = 0;

if (sizeof($seatLayout) > 1) 
{
	$maxRow = 0;
	$maxCol = 0;
	foreach ($seatLayout as $eachArea) 
	{
		if ($maxRow < $eachArea->RowCount) 
		{
			$maxRow = $eachArea->RowCount;
		}
		if ($maxCol < $eachArea->ColumnCount) 
		{
			$maxCol = $eachArea->ColumnCount;
		}
	}

	$areaCount = sizeof($seatLayout);
	$rowCount = $maxRow;
	$colCount = $maxCol;
}
else
{
	$areaCount = 1;
	$rowCount = $seatLayout->RowCount;
	$colCount = $seatLayout->ColumnCount;
}

echo "<br />";
echo "Number of Area : " . $areaCount . "<br />";
echo "Row : " . $rowCount . "<br />Column : " . $colCount . "<br />"; 
echo "<br />-------- -------- -------- -------- -------- -------- -------- --------<br />";

$seatLayoutArray = json_decode(json_encode($seatLayout), true);
$allSeats = array();
$seatsDesc = array();

for ($areaIdx = 0; $areaIdx < $areaCount; $areaIdx++) 
{ 
	$areaCategoryCode = "";
	$description = "";

	$userTicketAreaCatCode = "";
	$userTicketAreaNumber = 0;

	if ($areaCount > 1) 
	{
		$userTicketAreaCatCode = $seatLayoutArray[$areaIdx]['AreaCategoryCode'];
		$userTicketAreaNumber = $seatLayoutArray[$areaIdx]['Number'];
	}
	else
	{
		$userTicketAreaCatCode = $seatLayoutArray['AreaCategoryCode'];
		$userTicketAreaNumber = $seatLayoutArray['Number'];
	}

	foreach ($userTickets as $idx => $eachTicket) 
	{
		if ($eachTicket['AreaCatCode'] == $userTicketAreaCatCode) 
		{
			$userTickets[$idx]['AreaNumber'] = $userTicketAreaNumber;
		}
	}

	for ($rowIdx = 0; $rowIdx < $rowCount; $rowIdx++) 
	{ 
		$rowData = array();
		if ($areaCount > 1) 
		{
			$rowData = $seatLayoutArray[$areaIdx]['Rows']['Row'][$rowIdx];
			$areaCategoryCode = $seatLayoutArray[$areaIdx]['AreaCategoryCode'];
			$description = $seatLayoutArray[$areaIdx]['Description'];
		}
		else
		{
			$rowData = $seatLayoutArray['Rows']['Row'][$rowIdx];
			$areaCategoryCode = $seatLayoutArray['AreaCategoryCode'];
			$description = $seatLayoutArray['Description'];
		}
		$phyName = "";
		$row = array();

		if (sizeof($allSeats) > $rowIdx)
		{
			$row = $allSeats[$rowIdx];
		}

		if ($rowData['Seats']) 
		{
			$phyName = $rowData['PhysicalName'];
		}

		$numberOfSeats = 0;
		$leastIndexSeat = $colCount;
		$mostIndexSeat = 0;

		for ($colIdx = 0; $colIdx < $colCount; $colIdx++) 
		{ 
			$blankSeat['Status'] = "Blank";
			$col = $blankSeat;

			if (sizeof($row) > $colIdx) 
			{
				$col = $row[$colIdx];
			}
			
			if (sizeof($rowData['Seats']) > 0) 
			{
				foreach ($rowData['Seats']['Seat'] as $seat) 
				{
					if ($seat['Position']['ColumnIndex'] == $colIdx) 
					{
						$col = $seat;
						$col['SeatData'] = $phyName . $seat['Id'];
						$col['PhysicalName'] = $phyName;
						$col['AreaCategoryCode'] = $areaCategoryCode;
						$col['Description'] = $description;
					}
				} 
			}

			$row[$colIdx] = $col;

			if ($col['Status'] != "Blank") 
			{
				$numberOfSeats++;
				if ($mostIndexSeat < $colIdx) 
				{
					$mostIndexSeat = $colIdx;
				}
				if ($leastIndexSeat == $colCount) 
				{
					$leastIndexSeat = $colIdx;
				}
			}
		}

		$allSeats[$rowIdx] = $row;

		$seatsDesc[$rowIdx]['NumberOfSeats'] = $numberOfSeats;
		$seatsDesc[$rowIdx]['LeastIndexSeat'] = $leastIndexSeat;
		$seatsDesc[$rowIdx]['MostIndexSeat'] = $mostIndexSeat;

		if ($phyName != "") 
		{
			$seatsDesc[$rowIdx]['PhysicalName'] = $phyName;
		}
	}
}

function compareSeatPackage($a, $b)
{
    if ($a['SeatsPerTicket'] == $b['SeatsPerTicket']) 
    {
        return 0;
    }
    return ($a['SeatsPerTicket'] < $b['SeatsPerTicket']) ? 1 : -1;
}

usort($userTickets, 'compareSeatPackage');

$assignedSeats = $allSeats;
$seatsWillSelected = array();

foreach ($assignedSeats as $idxRow => $eachRow) 
{
	foreach ($eachRow as $idxSeat => $eachSeat) 
	{
		if ($allSeats[$idxRow][$idxSeat]['Status'] == "Reserved") 
		{
			$seatsWillSelected[] = $allSeats[$idxRow][$idxSeat];
		}

		if ($assignedSeats[$idxRow][$idxSeat]['Status'] == "Empty") 
		{
			$seatAreaNumber = $eachSeat['Position']['AreaNumber'];
			$seatAreaCatCode = $eachSeat['AreaCategoryCode'];
			$numSeatsInGroup = 0;
			$numSeatsAvailable = 0;
			$isEmptyGroup = true;

			if (array_key_exists('SeatsInGroup', $eachSeat)) 
			{
				if (array_values($eachSeat['SeatsInGroup']['SeatPosition']) === $eachSeat['SeatsInGroup']['SeatPosition']) 
				{
					$numSeatsInGroup = sizeof($eachSeat['SeatsInGroup']['SeatPosition']);
					$numSeatsAvailable = $numSeatsInGroup;

					foreach ($eachSeat['SeatsInGroup']['SeatPosition'] as $eachSeatGroup) 
					{
						if ($assignedSeats[$eachSeatGroup['RowIndex']][$eachSeatGroup['ColumnIndex']]['Status'] != "Empty")
						{
							$isEmptyGroup = false;
							$numSeatsAvailable--;
						}
					}
				}
				else
				{
					$numSeatsInGroup = 1;
					$numSeatsAvailable = 1;
				}
			}

			$isSingleSeatDone = true;

			foreach ($userTickets as $idx => $eachTicket) 
			{
				if (($eachTicket['SeatsPerTicket'] == 1) && ($eachTicket['SeatsLeft'] > 0) && ($eachTicket['AreaCatCode'] == '0000000001')) 
				{
					$isSingleSeatDone = false;
				}
			}
			
			foreach ($userTickets as $idx => $eachTicket) 
			{
				if ($eachTicket['AreaCatCode'] == $seatAreaCatCode && $eachTicket['SeatsLeft'] > 0) 
				{
					if (($eachTicket['SeatsPerTicket'] > 1) && ($eachTicket['SeatsPerTicket'] == $numSeatsInGroup) && ($isEmptyGroup == true) && ($isSingleSeatDone == true)) 
					{
						foreach ($eachSeat['SeatsInGroup']['SeatPosition'] as $eachSeatGroup) 
						{
							$seatsWillSelected[] = $assignedSeats[$eachSeatGroup['RowIndex']][$eachSeatGroup['ColumnIndex']];
							$assignedSeats[$eachSeatGroup['RowIndex']][$eachSeatGroup['ColumnIndex']]['Status'] = "Reserved";
						}
						$userTickets[$idx]['Qty'] = $userTickets[$idx]['Qty'] - 1;
						$userTickets[$idx]['SeatsLeft'] = $userTickets[$idx]['SeatsLeft'] - $numSeatsInGroup;

						break;
					}
					elseif ($eachTicket['SeatsPerTicket'] == 1) 
					{
						$seatsWillSelected[] = $assignedSeats[$idxRow][$idxSeat];
						$assignedSeats[$idxRow][$idxSeat]['Status'] = "Reserved";

						$userTickets[$idx]['Qty'] = $userTickets[$idx]['Qty'] - 1;
						$userTickets[$idx]['SeatsLeft'] = $userTickets[$idx]['SeatsLeft'] - 1;

						break;
					}
				}
			}
		}
	}
}


//******** ******** ******** ******** ******** ******** ******** ********
//******** ******** ******** ******** ******** ******** ******** ********

echo "<div style='display: none'>";
echo "<br /><br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** SetSelectedSeats Below ********" . "<br /><br />";
echo "</div>";

if (sizeof($seatsWillSelected) > 0) 
{
	$selectedSeats = array();

	foreach ($seatsWillSelected as $seat) 
	{
		$selectedSeats['SelectedSeat'][] = array(	'AreaCategoryCode'	=> $seat['AreaCategoryCode'],
													'AreaNumber'		=> $seat['Position']['AreaNumber'],
													'RowIndex'			=> $seat['Position']['RowIndex'],
													'ColumnIndex'		=> $seat['Position']['ColumnIndex']);
	}

	$params = array(	'OptionalClientClass'			=> "WWW",
						'OptionalClientId' 				=> "111.111.111.112", 
						'OptionalClientName'			=> "WEB",
						'CinemaId'						=> "0000000003",
						'SessionId'						=> $_POST['session_id'],
						'UserSessionId'					=> $userSessionID,
						'ReturnOrder'					=> true,
						'SelectedSeats'					=> $selectedSeats);

	$result = $client->__soapCall('SetSelectedSeats', array($params));

	if ($result->Result == "OK") 
	{
		unset($allSeats);
		$allSeats = $assignedSeats;

		unset($ticketList);
		$ticketList = array();

		unset($ticketName);
		$ticketName = array();

		unset($ticketPrice);
		$ticketPrice = array();

		$bestSeats = $result->Order->Sessions->Session->Tickets->Ticket;

		if (sizeof($bestSeats) > 1) 
		{
			foreach ($bestSeats as $bestSeat) 
			{
				if (strlen($bestSeat->SeatData) > 0) 
				{
					$ticketList[] = $bestSeat->SeatData;
					$ticketName[] = $bestSeat->Description;
					$ticketPrice[] = $bestSeat->PriceCents;
				}
			}
		}
		else
		{
			$bestSeat = $bestSeats;

			if (strlen($bestSeat->SeatData) > 0) 
			{
				$ticketList[] = $bestSeat->SeatData;
				$ticketName[] = $bestSeat->Description;
				$ticketPrice[] = $bestSeat->PriceCents;
			}
		}
	}
	else
	{
		//echo something;
	}
}

echo "<div style='display: none'>";
echo "<br /><br />" . "******** SetSelectedSeats Above ********" . "<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "<br /><br />";
echo "</div>";

//******** ******** ******** ******** ******** ******** ******** ********
//******** ******** ******** ******** ******** ******** ******** ********

//echo json_encode($seatsWillSelected) . "<br /><br />";
//echo json_encode($userTickets);
echo "<br />";
echo "Tickets From API : " . join(" || ", $ticketList);

echo "<div style='display: none' id='apiSeat'>";
echo json_encode($result->SeatLayoutData->Areas);
echo "</div>";
echo "<div style='display: none' id='tableSeat'>";
echo json_encode($allSeats);
echo "</div>";
echo "<div style='display: none'>";
echo "<br /><br />";
echo json_encode($seatsDesc);
echo "</div>";

//echo "<br />-------- -------- -------- -------- -------- -------- -------- --------<br />";
//echo "<br />-------- -------- -------- -------- -------- -------- -------- --------<br />";

//echo "<table>";

echo "<script src='jquery-2.1.1.min.js'></script>";
echo "<script>";

echo "var allSeats = JSON.parse('" . json_encode($allSeats) . "');";
echo "var reservedSeats = [];";
echo "var ticketList = [];";
echo "var ticketName = [];";
echo "var ticketPrice = [];";

if (sizeof($seatsWillSelected) > 0) 
{
	echo "reservedSeats = JSON.parse('" . json_encode($seatsWillSelected) . "');";
	echo "ticketList = JSON.parse('" . json_encode($ticketList) . "');";
	echo "ticketName = JSON.parse('" . json_encode($ticketName) . "');";
	echo "ticketPrice = JSON.parse('" . json_encode($ticketPrice) . "');";
}

echo "</script>";

for ($idxRow = $rowCount-1; $idxRow >= 0; $idxRow--) 
{
	echo "<table style='border-collapse: collapse;' class='seatTable'>";
	//echo "<table>";

	if ($seatsDesc[$idxRow]['NumberOfSeats'] > 0) 
	{
		echo "<tr>";

		if($seatsDesc[$idxRow]['MostIndexSeat'] == $colCount-1)
		{
			echo "<td style='padding:0px;'>";
			echo "<img src='img/Blank.png'><br />";
			echo "<div style='text-align:center;'>" . $seatsDesc[$idxRow]['PhysicalName'] . "</div><br />";
			echo "</td>";
		}

		for ($idxCol = $colCount-1; $idxCol >= $seatsDesc[$idxRow]['LeastIndexSeat']-1; $idxCol--) 
		{
			$seatName = "";
			$areaNumber = 0;

			if ($idxCol == $colCount-1 && $idxCol > $seatsDesc[$idxRow]['MostIndexSeat'])
			{
				$seatName = $seatsDesc[$idxRow]['PhysicalName'];
			}

			if ($idxCol == $seatsDesc[$idxRow]['LeastIndexSeat']-1)
			{
				$seatName = $seatsDesc[$idxRow]['PhysicalName'];
			}

			if ($allSeats[$idxRow][$idxCol]['Status'] == "Blank") 
			{
				$imgName = "img/Blank";
			}
			else
			{
				$imgName = "img/" . ((($allSeats[$idxRow][$idxCol]['Description'] == "Grand Sofa") && ($allSeats[$idxRow][$idxCol]['PhysicalName'] == "A")) ? "A_" : "") .
				str_replace(' ', '_', $allSeats[$idxRow][$idxCol]['Description']) . "_" . 
				$allSeats[$idxRow][$idxCol]['Status'] . "_" . 
				$allSeats[$idxRow][$idxCol]['SeatStyle'];

				$seatName = $allSeats[$idxRow][$idxCol]['SeatData'];
				$areaNumber = $allSeats[$idxRow][$idxCol]['Position']['AreaNumber'];
				/*
				if ($allSeats[$idxRow][$idxCol]['Status'] == 'Reserved') 
				{
					echo "<script>";
					echo "reservedSeats.push(JSON.parse('" . json_encode($allSeats[$idxRow][$idxCol]) . "'));";
					echo "</script>";
				}*/
			}

			$tdID = "_area" . $areaNumber . "row" . $idxRow . "col" . $idxCol;

			echo "<td style='padding:0px;' id='" . $tdID . "''>";
			echo "<img src='" . $imgName . ".png'><br />";

			echo "<div style='text-align:center;'>" . $seatName . "</div><br />";
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
}

echo "<div id='seatChanged'>Seat Changed : </div>";

?>

<script>

var selectedSeats = [];
var seatWithName = [];

for (var idx = 0; idx < reservedSeats.length; idx++) 
{
	selectedSeats.push(reservedSeats[idx]['SeatData']);
}

for (var idx = 0; idx < ticketList.length; idx++) 
{
	seatWithName.push(ticketName[idx] + " : " + ticketList[idx] + " - Price : " + ticketPrice[idx]);
}

seatWithName.sort();

$('#seatChanged').html('Selected Seats : ' + selectedSeats.join(', ') + '<br>Seat Package : ' + ticketList.join(' || ') + '<br><br>&nbsp;&nbsp;- ' + seatWithName.join('<br>&nbsp;&nbsp;- '));


$('.seatTable tr td').click(function(){

    var tdID = $(this).attr('id');

	var areaNum =  parseInt(tdID.match(/\d+/g)[0]);
	var rowIdx = parseInt(tdID.match(/\d+/g)[1]);
	var colIdx = parseInt(tdID.match(/\d+/g)[2]);

	var isSingleSeat = false;

	if (allSeats[rowIdx][colIdx]['Status'] != 'Empty') 
	{
		//alert('Not Empty');
		return;
	}

	if (allSeats[rowIdx][colIdx]['SeatsInGroup']) 
	{
		if ($.isArray(allSeats[rowIdx][colIdx]['SeatsInGroup']['SeatPosition']))
		{
			var seatsPosition = allSeats[rowIdx][colIdx]['SeatsInGroup']['SeatPosition'];

			var isSelect = false;
			var isGroupEmpty = true;
			var numSeatsAvailable = seatsPosition.length;

			var selectedIndice = [];
			var ticketListIndex = 0;

	    	for (var idx = 0; idx < seatsPosition.length; idx++) 
	    	{
	    		if (allSeats[seatsPosition[idx]['RowIndex']][seatsPosition[idx]['ColumnIndex']]['Status'] != "Empty") 
	    		{
	    			isGroupEmpty = false;
	    			numSeatsAvailable--;
	    		}
	    	}

	    	if (isGroupEmpty) 
	    	{
	    		isSingleSeat = false;

	    		for (var idxSeat = 0; idxSeat < reservedSeats.length; idxSeat++)
				{
					if (reservedSeats[idxSeat]['Position']['AreaNumber'] == areaNum) 
					{
						for (var idxTicket = 0; idxTicket < ticketList.length; idxTicket++) 
						{
							if ((ticketList[idxTicket].search(reservedSeats[idxSeat]['SeatData']) != -1) && (ticketList[idxTicket].split(',').length == seatsPosition.length) && !isSelect) 
							{
								isSelect = true;
								ticketListIndex = idxTicket;
							}
							else if ((ticketList[idxTicket].search(reservedSeats[idxSeat]['SeatData']) != -1) && (ticketList[idxTicket].split(',').length == 1) && !isSelect)
							{
								isSelect = true;
								isSingleSeat = true;
							}
						}
					}
				}

				if (isSelect && !isSingleSeat) 
				{
					var selectedTicketList = ticketList[ticketListIndex].split(',');

					for (var idxSeat = 0; idxSeat < reservedSeats.length; idxSeat++)
					{
						if (reservedSeats[idxSeat]['Position']['AreaNumber'] == areaNum) 
						{
							for (var idxTicket = 0; idxTicket < selectedTicketList.length; idxTicket++) 
							{
								if ((reservedSeats[idxSeat]['SeatData'] == selectedTicketList[idxTicket].trim()) && (selectedIndice.length < selectedTicketList.length))  
								{
									selectedIndice.push(idxSeat);
								}
							}
						}
					}

					selectedIndice.sort(function(a, b){return b-a});

					if (selectedIndice.length == selectedTicketList.length) 
					{
						for (var idx = 0; idx < selectedIndice.length; idx++) 
						{
							var removedSeat = reservedSeats[selectedIndice[idx]]['Position'];
							var imgSrc = $('#_area' + removedSeat['AreaNumber'] + 'row' + removedSeat['RowIndex'] + 'col' + removedSeat['ColumnIndex']).find('img').attr('src');
							$('#_area' + removedSeat['AreaNumber'] + 'row' + removedSeat['RowIndex'] + 'col' + removedSeat['ColumnIndex']).find('img').attr('src', imgSrc.replace('Reserved', 'Empty'));

							reservedSeats.splice(selectedIndice[idx], 1);

							allSeats[removedSeat['RowIndex']][removedSeat['ColumnIndex']]['Status'] = 'Empty';
						}

						selectedIndice.length = 0;
						var newTicketList = [];

						for (var idx = 0; idx < seatsPosition.length; idx++) 
				    	{
				    		var newSeat = allSeats[seatsPosition[idx]['RowIndex']][seatsPosition[idx]['ColumnIndex']];

				    		reservedSeats.push(newSeat);
				    		newTicketList.push(newSeat['SeatData']);

				    		var imgSrc = $('#_area' + newSeat['Position']['AreaNumber'] + 'row' + newSeat['Position']['RowIndex'] + 'col' + newSeat['Position']['ColumnIndex']).find('img').attr('src');
							$('#_area' + newSeat['Position']['AreaNumber'] + 'row' + newSeat['Position']['RowIndex'] + 'col' + newSeat['Position']['ColumnIndex']).find('img').attr('src', imgSrc.replace('Empty', 'Reserved'));

							allSeats[seatsPosition[idx]['RowIndex']][seatsPosition[idx]['ColumnIndex']]['Status'] = 'Reserved';
				    	}

				    	ticketList.splice(ticketListIndex, 1);
				    	ticketList.push(newTicketList.join(', '));

				    	var tempTicketName = ticketName[ticketListIndex];
				    	ticketName.splice(ticketListIndex, 1);
				    	ticketName.push(tempTicketName);

				    	var tempTicketPrice = ticketPrice[ticketListIndex];
				    	ticketPrice.splice(ticketListIndex, 1);
				    	ticketPrice.push(tempTicketPrice);
					}
				}
	    	}

	    	if (!isGroupEmpty && numSeatsAvailable >= 1) 
	    	{
	    		isSingleSeat = true;
	    	}
		}
		else
		{
			isSingleSeat = true;
		}
	}
	else
	{
		isSingleSeat = true;
	}

	if (isSingleSeat) 
	{
		var isSelect = false;
		var selectedIndex = 0;
		var ticketListIndex = 0;
    	for (var idxSeat = 0; idxSeat < reservedSeats.length; idxSeat++)
		{
			if (reservedSeats[idxSeat]['Position']['AreaNumber'] == areaNum) 
			{
				for (var idxTicket = 0; idxTicket < ticketList.length; idxTicket++) 
				{
					if ((ticketList[idxTicket].search(reservedSeats[idxSeat]['SeatData']) != -1) && (ticketList[idxTicket].split(',').length == 1) && !isSelect) 
					{
						isSelect = true;
						selectedIndex = idxSeat;
						ticketListIndex = idxTicket;
					}
				}
			}
		}

		if (isSelect) 
		{
			var removedSeat = reservedSeats[selectedIndex]['Position'];
			reservedSeats.splice(selectedIndex, 1);
			ticketList.splice(ticketListIndex, 1);

			var tempTicketName = ticketName[ticketListIndex];
			ticketName.splice(ticketListIndex, 1);

			var tempTicketPrice = ticketPrice[ticketListIndex];
			ticketPrice.splice(ticketListIndex, 1);

			var imgSrc = $(this).find('img').attr('src');
    		$(this).find('img').attr('src', imgSrc.replace('Empty', 'Reserved'));

    		var imgSrc = $('#_area' + removedSeat['AreaNumber'] + 'row' + removedSeat['RowIndex'] + 'col' + removedSeat['ColumnIndex']).find('img').attr('src');
			$('#_area' + removedSeat['AreaNumber'] + 'row' + removedSeat['RowIndex'] + 'col' + removedSeat['ColumnIndex']).find('img').attr('src', imgSrc.replace('Reserved', 'Empty'));

			allSeats[rowIdx][colIdx]['Status'] = 'Reserved';
			allSeats[removedSeat['RowIndex']][removedSeat['ColumnIndex']]['Status'] = 'Empty';

			reservedSeats.push(allSeats[rowIdx][colIdx]);
			ticketList.push(allSeats[rowIdx][colIdx]['SeatData']);

			ticketName.push(tempTicketName);
			ticketPrice.push(tempTicketPrice);
		}
	}

	var ticketIndex = ticketList.slice(0);

	function sortTicketIndex(a, b)
	{
		if (a.split(',').length == b.split(',').length) 
		{
			if (a.length < b.length) 
			{
				return -1;
			}
			else if (a.length > b.length)
			{
				return 1;
			}
			return 0;
		} 
		return (a.split(',').length < b.split(',').length) ? -1 : 1;
	}

	ticketIndex.sort();
	ticketIndex.sort(sortTicketIndex);

	var seatIndex = {};

	for (var idx = 0; idx < reservedSeats.length; idx++) 
	{
		seatIndex[reservedSeats[idx]['SeatData']] = idx;
	}

	var seatWillReserved = [];

	for (var idx = 0; idx < ticketIndex.length; idx++) 
	{
		if (ticketIndex[idx].split(',').length == 1) 
		{
			seatWillReserved.push(reservedSeats[seatIndex[ticketIndex[idx]]]);
		}
		else
		{
			var tickets = ticketIndex[idx].split(',');

			for (var tIdx = 0; tIdx < tickets.length; tIdx++)
			{
				tickets[tIdx] = tickets[tIdx].trim();
			}

			tickets.sort();
			tickets.sort(sortTicketIndex);

			for (var tIdx = 0; tIdx < tickets.length; tIdx++)
			{
				seatWillReserved.push(reservedSeats[seatIndex[tickets[tIdx]]]);
			}
		}
	}

	//******** ******** ******** ******** ******** ******** ******** ********

	var selectedSeats = [];
	var seatWithName = [];

	for (var idx = 0; idx < reservedSeats.length; idx++) 
	{
		selectedSeats.push(reservedSeats[idx]['SeatData']);
	}

	for (var idx = 0; idx < ticketList.length; idx++) 
	{
		seatWithName.push(ticketName[idx] + " : " + ticketList[idx] + " - Price : " + ticketPrice[idx]);
	}

	seatWithName.sort();

	$('#seatChanged').html('Selected Seats : ' + selectedSeats.join(', ') + '<br>Seat Package : ' + ticketList.join(' || ') + '<br><br>&nbsp;&nbsp;- ' + seatWithName.join('<br>&nbsp;&nbsp;- '));
});

</script>

<?php

echo "<div style='display: none'>";
echo $client->__getLastRequest();
echo "<br /><br />";
echo $client->__getLastResponse();
echo "<br /><br />";

echo "<br /><br />" . "******** GetSessionSeatData Above ********" . "<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "<br /><br />";
echo "</div>";

//******** ******** ******** ******** ******** ******** ******** ********
//******** ******** ******** ******** ******** ******** ******** ********

$params = array(	'OptionalClientClass'	=> "WWW",
					'OptionalClientId' 		=> "111.111.111.112", 
					'OptionalClientName'	=> "WEB",
					'UserSessionId'			=> $userSessionID);

echo "<div style='display: none'>";
echo "<br /><br />";					
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** CancelOrder Below ********" . "<br /><br />";

echo json_encode($params) . "<br /><br />";
echo "</div>";

$result = $client->__soapCall('CancelOrder', array($params));

echo "<br />-------- -------- -------- -------- -------- -------- -------- --------<br />";
echo "<br />";
echo "Cancel Order : " . $result->Result;
echo "<br /><br />";

//echo "<br /><br /><br /><br />";
//echo json_encode($result);
//echo "<br /><br /><br /><br />";

//$parser = xml_parser_create();
//xml_parse_into_struct($parser, $result->Order, $values, $index);
//xml_parser_free($parser);

echo "<div style='display: none'>";
echo $client->__getLastRequest();
echo "<br /><br />";
echo $client->__getLastResponse();
echo "<br /><br />";

echo "<br /><br />" . "******** CancelOrder Above ********" . "<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "<br /><br />";
echo "</div>";

//******** ******** ******** ******** ******** ******** ******** ********
//******** ******** ******** ******** ******** ******** ******** ********

$paymentInfo = array(	'PaymentValueCents'			=> $valueInCents,
						'BillFullOutstandingAmount'	=> false,
						'UseAsBookingRef'			=> false,
						'PaymentStatus'				=> "Y",
						'BillingValueCents'			=> $valueInCents,
						'CardBalance'				=> 0,
						'SaveCardToWallet'			=> false);

$paymentInfoCollection = array();

$paymentInfoCollection['PaymentInfo'][] = array(	'CardNumber'				=> "1234567890",
													'CardType'					=> "Credit",
													'PaymentValueCents'			=> $valueInCents,
													'PaymentTenderCategory'		=> "CREDIT",
													'BillFullOutstandingAmount'	=> false,
													'UseAsBookingRef'			=> false,
													'PaymentStatus'				=> "Y",
													'BillingValueCents'			=> $valueInCents,
													'CardBalance'				=> 0,
													'BankReference'				=> "7778888",
													'SaveCardToWallet'			=> false);

$passTypeRequest = array(	'IncludeApplePassBook'	=> false,
							'IncludeICal'			=> false);

$params = array(	'OptionalClientClass'					=> "WWW",
					'OptionalClientId' 						=> "111.111.111.112", 
					'OptionalClientName'					=> "WEB",
					'UserSessionId'							=> $userSessionID,
					'PaymentInfo'							=> $paymentInfo,
					'PaymentInfoCollection'					=> $paymentInfoCollection,
					'PerformPayment'						=> false,
					'CustomerEmail'							=> "test@mail.com",
					'CustomerPhone'							=> "0897654321",
					'CustomerName'							=> "test",
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

echo "<div style='display: none'>";
echo "<br /><br />";					
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** CompleteOrder Below ********" . "<br /><br />";
echo "</div>";

//echo json_encode($params) . "<br /><br />";

//$result = $client->__soapCall('CompleteOrder', array($params));

echo "<div style='display: none'>";
echo "<br /><br /><br /><br />";
echo json_encode($result);
echo "<br /><br /><br /><br />";

//$parser = xml_parser_create();
//xml_parse_into_struct($parser, $result->Order, $values, $index);
//xml_parser_free($parser);

echo $client->__getLastRequest();
echo "<br /><br />";
echo $client->__getLastResponse();
echo "<br /><br />";
echo "</div>";

if ($result->Result == "OK") 
{
	echo "VistaBookingNumber : " . $result->VistaBookingNumber . "<br />";
	echo "VistaBookingId : " . $result->VistaBookingId . "<br />";
}
else
{
	echo "Not Conplete.";
}

echo "<div style='display: none'>";
echo "<br /><br />" . "******** CompleteOrder Above ********" . "<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "<br /><br />";
echo "</div>";

mysql_close($connection);

//******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********
//******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********

$ticketList = array();
$ticketName = array();
$ticketPrice = array();

$selectedSeats = array();

$seatsWillSelected = json_decode($seatsFromSeatTable, true);

foreach ($seatsWillSelected as $seat) 
{
	$selectedSeats['SelectedSeat'][] = array(	'AreaCategoryCode'	=> $seat['AreaCategoryCode'],
												'AreaNumber'		=> $seat['Position']['AreaNumber'],
												'RowIndex'			=> $seat['Position']['RowIndex'],
												'ColumnIndex'		=> $seat['Position']['ColumnIndex']);
}

$params = array(	'OptionalClientClass'			=> "WWW",
					'OptionalClientId' 				=> "111.111.111.112", 
					'OptionalClientName'			=> "WEB",
					'CinemaId'						=> "0000000003",
					'SessionId'						=> $_POST['session_id'],
					'UserSessionId'					=> $userSessionID,
					'ReturnOrder'					=> true,
					'SelectedSeats'					=> $selectedSeats);

//$result = $client->__soapCall('SetSelectedSeats', array($params));

if ($result->Result == "OK") 
{
	$bestSeats = $result->Order->Sessions->Session->Tickets->Ticket;

	if (sizeof($bestSeats) > 1) 
	{
		foreach ($bestSeats as $bestSeat) 
		{
			if (strlen($bestSeat->SeatData) > 0) 
			{
				$ticketList[] = $bestSeat->SeatData;
				$ticketName[] = $bestSeat->Description;
				$ticketPrice[] = $bestSeat->PriceCents;
			}
		}
	}
	else
	{
		$bestSeat = $bestSeats;

		if (strlen($bestSeat->SeatData) > 0) 
		{
			$ticketList[] = $bestSeat->SeatData;
			$ticketName[] = $bestSeat->Description;
			$ticketPrice[] = $bestSeat->PriceCents;
		}
	}
}
else
{
	//echo something;
}

//******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********
//******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********

?>

</body>
</html>