<?php
class BackofficeComingsoonController extends Controller{

	public function comingsoon($id = null){ 		  
		
		  
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
	    	$dateNow = date('Y-m');
		//** Select Start movie_comingsoon ****
		$dataComingsoon = DB::select("select  movieID, movie_Name_EN,
					movie_Img_Thumb, movie_ReleaseDate, movie_Publish, movie_strName
					FROM  movie_comingsoon 
					WHERE movieID != 0 
					and movie_ReleaseDate >= '$dateNow' 
					ORDER BY movie_ReleaseDate desc"); 
		//** Select End movie_comingsoon ****
								 
		return View::make('backend.comingsoonList') -> with('dataComingsoon', $dataComingsoon);
	}

	public function comingsoonForm(){   
	
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
			return Redirect::to('backoffice_management/comingsoon#theater');
		} 

		return View::make('backend.comingsoonAdd');

	}
		public function comingsoonFormEdit($id = null){
			
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
		
			DB::table('movie_comingsoon')
			->where('movieID', $movieID)
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
            			   
			 return Redirect::to('backoffice_management/comingsoon#theater');
		}
		  
		 
		$results = DB::select('select movieID, movie_Name_CN, movie_Name_EN, movie_Name_TH,
		           	movie_Synopsis_CN, movie_Synopsis_EN,movie_Synopsis_TH,	 	     
					movie_Img_Thumb, movie_Publish,
					movie_Youtube, movie_ReleaseDate, movie_Duration, movie_Categories, movie_Directors, movie_Actors
					FROM  movie_comingsoon 
					WHERE movieID ='.$id);  
	        		           
		return View::make('backend.comingsoonEdit')-> with('rowMovie', $results);
	}//End  fn
	
	public function listEmailSubmitted(){
		
			$results = DB::table('movie_alertme')  
						->join('movie_comingsoon', 'movie_alertme.movieID', '=', 'movie_comingsoon.movieID')
						->orderBy('movie_alertme.movieID', 'desc')
					    ->orderBy('movie_alertme.signupDate', 'desc') 
					    ->get();
			 
			return View::make('backend.listEmailSubmitted')-> with('rowData', $results);
		
	}#end fn comingsoonFormEdit

}
?>