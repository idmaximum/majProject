<?php

class MovieController extends BaseController {

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
	
    public function movie($name = null){  
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
			$dateEndShowtime = date('Y-m-d 03:00', strtotime(" +1 day"));
			
			 $rowMovieDetail = DB::select("select *
					FROM  movie_list 
					WHERE   movie_Publish  = '1'  
					and movieID = '$name'
					GROUP BY movie_Name_EN" ); 
	 
		$rowMovie = DB::table('movie_showtimes')
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
					
		$movie_showtimes =DB::select("select showtime_dtmDate_Time, showtime_Movie_strID, showtime_Session_strID
									, showtime_strName, showtime_soundAttributes, showtime_SystemType
										FROM  movie_showtimes 
										WHERE showtime_ID != 0  
										and movie_showtimes.showtime_dtmDate_Time >= '$dateNow'
										and movie_showtimes.showtime_dtmDate_Time <= 'DATE_ADD(CURDATE(), INTERVAL 30 HOUR)'
										ORDER BY showtime_dtmDate_Time asc");    
	
		return View::make('frontend.moviedetail')-> with('movie_lists', $rowMovie)
												-> with('movie_lists_detail', $rowMovieDetail)
		  										-> with('movie_showtimes', $movie_showtimes); 
	}#end Movie 
	
 		 public function movieTH($name = null){  
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
			   }	#enc Fn 
	  
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
			$dateEndShowtime = date('Y-m-d 03:00', strtotime(" +1 day"));
			
		 $rowMovieDetail = DB::select("select *
					FROM  movie_list 
					WHERE   movie_Publish  = '1'  
					and movieID = '$name'
					GROUP BY movie_Name_EN" ); 
	 
		$rowMovie = DB::table('movie_showtimes')
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
					
		$movie_showtimes =DB::select("select showtime_dtmDate_Time, showtime_Movie_strID, showtime_Session_strID
									, showtime_strName, showtime_soundAttributes, showtime_SystemType
										FROM  movie_showtimes 
										WHERE showtime_ID != 0  
										and movie_showtimes.showtime_dtmDate_Time >= '$dateNow'
										and movie_showtimes.showtime_dtmDate_Time <= 'DATE_ADD(CURDATE(), INTERVAL 30 HOUR)'
										ORDER BY showtime_dtmDate_Time asc");    
	
		return View::make('frontendTH.moviedetail')-> with('movie_lists', $rowMovie)
												-> with('movie_lists_detail', $rowMovieDetail)
		  										-> with('movie_showtimes', $movie_showtimes); 
	}
	
	  public function movieKiosk($name = null){  
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
			$dateEndShowtime = date('Y-m-d 03:00', strtotime(" +1 day"));
			
			 $rowMovieDetail = DB::select("select *
					FROM  movie_list 
					WHERE   movie_Publish  = '1'  
					and movieID = '$name'
					GROUP BY movie_Name_EN" ); 
	 
		$rowMovie = DB::table('movie_showtimes')
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
					
		$movie_showtimes =DB::select("select showtime_dtmDate_Time, showtime_Movie_strID, showtime_Session_strID
									, showtime_strName, showtime_soundAttributes, showtime_SystemType
										FROM  movie_showtimes 
										WHERE showtime_ID != 0  
										and movie_showtimes.showtime_dtmDate_Time >= '$dateNow'
										and movie_showtimes.showtime_dtmDate_Time <= 'DATE_ADD(CURDATE(), INTERVAL 30 HOUR)'
										ORDER BY showtime_dtmDate_Time asc");    
	
		return View::make('kiosk.moviedetail')-> with('movie_lists', $rowMovie)
												-> with('movie_lists_detail', $rowMovieDetail)
		  										-> with('movie_showtimes', $movie_showtimes); 
	}#end Movie 
}