<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/ 
	  public function landingPage(){   
	  	//********
		function subLanguage($word){
			if($word == 'TH'){
				 $language = 'Thai';
			}else if($word == 'EN'){
				$language = 'English';
			}else if($word == 'CN'){
				$language = 'Chinese';
			}else if($word == 'ST'){
					$language = 'Soundtrack';
			}else{
				$language = '-';
			 }
			 return $language;
		
		}# end fn sublang
						
		 function str_replace_text($word){
				$strwordArr = array("#",":" ,"'","\'","-","%",":") ;
				$strCensor = "" ;
				
				foreach ($strwordArr as $value) {
				$word = str_replace($value,$strCensor ,$word);
				}
				$strwordArr_2 = array("(",")","/"," ") ;
				$strCensor_2 = "-" ;
				foreach ($strwordArr_2 as $value_2) {
				$word = str_replace($value_2,$strCensor_2 ,$word);
				}
				 $word = str_replace("_","" ,$word);
				return ( $word) ;
		   }#end fn
		   function countMovieShowtimeDay($dayStart,$dayEnd, $movieID, $showtime_SystemType){
				     $dataCountAllResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', $dayStart) 
								->where('movie_showtimes.showtime_dtmDate_Time','<=', $dayEnd) 
								->where('movie_showtimes.showtime_Movie_strID','=', $movieID) 
								->where('movie_showtimes.showtime_SystemType','=', $showtime_SystemType)
								->where('movie_list.movie_Publish' , '1')  
								->count(); 
					
					return $dataCountAllResult;
			 }#end fn count
		   
		//**************
		
		   	  $dateNow = date('Y-m-d 08:00'); 
			  $dateEndShowtime = date('Y-m-d 03:00', strtotime(" +1 day"));
		
	 	 	  $dataMovie = DB::table('movie_showtimes')
					->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
					->where('movie_showtimes.showtime_dtmDate_Time','>=', $dateNow)
					->where('movie_showtimes.showtime_dtmDate_Time','<=', $dateEndShowtime) 
					->where('movie_list.movieID','>', '0')
					->where('movie_list.movie_Publish' , '1')
					->groupBy('movie_showtimes.showtime_Movie_strID')
					->groupBy('movie_showtimes.showtime_SystemType')
				    ->orderBy('movie_list.movie_orderBy', 'asc')
					->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
					->get(); 
					
		//************** Test **///////// 
	 
	 	$dataShowtimes = DB::select("select showtime_dtmDate_Time, showtime_Movie_strID, showtime_Session_strID
									, showtime_strName, showtime_soundAttributes, showtime_SystemType
										FROM  movie_showtimes 
										WHERE showtime_ID != 0  
										and movie_showtimes.showtime_dtmDate_Time >= '$dateNow'
										and movie_showtimes.showtime_dtmDate_Time <= 'DATE_ADD(CURDATE(), INTERVAL 30 HOUR)'
										ORDER BY showtime_dtmDate_Time asc");  
										
		$dataBanner = DB::table('movie_banner') 
					->select('banner_name', 'banner_url','banner_pic')
					->where('banner_publish','1') 
				    ->orderBy('orderBy', 'asc')
					->get(); 		
	
		return View::make('frontend.landing') -> with('movie_lists', $dataMovie)
										   -> with('movie_showtimes', $dataShowtimes)  
										   -> with('movie_banner', $dataBanner); 	
		 
	}
	public function home(){ 
		//********
		function subLanguage($word){
			if($word == 'TH'){
				 $language = 'Thai';
			}else if($word == 'EN'){
				$language = 'English';
			}else if($word == 'CN'){
				$language = 'Chinese';
			}else if($word == 'ST'){
					$language = 'Soundtrack';
			}else{
				$language = '-';
			 }
			 return $language;
		
		}# end fn sublang
						
		 function str_replace_text($word){
				$strwordArr = array("#",":" ,"'","\'","-","%",":") ;
				$strCensor = "" ;
				
				foreach ($strwordArr as $value) {
				$word = str_replace($value,$strCensor ,$word);
				}
				$strwordArr_2 = array("(",")","/"," ") ;
				$strCensor_2 = "-" ;
				foreach ($strwordArr_2 as $value_2) {
				$word = str_replace($value_2,$strCensor_2 ,$word);
				}
				 $word = str_replace("_","" ,$word);
				return ( $word) ;
		   }#end fn
		   function countMovieShowtimeDay($dayStart,$dayEnd, $movieID, $showtime_SystemType){
				     $dataCountAllResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', $dayStart) 
								->where('movie_showtimes.showtime_dtmDate_Time','<=', $dayEnd) 
								->where('movie_showtimes.showtime_Movie_strID','=', $movieID) 
								->where('movie_showtimes.showtime_SystemType','=', $showtime_SystemType)
								->where('movie_list.movie_Publish' , '1')  
								->count(); 
					
					return $dataCountAllResult;
			 }#end fn count
		   
		//**************
		
		   	 $dateNow = date('Y-m-d 08:00'); 
			  $dateEndShowtime = date('Y-m-d 03:00', strtotime(" +1 day"));
		
	 	 	  $dataMovie = DB::table('movie_showtimes')
					->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
					->where('movie_showtimes.showtime_dtmDate_Time','>=', $dateNow)
					->where('movie_showtimes.showtime_dtmDate_Time','<=', $dateEndShowtime) 
					->where('movie_list.movieID','>', '0')
					->where('movie_list.movie_Publish' , '1')
					->groupBy('movie_showtimes.showtime_Movie_strID')
					->groupBy('movie_showtimes.showtime_SystemType')
				    ->orderBy('movie_list.movie_orderBy', 'asc')
					->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
					->get(); 
					
		//************** Test **///////// 
	 
	 	$dataShowtimes = DB::select("select showtime_dtmDate_Time, showtime_Movie_strID, showtime_Session_strID
									, showtime_strName, showtime_soundAttributes, showtime_SystemType
										FROM  movie_showtimes 
										WHERE showtime_ID != 0  
										and movie_showtimes.showtime_dtmDate_Time >= '$dateNow'
										and movie_showtimes.showtime_dtmDate_Time <= 'DATE_ADD(CURDATE(), INTERVAL 30 HOUR)'
										ORDER BY showtime_dtmDate_Time asc");  
										
		$dataBanner = DB::table('movie_banner') 
					->select('banner_name', 'banner_url','banner_pic')
					->where('banner_publish','1') 
				    ->orderBy('orderBy', 'asc')
					->get(); 		
	
		return View::make('frontend.home') -> with('movie_lists', $dataMovie)
										   -> with('movie_showtimes', $dataShowtimes)  
										   -> with('movie_banner', $dataBanner); 	/**/
										   
	}# end Home
	
	public function homeTH(){ 
		//********
		function subLanguage($word){
			if($word == 'TH'){
				 $language = 'Thai';
			}else if($word == 'EN'){
				$language = 'English';
			}else if($word == 'CN'){
				$language = 'Chinese';
			}else if($word == 'ST'){
					$language = 'Soundtrack';
			}else{
				$language = '-';
			 }
			 return $language;
		
		}# end fn sublang
						
		 function str_replace_text($word){
				$strwordArr = array("#",":" ,"'","\'","-","%",":") ;
				$strCensor = "" ;
				
				foreach ($strwordArr as $value) {
				$word = str_replace($value,$strCensor ,$word);
				}
				$strwordArr_2 = array("(",")","/"," ") ;
				$strCensor_2 = "-" ;
				foreach ($strwordArr_2 as $value_2) {
				$word = str_replace($value_2,$strCensor_2 ,$word);
				}
				 $word = str_replace("_","" ,$word);
				return ( $word) ;
		   }#end fn
		   function countMovieShowtimeDay($dayStart,$dayEnd, $movieID, $showtime_SystemType){
				     $dataCountAllResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', $dayStart) 
								->where('movie_showtimes.showtime_dtmDate_Time','<=', $dayEnd) 
								->where('movie_showtimes.showtime_Movie_strID','=', $movieID) 
								->where('movie_showtimes.showtime_SystemType','=', $showtime_SystemType)
								->where('movie_list.movie_Publish' , '1')  
								->count(); 
					
					return $dataCountAllResult;
			 }#end fn count
		   
		//**************
		
		   	  $dateNow = date('Y-m-d 08:00'); 
			  $dateEndShowtime = date('Y-m-d 03:00', strtotime(" +1 day"));
		
	 	 	  $dataMovie = DB::table('movie_showtimes')
					->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
					->where('movie_showtimes.showtime_dtmDate_Time','>=', $dateNow)
					->where('movie_showtimes.showtime_dtmDate_Time','<=', $dateEndShowtime) 
					->where('movie_list.movieID','>', '0')
					->where('movie_list.movie_Publish' , '1')
					->groupBy('movie_showtimes.showtime_Movie_strID')
					->groupBy('movie_showtimes.showtime_SystemType')
				    ->orderBy('movie_list.movie_orderBy', 'asc')
					->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
					->get(); 
					
		//************** Test **///////// 
	 
	 	$dataShowtimes = DB::select("select showtime_dtmDate_Time, showtime_Movie_strID, showtime_Session_strID
									, showtime_strName, showtime_soundAttributes, showtime_SystemType
										FROM  movie_showtimes 
										WHERE showtime_ID != 0  
										and movie_showtimes.showtime_dtmDate_Time >= '$dateNow'
										and movie_showtimes.showtime_dtmDate_Time <= 'DATE_ADD(CURDATE(), INTERVAL 30 HOUR)'
										ORDER BY showtime_dtmDate_Time asc");  
										
		$dataBanner = DB::table('movie_banner') 
					->select('banner_name', 'banner_url','banner_pic')
					->where('banner_publish','1') 
				    ->orderBy('orderBy', 'asc')
					->get(); 		
	
		return View::make('frontendTH.home') -> with('movie_lists', $dataMovie)
										   -> with('movie_showtimes', $dataShowtimes)  
										   -> with('movie_banner', $dataBanner); 	/**/
										   
	}# end Home TH
     public function commingSoon(){   
		return View::make('frontend.commingsoon'); 
	}
	
	 public function information(){   
	 	 $results = DB::table('movie_pages_infomation')
		 			->where('pages_ID', '1')
					->select('pages_infomation')
					->get();
					
		return View::make('frontend.information')-> with('rowData', $results); 
	}
	 public function informationTH(){   
	 	 $results = DB::table('movie_pages_infomation')
		 			->where('pages_ID', '1')
					->select('pages_infomation')
					->get();
					
		return View::make('frontendTH.information')-> with('rowData', $results); 
	}
  
	public function event_activity(){   
		return View::make('frontend.event_activity'); 
	}
	public function event_activityTH(){   
		return View::make('frontendTH.event_activity'); 
	}
    public function event_activityDetail(){   
		return View::make('frontend.event_activitydetail'); 
	}
	 public function event_activityDetailTH(){   
		return View::make('frontendTH.event_activitydetail'); 
	}
	
	 public function contactUS(){  
	 	 $results = DB::table('movie_pages_infomation')
		 			->where('pages_ID', '1')
					->select('pages_address', 'pages_tel', 'pages_email', 
							  'pages_getByTrain', 'pages_getByBus')
					->get();
					 
		return View::make('frontend.contact')-> with('rowData', $results); 
	}
	public function contactUSTH(){  
	 	 $results = DB::table('movie_pages_infomation')
		 			->where('pages_ID', '1')
					->select('pages_address', 'pages_tel', 'pages_email', 
							  'pages_getByTrain', 'pages_getByBus')
					->get();
					 
		return View::make('frontendTH.contact')-> with('rowData', $results); 
	}
	
	public function contactSend(){
		
		  $name  = Input::get('name');
   		  $email = Input::get('email');
		  $subject = Input::get('subject');
		  $tel = Input::get('tel');
		  $comment = Input::get('comment');
		
			Mail::send('frontend.sendmailContent', array('name'=>$name,'email'=>$email,'subject'=>$subject,'tel'=>$tel,'comment'=>$comment), function($message){
			  $message->to('sarunsak.ph@gmail.com', 'K. '.Input::get('name') )->subject('Contact To Embassycineplex');
		   });
 
	}
	
	 public function testSendMail(){ 
	   
	 	$firstname 	= 'Innovation Plus'; 
		$pincode 	= '660'; 
		
		$user = array(
			'email'=>'sarunsak@hotmail.com',
			'name'=>'Sarunsak'
		);
		
	 
	 	 Mail::send('emails.enews', array('email'=>$firstname,'pincode'=>$pincode), function($message) use ($user){ 
       		  $message->to($user['email'], $user['name'])->subject('Notify movie ticket booking from Embassycineplex.com');
   		 });
	 }#end 
	
 	 public function getFnCreateDB(){   
		//*********
	 $logTable = "log_vistaws_" . date('Y_m'); 
	$dbCreate =  DB::select("SHOW TABLES FROM www_embassycineplex_com WHERE Tables_in_www_embassycineplex_com LIKE '$logTable'");
	  // $dbCreate =  DB::select("SHOW TABLES FROM embassy_2014_v2 WHERE Tables_in_embassy_2014_v2 LIKE '$logTable'");
	  
	  if($dbCreate){
		  $logExists = true;
	  }else{
		  $sbdData = DB::select("CREATE TABLE  	`$logTable` (
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
								  PRIMARY KEY (`log_id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
			 exit();
		  }#*************** end
		//*********
	}
		public function homeKiosk(){ 
		//********
		function subLanguage($word){
			if($word == 'TH'){
				 $language = 'Thai';
			}else if($word == 'EN'){
				$language = 'English';
			}else if($word == 'CN'){
				$language = 'Chinese';
			}else if($word == 'ST'){
					$language = 'Soundtrack';
			}else{
				$language = '-';
			 }
			 return $language;
		
		}# end fn sublang
						
		 function str_replace_text($word){
				$strwordArr = array("#",":" ,"'","\'","-","%",":") ;
				$strCensor = "" ;
				
				foreach ($strwordArr as $value) {
				$word = str_replace($value,$strCensor ,$word);
				}
				$strwordArr_2 = array("(",")","/"," ") ;
				$strCensor_2 = "-" ;
				foreach ($strwordArr_2 as $value_2) {
				$word = str_replace($value_2,$strCensor_2 ,$word);
				}
				 $word = str_replace("_","" ,$word);
				return ( $word) ;
		   }#end fn
		   function countMovieShowtimeDay($dayStart,$dayEnd, $movieID, $showtime_SystemType){
				     $dataCountAllResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', $dayStart) 
								->where('movie_showtimes.showtime_dtmDate_Time','<=', $dayEnd) 
								->where('movie_showtimes.showtime_Movie_strID','=', $movieID) 
								->where('movie_showtimes.showtime_SystemType','=', $showtime_SystemType)
								->where('movie_list.movie_Publish' , '1')  
								->count(); 
					
					return $dataCountAllResult;
			 }#end fn count
		   
		//**************
		
		   	 $dateNow = date('Y-m-d 08:00'); 
			  $dateEndShowtime = date('Y-m-d 03:00', strtotime(" +1 day"));
		
	 	 	  $dataMovie = DB::table('movie_showtimes')
					->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
					->where('movie_showtimes.showtime_dtmDate_Time','>=', $dateNow)
					->where('movie_showtimes.showtime_dtmDate_Time','<=', $dateEndShowtime) 
					->where('movie_list.movieID','>', '0')
					->where('movie_list.movie_Publish' , '1')
					->groupBy('movie_showtimes.showtime_Movie_strID')
					->groupBy('movie_showtimes.showtime_SystemType')
				    ->orderBy('movie_list.movie_orderBy', 'asc')
					->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
					->get(); 
					
		//************** Test **///////// 
	 
	 	$dataShowtimes = DB::select("select showtime_dtmDate_Time, showtime_Movie_strID, showtime_Session_strID
									, showtime_strName, showtime_soundAttributes, showtime_SystemType
										FROM  movie_showtimes 
										WHERE showtime_ID != 0  
										and movie_showtimes.showtime_dtmDate_Time >= '$dateNow'
										and movie_showtimes.showtime_dtmDate_Time <= 'DATE_ADD(CURDATE(), INTERVAL 30 HOUR)'
										ORDER BY showtime_dtmDate_Time asc");  
										
		$dataBanner = DB::table('movie_banner') 
					->select('banner_name', 'banner_url','banner_pic')
					->where('banner_publish','1') 
				    ->orderBy('orderBy', 'asc')
					->get(); 		
	
		return View::make('kiosk.home') -> with('movie_lists', $dataMovie)
										   -> with('movie_showtimes', $dataShowtimes)  
										   -> with('movie_banner', $dataBanner); 	/**/
										   
	}# end Home
}