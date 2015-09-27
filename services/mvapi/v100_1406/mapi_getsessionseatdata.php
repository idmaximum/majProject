<?php

$session_id = "";
$user_session_id = "";

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

$wsdl = "http://10.121.130.25/WSVistaWebClient/TicketingService.asmx?WSDL"; 
$client = new SoapClient($wsdl, array('trace' => true)); 
	
$params = array(	'OptionalClientClass'			=> $clientClass,
					'OptionalClientId' 				=> $clientID, 
					'OptionalClientName'			=> $clientName,
					'CinemaId'						=> "0000008001",
					'SessionId'						=> $session_id,
					'UserSessionId'					=> $user_session_id,
					'ReturnOrder'					=> true,
					'ExcludeAreasWithoutTickets'	=> false,
					'IncludeBrokenSeats'			=> true,
					'IncludeHouseSpecialSeats'		=> true,
					'IncludeGreyAndSofaSeats'		=> true,
					'IncludeAllSeatPriorities'		=> true,
					'IncludeSeatNumbers'			=> true);

$result = $client->__soapCall('GetSessionSeatData', array($params));

$seatLayout = $result->SeatLayoutData->Areas->Area;

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

$seatLayoutArray = json_decode(json_encode($seatLayout), true);
$allSeats = array();
$seatsDesc = array();

for ($areaIdx = 0; $areaIdx < $areaCount; $areaIdx++) 
{ 
	$areaCategoryCode = "";
	$description = "";

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
$resultJSON['data']['seat_layer'] = $result->SeatLayoutData->Areas;
$resultJSON['data']['seat_table'] = $allSeats;
$resultJSON['data']['result'] = $result->Order;

echo json_encode($resultJSON);

$seatData = json_decode(json_encode($result->SeatLayoutData->AreaCategories->AreaCategory), true);

$getSeatResult = $result->Result;
$getSeatRequest = json_encode($params);
$getSeatResponse = json_encode($seatData);

$connection = mysql_connect("10.121.128.10", "embassy", "embassy@2014");
mysql_query("SET NAMES 'utf8'");

$logExists = false;
$logTable = "";

if ($connection)
{
	$logTable = "log_vistaws_20" . substr($user_session_id, 5, 2) . "_" . substr($user_session_id, 7, 2);

  	$db = mysql_select_db("www_embassycineplex_com");
  	$updateQuery = "UPDATE `www_embassycineplex_com`.`$logTable` SET `soap_process` = CONCAT(`soap_process`, ', GetSessionSeatData'),
  																`status` = '$getSeatResult',
  																`getsessionseat_request` = '$getSeatRequest',
  																`getsessionseat_response` = '$getSeatResponse' 
  																WHERE user_session_id = '$user_session_id'";
	mysql_query($updateQuery);
}

mysql_close($connection);

?>