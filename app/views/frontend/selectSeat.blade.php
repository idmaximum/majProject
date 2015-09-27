<?php
	 $logTable = "log_vistaws_" . date('Y_m'); 
		//*********************************
		
		$wsdl = "http://10.121.130.25/WSVistaWebClient/TicketingService.asmx?WSDL"; 
		//$wsdl = "http://10.100.101.146/WSVistaWebClient/TicketingService.asmx?WSDL"; 
		$client = new SoapClient($wsdl, array('trace' => true));  
		 
		if(Session::get('userSessionID') != ''){ //cancel order 
		
				$userSessionID = Session::get('userSessionID');
			 
				$params = array(	'OptionalClientClass'	=> "WWW",
									'OptionalClientId' 		=> "111.111.111.112", 
									'OptionalClientName'	=> "WEB",
									'UserSessionId'			=> $userSessionID);
				$result = $client->__soapCall('CancelOrder', array($params));
				
				$cancelResult = $result->Result;
				$CancelOrderRequest = json_encode($params);
				$CancelOrderResponse = json_encode($result);
								
				$dataTblLog =  DB::table($logTable)
										->where('user_session_id' , $userSessionID) 
										->pluck('soap_process'); 			 
				$SOAPprocess = $dataTblLog.', CancelOrder';
				
				DB::table($logTable)
						  ->where('user_session_id', $userSessionID)
						  ->update(array('soap_process'			=> $SOAPprocess, 
										 'status' 	=> $cancelResult, 
										 'cancelorder_request' 	=> $CancelOrderRequest, 
								  		 'cancelorder_response' => $CancelOrderResponse)); 
				 
			 	Session::forget('userSessionID'); 
		}#end remove
		
		  list($usec, $sec) = explode(" ", microtime());
		  $userSessionID  = strval("01WWW" . date('ymdHis', $sec) . str_pad(intval($usec * 1000), 3, '0', STR_PAD_LEFT) . str_pad(1, 5, '0', STR_PAD_LEFT));
		  
	   Session::put('userSessionID', $userSessionID);
	   $userSessionID = Session::get('userSessionID');
	 
	//echo json_encode($userTickets);
	
	 $params = array(	'OptionalClientClass'			=> "WWW",
					'OptionalClientId' 				=> "111.111.111.112", 
					'OptionalClientName'			=> "WEB",
					'UserSessionId'					=> $userSessionID,
					'CinemaId' 						=> "0000008001", 
					'SessionId'						=> $sessID,
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
		  
	/*		echo "Add Ticket : " . $result->Result . "<br />";
			echo "Seat Allocated : " . json_encode(!$result->SeatsNotAllocated) . "<br /><br />";*/ 
		 
	 if($result->Result != 'OK'){
			 
			 ?>
<meta http-equiv="refresh" content="0;URL={{URL::to("selectTicketerror/$movieID/$sessID")}}" />
<?php 
			  exit(); 
		  }	/* */#endif 
		  
		  $valueInCents = $result->Order->TotalValueCents;
		  $bestSeats = $result->Order->Sessions->Session->Tickets->Ticket;  
		  $priceTotal =  $valueInCents;
/*
echo "Add Ticket : " . $result->Result . "<br />";
echo "Seat Allocated : " . json_encode(!$result->SeatsNotAllocated) . "<br /><br />";*/ 
 

$numSeatType =  sizeof($userTickets);//get count Seat Type

$ticketList = array(); 
$ticketName = array();
$ticketPrice = array();
//****************
if (sizeof($bestSeats) > 1) 
{
	foreach ($bestSeats as $bestSeat) 
	{
	//	echo "&nbsp;&nbsp;- " . $bestSeat->Description . " : " . $bestSeat->SeatData . "<br />";

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
	//echo "&nbsp;&nbsp;- " . $bestSeat->Description . " : " . $bestSeat->SeatData . "<br />";
	

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
//**********
$addTicketResult = $result->Result;
  $addTicketRequest = json_encode($params);
  $addTicketResponse = json_encode($result->Order->Sessions->Session->Tickets->Ticket);

 

 $dateNow = date('Y-m-d H:i:s');
 
 DB::table($logTable)->insert(
    array(
	'soap_process' => 'AddTickets', 
	'date_time' => $dateNow, 
	'status' => $addTicketResult, 
	'addticket_status' => $addTicketResult, 
	'addticket_request' => $addTicketRequest, 
	'addticket_response' =>  $addTicketResponse ,
	'session_id' =>  $sessID , 
	'user_session_id' => $userSessionID )
);
/*  
//************ Get order ****

$params = array(	'OptionalClientClass'			=> "WWW",
					'OptionalClientId' 				=> "111.111.111.112", 
					'OptionalClientName'			=> "WEB",
					'UserSessionId'					=> $userSessionID,
					'ProcessOrderValue'				=> false,
					'BookingMode'					=> 0);

$result = $client->__soapCall('GetOrder', array($params));
*/
//******** ******** ******** ******** ******** ******** ******** ********
$params = array(	'OptionalClientClass'			=> "WWW",
					'OptionalClientId' 				=> "111.111.111.112", 
					'OptionalClientName'			=> "WEB",
					'CinemaId'						=> "0000008001",
					'SessionId'						=> $sessID,
					'UserSessionId'					=> $userSessionID,
					'ReturnOrder'					=> true,
					'ExcludeAreasWithoutTickets'	=> false,
					'IncludeBrokenSeats'			=> true,
					'IncludeHouseSpecialSeats'		=> true,
					'IncludeGreyAndSofaSeats'		=> true,
					'IncludeAllSeatPriorities'		=> true,
					'IncludeSeatNumbers'			=> true);
$result = $client->__soapCall('GetSessionSeatData', array($params));

//************
 $seatData = json_decode(json_encode($result->SeatLayoutData->AreaCategories->AreaCategory), true); 
$GetSessioResult = $result->Result;
$GetSessionRequest = json_encode($params);
 $GetSessionResponse = json_encode($seatData); 

//****	Update Update Log	*****
  	$dataTblLog =  DB::table($logTable)
						  ->where('user_session_id' , $userSessionID) 
						  ->pluck('soap_process'); 			 
	$SOAPprocess = $dataTblLog.', GetSessionSeatData';
 
 	 DB::table($logTable)
			->where('user_session_id', $userSessionID)
			->update(array('soap_process'			=> $SOAPprocess, 
						   'status' 	=> $GetSessioResult, 
						   'getsessionseat_status' 	=> $GetSessioResult, 
						   'getsessionseat_request' 	=> $GetSessionRequest, 
						   'getsessionseat_response'	=> $GetSessionResponse));  
//******* End Update Log	*****
//*********** End Get order **********

$seatLayout = $result->SeatLayoutData->Areas->Area;
//echo "<br />-------- -------- -------- -------- -------- -------- -------- --------<br />";

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

/*echo "<br />";
echo "Number of Area : " . $areaCount . "<br />";
echo "Row : " . $rowCount . "<br />Column : " . $colCount . "<br />"; 
echo "<br />-------- -------- -------- -------- -------- -------- -------- --------<br />";*/

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

//echo "------------------------------------------------<br>";

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
					//$isSingleSeatDone = false;
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

//******** ******** SetSelectedSeats Below **************** ********  
 
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
						'CinemaId'						=> "0000008001",
						'SessionId'						=> $sessID,
						'UserSessionId'					=> $userSessionID,
						'ReturnOrder'					=> true,
						'SelectedSeats'					=> $selectedSeats);

	$result = $client->__soapCall('SetSelectedSeats', array($params));
 
	$setSeatResult = $result->Result;
	$setSeatRequest = json_encode($params);
	$setSeatResponse = json_encode($result->Order->Sessions->Session->Tickets->Ticket);
	
	//****	Update Update Log	*****
  	$dataTblLog =  DB::table($logTable)
						  ->where('user_session_id' , $userSessionID) 
						  ->pluck('soap_process'); 			 
	$SOAPprocess = $dataTblLog.', SetSelectedSeats';
  
 	 DB::table($logTable)
			->where('user_session_id', $userSessionID)
			->update(array('soap_process'			=> $SOAPprocess,
						   'status' 					=> $setSeatResult,  
						   'setselectedseat_status' 	=> $setSeatResult,
						   'setselectedseat_request' 	=> $setSeatRequest, 
						   'setselectedseat_response'	=> $setSeatResponse));  
	//******* End Update Log	*****

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
//************** Start Insert *********************** 
//************** End Insert *****************************
 $config_path = "https://www.embassycineplex.com";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Embassy Diplomat Screens by AIS</title>
<meta property="og:image" content="http://www.embassycineplex.com/images/share.jpg" />
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/reset.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/font.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/screen.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/screen2.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/screenInside.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/screenTickets.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/js/DropDown/css/style.css"> 
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/js/formValidator/css/validationEngine.jquery.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/js/tooltipster/css/tooltipster2.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/js/timeTo/timeTo.css">  
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/js/colorbox-master/example3/colorbox.css">
@include('frontend.incScriptTop')
</head>
<body>
<div id="main"> @include('frontend.incHeader')
  <div id="countdown" class="url"></div>
  <div id="content" class="content-main">
    <div class="titleMovie"> <a href="{{URL::to("selectTicket/$movieID/$sessID")}}"><img src="images/btn-back.png"  alt="btn Back" class="hoverImg08"></a> </div>
    <div class="contentPage"> @foreach($movie_DataDetail as $movie)
      <?php
     	$movieName =	$movie->movie_Name_EN;  
		$sessID = $movie->showtime_Session_strID;
	 ?>
      <div class="content-detail-movie">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="18%"><div class="rowShowTodayImage"><img src="{{asset("uploads/movie/$movie->movie_Img_Thumb")}}" width="140" height="210"  alt="{{$movieName}}"></div></td>
            <td width="82%" align="left" valign="top"><h2 class="txtGold24">{{$movieName}}</h2>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="15%"><?php
            	if($movie->movie_Rating == "ส."){ 
					$imgRate = "rate_raise.png"; 
				 }else if($movie->movie_Rating == "น13+"){ 
					$imgRate = "rate_up_13_en.png";
				 }else if($movie->movie_Rating == "น15+"){ 
					$imgRate = "rate_up_15_en.png";
				 }else if($movie->movie_Rating == "น18+"){ 
					$imgRate = "rate_up_18_en.png";
				  }else if($movie->movie_Rating == "ฉ20-"){ 
					$imgRate = "rate_under_20_en.png";
				  }else { 
					$imgRate = "rate_general_en.png";
				 }//***********
				 
				 if($movie->showtime_SystemType == "VS00000001"){ 
					$imgSystem = "type_digital.png";
					$systemName = '2D';
				 }else if($movie->showtime_SystemType == "0000000001"){ 
					$imgSystem = "type_3d.png";
					$systemName = 'D3D';
				 }else if($movie->showtime_SystemType == "0000000002"){ 
								  $imgSystem = "type_hfr_3d.png";
								  $systemName = 'HFR 3D';		  
				 }else{
					$imgSystem = "type_digital.png";
					$systemName = '2D';
				 }  //*************
			?>
                    <p><img src="{{asset("images/icon/$imgRate")}}" alt="{{$movie->movie_Rating}}" style="padding:0; padding-right:5px;  max-width:40px"> <img src="{{asset("images/icon/$imgSystem")}}" alt="{{$systemName}}" style="max-width:40px"></p></td>
                  <td width="85%" class="txtSoundTrack" style="padding-left:5px"><?php
                   		$showtimes =  $movie->showtime_soundAttributes.";";
						echo	 $showtimes = strstr($showtimes, ';', true); // As of PHP 5.3.0
				   ?></td>
                </tr>
              </table>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <table width="100%" border="0" cellspacing="1" cellpadding="1" class="detailTable">
                <tr>
                  <td width="33%">Date &nbsp;<span class="txtWhite18">{{ date('d F Y', strtotime($movie->showtime_dtmDate_Time)) }}</span></td>
                  <td width="33%">Time &nbsp;<span class="txtWhite18"><?php echo date('H:i', strtotime($movie->showtime_dtmDate_Time))?></span></td>
                  <td width="33%">Hall &nbsp;<span class="txtWhite18">{{strReplaceText($movie->showtime_strName)}}</span></td>
                </tr>
              </table>
              <p>&nbsp;</p></td>
          </tr>
        </table>
      </div>
      @endforeach
      <div class="movie-step">
        <p>&nbsp;</p>
        <p><img src="images/step_seat_type_2.png" width="1024" height="81"></p>
      </div>
      <div class="content-seat-type">
        <p>&nbsp;</p
          >
        <p>&nbsp;</p
          >
        <p><img src="images/12_theatre_3_07.png" width="1021" height="153"></p>
        <div style="width:1000px; margin:auto; text-align:center;color: #f1e3c2;text-transform: uppercase;">
          <?php 	   
							   
			  for ($idxRow = $rowCount-1; $idxRow >= 0; $idxRow--) 
			  {
				  echo "<table style='border-collapse: collapse;' class='seatTable '>";
				  //echo "<table>";
			  
				  if ($seatsDesc[$idxRow]['NumberOfSeats'] > 0) 
				  {
					  echo "<tr>";
			  
					  if($seatsDesc[$idxRow]['MostIndexSeat'] == $colCount-1)
					  {
						  echo "<td style='padding:0px;'  class='tableSeatsLeft'>";
						  echo "<img src='images/theater/Blank.png'><br />";
						  echo "<div style='text-align:center;'>" . $seatsDesc[$idxRow]['PhysicalName'] . "</div><br />";
						  echo "</td>";
					  }
			  
					  for ($idxCol = $colCount-1; $idxCol >= $seatsDesc[$idxRow]['LeastIndexSeat']-1; $idxCol--) 
					  {
						  $seatName = "";
						  $areaNumber = 0;
						  $styleRight = '';
						  $styleLeft  = '';
						  $styleStatus  = '';
						  $seatName = "";
						  $styleBlank = "";
						  $imgSeatHover = '';
						 $stylePointerCurser = ''; 
			  
						  if ($idxCol == $colCount-1 && $idxCol > $seatsDesc[$idxRow]['MostIndexSeat'])
						  {
							  $seatName = $seatsDesc[$idxRow]['PhysicalName'];
							  $styleLeft = "tableSeatsLeft";
						  }
			  
						  if ($idxCol == $seatsDesc[$idxRow]['LeastIndexSeat']-1)
						  {
							  $seatName = $seatsDesc[$idxRow]['PhysicalName'];
							  $styleRight = "tableSeatsRight";
						  }
			  
						  if ($allSeats[$idxRow][$idxCol]['Status'] == "Blank") 
						  {
							  $imgName = "images/theater/Blank";
						  }
						  else
						  {
							  $imgName = "images/theater/". ((($allSeats[$idxRow][$idxCol]['Description'] == "Grand Sofa") && ($allSeats[$idxRow][$idxCol]['PhysicalName'] == "A")) ? "A_" : "") . 
							  str_replace(' ', '_', $allSeats[$idxRow][$idxCol]['Description']) . "_" . 
							  $allSeats[$idxRow][$idxCol]['Status'] . "_" . 
							  $allSeats[$idxRow][$idxCol]['SeatStyle'];
							  
					/*		  $imgName = "img/" . ((($allSeats[$idxRow][$idxCol]['Description'] == "Grand Sofa") && ($allSeats[$idxRow][$idxCol]['PhysicalName'] == "A")) ? "A_" : "") .
				str_replace(' ', '_', $allSeats[$idxRow][$idxCol]['Description']) . "_" . 
				$allSeats[$idxRow][$idxCol]['Status'] . "_" . 
				$allSeats[$idxRow][$idxCol]['SeatStyle'];*/ 
			  
							  $seatName = $allSeats[$idxRow][$idxCol]['SeatData'];
							  $areaNumber = $allSeats[$idxRow][$idxCol]['Position']['AreaNumber']; 
							  $stylePointerCurser = "seatSelect";
							  
							  $NamePicSeat = str_replace(' ', '_', $allSeats[$idxRow][$idxCol]['Description']);
							  $styleBlank = "imgSeat";
							  $imgSeatHover = "<img src=images/theater/imgMouseOver/$NamePicSeat.jpg>";	
						  }
			  
						  $tdID = "_area" . $areaNumber . "row" . $idxRow . "col" . $idxCol;
			  				if($allSeats[$idxRow][$idxCol]['Status'] == "Sold"){
									 $styleStatus = "statusSold";
								}#end if
								
						  echo "<td style='padding:0px;' id='" . $tdID . "''  class='".$styleRight."".$stylePointerCurser." ".$styleLeft." ".$styleStatus."' >";
						//  echo "<img src='" . $imgName . ".png'><br />";
						  echo "<p class='".$styleBlank."' title='".$imgSeatHover."'><img src='" . $imgName . ".png'><p>";  
						  echo "<div style='text-align:center;'>" . $seatName . "</div><br />";
						  echo "</td>";
					  }
					  echo "</tr>";
				  }
				  echo "</table>";
			  }
			  
			  echo "<div id='seatChanged'></div>";
            ?>
        </div>
        <p class="clear"></p>
      </div>
      <table width="100%" border="0" cellspacing="1" cellpadding="1" class="detailTable" id="detailPaymentTicket">
      </table>
      <?php if ($numSeatType > 1){?>
      <br>
      <div class="total-price">Total Price <span style="font-size:22px" class="txtWhite20">
        <?php
		 	 $priceTotal	 = 	substr("$priceTotal", 0, -2); 
		    echo number_format($priceTotal)?>
        Baht</span></div>
      <?php }else{#end if
		     $priceTotal	 = 	substr("$priceTotal", 0, -2);
		   }#?>
      <div class="content-seat-type">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="47%" valign="top"><p>&nbsp;</p>
              <p>&nbsp;</p>
              <p style="text-align:center"><img src="images/txt_confirm_booking.png" width="367" height="22"></p>
              <?php
		 	 $cname = '';
			 $email = '';
			 $mobile = '';
			 $checkRememberMe = '';
			 
          	if (isset($_COOKIE["cname"]) && isset($_COOKIE["email"]) && isset($_COOKIE["mobile"])){
				$cname = $_COOKIE["cname"];
				$email = $_COOKIE["email"];
				$mobile = $_COOKIE["mobile"];
				$checkRememberMe = 'Y';
			}#endif
		  ?>
              <form action="{{URL::to("submitReserve")}}" method="post" class="formPayment">
                <div style="width:336px; margin:auto">
                  <p>
                    <label for="cname" class="txtBrown18_2">Your Name</label>
                    <br />
                    <input type="text" name="cname" value="{{$cname}}" id="cname" class="validate[required]  txtBrown18_2 cName" autocomplete="off">
                  </p>
                  <p>
                    <label for="email" class="txtBrown18_2">Your E-mail</label>
                    <br />
                    <input type="text" name="email" value="{{$email}}" id="email" class="validate[required,custom[email]] cEmails txtBrown18_2" autocomplete="off">
                  </p>
                  <p>
                    <label for="mobile" class="txtBrown18_2">Mobile No.</label>
                    <br />
                    <input type="text" name="mobile" value="{{$mobile}}" id="mobile" class="validate[required,maxSize[10],minSize[9],custom[integer]]  txtBrown18_2 cMobile" autocomplete="off">
                  </p>
                  <div style="margin-bottom:20px">
                    <input type="checkbox" name="remember" id="remember" value="y" <?php if($checkRememberMe != ''){?>checked<?php }?>>
                    <label for="remember" class="txtGold18">Remember Me</label>
                  </div>
                </div>
                <input name="url" type="text" class="url">
                <table width="100%">
                  <tr>
                    <td width="50%" align="right" ><?php $dateBooking = date('Y-m-d H:i', strtotime(" +60 minutes")); 
						if($dateBooking < $movie->showtime_dtmDate_Time){ 
					?>
                      <input type="image" src="images/btn_reserve.png" class="buttonBack hoverImg08" id="bookingConfirm">
                      <?php 	}else{?>
                      <span id="reserveNo"><a  href="#" title="Please make reservations at least 60 minutes before showtime" class="tooltip btnNoBooking"><img src="{{asset("images/btn_reserve_no.png")}}" alt="no reserve" class="buttonBackNo"  ></a></span>
                      <?php }/*  */?>
                      &nbsp; </td>
                    <td align="left" width="50%">&nbsp;
                      <input type="image" src="images/btn_buy.png" class="buttonBack hoverImg08" id="payment"  onclick="javascript: form.action='http://www.embassycineplex.com/services/bay/payment_confirmation.php';"></td>
                  </tr>
                </table>
                <div style="text-align:center; padding:10px; display:none " class="loading">
                  <p class="txtWhite18">Processing ...</p>
                  <img src="{{asset("images/loading.gif")}}" alt="{{$movie->movie_Rating}}"   > </div>
            	<input name="userSessionID" type="hidden" value="{{$userSessionID}}" id="userSessionID">
                <input name="valueInCents" type="hidden" value="{{$valueInCents}}">
                <input name="movieID" type="hidden" value="{{$movieID}}">
                <input name="sessID" type="hidden" value="{{$sessID}}">
                <input name="seatPosition" type="hidden" class="seatPosition">
                <input name="seatsFromSeatTable" type="hidden" class="selectedSeats">
                <input type="hidden" name="transaction_uuid" value="<?php echo uniqid() ?>">
                <input type="hidden" name="signed_field_names"
               value="access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency">
                <input type="hidden" name="unsigned_field_names" size="40" value="ship_to_address_line1,bill_to_forename,bill_to_phone,bill_to_email,bill_to_company_name,bill_to_address_line1,bill_to_address_line2,bill_to_address_city,bill_to_address_state,bill_to_address_postal_code,bill_to_address_country,bill_to_surname">
                <?php
                		//****************
						function str_replace_text($word){
							  $strwordArr = array("#",":"," ","'","/","\"","-","--") ;
							#  $strwordArr = array("#",":"," ") ;
							  $strCensor = " " ;
							  $num  = 50;
								if(strlen($word) >= $num ) {
									$word = iconv_substr($word, 0, $num,"UTF-8")."";				
									foreach ($strwordArr as $value) {
									  $word = str_replace($value,$strCensor ,$word);
									}
									
								}else{ 		  
									foreach ($strwordArr as $value) {
									  $word = str_replace($value,$strCensor ,$word);
									}
								  } #ens if
								  
							  return ( $word) ;
						 }	
						
						 function strCrop($txt,$num) { #ข้อความ,จำนวน
							if(strlen($txt) >= $num ) {
								$txt = iconv_substr($txt, 0, $num,"UTF-8")." ";
							}
							return $txt;
						}
						//****************
						 $movieNameSub =  str_replace_text($movieName);
  	 					$movieNameSub =  strCrop($movieNameSub,16);
				?>
                <input type="hidden" name="ship_to_address_line1" size="60" value="{{$movieNameSub}} | {{ date('d F Y', strtotime($movie->showtime_dtmDate_Time)) }} ({{ date('H:i', strtotime($movie->showtime_dtmDate_Time))}})">
                <input type="hidden" name="bill_to_forename" size="60" value="{{$cname}}" id="bill_to_forename">
                <input type="hidden" name="bill_to_surname" size="60" value="EDS" >
                <input type="hidden" name="bill_to_phone" size="60" value="{{$mobile}}" id="bill_to_phone">
                <input type="hidden" name="bill_to_email" size="60"  value="{{$email}}" id="bill_to_email">
                <input type="hidden" name="bill_to_address_postal_code" size="60" value="10330">
                <input type="hidden" name="bill_to_address_state" size="60" value="Bangkok">
                <input type="hidden" name="bill_to_address_city" size="60" value="Pathumwan">
                <input type="hidden" name="bill_to_address_line1" size="60" value="6th Floor , Central Embassy 1031">
                <input type="hidden" name="bill_to_address_line2" size="60" value="Ploenchit road">
                <input type="hidden" name="bill_to_company_name" size="60" value="Executive Cinema Corporation">
                <input type="hidden" name="transaction_type" size="25" value="sale">
                <input type="hidden" name="bill_to_address_country" size="60" value="TH">
                <input type="hidden" name="currency" size="25" value="THB">
                <input type="hidden" name="reference_number" size="40" value="{{$userSessionID}}">
                <input type="hidden" name="amount" size="25" value="{{$priceTotal}}">
                <input type="hidden" name="signed_date_time" value="<?php echo gmdate("Y-m-d\TH:i:s\Z"); ?>">
                <input type="hidden" name="locale" value="en">
                <input name="website" type="text" class="url">
                <input name="theatreName" type="hidden" value="{{$movie->showtime_strName}}">
                <input name="timeShowing" type="hidden" value="{{$movie->showtime_dtmDate_Time}}">
                <input name="movieName" type="hidden" value="{{$movieName}}">                
                 <input type="hidden" name="access_key" value="cbed4a5d2e2d325a8bda05d0722f44bf">
                <input type="hidden" name="profile_id" value="8EC01B2E-D8F7-449E-8054-2C32C4D2B4CA">
              </form>
              <br>
              <br>
              <br>
              <br>
              <?php //////////////////////// Payment ////////////////////////////?>
            </td>
          </tr>
        </table>
        <p class="clear"></p>
      </div>
      <br>
      <br>
      <div class="content-next clear" id="prevBTN"> <a href="{{URL::to("selectTicket/$movieID/$sessID")}}"><img src="images/btn_seat_prev.png" width="120" height="46" class="hoverImg08"></a> &nbsp; &nbsp; &nbsp; </div>
    </div>
  </div>
    <div class="url">
     <div id='inline_content' style='padding:30px; background:#fff;text-align:center;'>
       <p  class="txtBlack20 fontSynopis"><strong>Please make reservations at least 60 minutes before showtime</strong></p> 
       </div>
   </div>
  @include('frontend.incFooter')</div>
@include('frontend.incScriptBottom')
{{ HTML::script('js/InFieldLabels/jquery.infieldlabel.min.js') }}
{{ HTML::script('js/formValidator/js/languages/jquery.validationEngine-en.js') }}
{{ HTML::script('js/formValidator/js/jquery.validationEngine.js') }}
{{ HTML::script('js/tooltipster/js/jquery.tooltipster2.js') }}
{{ HTML::script('js/timeTo/jquery.timeTo.min.js') }} 
{{ HTML::script('js/colorbox-master/jquery.colorbox.js') }}
<script type="text/javascript" >
jQuery(function(){
   jQuery("label").inFieldLabels();   
	jQuery('.buttonBackNo').bind('click', false); 
   jQuery('.tooltip').tooltipster({ 
	 		fixedWidth: 365 ,offsetY: 25
	}); 
	
	
    var cname = jQuery('#cname').val();	
   	jQuery('#bill_to_forename').val(cname);
	jQuery('#bill_to_surname').val(cname);
	
	
	 var email = jQuery('#email').val();	
   	jQuery('#bill_to_email').val(email);
	
	 var mobile = jQuery('#mobile').val();	
   	jQuery('#bill_to_phone').val(mobile);
	
   jQuery( "#cname" ).keyup(function( event ) {
	 	var cname = jQuery(this).val();		
	  	jQuery('#bill_to_forename').val(cname)	   ;
		jQuery('#bill_to_surname').val(cname)	 ;  
	 });
	 
	  jQuery( "#email" ).keyup(function( event ) {
	 	var email = jQuery(this).val();		
	  	jQuery('#bill_to_email').val(email)	   
	 });
	 
	   jQuery( "#mobile" ).keyup(function( event ) {
	 	var mobile = jQuery(this).val();		
	  	jQuery('#bill_to_phone').val(mobile)	   
	 });
	 
    jQuery(".formPayment").validationEngine('attach', {
		 
		  onValidationComplete: function(form, valid){
            if (valid) { 
                jQuery('#bookingConfirm, #prevBTN, #payment').hide(); 
				jQuery('.loading').fadeIn();
                form.validationEngine('submit');
            }
        }		 
	}); 
   
    jQuery('.imgSeat').tooltipster({ 
	 		fixedWidth: 316 ,offsetY: -15
	}); 
	
	jQuery('a').click(function (e) {
		  e.preventDefault();                   // prevent default anchor behavior
		  var goTo = this.getAttribute("href"); // store anchor href 
		 //** 
		   var var1 = jQuery('#userSessionID').val(); 
		   var var2 = jQuery('.url').val(); 
			jQuery.ajax({
				url : '{{URL::to("cancelTicket")}}', 
					type:"GET", cache: false, data : "var1="+var1+"&var2="+var2,	  	
					success :function(data){ 
				 }
			});   
		  setTimeout(function(){
			   window.location = goTo;
		  },500);       
	  });  
	   jQuery('#countdown').timeTo({
            seconds: 540,
            displayHours: false
		  }, function(){
			  var var1 = jQuery('#userSessionID').val(); 
		   	  var var2 = jQuery('.url').val();
			  
			  jQuery.ajax({
				url : '{{URL::to("cancelTicket")}}', 
					type:"GET", cache: false, data : "var1="+var1+"&var2="+var2,	  	
					success :function(data){ 
					alert('Your session has expired Please try again'); 
					window.location = '{{URL::to("selectTicket/$movieID/$sessID")}}'; 
				 }
			});   
		  });
}); 
</script> 
<script>
<?php
	//****************
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
?> 
</script> 
{{ HTML::script('js/javascript.js') }}
</body>
</html>