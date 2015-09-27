<?php 
class MovieBookingController extends BaseController { 
	  
	 public function selectTicket($movieID = null,$sessionID = null){ 
		function strReplaceText($word){
			$strwordArr = array("Theater ","Theatre ");
			$strCensor = "" ;
			
			foreach ($strwordArr as $value) {
				$word = str_replace($value,$strCensor ,$word);
			} 				 
			return ($word);
	   }#end fn 						
		$rowMovieDetail = DB::table('movie_showtimes')
						->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
						->where('movie_showtimes.showtime_Session_strID','=', $sessionID)
						->where('movie_list.movieID','=', $movieID) 
						->where('movie_list.movieID','>', '0')
						->where('movie_list.movie_Publish' , '1') 
						->get(); 						
	 
		 return View::make('frontend.selectTicketType')-> with('movie_DataDetail', $rowMovieDetail) ;
		 //return $movieID; 
	 }#end fb selectTicket
	 
	  public function selectTicketTH($movieID = null,$sessionID = null){ 
		  function strReplaceText($word){
			  $strwordArr = array("Theater ","Theatre ");
			  $strCensor = "" ;
			  
			  foreach ($strwordArr as $value) {
				  $word = str_replace($value,$strCensor ,$word);
			  } 				 
			  return ($word);
		 }#end fn 						
		$rowMovieDetail = DB::table('movie_showtimes')
						->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
						->where('movie_showtimes.showtime_Session_strID','=', $sessionID)
						->where('movie_list.movieID','=', $movieID) 
						->where('movie_list.movieID','>', '0')
						->where('movie_list.movie_Publish' , '1') 
						->get(); 						
	 
		 return View::make('frontendTH.selectTicketType')-> with('movie_DataDetail', $rowMovieDetail) ;
		 //return $movieID; 
	 }#end fb selectTicket
	 
	   public function selectTicketKiosk($movieID = null,$sessionID = null){ 
		  function strReplaceText($word){
			  $strwordArr = array("Theater ","Theatre ");
			  $strCensor = "" ;
			  
			  foreach ($strwordArr as $value) {
				  $word = str_replace($value,$strCensor ,$word);
			  } 				 
			  return ($word);
		 }#end fn 						
		$rowMovieDetail = DB::table('movie_showtimes')
						->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
						->where('movie_showtimes.showtime_Session_strID','=', $sessionID)
						->where('movie_list.movieID','=', $movieID) 
						->where('movie_list.movieID','>', '0')
						->where('movie_list.movie_Publish' , '1') 
						->get(); 						
	 
		 return View::make('kiosk.selectTicketType')-> with('movie_DataDetail', $rowMovieDetail) ;
		 //return $movieID; 
	 }#end fb selectTicket
	 
	 
 	 public function selectSeat(){ 
		function strReplaceText($word){
			$strwordArr = array("Theater ","Theatre ");
			$strCensor = "" ;
			
			foreach ($strwordArr as $value) {
				$word = str_replace($value,$strCensor ,$word);
			} 				 
			return ($word);
	   }#end fn 
		 $movieID 		= Input::get('movieID');	
		 $sessID 		= Input::get('sessID');	
		 $ticket_code 	=  Input::get('ticket_code') ; 
		 $url 	=  Input::get('url') ; 
		if($url == ''){  
		 
			 $rowMovieDetail = DB::table('movie_showtimes')
						->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
						->where('movie_showtimes.showtime_Session_strID','=', $sessID)
						->where('movie_list.movieID','=', $movieID) 
						->where('movie_list.movieID','>', '0')
						->where('movie_list.movie_Publish' , '1') 
						->get(); 		
	 
	 	$ticketTypes = array();
		  $numSeat = '';
		  
		  foreach (explode(",", $ticket_code) as $idx){   
			 if(Input::get('nTicket'.$idx)){
				 
				 	$nameTypeSeat = Input::get('nTicket'.$idx); 
					$countSeat = $nameTypeSeat ;
				 
			 	 	$ticketTypes['TicketType'][] = array(
													'TicketTypeCode'			=> $idx,
													'Qty'						=> $countSeat,
													'PriceInCents'				=> Input::get('price'.$idx),
													'OptionalAreaCatSequence'	=> Input::get('areaCatIntSeq'.$idx),
													'BookingFeeOverride'		=> null,
													'LoyaltyRecognitionSequence'=> 0 
												); 
					$userTickets[] = array(	'TicketTypeCode'		=> $idx,
								'Qty'					=> $countSeat,
								'AreaCatCode'			=> Input::get('areaCatCode'.$idx), 
								'AreaNumber'			=> 0,
								'SeatsPerTicket'		=> Input::get('seatsPerTicket'.$idx),
								'SeatsLeft'				=> Input::get('seatsPerTicket'.$idx) * $countSeat);
				 
				 }#end if   
		  }#end foreach 
		//   return $userTickets ;
		return View::make('frontend.selectSeat')-> with('ticketTypes' , $ticketTypes)
		 											-> with('userTickets' , $userTickets)
		  								 			-> with('movieID'  , $movieID)
													-> with('sessID'  , $sessID)
													-> with('movie_DataDetail', $rowMovieDetail);  /* */
		}#end if url
	 }#end fb selectSeat
	 
