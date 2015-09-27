<?php
class BackofficeMovieController extends Controller{ 

	public function movie($id = null){ 	 
		  
		$action_up = Input::get('action_up');		
		 
		if($action_up != ''){//  Check select dropdown
		 	
	
			$input = Input::all();	
			$movie_Name_EN = $input['movie_Name_EN'];		  
			$num =  count($movie_Name_EN);	
			  
			switch($action_up){
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
			  
			   
		}#end input Select *************
	    
		//** Select Start movie_list ****
		$rowMovie = DB::select('select movieID, movie_Name_EN,
			movie_Img_Thumb, movie_ReleaseDate, movie_Publish, movie_strName
			FROM  movie_list 
			WHERE movieID != 0 
			GROUP BY movie_Name_EN
			ORDER BY movie_Publish asc, movie_ReleaseDate desc, movieID desc'); 
		//** Select End movie_list ****
								 
		return View::make('backend.movieList') -> with('rowMovie', $rowMovie);
	} 
	public function movieEdit($id = null){
			
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
		
			DB::table('movie_list')
			->where('movie_Name_EN', $movie_Name_EN)
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
					'movie_Actors' => $movie_Actors
					));
            			   
			 return Redirect::to('admin/movie#theater');
		}
		  
		 
		$results = DB::select('select movieID, movie_Name_CN, movie_Name_EN, movie_Name_TH,
		           	movie_Synopsis_CN, movie_Synopsis_EN,movie_Synopsis_TH,	 	     
					movie_Img_Thumb, movie_Publish,
					movie_Youtube, movie_ReleaseDate, movie_Duration, movie_Categories, movie_Directors, movie_Actors
					FROM  movie_list 
					WHERE movieID ='.$id);  
	        		           
		return View::make('backend.movieEdit')-> with('rowMovie', $results);
	}//End 

}
?>