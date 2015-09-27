<?php

class ComingsoonController extends BaseController {

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
	 
      public function comingsoonList(){  
	  		
			
	  		 function countShowtimeComingsoon($movie_strID){
				 	$dateNow = date('Y-m-d 06:00');
					
				     $dataCountAllResult =  DB::table('movie_comingsoon')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_comingsoon.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$dateNow") 
								 ->where('movie_comingsoon.movie_strID','=', $movie_strID)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_comingsoon.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_comingsoon.orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountAllResult;
			 }#end fn  countMovieShowtimeAll
	  
	  		
	  		 function countMovieComingsoon($getStart, $getEnd){  
				  $dateNow = date('Y-m-d 08:00'); 										
				   $dataCountAllResult = DB::table('movie_comingsoon') 
										  ->where('movie_ReleaseDate','>', $getStart) 
										  ->where('movie_ReleaseDate','<=', $getEnd) 
										  ->where('movie_ReleaseDate','>', $dateNow)
										 ->where('movie_Publish' , '1')
										 ->count();
					
				 	      return $dataCountAllResult;
			 }#end fn dataCountAllResult.
			 
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
	  		$dateNow = date('Y-m-d');
	 		$SelectComingsoon = DB::table('movie_comingsoon') 
							->select('movieID', 'movie_Name_EN', 'movie_Img_Thumb', 'movie_ReleaseDate', 'movie_Youtube', 'movie_strID')
							->where('movie_Publish' , '1') 
							->where('movie_ReleaseDate','>', $dateNow)
							->orderBy('movie_ReleaseDate', 'asc') 
							->get(); 
	  
			return View::make('frontend.commingsoon')-> with('rowComingsoon', $SelectComingsoon); 
	}# end fn comingsoonList
	
	public function comingsoonListTH(){  
			 function countShowtimeComingsoon($movie_strID){
				 	$dateNow = date('Y-m-d 06:00');
					
				     $dataCountAllResult =  DB::table('movie_comingsoon')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_comingsoon.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$dateNow") 
								 ->where('movie_comingsoon.movie_strID','=', $movie_strID)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_comingsoon.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_comingsoon.orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountAllResult;
			 }#end fn  countMovieShowtimeAll
	
			 function countMovieComingsoon($getStart, $getEnd){  
					$dateNow = date('Y-m-d 08:00'); 										
					 $dataCountAllResult = DB::table('movie_comingsoon') 
											->where('movie_ReleaseDate','>', $getStart) 
											->where('movie_ReleaseDate','<=', $getEnd) 
											 ->where('movie_ReleaseDate','>', $dateNow)
										   ->where('movie_Publish' , '1')
										   ->count();
					
				 	      return $dataCountAllResult;
			 }#end fn dataCountAllResult.
			 
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
	  	$dateNow = date('Y-m-d');
	 		$SelectComingsoon = DB::table('movie_comingsoon') 
							->select('movieID', 'movie_Name_TH', 'movie_Img_Thumb', 
									 'movie_ReleaseDate', 'movie_Youtube', 'movie_strID')
							->where('movie_Publish' , '1')
							->where('movie_ReleaseDate','>', $dateNow)
							->orderBy('movie_ReleaseDate', 'asc') 
							->get(); 
	  
			return View::make('frontendTH.commingsoon')-> with('rowComingsoon', $SelectComingsoon); 
	}# end fn comingsoonListTH
	