	  public function selectSeatTH(){ 
		function strReplaceText($word){
			$strwordArr = array("Theater ","Theatre ");
			$strCensor = "" ;
			
			foreach ($strwordArr as $value) {
				$word = str_replace($value,$strCensor ,$word);
			} 				 
			return ($word);
	   }#end fn 
		 $movieID 		= Input::get('movieID');	
		 $sessID 		= Input::get('sessID');	
		 $ticket_code 	=  Input::get('ticket_code') ; 
		 $url 	=  Input::get('url') ; 
		if($url == ''){  
		 
			 $rowMovieDetail = DB::table('movie_showtimes')
						->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
						->where('movie_showtimes.showtime_Session_strID','=', $sessID)
						->where('movie_list.movieID','=', $movieID) 
						->where('movie_list.movieID','>', '0')
						->where('movie_list.movie_Publish' , '1') 
						->get(); 		
	 
	 	$ticketTypes = array();
		  $numSeat = '';
		  
		  foreach (explode(",", $ticket_code) as $idx){   
			 if(Input::get('nTicket'.$idx)){
				 
				 	$nameTypeSeat = Input::get('nTicket'.$idx); 
					$countSeat = $nameTypeSeat ;
				 
			 	 	$ticketTypes['TicketType'][] = array(
													'TicketTypeCode'			=> $idx,
													'Qty'						=> $countSeat,
													'PriceInCents'				=> Input::get('price'.$idx),
													'OptionalAreaCatSequence'	=> Input::get('areaCatIntSeq'.$idx),
													'BookingFeeOverride'		=> null,
													'LoyaltyRecognitionSequence'=> 0 
												); 
					$userTickets[] = array(	'TicketTypeCode'		=> $idx,
								'Qty'					=> $countSeat,
								'AreaCatCode'			=> Input::get('areaCatCode'.$idx), 
								'AreaNumber'			=> 0,
								'SeatsPerTicket'		=> Input::get('seatsPerTicket'.$idx),
								'SeatsLeft'				=> Input::get('seatsPerTicket'.$idx) * $countSeat);
				 
				 }#end if   
		  }#end foreach 
		//   return $userTickets ;
		return View::make('frontendTH.selectSeat')-> with('ticketTypes' , $ticketTypes)
		 											-> with('userTickets' , $userTickets)
		  								 			-> with('movieID'  , $movieID)
													-> with('sessID'  , $sessID)
													-> with('movie_DataDetail', $rowMovieDetail);  /* */
		}#end if url
	 }#end fb selectSeat
	 
	  public function selectSeatKiosk(){ 
		function strReplaceText($word){
			$strwordArr = array("Theater ","Theatre ");
			$strCensor = "" ;
			
			foreach ($strwordArr as $value) {
				$word = str_replace($value,$strCensor ,$word);
			} 				 
			return ($word);
	   }#end fn 
		 $movieID 		= Input::get('movieID');	
		 $sessID 		= Input::get('sessID');	
		 $ticket_code 	=  Input::get('ticket_code') ; 
		 $url 	=  Input::get('url') ; 
		if($url == ''){  
		 
			 $rowMovieDetail = DB::table('movie_showtimes')
						->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
						->where('movie_showtimes.showtime_Session_strID','=', $sessID)
						->where('movie_list.movieID','=', $movieID) 
						->where('movie_list.movieID','>', '0')
						->where('movie_list.movie_Publish' , '1') 
						->get(); 		
	 
	 	$ticketTypes = array();
		  $numSeat = '';
		  
		  foreach (explode(",", $ticket_code) as $idx){   
			 if(Input::get('nTicket'.$idx)){
				 
				 	$nameTypeSeat = Input::get('nTicket'.$idx); 
					$countSeat = $nameTypeSeat ;
				 
			 	 	$ticketTypes['TicketType'][] = array(
													'TicketTypeCode'			=> $idx,
													'Qty'						=> $countSeat,
													'PriceInCents'				=> Input::get('price'.$idx),
													'OptionalAreaCatSequence'	=> Input::get('areaCatIntSeq'.$idx),
													'BookingFeeOverride'		=> null,
													'LoyaltyRecognitionSequence'=> 0 
												); 
					$userTickets[] = array(	'TicketTypeCode'		=> $idx,
								'Qty'					=> $countSeat,
								'AreaCatCode'			=> Input::get('areaCatCode'.$idx), 
								'AreaNumber'			=> 0,
								'SeatsPerTicket'		=> Input::get('seatsPerTicket'.$idx),
								'SeatsLeft'				=> Input::get('seatsPerTicket'.$idx) * $countSeat);
				 
				 }#end if   
		  }#end foreach 
		//   return $userTickets ;
		return View::make('kiosk.selectSeat')-> with('ticketTypes' , $ticketTypes)
		 											-> with('userTickets' , $userTickets)
		  								 			-> with('movieID'  , $movieID)
													-> with('sessID'  , $sessID)
													-> with('movie_DataDetail', $rowMovieDetail);  /* */
		}#end if url
	 }#end fb selectSeat
	 
