<?php
	 $logTable = "log_vistaws_" . date('Y_m'); 
		//*********************************
		
		$wsdl = "http://10.121.130.25/WSVistaWebClient/TicketingService.asmx?WSDL"; 
		$client = new SoapClient($wsdl, array('trace' => true));  
		 
		if(Session::get('userSessionID') != ''){ //cancel order 
		
				$userSessionID = Session::get('userSessionID');
			 
				$params = array(	'OptionalClientClass'	=> "WWW",
									'OptionalClientId' 		=> "111.111.111.112", 
									'OptionalClientName'	=> "WEB",
									'UserSessionId'			=> $userSessionID);
				$result = $client->__soapCall('CancelOrder', array($params));
				$CancelOrderRequest =  $client->__getLastRequest();
				$CancelOrderResponse =  $client->__getLastResponse();
								
				$dataTblLog =  DB::table($logTable)
										->where('user_session_id' , $userSessionID) 
										->pluck('soap_process'); 			 
				  $SOAPprocess = $dataTblLog.', CancelOrder';
				
				DB::table($logTable)
						  ->where('user_session_id', $userSessionID)
						  ->update(array('soap_process'			=> $SOAPprocess, 
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
		  if($result->Result != 'OK'){
			 
			 ?>
            <meta http-equiv="refresh" content="0;URL={{URL::to("selectTicketerror/$movieID/$sessID")}}" />    
          <?php 
			  exit(); 
		  }#endif 
		  
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
$addTicketRequest = $client->__getLastRequest();
$addTicketResponse = $client->__getLastResponse(); 
 $dateNow = date('Y-m-d H:i:s');
 
 DB::table($logTable)->insert(
    array(
	'soap_process' => 'AddTickets', 
	'date_time' => $dateNow, 
	'status' => $addTicketResult, 
	'addticket_request' => $addTicketRequest, 
	'addticket_response' =>  $addTicketResponse ,
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

$GetSessionRequest =  $client->__getLastRequest();
$GetSessionResponse =  $client->__getLastResponse();

//****	Update Update Log	*****
  	$dataTblLog =  DB::table($logTable)
						  ->where('user_session_id' , $userSessionID) 
						  ->pluck('soap_process'); 			 
	$SOAPprocess = $dataTblLog.', GetSessionSeatData';
 	 $GetSessionResponse = 'OK';
 	 DB::table($logTable)
			->where('user_session_id', $userSessionID)
			->update(array('soap_process'			=> $SOAPprocess, 
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

	$SetSessionRequest =  $client->__getLastRequest();
	$SetSessionResponse =  $client->__getLastResponse();
	
	//****	Update Update Log	*****
  	$dataTblLog =  DB::table($logTable)
						  ->where('user_session_id' , $userSessionID) 
						  ->pluck('soap_process'); 			 
	$SOAPprocess = $dataTblLog.', SetSelectedSeats';
  
 	 DB::table($logTable)
			->where('user_session_id', $userSessionID)
			->update(array('soap_process'			=> $SOAPprocess, 
						   'setselectedseat_request' 	=> $SetSessionRequest, 
						   'setselectedseat_response'	=> $SetSessionResponse));  
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
?> 
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Embassy Diplomat Screens by AIS</title>
<meta property="og:image" content="http://www.embassycineplex.com/images/share.jpg" /> 
{{HTML::style('css/reset.css')}}
{{HTML::style('css/font.css')}}
{{HTML::style('css/screen.css')}}
{{HTML::style('css/screen2.css')}}
{{HTML::style('css/screenInside.css')}}
{{HTML::style('js/DropDown/css/style.css')}}
{{HTML::style('css/screenTickets.css')}}
{{HTML::style('js/tooltipster/css/tooltipster2.css')}}
{{HTML::style('js/formValidator/css/validationEngine.jquery.css')}}
{{HTML::style('js/timeTo/timeTo.css')}} 
@include('frontend.incScriptTop')
</head>
<body> 
<div id="main"> @include('frontend.incHeader')
 <div id="countdown" class="url"></div>
  <div id="content" class="content-main">
    <div class="titleMovie"> 
      <a href="{{URL::to("selectTicket/$movieID/$sessID")}}"><img src="images/btn-back.png"  alt="btn Back"></a>
    </div>
    <div class="contentPage">
   	 @foreach($movie_DataDetail as $movie)
     <?php
     	$movieName =	$movie->movie_Name_EN;  
		$sessID = $movie->showtime_Session_strID;
	 ?>
      <div class="content-detail-movie">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="18%"><div class="rowShowTodayImage"><img src="{{asset("uploads/movie/$movie->movie_Img_Thumb")}}" width="140" height="210" class="hoverImg08" alt="{{$movieName}}"></div></td>
            <td width="82%" align="left" valign="top"><h2 class="txtGold24">{{$movieName}}</h2>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="15%">
                   <?php
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
				 }  //*************
			?><p><img src="{{asset("images/icon/$imgRate")}}" alt="{{$movie->movie_Rating}}" style="padding:0; max-width:40px"> 
                 	<img src="{{asset("images/icon/$imgSystem")}}" alt="{{$systemName}}" style="max-width:40px"></p>
                  </td>
                  <td width="85%" class="txtSoundTrack"><?php
                   		$showtimes =  $movie->showtime_soundAttributes.";";
						echo	 $showtimes = strstr($showtimes, ';', true); // As of PHP 5.3.0
				   ?></td>
                </tr>
              </table>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <table width="100%" border="0" cellspacing="1" cellpadding="1" class="detailTable">
                <tr>
                  <td width="33%">Date <span class="txtWhite18">{{ date('d F Y', strtotime($movie->showtime_dtmDate_Time)) }}</span></td>
                  <td width="33%">Time <span class="txtWhite18">{{ date('H:i', strtotime($movie->showtime_dtmDate_Time))}}</span></td>
                  <td width="33%">Hall <span class="txtWhite18">{{strReplaceText($movie->showtime_strName)}}</span></td>
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
							  $imgName = "images/theater/" . 
							  str_replace(' ', '_', $allSeats[$idxRow][$idxCol]['Description']) . "_" . 
							  $allSeats[$idxRow][$idxCol]['Status'] . "_" . 
							  $allSeats[$idxRow][$idxCol]['SeatStyle'];
			  
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
      <?php if ($numSeatType > 1){?><br> 
         <div class="total-price">Total Price   <span class="txtWhite18">
		 <?php
		 	 $priceTotal	 = 	substr("$priceTotal", 0, -2); 
		    echo number_format($priceTotal)?></span> Baht</div> 
            <?php }#end if?>
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
        <p>
            <label for="cname" class="txtBrown18_2">Your Name</label><br />
            <input type="text" name="cname" value="{{$cname}}" id="cname" class="validate[required]  txtBrown18_2 cName">
        </p>
         <p>
            <label for="email" class="txtBrown18_2">Your E-mail</label><br />
            <input type="text" name="email" value="{{$email}}" id="email" class="validate[required,custom[email]] cEmails txtBrown18_2">
        </p>
        <p>
            <label for="mobile" class="txtBrown18_2">Mobile No.</label><br />
            <input type="text" name="mobile" value="{{$mobile}}" id="mobile" class="validate[required,maxSize[10],minSize[9],custom[integer]]  txtBrown18_2 cMobile">
        </p>
          <div style="margin-bottom:20px">
            <input type="checkbox" name="remember" id="remember" value="y" <?php if($checkRememberMe != ''){?>checked<?php }?>>
            <label for="remember" class="txtGold18">Remember Me</label> 
          </div>
           
        <input name="url" type="text" class="url">
        <?php  $dateBooking = date('Y-m-d H:i', strtotime(" +60 minutes")); 
				if($dateBooking < $movie->showtime_dtmDate_Time){ 
		?>
        <input type="image" src="images/btn-confirm-booking.png" class="buttonBack" id="bookingConfirm">
         <div style="text-align:center; padding:10px; display:none " class="loading">
         	<p class="txtWhite18">Processing ...</p>
         	<img src="{{asset("images/loading.gif")}}" alt="{{$movie->movie_Rating}}"   >
         </div> 
		<input name="userSessionID" type="hidden" value="{{$userSessionID}}" id="userSessionID">
        <input name="valueInCents" type="hidden" value="{{$valueInCents}}">
        <input name="movieID" type="hidden" value="{{$movieID}}">
        <input name="sessID" type="hidden" value="{{$sessID}}">
        <?php 	}else{?>
         <div class="txtRed24  fontSynopis">Bookings can only be made not less than 60mins prior
to show time. <br>Please select a later time.
		 </div>
        <?php }?>
    <input name="seatPosition" type="hidden" id="seatPosition">
    <input name="seatsFromSeatTable" type="hidden" id="selectedSeats"> 
      </form>
      </td>
     
      </tr>
      </table>
      <p class="clear"></p> 
    </div><br><br> 
		<div class="content-next clear" id="prevBTN">  
 		 <a href="{{URL::to("selectTicket/$movieID/$sessID")}}"><img src="images/btn_seat_prev.png" width="120" height="46"></a> &nbsp; &nbsp; &nbsp; </div> 
         
    </div>
  </div>
  @include('frontend.incFooter')</div>
@include('frontend.incScriptBottom')
{{ HTML::script('js/InFieldLabels/jquery.infieldlabel.min.js') }}
{{ HTML::script('js/formValidator/js/languages/jquery.validationEngine-en.js') }}
{{ HTML::script('js/formValidator/js/jquery.validationEngine.js') }}
{{ HTML::script('js/tooltipster/js/jquery.tooltipster2.js') }}
{{ HTML::script('js/timeTo/jquery.timeTo.min.js') }} 
<script type="text/javascript" >
jQuery(function(){
   jQuery("label").inFieldLabels();  
   
    jQuery(".formPayment").validationEngine('attach', {
		 
		  onValidationComplete: function(form, valid){
            if (valid) { 
                jQuery('#bookingConfirm, #prevBTN').hide(); 
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
	//****************
?>
function addCommas(NumberStr)
{
    NumberStr+= '';
	var NumberStr = NumberStr.substring(0, NumberStr.length-2);
    NumberData = NumberStr.split('.');
    Number1 = NumberData[0];
    Number2 = NumberData.length > 1 ? '.' + NumberData[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(Number1)) {
        Number1 = Number1.replace(rgx, '$1' + ',' + '$2');
    }
    return Number1 + Number2;
}

var selectedSeats = [];
var seatWithName = [];
var seatWithNameTable = [];

for (var idx = 0; idx < reservedSeats.length; idx++) 
{
	selectedSeats.push(reservedSeats[idx]['SeatData']);
}
/*
for (var idx = 0; idx < ticketList.length; idx++) 
{
	seatWithName.push(ticketName[idx] + " : " + ticketList[idx]+ " - Price : " + ticketPrice[idx]);
} 
seatWithName.sort();

$('#seatChanged').html('Selected Seats : ' + selectedSeats.join(', ') + '<br>Seat Package : ' + ticketList.join(' || ') + '<br><br>&nbsp;&nbsp;- ' + seatWithName.join('<br>&nbsp;&nbsp;- ')); 
*/ 

	var seatPositionBefore =  selectedSeats.join(', ');
	jQuery( "#seatPosition" ).val(seatPositionBefore);
	jQuery( "#selectedSeats" ).val(JSON.stringify(reservedSeats));
	 
///*******************
for (var idx = 0; idx < ticketList.length; idx++) {
	//sizeof(); 
	var TextTicketName = ticketName[idx];
	 
	seatWithNameTable.push("<tr><td width='33%'>"+TextTicketName +" <span class='txtWhite18'>"+ "" + "</span></td><td width='33%'>Seat No. <span class='txtWhite18'>" + ticketList[idx]+ "</span></td><td width='33%'>Price <span class='txtWhite18'>" + addCommas(ticketPrice[idx]) + " Baht</span></td></tr>"); 
	 
} 
seatWithNameTable.sort();

$('#detailPaymentTicket').html(seatWithNameTable);
///******************* 

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

	var selectedSeats = [];
	var seatWithName = [];
	var seatWithNameTable = [];

	for (var idx = 0; idx < reservedSeats.length; idx++) 
	{
		selectedSeats.push(reservedSeats[idx]['SeatData']);
	}
	 
	/*for (var idx = 0; idx < ticketList.length; idx++) 
	{
		seatWithName.push(ticketName[idx] + " : " + ticketList[idx] + " - Price : " + ticketPrice[idx]);
	}

	seatWithName.sort();

	$('#seatChanged').html('Selected Seats : ' + selectedSeats.join(', ') + '<br>Seat Package : ' + ticketList.join(' || ') + '<br><br>&nbsp;&nbsp;- ' + seatWithName.join('<br>&nbsp;&nbsp;- ')); */
	
	var seatPosition =  selectedSeats.join(', ');
	jQuery( "#seatPosition" ).val(seatPosition);
	jQuery( "#selectedSeats" ).val(JSON.stringify(seatWillReserved));
	 
	///*******************
for (var idx = 0; idx < ticketList.length; idx++) {
	//sizeof(); 
	var TextTicketName = ticketName[idx];
	 
	seatWithNameTable.push("<tr><td width='33%'>"+TextTicketName +" <span class='txtWhite18'>"+ "" + "</span></td><td width='33%'>Seat No. <span class='txtWhite18'>" + ticketList[idx]+ "</span></td><td width='33%'>Price <span class='txtWhite18'>" + addCommas(ticketPrice[idx]) + " Baht</span></td></tr>"); 
	 
} 
seatWithNameTable.sort();

$('#detailPaymentTicket').html(seatWithNameTable);
///******************* v
});
</script>
</body>
</html> 