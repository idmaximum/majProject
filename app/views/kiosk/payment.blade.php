<?php  
	$logTable = "log_vistaws_" . date('Y_m');
	$email 	=  $dataResults['email'];
	$cname 	=  $dataResults['cname'];
	$mobile	= $dataResults['mobile'];
	$userSessionID	=  $dataResults['userSessionID'];
	$valueInCents	= $dataResults['valueInCents'];
	$seatPosition	= $dataResults['seatPosition'];
	$sessID	= $dataResults['sessID'];
	$movieID	= $dataResults['movieID'];
	 
	$seatsFromSeatTable	= $dataResults['seatsFromSeatTable'];  
    $SeatPrice	 = 	substr("$valueInCents", 0, -2);
	
	$ticketList = array();
	$ticketName = array();
	$ticketPrice = array(); 
	$selectedSeats = array();
	
	$seatsWillSelected = json_decode($seatsFromSeatTable, true);
	
  $wsdl = "http://10.121.130.25/WSVistaWebClient/TicketingService.asmx?WSDL"; 
	  //$wsdl = "http://10.100.101.146/WSVistaWebClient/TicketingService.asmx?WSDL";  
	
	$client = new SoapClient($wsdl, array('trace' => true)); 	
	
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

	// echo json_encode($result);
	 if($result->Result != 'OK'){
			 
	 ?>
            <meta http-equiv="refresh" content="0;URL={{URL::to("kiosk/selectTicketerror/$movieID/$sessID")}}" />    
    <?php 
			  exit(); 
	}#endif 

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
						'CustomerEmail'							=> "$email",
						'CustomerPhone'							=> "$mobile",
						'CustomerName'							=> "$cname",
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
	 
	$result = $client->__soapCall('CompleteOrder', array($params));
	$pincode =  $result->VistaBookingNumber; 
	
	$paymentResult = $result->Result;
	
	$completeOrderData = json_decode(json_encode($result), true);
	unset($completeOrderData['PrintStream']);
	unset($completeOrderData['PrintStreamCollection']); 
	
	$CompleteOrderRequest = json_encode($params);
	$CompleteOrderResponse = json_encode($completeOrderData);
  //**************
?> 
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Embassy Diplomat Screens by AIS</title>
<meta property="og:image" content="http://www.embassycineplex.com/images/share.jpg" /> 
{{HTML::style('css/reset.css')}}
{{HTML::style('css/font.css')}}
{{HTML::style('css/screenKiosk.css')}}
{{HTML::style('css/screen2.css')}} 
{{HTML::style('css/screenInside.css')}}  
{{HTML::style('css/screenTickets.css')}} 
@include('kiosk.incScriptTop') 
</head>
<body>
<div id="main"> @include('kiosk.incHeader')
  <div id="content" class="content-main">
   <div class="contentPage">
      <div class="movie-step">
        <p><img src="../images/step_seat_type_3.png" width="820" ></p>
      </div>
      <p>&nbsp;</p>
      <div class="contentOrderComplate">
      <p style="text-align:center"><img src="../images/ic_confirmation.png" width="252" height="65"></p>
      <p style="text-align:center">&nbsp;</p>
       <p class="linePayment"></p>
      <p>&nbsp; </p>
      <div class="content-detail-movie">
     	 @foreach($movie_DataDetail as $movie)
          <?php
			  $movieName =	$movie->movie_Name_EN;  
			  $sessID = $movie->showtime_Session_strID;
			  $imgPoster = $movie->movie_Img_Thumb;
			  $movieSession = $movie->showtime_dtmDate_Time;
			  $hall 		=	$movie->showtime_strName;
		   ?>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="18%" valign="top"><div class="rowShowTodayImage"><img src="{{asset("uploads/movie/$imgPoster")}}" width="140" height="210" class="hoverImg08" alt="{{$movieName}}"></div></td>
              <td width="82%" align="left" valign="top"><h2 class="txtGold24">{{$movieName}}</h2>
                <p>&nbsp;</p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="15%">   <?php
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
			?><p><img src="{{asset("images/icon/$imgRate")}}" alt="{{$movie->movie_Rating}}" style="padding:0; max-width:40px"> 
                 	<img src="{{asset("images/icon/$imgSystem")}}" alt="{{$systemName}}" style="width:40px"></p></td>
                    <td width="85%" class="txtSoundTrack"><?php
                   		$showtimes =  $movie->showtime_soundAttributes.";";
						echo	 $showtimes = strstr($showtimes, ';', true); // As of PHP 5.3.0
				   ?></td>
                  </tr>
                </table>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detailComplate">
                  <tr>
                    <td width="15%">Date </td>
                    <td width="24%" class="txtWhite18">{{ date('d F Y', strtotime($movieSession)) }}</td>
                    <td width="13%">Hall</td>
                    <td width="18%" class="txtWhite18">{{strReplaceText($movie->showtime_strName)}}</td>
                    <td width="15%">Total Price</td>
                    <td width="15%" class="txtWhite18"><?php  echo number_format($SeatPrice)?>  Baht</td>
                  </tr>
                  <tr>
                    <td>Time</td>
                    <td class="txtWhite18">{{ date('H:i', strtotime($movieSession))}}</td>
                    <td> Seat No.</td>
                    <td colspan="3" class="txtWhite18">
                      <?php    echo rtrim(trim($seatPosition), ',') . "";?>
                    </td>
                  </tr>
                  <tr>
                    <td>Your Name</td>
                    <td class="txtWhite18">{{$cname}}</td>
                    <td> Phone</td>
                    <td class="txtWhite18">{{$mobile}}</td>
                    <td>Booking No</td>
                    <td class="txtWhite18">{{$pincode}}</td>
                  </tr>
                </table>
              <p>&nbsp;</p></td>
            </tr>
          </table>
          @endforeach
        </div>
        <p class="linePayment"></p>
        <div class="content-seat-type"> 
          <p>&nbsp;</p>
          <div class="contentQrcode">     
          <?php
          		$pincodeQR = 	sprintf("%07d",$pincode);
		  ?>     	
          	<p><img src="https://chart.googleapis.com/chart?chs=250x250&amp;cht=qr&amp;chl={{$pincodeQR}}&amp;choe=UTF-8" alt="QR code"></p>
          	<p style="padding-top:5px;letter-spacing:2px ; font-size:24px" class="txtWhite22"><span style="letter-spacing:0px">Booking No. </span> {{$pincode}}</p>
          </div>
          <p>&nbsp;</p>
          <p class="txtRed18" style="padding:10px 0 12px 0;">Please pay for your reserved tickets at Box Office 60 minutes before showtime </p>
          <p class="txtRed18">Bookings will automatically be cancelled if not issued 60 minutes before showtime</p>
          <p class="clear"></p>
        </div>
      </div>
    </div>