	  public function submitReserve(){ 
	  	function strReplaceText($word){
			$strwordArr = array("Theater ","Theatre ");
			$strCensor = "" ;
			
			foreach ($strwordArr as $value) {
				$word = str_replace($value,$strCensor ,$word);
			} 				 
			return ($word);
	   }#end fn 
	  
	  	$remember = '';
		
	    $input = Input::all();
	  	$sessID = $input['sessID'];
		$movieID = $input['movieID'];
		
		$cname = $input['cname'];
		$email = $input['email'];
		$mobile = $input['mobile']; 
		
		if (isset($input['remember'])){
		  setcookie("cname",	$cname, strtotime( '+365 days' )); 
		  setcookie("email",	$email, strtotime( '+365 days' )); 
		  setcookie("mobile",	$mobile, strtotime( '+365 days' )); 
		}#end 
	  	 $rowMovieDetail = DB::table('movie_showtimes')
						->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
						->where('movie_showtimes.showtime_Session_strID','=', $sessID)
						->where('movie_list.movieID','=', $movieID) 
						->where('movie_list.movieID','>', '0')
						->where('movie_list.movie_Publish' , '1') 
						->get(); 						
		 
		return  View::make('frontend.payment')-> with('movie_DataDetail', $rowMovieDetail)
											  -> with('dataResults' , $input); 
	 }#end fb selectSeat
	 
	  public function submitReserveKiosk(){ 
	  	function strReplaceText($word){
			$strwordArr = array("Theater ","Theatre ");
			$strCensor = "" ;
			
			foreach ($strwordArr as $value) {
				$word = str_replace($value,$strCensor ,$word);
			} 				 
			return ($word);
	   }#end fn 
	  
	  	$remember = '';
		
	    $input = Input::all();
	  	$sessID = $input['sessID'];
		$movieID = $input['movieID'];
		
		$cname = $input['cname'];
		$email = $input['email'];
		$mobile = $input['mobile']; 
		
		if (isset($input['remember'])){
		  setcookie("cname",	$cname, strtotime( '+365 days' )); 
		  setcookie("email",	$email, strtotime( '+365 days' )); 
		  setcookie("mobile",	$mobile, strtotime( '+365 days' )); 
		}#end 
	  	 $rowMovieDetail = DB::table('movie_showtimes')
						->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
						->where('movie_showtimes.showtime_Session_strID','=', $sessID)
						->where('movie_list.movieID','=', $movieID) 
						->where('movie_list.movieID','>', '0')
						->where('movie_list.movie_Publish' , '1') 
						->get(); 						
		 
		return  View::make('kiosk.payment')-> with('movie_DataDetail', $rowMovieDetail)
											  -> with('dataResults' , $input); 
	 }#end fb selectSeat
	 
	 
	 public function cancelOrder(){ 
		 
		  $chkUrl =  Input::get('var2');
		 
		  if($chkUrl == ''){			 
				$userSessionID =  Input::get('var1'); 
				
				$wsdl = "http://10.121.130.25/WSVistaWebClient/TicketingService.asmx?WSDL"; 
				//$wsdl = "http://10.100.101.146/WSVistaWebClient/TicketingService.asmx?WSDL"; 
				
				$client = new SoapClient($wsdl, array('trace' => true)); 
				
				$params = array(	'OptionalClientClass'	=> "WWW",
									'OptionalClientId' 		=> "111.111.111.112", 
									'OptionalClientName'	=> "WEB",
									'UserSessionId'			=> $userSessionID);
									
				$result = $client->__soapCall('CancelOrder', array($params));
			 	
				$cancelResult = $result->Result;
				$CancelOrderRequest = json_encode($params);
				$CancelOrderResponse = json_encode($result);				
				
				// Update To Log DB
				$logTable = "log_vistaws_" . date('Y_m');	
				
				//********* Add soap_process ****
				$dataTblLog =  DB::table($logTable)
										->where('user_session_id' , $userSessionID) 
										->pluck('soap_process'); 			 
				$SOAPprocess = $dataTblLog.', CancelOrder';
				//********* End Add soap_process ****
							
				DB::table($logTable)
						  ->where('user_session_id', $userSessionID)
						  ->update(array(
										 'soap_process'			=> $SOAPprocess, 
										 'status' 	=> $cancelResult, 
										 'cancelorder_request' 	=> $CancelOrderRequest, 
								  		 'cancelorder_response' => $CancelOrderResponse)); 
				// End Update To log
				
		 }#end if	
	 }#end fn cancel order
	 