	 public function comingsoonDetail($name = null){ 
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
		$results = DB::select("select *
							  FROM  movie_comingsoon 
							  WHERE movieID ='$name'");  
	  
		return View::make('frontend.comingsoondetail')-> with('rowComingsoon', $results) ;
	}#end Fn ComingsoonDetail
	
	 public function comingsoonDetailTH($name = null){ 
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
		$results = DB::select("select *
							  FROM  movie_comingsoon 
							  WHERE movieID ='$name'");  
	  
		return View::make('frontendTH.comingsoondetail')-> with('rowComingsoon', $results) ;
	}#end Fn ComingsoonDetail TH
	
		 public function comingsoonDetailKiosk($name = null){ 
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
		$results = DB::select("select *
							  FROM  movie_comingsoon 
							  WHERE movieID ='$name'");  
	  
		return View::make('kiosk.comingsoondetail')-> with('rowComingsoon', $results) ;
	}#end Fn ComingsoonDetail TH
	
	public function comingsoonSaveEmail($name = null){ 
	
		$results = DB::select("select *
							  FROM  movie_comingsoon 
							  WHERE movieID ='$name'");  
	  
		return View::make('frontend.comingsoonSaveDetail')-> with('rowComingsoon', $results) ;
	}
	
	 public function comingsoonSendAlertEmail(){
		 
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
		 
		 $url = Input::get('url');
		 
		 if($url == ''){   
		 
		 		$nameMovieSub =  str_replace_text(Input::get('movie_Name_EN'));  
				 DB::table('movie_alertme')-> insert( 
						array('email' => Input::get('email'), 		
						'movieID' => Input::get('movieID'),  
						'signupDate' => date("Y-m-d H:i")));
						
				return Redirect::to('comingsoonsave/'.Input::get('movieID').'/'.$nameMovieSub);	
			 
		 }#end if  
	 }
	 
	 public function comingsoonListKiosk(){  
			 function countShowtimeComingsoon($movie_strID){
				 	$dateNow = date('Y-m-d 06:00');
					
				     $dataCountAllResult =  DB::table('movie_comingsoon')
					 			->leftJoin('movie_showtimes', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_comingsoon.movie_strID')
								->where('movie_showtimes.showtime_dtmDate_Time','>=', "$dateNow") 
								 ->where('movie_comingsoon.movie_strID','=', $movie_strID)
								->where('movie_showtimes.showtime_ID','!=', '')
								->where('movie_comingsoon.movie_Publish' , '1')
								->groupBy('movie_showtimes.showtime_Movie_strID')
								->groupBy('movie_showtimes.showtime_SystemType')
								->orderBy('movie_comingsoon.orderBy', 'asc')
								->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
								->count(); 
					
					return $dataCountAllResult;
			 }#end fn  countMovieShowtimeAll
	
			 function countMovieComingsoon($getStart, $getEnd){  
					$dateNow = date('Y-m-d 08:00'); 										
					 $dataCountAllResult = DB::table('movie_comingsoon') 
											->where('movie_ReleaseDate','>', $getStart) 
											->where('movie_ReleaseDate','<=', $getEnd) 
											 ->where('movie_ReleaseDate','>', $dateNow)
										   ->where('movie_Publish' , '1')
										   ->count();
					
				 	      return $dataCountAllResult;
			 }#end fn dataCountAllResult.
			 
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
	  	$dateNow = date('Y-m-d');
	 		$SelectComingsoon = DB::table('movie_comingsoon') 
							->select('movieID', 'movie_Name_EN', 'movie_Img_Thumb', 
									 'movie_ReleaseDate', 'movie_Youtube', 'movie_strID')
							->where('movie_Publish' , '1')
							->where('movie_ReleaseDate','>', $dateNow)
							->orderBy('movie_ReleaseDate', 'asc') 
							->get(); 
	  
			return View::make('kiosk.commingsoon')-> with('rowComingsoon', $SelectComingsoon); 
	}# end fn comingsoonListTH
	
		 public function comingsoonSendAlertEmailKiosk(){
		 
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
		 
		 $url = Input::get('url');
		 
		 if($url == ''){   
		 
		 		$nameMovieSub =  str_replace_text(Input::get('movie_Name_EN'));  
				 DB::table('movie_alertme')-> insert( 
						array('email' => Input::get('email'), 		
						'movieID' => Input::get('movieID'),  
						'signupDate' => date("Y-m-d H:i")));
						
				return Redirect::to('kiosk/comingsoonsave/'.Input::get('movieID').'/'.$nameMovieSub);	
			 
		 }#end if  
	 }
	 
	 	public function comingsoonSaveEmailKiosk($name = null){ 
	
		$results = DB::select("select *
							  FROM  movie_comingsoon 
							  WHERE movieID ='$name'");  
	  
		return View::make('kiosk.comingsoonSaveDetail')-> with('rowComingsoon', $results) ;
	}
 
}