<?php

class AdvanceBookingController extends BaseController {

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
	 
		public function AdvanceBooking(){  
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
			 }#end fn dataCountAllResult.
			 
			 function countMovieShowtimeAll($daySelcet, $movieID){
				     $dataCountAllResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								 ->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountAllResult;
			 }#end fn  countMovieShowtimeAll
			 
			function subLanguage($word){
				if($word == 'TH'){
					 $language = 'Thai';
				}else if($word == 'ST'){
					$language = 'Soundtrack';
				}else if($word == 'EN'){
					$language = 'English';
				}else if($word == 'CN'){
					$language = 'Chinese';
				}else{
					$language = '-';
				 }
				 return $language;
			
			}# end fn sublang
	
	    	$dateNow = date('Y-m-d 06:00');
			//********
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
			   }	
			//**************
			 function countShowtime($daySelcet, $dayEndSelcet, $movieID,$SystemType){
				     $dataCountResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								->where('movie_showtimes.showtime_dtmDate_Time','<=', "$dayEndSelcet") 
								->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_SystemType','=', $SystemType)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountResult;
			 }#end fn 
		
			$rowMovie = DB::table('movie_showtimes')
					->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
					->where('movie_showtimes.showtime_dtmDate_Time','>=', $dateNow) 
					->where('movie_list.movieID','>', '0')
					->where('movie_showtimes.showtime_ID','!=', '')
					->where('movie_list.movie_Publish' , '1')
					->groupBy('movie_showtimes.showtime_Movie_strID')
					->groupBy('movie_showtimes.showtime_SystemType')
				    ->orderBy('movie_list.movie_orderBy', 'asc')
					->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
					->get(); 
		
			$movie_showtimes = DB::select("select showtime_dtmDate_Time, showtime_Movie_strID, showtime_Session_strID
										, showtime_strName, showtime_soundAttributes, showtime_SystemType
										FROM  movie_showtimes 
										WHERE showtime_ID != 0  
										and movie_showtimes.showtime_dtmDate_Time >= '$dateNow' 
										ORDER BY showtime_dtmDate_Time asc");  
	
		return View::make('frontend.advanceBooking')-> with('movie_lists', $rowMovie)
										   			-> with('movie_showtimes', $movie_showtimes);
	
	} #end Advance Booking 
	
	public function AdvanceBookingTH(){  
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
			 }#end fn dataCountAllResult.
			 
			 function countMovieShowtimeAll($daySelcet, $movieID){
				     $dataCountAllResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								 ->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountAllResult;
			 }#end fn  countMovieShowtimeAll
			 
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
	
	    	$dateNow = date('Y-m-d 06:00');
			//********
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
			   }	
			//**************
			 function countShowtime($daySelcet, $dayEndSelcet, $movieID,$SystemType){
				     $dataCountResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								->where('movie_showtimes.showtime_dtmDate_Time','<=', "$dayEndSelcet") 
								->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_SystemType','=', $SystemType)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountResult;
			 }#end fn 
		
			$rowMovie = DB::table('movie_showtimes')
					->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
					->where('movie_showtimes.showtime_dtmDate_Time','>=', $dateNow) 
					->where('movie_list.movieID','>', '0')
					->where('movie_showtimes.showtime_ID','!=', '')
					->where('movie_list.movie_Publish' , '1')
					->groupBy('movie_showtimes.showtime_Movie_strID')
					->groupBy('movie_showtimes.showtime_SystemType')
				    ->orderBy('movie_list.movie_orderBy', 'asc')
					->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
					->get(); 
		
			$movie_showtimes = DB::select("select showtime_dtmDate_Time, showtime_Movie_strID, showtime_Session_strID
										, showtime_strName, showtime_soundAttributes, showtime_SystemType
										FROM  movie_showtimes 
										WHERE showtime_ID != 0  
										and movie_showtimes.showtime_dtmDate_Time >= '$dateNow' 
										ORDER BY showtime_dtmDate_Time asc");  
	
		return View::make('frontendTH.advanceBooking')-> with('movie_lists', $rowMovie)
										   			-> with('movie_showtimes', $movie_showtimes);
	
	}  #end Advance Book TH
	public function SelectDatepicker(){
		
			//********* Fn
			function subLanguage($word){
				if($word == 'TH'){
					 $language = 'Thai';
				}else if($word == 'EN'){
					$language = 'English';
				}else if($word == 'CN'){
					$language = 'Chinese';
				}else{
					$language = '-';
				 }
				 return $language;
			
			}# end fn sublang
	
	    	$dateNow = date('Y-m-d 06:00');
			//********
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
			   }	
			   
			 function countShowtime($daySelcet, $dayEndSelcet, $movieID,$SystemType){
				     $dataCountResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								->where('movie_showtimes.showtime_dtmDate_Time','<=', "$dayEndSelcet") 
								->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_SystemType','=', $SystemType)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountResult;
			 }#end fn 
			 
			 function countMovieShowtimeAll($daySelcet, $movieID){
				     $dataCountAllResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								 ->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountAllResult;
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
			 }#end fn countMovieShowtimeDay  
			//************ End Fn 
			
			 $selectDate = Input::get('selectDate');
			 
			 $rowMovie = DB::table('movie_showtimes')
					->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
					->where('movie_showtimes.showtime_dtmDate_Time','>=', $selectDate) 
					->where('movie_list.movieID','>', '0')
					->where('movie_showtimes.showtime_ID','!=', '')
					->where('movie_list.movie_Publish' , '1')
					->groupBy('movie_showtimes.showtime_Movie_strID')
					->groupBy('movie_showtimes.showtime_SystemType')
				    ->orderBy('movie_list.movie_orderBy', 'asc')
					->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
					->get(); 
		
			$movie_showtimes = DB::select("select showtime_dtmDate_Time, showtime_Movie_strID, showtime_Session_strID
										, showtime_strName, showtime_soundAttributes, showtime_SystemType
										FROM  movie_showtimes 
										WHERE showtime_ID != 0  
										and movie_showtimes.showtime_dtmDate_Time >= '$dateNow' 
										ORDER BY showtime_dtmDate_Time asc");  
			 
			 
			return View::make('frontend.getDateBooking')-> with('dataDate', $selectDate)
														-> with('movie_lists', $rowMovie)
										   				-> with('movie_showtimes', $movie_showtimes) ;
		 
		}#end Fn Datepick
		
		public function SelectDatepickerKiosk(){
		
			//********* Fn
			function subLanguage($word){
				if($word == 'TH'){
					 $language = 'Thai';
				}else if($word == 'EN'){
					$language = 'English';
				}else if($word == 'CN'){
					$language = 'Chinese';
				}else{
					$language = '-';
				 }
				 return $language;
			
			}# end fn sublang
	
	    	$dateNow = date('Y-m-d 06:00');
			//********
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
			   }	
			   
			  function countShowtime($daySelcet, $dayEndSelcet, $movieID,$SystemType){
				     $dataCountResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								->where('movie_showtimes.showtime_dtmDate_Time','<=', "$dayEndSelcet") 
								->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_SystemType','=', $SystemType)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountResult;
			 }#end fn 
			 
			 function countMovieShowtimeAll($daySelcet, $movieID){
				     $dataCountAllResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								 ->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountAllResult;
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
			 }#end fn countMovieShowtimeDay  
			//************ End Fn 
			
			 $selectDate = Input::get('selectDate');
			 
			 $rowMovie = DB::table('movie_showtimes')
					->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
					->where('movie_showtimes.showtime_dtmDate_Time','>=', $selectDate) 
					->where('movie_list.movieID','>', '0')
					->where('movie_showtimes.showtime_ID','!=', '')
					->where('movie_list.movie_Publish' , '1')
					->groupBy('movie_showtimes.showtime_Movie_strID')
					->groupBy('movie_showtimes.showtime_SystemType')
				    ->orderBy('movie_list.movie_orderBy', 'asc')
					->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
					->get(); 
		
			$movie_showtimes = DB::select("select showtime_dtmDate_Time, showtime_Movie_strID, showtime_Session_strID
										, showtime_strName, showtime_soundAttributes, showtime_SystemType
										FROM  movie_showtimes 
										WHERE showtime_ID != 0  
										and movie_showtimes.showtime_dtmDate_Time >= '$dateNow' 
										ORDER BY showtime_dtmDate_Time asc");  
			 
			 
			return View::make('kiosk.getDateBooking')-> with('dataDate', $selectDate)
														-> with('movie_lists', $rowMovie)
										   				-> with('movie_showtimes', $movie_showtimes) ;
		 
		}#SelectDatepickerTH
		
			public function SelectDatepickerTH(){
		
			//********* Fn
			function subLanguage($word){
				if($word == 'TH'){
					 $language = 'Thai';
				}else if($word == 'EN'){
					$language = 'English';
				}else if($word == 'CN'){
					$language = 'Chinese';
				}else{
					$language = '-';
				 }
				 return $language;
			
			}# end fn sublang
	
	    	$dateNow = date('Y-m-d 06:00');
			//********
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
			   }	
			   
			  function countShowtime($daySelcet, $dayEndSelcet, $movieID,$SystemType){
				     $dataCountResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								->where('movie_showtimes.showtime_dtmDate_Time','<=', "$dayEndSelcet") 
								->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_SystemType','=', $SystemType)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountResult;
			 }#end fn 
			 
			 function countMovieShowtimeAll($daySelcet, $movieID){
				     $dataCountAllResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								 ->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountAllResult;
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
			 }#end fn countMovieShowtimeDay  
			//************ End Fn 
			
			 $selectDate = Input::get('selectDate');
			 
			 $rowMovie = DB::table('movie_showtimes')
					->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
					->where('movie_showtimes.showtime_dtmDate_Time','>=', $selectDate) 
					->where('movie_list.movieID','>', '0')
					->where('movie_showtimes.showtime_ID','!=', '')
					->where('movie_list.movie_Publish' , '1')
					->groupBy('movie_showtimes.showtime_Movie_strID')
					->groupBy('movie_showtimes.showtime_SystemType')
				    ->orderBy('movie_list.movie_orderBy', 'asc')
					->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
					->get(); 
		
			$movie_showtimes = DB::select("select showtime_dtmDate_Time, showtime_Movie_strID, showtime_Session_strID
										, showtime_strName, showtime_soundAttributes, showtime_SystemType
										FROM  movie_showtimes 
										WHERE showtime_ID != 0  
										and movie_showtimes.showtime_dtmDate_Time >= '$dateNow' 
										ORDER BY showtime_dtmDate_Time asc");  
			 
			 
			return View::make('frontendTH.getDateBooking')-> with('dataDate', $selectDate)
														-> with('movie_lists', $rowMovie)
										   				-> with('movie_showtimes', $movie_showtimes) ;
		 
		}#SelectDatepickerTH
		//********************* Comingsoon Advance ****************************
		
		public function ComingsoonAdvanceBooking($id=null, $name=null){  			
		
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
			 }#end fn dataCountAllResult.
			 
			 function countMovieShowtimeAll($daySelcet, $movieID){
				     $dataCountAllResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								 ->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountAllResult;
			 }#end fn  countMovieShowtimeAll
			 
			function subLanguage($word){
				if($word == 'TH'){
					 $language = 'Thai';
				}else if($word == 'ST'){
					$language = 'Soundtrack';
				}else if($word == 'EN'){
					$language = 'English';
				}else if($word == 'CN'){
					$language = 'Chinese';
				}else{
					$language = '-';
				 }
				 return $language;
			
			}# end fn sublang
	
	    	$dateNow = date('Y-m-d 06:00');
			//********
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
			   }	
			//**************
			 function countShowtime($daySelcet, $dayEndSelcet, $movieID,$SystemType){
				     $dataCountResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								->where('movie_showtimes.showtime_dtmDate_Time','<=', "$dayEndSelcet") 
								->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_SystemType','=', $SystemType)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountResult;
			 }#end fn
			 
			$dataMovieStrID =  DB::table('movie_comingsoon')
										->where('movieID' , $id) 
										->pluck('movie_strID'); 
										
			$dataShowtimesDate =  DB::table('movie_showtimes')
										->where('showtime_Movie_strID' , $dataMovieStrID) 
										->orderBy('showtime_dtmDate_Time', 'asc')
										->pluck('showtime_dtmDate_Time');
		
			$rowMovie = DB::table('movie_showtimes')
					->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
					->where('movie_showtimes.showtime_dtmDate_Time','>=', $dateNow) 
					->where('movie_list.movie_strID','=', $dataMovieStrID)
					->where('movie_showtimes.showtime_ID','!=', '')
					->where('movie_list.movie_Publish' , '1')
					->groupBy('movie_showtimes.showtime_Movie_strID')
					->groupBy('movie_showtimes.showtime_SystemType')
				    ->orderBy('movie_list.movie_orderBy', 'asc')
					->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
					->get(); 
		
			$movie_showtimes = DB::select("select showtime_dtmDate_Time, showtime_Movie_strID, showtime_Session_strID
										, showtime_strName, showtime_soundAttributes, showtime_SystemType
										FROM  movie_showtimes 
										WHERE showtime_ID != 0  
										and movie_showtimes.showtime_dtmDate_Time >= '$dateNow' 
										ORDER BY showtime_dtmDate_Time asc");  
	
		return View::make('frontend.comingsoonBooking')-> with('movie_lists', $rowMovie)
													-> with('movie_comingsoonID', $id)
													-> with('dataShowtimesDate', $dataShowtimesDate) 
										   			-> with('movie_showtimes', $movie_showtimes); /**/
	
	} #end Advance Booking 
	
	public function ComingsoonAdvanceBookingTH($id=null, $name=null){  			
		
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
			 }#end fn dataCountAllResult.
			 
			 function countMovieShowtimeAll($daySelcet, $movieID){
				     $dataCountAllResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								 ->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountAllResult;
			 }#end fn  countMovieShowtimeAll
			 
			function subLanguage($word){
				if($word == 'TH'){
					 $language = 'Thai';
				}else if($word == 'ST'){
					$language = 'Soundtrack';
				}else if($word == 'EN'){
					$language = 'English';
				}else if($word == 'CN'){
					$language = 'Chinese';
				}else{
					$language = '-';
				 }
				 return $language;
			
			}# end fn sublang
	
	    	$dateNow = date('Y-m-d 06:00');
			//********
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
			   }	
			//**************
			 function countShowtime($daySelcet, $dayEndSelcet, $movieID,$SystemType){
				     $dataCountResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								->where('movie_showtimes.showtime_dtmDate_Time','<=', "$dayEndSelcet") 
								->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_SystemType','=', $SystemType)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountResult;
			 }#end fn
			 
			$dataMovieStrID =  DB::table('movie_comingsoon')
										->where('movieID' , $id) 
										->pluck('movie_strID'); 
										
			$dataShowtimesDate =  DB::table('movie_showtimes')
										->where('showtime_Movie_strID' , $dataMovieStrID) 
										->orderBy('showtime_dtmDate_Time', 'asc')
										->pluck('showtime_dtmDate_Time');
		
			$rowMovie = DB::table('movie_showtimes')
					->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
					->where('movie_showtimes.showtime_dtmDate_Time','>=', $dateNow) 
					->where('movie_list.movie_strID','=', $dataMovieStrID)
					->where('movie_showtimes.showtime_ID','!=', '')
					->where('movie_list.movie_Publish' , '1')
					->groupBy('movie_showtimes.showtime_Movie_strID')
					->groupBy('movie_showtimes.showtime_SystemType')
				    ->orderBy('movie_list.movie_orderBy', 'asc')
					->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
					->get(); 
		
			$movie_showtimes = DB::select("select showtime_dtmDate_Time, showtime_Movie_strID, showtime_Session_strID
										, showtime_strName, showtime_soundAttributes, showtime_SystemType
										FROM  movie_showtimes 
										WHERE showtime_ID != 0  
										and movie_showtimes.showtime_dtmDate_Time >= '$dateNow' 
										ORDER BY showtime_dtmDate_Time asc");  
	
		return View::make('frontendTH.comingsoonBooking')-> with('movie_lists', $rowMovie)
													-> with('movie_comingsoonID', $id)
													-> with('dataShowtimesDate', $dataShowtimesDate) 
										   			-> with('movie_showtimes', $movie_showtimes); /**/
	
	} #end Advance Booking 
	
		public function AdvanceBookingKiosk(){  
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
			 }#end fn dataCountAllResult.
			 
			 function countMovieShowtimeAll($daySelcet, $movieID){
				     $dataCountAllResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								 ->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountAllResult;
			 }#end fn  countMovieShowtimeAll
			 
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
	
	    	$dateNow = date('Y-m-d 06:00');
			//********
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
			   }	
			//**************
			 function countShowtime($daySelcet, $dayEndSelcet, $movieID,$SystemType){
				     $dataCountResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								->where('movie_showtimes.showtime_dtmDate_Time','<=', "$dayEndSelcet") 
								->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_SystemType','=', $SystemType)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountResult;
			 }#end fn 
		
			$rowMovie = DB::table('movie_showtimes')
					->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
					->where('movie_showtimes.showtime_dtmDate_Time','>=', $dateNow) 
					->where('movie_list.movieID','>', '0')
					->where('movie_showtimes.showtime_ID','!=', '')
					->where('movie_list.movie_Publish' , '1')
					->groupBy('movie_showtimes.showtime_Movie_strID')
					->groupBy('movie_showtimes.showtime_SystemType')
				    ->orderBy('movie_list.movie_orderBy', 'asc')
					->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
					->get(); 
		
			$movie_showtimes = DB::select("select showtime_dtmDate_Time, showtime_Movie_strID, showtime_Session_strID
										, showtime_strName, showtime_soundAttributes, showtime_SystemType
										FROM  movie_showtimes 
										WHERE showtime_ID != 0  
										and movie_showtimes.showtime_dtmDate_Time >= '$dateNow' 
										ORDER BY showtime_dtmDate_Time asc");  
	
		return View::make('kiosk.advanceBooking')-> with('movie_lists', $rowMovie)
										   			-> with('movie_showtimes', $movie_showtimes);
	
	}  #end Advance Book TH
	
		public function ComingsoonAdvanceBookingKiosk($id=null, $name=null){  			
		
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
			 }#end fn dataCountAllResult.
			 
			 function countMovieShowtimeAll($daySelcet, $movieID){
				     $dataCountAllResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								 ->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountAllResult;
			 }#end fn  countMovieShowtimeAll
			 
			function subLanguage($word){
				if($word == 'TH'){
					 $language = 'Thai';
				}else if($word == 'ST'){
					$language = 'Soundtrack';
				}else if($word == 'EN'){
					$language = 'English';
				}else if($word == 'CN'){
					$language = 'Chinese';
				}else{
					$language = '-';
				 }
				 return $language;
			
			}# end fn sublang
	
	    	$dateNow = date('Y-m-d 06:00');
			//********
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
			   }	
			//**************
			 function countShowtime($daySelcet, $dayEndSelcet, $movieID,$SystemType){
				     $dataCountResult =  DB::table('movie_list')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$daySelcet") 
								->where('movie_showtimes.showtime_dtmDate_Time','<=', "$dayEndSelcet") 
								->where('movie_list.movieID','=', $movieID)
								->where('movie_showtimes.showtime_SystemType','=', $SystemType)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_list.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_list.movie_orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountResult;
			 }#end fn
			 
			$dataMovieStrID =  DB::table('movie_comingsoon')
										->where('movieID' , $id) 
										->pluck('movie_strID'); 
										
			$dataShowtimesDate =  DB::table('movie_showtimes')
										->where('showtime_Movie_strID' , $dataMovieStrID) 
										->orderBy('showtime_dtmDate_Time', 'asc')
										->pluck('showtime_dtmDate_Time');
		
			$rowMovie = DB::table('movie_showtimes')
					->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
					->where('movie_showtimes.showtime_dtmDate_Time','>=', $dateNow) 
					->where('movie_list.movie_strID','=', $dataMovieStrID)
					->where('movie_showtimes.showtime_ID','!=', '')
					->where('movie_list.movie_Publish' , '1')
					->groupBy('movie_showtimes.showtime_Movie_strID')
					->groupBy('movie_showtimes.showtime_SystemType')
				    ->orderBy('movie_list.movie_orderBy', 'asc')
					->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
					->get(); 
		
			$movie_showtimes = DB::select("select showtime_dtmDate_Time, showtime_Movie_strID, showtime_Session_strID
										, showtime_strName, showtime_soundAttributes, showtime_SystemType
										FROM  movie_showtimes 
										WHERE showtime_ID != 0  
										and movie_showtimes.showtime_dtmDate_Time >= '$dateNow' 
										ORDER BY showtime_dtmDate_Time asc");  
	
		return View::make('kiosk.comingsoonBooking')-> with('movie_lists', $rowMovie)
													-> with('movie_comingsoonID', $id)
													-> with('dataShowtimesDate', $dataShowtimesDate) 
										   			-> with('movie_showtimes', $movie_showtimes); /**/
	
	} #end Advance Booking 
	
}