	 public function getUserIDToSendMail(){
		 
		     $userSessionID =  Input::get('user_session_id');  
		 	$logTable = "log_vistaws_" . date('Y_m');	 
		 
		    $DataLogBooking = DB::table($logTable)
						  ->select('phone', 'email', 'cname', 'theater', 
						  		   'show_time', 'session_id', 'movie', 'seat', 'amount' , 'pincode' )
						  ->where('user_session_id','=', $userSessionID) 
						  ->where('pincode','!=', '')
						  ->get(); 
						  
		   foreach ($DataLogBooking as $resultLog){ 
				$mobile 		=  $resultLog->phone;
				$email		=  $resultLog->email;
				$cname 		=  $resultLog->cname;
				$hall	 	=  $resultLog->theater;
				$movieSession 	=  $resultLog->show_time;
			 	$sessID	    =  $resultLog->session_id;
				$movieName =  $resultLog->movie;
			    $seatPosition   =  $resultLog->seat;
				$SeatPrice	   =  $resultLog->amount; 
				$pincode	   =  $resultLog->pincode;  
			} #end foreach
			
			//**********
		    $rowMovieDetail = DB::table('movie_showtimes')
							  ->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
							  ->where('movie_showtimes.showtime_Session_strID','=', $sessID) 
							  ->where('movie_list.movieID','>', '0')
							  ->where('movie_list.movie_Publish' , '1') 
							  ->get(); 
			//***********
			foreach ($rowMovieDetail as $resultMovieDetail){ 
				$movieName 			=  $resultMovieDetail->movie_Name_EN;
				$imgPoster			=  $resultMovieDetail->movie_Img_Thumb;
				$showtimes 			=  $resultMovieDetail->showtime_soundAttributes;
				$movie_Rating 			=  $resultMovieDetail->movie_Rating; 
				$showtime_SystemType 	=  $resultMovieDetail->showtime_SystemType; 
				
			} #end foreach
			
				if($movie_Rating == "ส."){ 
					$imgRate = "rate_raise.png"; 
				 }else if($movie_Rating == "น13+"){ 
					$imgRate = "rate_up_13_en.png";
				 }else if($movie_Rating == "น15+"){ 
					$imgRate = "rate_up_15_en.png";
				 }else if($movie_Rating == "น18+"){ 
					$imgRate = "rate_up_18_en.png";
				  }else if($movie_Rating == "ฉ20-"){ 
					$imgRate = "rate_under_20_en.png";
				  }else { 
					$imgRate = "rate_general_en.png";
				 }//***********
				 
				 if($showtime_SystemType == "VS00000001"){ 
					$imgSystem = "type_digital.png";
					$systemName = '2D';
				 }else if($showtime_SystemType == "0000000001"){ 
					$imgSystem = "type_3d.png";
					$systemName = 'D3D';
				  }else if($showtime_SystemType == "0000000002"){ 
					$imgSystem = "type_hfr_3d.png";
					$systemName = 'HFR 3D';		  
				 }else{
					$imgSystem = "type_digital.png";
					$systemName = '2D';
				 }  //*************
			
		//********** Start Send mail **/////////////
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
		 });	/**/
		 echo 'OK';
		//********* ****************************	
			
	 
	}#end fn getUserIDToSendMail
	 
	  public function selectTicketError($movieID = null,$sessionID = null){ 
			 
			 $data = array(
					  'movieID'=> $movieID ,
					  'sessionID'=> $sessionID 
			  );
			  
		 	return  View::make('frontend.errorSelectTicket')-> with('data', $data); 
		  }#end selectTicketError
		  
		    public function selectTicketErrorKiosk($movieID = null,$sessionID = null){ 
			 
			 $data = array(
					  'movieID'=> $movieID ,
					  'sessionID'=> $sessionID 
			  );
			  
		 	return  View::make('kiosk.errorSelectTicket')-> with('data', $data); 
		  }#end selectTicketError
		  
		 public function responseBooking(){  
		 
		    $allvar = '';
			$allvar =  Input::all(); 
			
		 $jsonRespon = 	 json_encode($allvar);
		 
		  $decision = '';
		  $decision = $_POST['decision']; 
		  $userSessionID =  Input::get('req_reference_number'); 
			
		    if($decision == 'CANCEL'){
				
			
				
				$wsdl = "http://10.121.130.25/WSVistaWebClient/TicketingService.asmx?WSDL"; 
				//$wsdl = "http://10.100.101.146/WSVistaWebClient/TicketingService.asmx?WSDL"; 
				
				$client = new SoapClient($wsdl, array('trace' => true)); 
				
				$params = array(	'OptionalClientClass'	=> "WWW",
									'OptionalClientId' 		=> "111.111.111.112", 
									'OptionalClientName'	=> "WEB",
									'UserSessionId'			=> $userSessionID);
									
				$result = $client->__soapCall('CancelOrder', array($params));
			 	
				$cancelResult = $result->Result;
				$CancelOrderRequest = json_encode($params);
				$CancelOrderResponse = json_encode($result);				
				
				// Update To Log DB
				$logTable = "log_vistaws_" . date('Y_m');	
				
				//********* Add soap_process ****
				$dataTblLog =  DB::table($logTable)
										->where('user_session_id' , $userSessionID) 
										->pluck('soap_process'); 			 
				$SOAPprocess = $dataTblLog.', CancelOrder';
				
				DB::table($logTable)
						  ->where('user_session_id', $userSessionID)
						  ->update(array(
										 'soap_process'			=> $SOAPprocess, 
										 'status' 	=> $cancelResult,										 
										 'decision' 	=> $decision, 
										 'payment_response' 	=> $jsonRespon, 
										 'order_status' 	=> 'CANCEL', 
										 'cancelorder_request' 	=> $CancelOrderRequest, 
								  		 'cancelorder_response' => $CancelOrderResponse)); 
				// End Update To log
				
				 $logTable = "log_vistaws_" . date('Y_m');
				 //**********
				$sessionID =  DB::table($logTable)
										->where('user_session_id' , $userSessionID) 
										->pluck('session_id'); 					 
				
				 $rowMovieDetail = DB::table('movie_showtimes')
								  ->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								  ->where('movie_showtimes.showtime_Session_strID','=', $sessionID)						 
								  ->where('movie_list.movieID','>', '0')
								  ->where('movie_list.movie_Publish' , '1') 
								  ->get();
								  
				
				//********* End Add soap_process ****
				
			   return  View::make('frontend.cancelPaymentOrder')-> with('dataResult', $allvar)
			   													-> with('movie_DataDetail', $rowMovieDetail) ;			   
			   
			 }else if($decision == 'ACCEPT'){
				 function strReplaceText($word){
			$strwordArr = array("Theater ","Theatre ");
			$strCensor = "" ;
			
			foreach ($strwordArr as $value) {
				$word = str_replace($value,$strCensor ,$word);
			} 				 
			return ($word);
	   }#end fn 
				 $logTable = "log_vistaws_" . date('Y_m');
				 //**********
				$sessionID =  DB::table($logTable)
										->where('user_session_id' , $userSessionID) 
										->pluck('session_id'); 					 
				
				 $rowMovieDetail = DB::table('movie_showtimes')
								  ->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								  ->where('movie_showtimes.showtime_Session_strID','=', $sessionID)						 
								  ->where('movie_list.movieID','>', '0')
								  ->where('movie_list.movie_Publish' , '1') 
								  ->get(); 
								  
				 $rowLogDetail = DB::table($logTable)->where('user_session_id' , $userSessionID)->get();				  	 
				 
			   	return  View::make('frontend.responPaymentSuccess')-> with('dataResult', $allvar)
			   													   -> with('movie_DataDetail', $rowMovieDetail) 
																   -> with('log_DataDetail', $rowLogDetail) ;  
			  }
		 
		 
		 }#end fn
		  
		public  function paymentError(){
			     return   View::make('frontend.errorPayment');  
	    }
	 
		 
}