</div>
  @include('kiosk.incFooter') </div>
@include('kiosk.incScriptBottom')
<?php
		//****	Update Update Log	*****
  	$dataTblLog =  DB::table($logTable)
						  ->where('user_session_id' , $userSessionID) 
						  ->pluck('soap_process'); 			 
	$SOAPprocess = $dataTblLog.', CompleteOrder';
  
 	 DB::table($logTable)
			->where('user_session_id', $userSessionID)
			->update(array('soap_process'			=> $SOAPprocess,  
							'order_payment' 	=> 'BOOKING',
							'order_status' 	=> 'SUCCESS',							
							'email' 	=> $email,
							'cname' 	=> $cname,
							'phone' 	=> $mobile,
							'channel' 	=> 'KIOSK',
							'amount' 	=> $SeatPrice, 
							'seat' 	=> $seatPosition,
							'show_time' 	=> $movieSession,
							'theater' 	=> $hall,
							'movie' 	=> $movieName, 							
							'pincode' 	=> $pincode,  
							 'status' 					=> $paymentResult, 
						 	 'completeorder_status' 	=> $paymentResult,  
							 
						    'completeorder_request' 	=> $CompleteOrderRequest,  
						    'completeorder_response'	=> $CompleteOrderResponse));  
	//******* End Update Log	*****
	
	$data = array(
		'seatPosition'	=> $seatPosition,
		'SeatPrice'		=> $SeatPrice,
		'imgSystem'		=> $imgSystem,
		'systemName'	=> $systemName, 
		'imgRate'		=> $imgRate, 
		'movieName'		=> $movieName,
		'sessID'		=> $sessID,
		'imgPoster'		=> $imgPoster,
		'movieSession'	=> $movieSession,  
		'pincode'		=> $pincode,
		'mobile'		=> $mobile,
		'hall'			=> $hall, 
		'showtimes'		=> $showtimes, 
		'cname'			=> $cname, 		 
		'email'			=> $email 
	); 
	
	$user = array(
			'email'=> $email 
	);
	 
 Mail::send('emails.enews', $data , function($message)use ($user){  
	  $message->to($user['email'], $user['email'])->subject('Movie ticket booking notification from Embassycineplex.com');
 });
 Session::forget('userSessionID');  //End session
?>
</body>
</html>