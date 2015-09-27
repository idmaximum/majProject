<?php
class BackofficeMovieListController extends Controller{ 
			
	public function movieList($id = null){ 		  
	 
		//************** Movie List Start ************ 
		$actionMovieList = Input::get('actionMovieList');	
		
		if($actionMovieList != ''){//  Check select dropdown 
	
			$input = Input::all();	
			$movie_Name_EN = $input['movie_Name_EN'];		  
			$num =  count($movie_Name_EN);	
			  
			switch($actionMovieList){
				case "ลบ | Delete" : 
				for( $i = 0; $i < $num; $i++){					
					//************** 
				 	$sbdNews = DB::select("select movie_Img_Thumb 
										  FROM  movie_list 
										  WHERE movie_Name_EN = '$movie_Name_EN[$i]'"); 
					foreach ($sbdNews as $row)
					  {
						 File::delete('uploads/movie/'.$row->movie_Img_Thumb);
					  }
					//*************  
					
					DB::delete("delete from movie_list where movie_Name_EN =  '$movie_Name_EN[$i]'");
						   
						    
				}#end for del
					
				break;
				case "เผยแพร่ | Publish" :
				$query = "update movie_list set movie_Publish='1' where ";
				for( $i = 0; $i < $num; $i++){
					$query .= "(movie_Name_EN = '$movie_Name_EN[$i]')";
					if($i < $num-1){
						$query .= " or ";
					}
				}  
				DB::update($query);	
					  
					 
				break;					  
				case "ซ่อน | Unpublish" :
				$query = "update movie_list set movie_Publish='0' where ";
				for( $i = 0; $i < $num; $i++){
					$query .= "(movie_Name_EN = '$movie_Name_EN[$i]')";
					if($i < $num-1){
						$query .= " or ";
					}
				}  
				DB::update($query);	 
				break;
			} 
			  
			   
		}#end IF   Select *************
		
		//************** Movie List End ************ 
		  
		//**********   start Select DB Comingsoon *******************///
		$action_up = Input::get('action_up');		
		 
		if($action_up != ''){//  Check select dropdown
		 	
		$input = Input::all();	
			$movie_Name_EN = $input['movie_Name_EN'];		  
			$num =  count($movie_Name_EN);	
			  
			switch($action_up){
				case "ลบ | Delete" : 
				for( $i = 0; $i < $num; $i++){					
					//************** 
				 	$sbdNews = DB::select('select movie_Img_Thumb 
										  FROM  movie_comingsoon 
										  WHERE movie_Name_EN = '.$movie_Name_EN["$i"]); 
					foreach ($sbdNews as $row)
					  {
						 File::delete('uploads/movie/'.$row->movie_Img_Thumb);
					  }
					//*************
					DB::delete('delete from movie_comingsoon where movie_Name_EN = '.$movie_Name_EN["$i"]); 
						    
				}#end for del
					
				break;
				case "เผยแพร่ | Publish" :
				$query = "update movie_comingsoon set movie_Publish='1' where ";
				for( $i = 0; $i < $num; $i++){
					$query .= "(movie_Name_EN = '$movie_Name_EN[$i]')";
					if($i < $num-1){
						$query .= " or ";
					}
				}  
				DB::update($query);	 
					 
				break;					  
				case "ซ่อน | Unpublish" :
				$query = "update movie_comingsoon set movie_Publish='0' where ";
				for( $i = 0; $i < $num; $i++){
					$query .= "(movie_Name_EN = '$movie_Name_EN[$i]')";
					if($i < $num-1){
						$query .= " or ";
					}
				}  
				DB::update($query);	 
				break;
			}  
			   
		}#end input Select *************
	    	$dateNow = date('Y-m-d');
		//** Select Start movie_comingsoon ****
		$resultComingsoon = DB::select("select  movieID, movie_Name_EN,
					movie_Img_Thumb, movie_ReleaseDate, movie_Publish, movie_strName
					FROM  movie_comingsoon 
					WHERE movieID != 0 
					and movie_ReleaseDate >= '$dateNow' 
					ORDER BY movie_ReleaseDate asc"); 
		//** Select End movie_comingsoon **** 
		//**********   start Select DB Comingsoon *******************///  
		  $dateNow = date('Y-m-d 08:00');  
		//********  Start Movie List ***************//
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
		
	 	 	 $dateEndShowtime = date('Y-m-d 03:00', strtotime(" +1 day"));
	 	 	  $dataMovie = DB::table('movie_showtimes')
							->leftJoin('movie_list', 'movie_showtimes.showtime_Movie_strID', '=', 'movie_list.movie_strID')
							->where('movie_showtimes.showtime_dtmDate_Time','>=', $dateNow)
							//->where('movie_showtimes.showtime_dtmDate_Time','<=', $dateEndShowtime) 
							->where('movie_list.movieID','>', '0')
							->where('movie_list.movie_statusUpdateData' , '1')
							 ->groupBy('movie_list.movie_Name_EN')
							 ->groupBy('movie_showtimes.showtime_SystemType')
							->orderBy('movie_list.movie_orderBy', 'asc')
							->orderBy('movie_showtimes.showtime_SystemType', 'asc') 
							->get(); 												 
			//********  Start Movie List ***************//									 
								 
		return View::make('backend.movielist') -> with('dataComingsoon', $resultComingsoon) 
											   -> with('movie_lists', $dataMovie);
	}
	 
	public function comingsoonList($id = null){ 		  
		
		//************** Movie List Start ************ 
		$actionMovieList = Input::get('actionMovieList'); 
		
		//**********   start Select DB Comingsoon *******************///
		$action_up = Input::get('action_up');		
		 
		if($action_up != ''){//  Check select dropdown
		 	
		$input = Input::all();	
			$movieID = $input['movieID'];		  
			$num =  count($movieID);	
			  
			switch($action_up){
				case "ลบ | Delete" : 
				for( $i = 0; $i < $num; $i++){					
					//************** 
				 	$sbdNews = DB::select('select movie_Img_Thumb 
										  FROM  movie_comingsoon 
										  WHERE movieID = '.$movieID["$i"]); 
					foreach ($sbdNews as $row)
					  {
						 File::delete('uploads/movie/'.$row->movie_Img_Thumb);
					  }
					//*************
					DB::delete('delete from movie_comingsoon where movieID = '.$movieID["$i"]); 
						    
				}#end for del
					
				break;
				case "เผยแพร่ | Publish" :
				$query = "update movie_comingsoon set movie_Publish='1' where ";
				for( $i = 0; $i < $num; $i++){
					$query .= "(movieID = '$movieID[$i]')";
					if($i < $num-1){
						$query .= " or ";
					}
				}  
				DB::update($query);	 
					 
				break;					  
				case "ซ่อน | Unpublish" :
				$query = "update movie_comingsoon set movie_Publish='0' where ";
				for( $i = 0; $i < $num; $i++){
					$query .= "(movieID = '$movieID[$i]')";
					if($i < $num-1){
						$query .= " or ";
					}
				}  
				DB::update($query);	 
				break;
			}  
			   
		}#end input Select *************
	    	$dateNow = date('Y-m-d');
		//** Select Start movie_comingsoon ****
		$resultComingsoon = DB::select("select  movieID, movie_Name_EN,
					movie_Img_Thumb, movie_ReleaseDate, movie_Publish, movie_strName
					FROM  movie_comingsoon 
					WHERE movieID != 0 
					and movie_ReleaseDate >= '$dateNow' 
					ORDER BY movie_ReleaseDate asc"); 
		//** Select End movie_comingsoon **** 
		//**********   start Select DB Comingsoon *******************///
		
		 $resultMovieList = DB::select("select movieID, movie_Name_EN,
										movie_Img_Thumb, movie_ReleaseDate, movie_Publish, movie_strName
										FROM  movie_list 
										WHERE movieID != 0 
										and movie_statusUpdateData = '1'
										GROUP BY movie_Name_EN
										ORDER BY movie_orderBy asc, movie_Publish asc, 
												 movie_ReleaseDate desc, movieID desc"); 
								 
		return View::make('backend.comingsoonlist') -> with('dataComingsoon', $resultComingsoon)
											   -> with('dataMovieList', $resultMovieList);
	}
	
 public function movieListEdit($id = null){
			
		$movieID = Input::get('movieID');	
		
		if($movieID != ''){//  Check Edit
		
			$file = Input::file('file1');		 
			
			if($file != ''){
				$destinationPath = 'uploads/movie/';
				$nowTime = date("YmdHi");
				$filename = str_random(10).''.$nowTime.'.'.$file->getClientOriginalExtension();
				Input::file('file1')->move($destinationPath, $filename);
				
					
			}else{//end if file
				$filename = Input::get('oldImage');	
			}
		
			 	
			$movie_Name_CN = Input::get('movie_Name_CN');
			$movie_Name_EN = Input::get('movie_Name_EN');
			$movie_Name_TH = Input::get('movie_Name_TH');
			
			$movie_Synopsis_TH = Input::get('movie_Synopsis_TH');	
			$movie_Synopsis_EN = Input::get('movie_Synopsis_EN');	
			$movie_Synopsis_CN = Input::get('movie_Synopsis_CN');
			
			$movie_Youtube = Input::get('movie_Youtube');
			$movie_ReleaseDate = Input::get('movie_ReleaseDate');
			$movie_Duration = Input::get('movie_Duration');
			$movie_Categories = Input::get('movie_Categories');
			$movie_Directors = Input::get('movie_Directors');
			$movie_Actors = Input::get('movie_Actors');  
			$movie_Rating = Input::get('movie_Rating');   
			$movie_strID = Input::get('movie_strID');   
		
			DB::table('movie_list')
			->where('movieID', $movieID)
			->update(array('movie_Name_CN' => $movie_Name_CN,
					'movie_Name_EN' => $movie_Name_EN,
					'movie_Name_TH' => $movie_Name_TH,					
					'movie_Img_Thumb' => $filename,
					'movie_Synopsis_CN' => $movie_Synopsis_CN,
					'movie_Synopsis_EN' => $movie_Synopsis_EN,
					'movie_Synopsis_TH' => $movie_Synopsis_TH,
					'movie_Rating' => $movie_Rating,
					
					'movie_Youtube' => $movie_Youtube,
					'movie_ReleaseDate' => $movie_ReleaseDate,
					'movie_Duration' => $movie_Duration,
					'movie_Categories' => $movie_Categories,
					'movie_Directors' => $movie_Directors,
					'movie_Actors' => $movie_Actors
					));
					
			DB::table('movie_comingsoon')
			  ->where('movie_strID', $movie_strID)
			  ->update(array('movie_Name_CN' => $movie_Name_CN,
					  'movie_Name_EN' => $movie_Name_EN,
					  'movie_Name_TH' => $movie_Name_TH,
					  'movie_strID' => $movie_strID,					
					  'movie_Img_Thumb' => $filename,
					  'movie_Synopsis_CN' => $movie_Synopsis_CN,
					  'movie_Synopsis_EN' => $movie_Synopsis_EN,
					  'movie_Synopsis_TH' => $movie_Synopsis_TH,
					  'movie_Rating' => $movie_Rating,
					  'movie_Youtube' => $movie_Youtube,
					  'movie_ReleaseDate' => $movie_ReleaseDate,
					  'movie_Duration' => $movie_Duration,
					  'movie_Categories' => $movie_Categories,
					  'movie_Directors' => $movie_Directors,
					  'movie_Actors' => $movie_Actors
					  ));
            			   
			 return Redirect::to('backoffice_management/movielist#theater');
		}
		  
		 
		$results = DB::select('select movieID, movie_Name_CN, movie_Name_EN, movie_Name_TH,
		           	movie_Synopsis_CN, movie_Synopsis_EN,movie_Synopsis_TH,	movie_Rating, 	     
					movie_Img_Thumb, movie_Publish, movie_strID,
					movie_Youtube, movie_ReleaseDate, movie_Duration, movie_Categories, movie_Directors, movie_Actors
					FROM  movie_list 
					
					WHERE movieID ='.$id);  
	        		           
		return View::make('backend.movieEdit')-> with('rowMovie', $results);
	}//End Fn movielist edit

	public function movieForm(){   
	
		$action = Input::get('action'); 
		if($action != ''){	  
			   $file = Input::file('file1'); 
			   
			   if($file != ''){	
			   	 	$destinationPath = 'uploads/movie/';
					$nowTime = date("YmdHi");
					$filename = str_random(10).''.$nowTime.'.'.$file->getClientOriginalExtension();  
					Input::file('file1')->move($destinationPath, $filename);
					//************* 
				}else{
					$filename = '';
				}
			 
			$movie_Name_CN = Input::get('movie_Name_CN');
			$movie_Name_EN = Input::get('movie_Name_EN');
			$movie_Name_TH = Input::get('movie_Name_TH');
			
			$movie_Synopsis_TH = Input::get('movie_Synopsis_TH');	
			$movie_Synopsis_EN = Input::get('movie_Synopsis_EN');	
			$movie_Synopsis_CN = Input::get('movie_Synopsis_CN');
			
			$movie_Youtube = Input::get('movie_Youtube');
			$movie_ReleaseDate = Input::get('movie_ReleaseDate');
			$movie_Duration = Input::get('movie_Duration');
			$movie_Categories = Input::get('movie_Categories');
			$movie_Directors = Input::get('movie_Directors');
			$movie_Actors = Input::get('movie_Actors');  
			
			// Add Data **** 
			DB::table('movie_comingsoon')-> insert(
				array('movie_Name_CN' => Input::get('movie_Name_CN'), 		
					  'movie_Name_EN' => Input::get('movie_Name_EN'),
					  'movie_Name_TH' => Input::get('movie_Name_TH'),
					  
					  'movie_Synopsis_TH' => Input::get('movie_Synopsis_TH'),
					  'movie_Synopsis_EN' => Input::get('movie_Synopsis_EN'),
					  'movie_Synopsis_CN' => Input::get('movie_Synopsis_CN'),
					  
					  'movie_Youtube' => Input::get('movie_Youtube'),
					  'movie_ReleaseDate' => Input::get('movie_ReleaseDate'),
					  'movie_Duration' => Input::get('movie_Duration'),
					  'movie_Categories' => Input::get('movie_Categories'),
					  'movie_Directors' => Input::get('movie_Directors'),
					  'movie_Actors' => Input::get('movie_Actors'),
																
					'movie_Img_Thumb' => $filename, 
					
					'movie_Publish' => '1',
					'movie_create' => date("Y-m-d")));
			return Redirect::to('backoffice_management/comingsoonlist#theater');
		} 

		return View::make('backend.movieAdd');

	}
	 public function movieComingsoonFormEdit($id = null){
			
		  $movieID = Input::get('movieID');	
		  
		  if($movieID != ''){//  Check Edit
		  
			  $file = Input::file('file1');		 
			  
			  if($file != ''){
				  $destinationPath = 'uploads/movie/';
				  $nowTime = date("YmdHi");
				  $filename = str_random(10).''.$nowTime.'.'.$file->getClientOriginalExtension();
				  Input::file('file1')->move($destinationPath, $filename);
				  
					  
			  }else{//end if file
				  $filename = Input::get('oldImage');	
			  }
		  
			 $movie_Rating = Input::get('movie_Rating');   
			  $movie_Name_CN = Input::get('movie_Name_CN');
			  $movie_Name_EN = Input::get('movie_Name_EN');
			  $movie_Name_TH = Input::get('movie_Name_TH');
			  
			  $movie_Synopsis_TH = Input::get('movie_Synopsis_TH');	
			  $movie_Synopsis_EN = Input::get('movie_Synopsis_EN');	
			  $movie_Synopsis_CN = Input::get('movie_Synopsis_CN');
			  
			  $movie_Youtube = Input::get('movie_Youtube');
			  $movie_ReleaseDate = Input::get('movie_ReleaseDate');
			  $movie_Duration = Input::get('movie_Duration');
			  $movie_Categories = Input::get('movie_Categories');
			  $movie_Directors = Input::get('movie_Directors');
			  $movie_Actors = Input::get('movie_Actors');  
			  $movie_strID = Input::get('movie_strID');
		  
			  DB::table('movie_comingsoon')
			  ->where('movieID', $movieID)
			  ->update(array('movie_Name_CN' => $movie_Name_CN,
					  'movie_Name_EN' => $movie_Name_EN,
					  'movie_Name_TH' => $movie_Name_TH,
					  'movie_strID' => $movie_strID,					
					  'movie_Img_Thumb' => $filename,
					  'movie_Synopsis_CN' => $movie_Synopsis_CN,
					  'movie_Synopsis_EN' => $movie_Synopsis_EN,
					  'movie_Synopsis_TH' => $movie_Synopsis_TH,
					   'movie_Rating' => $movie_Rating,
					  'movie_Youtube' => $movie_Youtube,
					  'movie_ReleaseDate' => $movie_ReleaseDate,
					  'movie_Duration' => $movie_Duration,
					  'movie_Categories' => $movie_Categories,
					  'movie_Directors' => $movie_Directors,
					  'movie_Actors' => $movie_Actors
					  ));
					  
			  //***********
			  if($movie_strID != ''){
				  $movie_statusUpdateData = '1';
				   DB::table('movie_list')
							->where('movie_strID', $movie_strID)
							->update(array('movie_Name_CN' => $movie_Name_CN,
									'movie_Name_EN' => $movie_Name_EN,
									'movie_Name_TH' => $movie_Name_TH,					
									'movie_Img_Thumb' => $filename,
									'movie_Synopsis_CN' => $movie_Synopsis_CN,
									'movie_Synopsis_EN' => $movie_Synopsis_EN,
									'movie_Synopsis_TH' => $movie_Synopsis_TH, 
									'movie_Youtube' => $movie_Youtube,
									'movie_ReleaseDate' => $movie_ReleaseDate,
									'movie_Duration' => $movie_Duration,
									'movie_Categories' => $movie_Categories,
									'movie_Directors' => $movie_Directors,
									'movie_statusUpdateData' => $movie_statusUpdateData,
									
									'movie_Actors' => $movie_Actors
									)); 
				  }#end if
			  //***********
							 
			   return Redirect::to('backoffice_management/comingsoonlist#theater');
		  }
			
		   
		  $results = DB::select('select movieID, movie_Name_CN, movie_Name_EN, movie_Name_TH,
					  movie_Synopsis_CN, movie_Synopsis_EN,movie_Synopsis_TH, movie_strID,	 	     
					  movie_Img_Thumb, movie_Publish, movie_Rating,
					  movie_Youtube, movie_ReleaseDate, movie_Duration, movie_Categories, movie_Directors, movie_Actors
					  FROM  movie_comingsoon 
					  WHERE movieID ='.$id);  
								 
		  return View::make('backend.movieComingsoonEdit')-> with('rowMovie', $results);
	}//End  fn
	
	public function listEmailSubmitted(){
		
			$results = DB::table('movie_alertme')  
						->join('movie_comingsoon', 'movie_alertme.movieID', '=', 'movie_comingsoon.movieID')
						->orderBy('movie_alertme.movieID', 'desc')
					    ->orderBy('movie_alertme.signupDate', 'desc') 
					    ->get();
			 
			return View::make('backend.listEmailSubmitted')-> with('rowData', $results);
		
	}#end fn comingsoonFormEdit
	public function dragDropMovieList(){  
	 
		$result = Input::get('table-1');
		
		//$num = count($result);
		$order  = 0;
		foreach($result as $value) {
			$order++;
			DB::table('movie_list')
					->where('movieID', $value)
					->update(array('movie_orderBy' => $order));
			
			
			}#end foreach
	}

}
?>