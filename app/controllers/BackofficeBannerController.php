<?php
class BackofficeBannerController extends Controller{

	public function banner($id = null){ 		  
		
		  
		$action_up = Input::get('action_up');		
		 
		if($action_up != ''){//  Check select dropdown
		 	
	
			$input = Input::all();	
			$banner_ID = $input['banner_ID'];		  
			$num =  count($banner_ID);	
			  
			switch($action_up){
				case "ลบ | Delete" : 
				for( $i = 0; $i < $num; $i++){					
					//************** 
				 	$sbdNews = DB::select('select banner_pic, banner_picMobile 
										  FROM  movie_banner 
										  WHERE banner_ID = '.$banner_ID["$i"]); 
					foreach ($sbdNews as $row)
					  {
						 File::delete('uploads/banner/'.$row->banner_pic);
						 File::delete('uploads/banner/'.$row->banner_picMobile);
					  }
					//*************  
					
					DB::delete('delete from movie_banner where banner_ID = '.$banner_ID["$i"]);
						   
						    
				}#end for del
					
				break;
				case "เผยแพร่ | Publish" :
				$query = "update movie_banner set banner_publish ='1' where ";
				for( $i = 0; $i < $num; $i++){
					$query .= "(banner_ID = $banner_ID[$i])";
					if($i < $num-1){
						$query .= " or ";
					}
				}  
				DB::update($query);	
					  
					 
				break;					  
				case "ซ่อน | Unpublish" :
				$query = "update movie_banner set banner_publish='0' where ";
				for( $i = 0; $i < $num; $i++){
					$query .= "(banner_ID = $banner_ID[$i])";
					if($i < $num-1){
						$query .= " or ";
					}
				}  
				DB::update($query);	 
				break;
			} 
			  
			   
		}#end input Select *************
	    
		//** Select Start movie_banner ****
		$sbdBanner = DB::select('select *
			FROM  movie_banner 
			WHERE banner_ID != 0 
			ORDER BY orderBy asc'); 
		//** Select End movie_banner ****
								 
		return View::make('backend.banner') -> with('sbdBanner', $sbdBanner);
	} 

	public function bannerForm(){  
	 
		
		$action = Input::get('action'); 
		if($action != ''){	  
			 
			     $file = Input::file('file1');
			   $file2 = Input::file('file2');
			   
			   if($file != ''){	
			   	 	$destinationPath = 'uploads/banner/';
					$nowTime = date("YmdHi");
					$filename = str_random(10).''.$nowTime.'.'.$file->getClientOriginalExtension();  
					Input::file('file1')->move($destinationPath, $filename);
					//*************
					
				}else{
					$filename = '';
				}
				
				 if($file2 != ''){	
			   	 	$destinationPath = 'uploads/banner/';
					$nowTime = date("YmdHi");
					$filename2 = str_random(10).''.$nowTime.'.'.$file2->getClientOriginalExtension();
					 Input::file('file2')->move($destinationPath, $filename2); 
					
				}else{
					$filename2 = '';
				}
		
			// Add Data **** 
			DB::table('movie_banner')-> insert(
				array('banner_name' => Input::get('banner_name'), 		
					  'banner_url' => Input::get('banner_url'),
																
					'banner_pic' => $filename,
					'banner_picMobile' => $filename2,
					
					'banner_publish' => '1',
					'banner_create' => date("Y-m-d")));
			 return Redirect::to('backoffice_management/banner#content');
		} 

		return View::make('backend.bannerAdd');

	}
	public function bannerFormEdit($id = null){
			
		$banner_ID = Input::get('banner_ID');	
		$oldImage = Input::get('oldImage');	
		$oldImageMobile = Input::get('oldImageMobile');	
		
		if($banner_ID != ''){//  Check Edit
		
			$file = Input::file('file1');	
			$file2 = Input::file('file2');	 
			
			if($file != ''){
				$destinationPath = 'uploads/banner/';
				$nowTime = date("YmdHi");
				$filename = str_random(10).''.$nowTime.'.'.$file->getClientOriginalExtension();
				Input::file('file1')->move($destinationPath, $filename);
				
					
			}else{//end if file
				$filename = Input::get('oldImage');	
			}
			
			if($file2 != ''){
				$destinationPath = 'uploads/banner/';
				$nowTime = date("YmdHi");
				$filename2 = str_random(10).''.$nowTime.'.'.$file2->getClientOriginalExtension();
				Input::file('file2')->move($destinationPath, $filename2);
				
					
			}else{//end if file
				$filename2 = Input::get('oldImageMobile');	
			}
		
			$banner_ID = Input::get('banner_ID');	
			$banner_name = Input::get('banner_name');
			$banner_url = Input::get('banner_url');
		 
		
			DB::table('movie_banner')
			->where('banner_ID', $banner_ID)
			->update(array('banner_name' => $banner_name,
					'banner_url' => $banner_url, 			
					'banner_pic' => $filename,
					'banner_picMobile' => $filename2 ));
            			   
			return Redirect::to('backoffice_management/banner#content');
		}
		  
		 
		$results = DB::select('select banner_name, banner_url, banner_pic, banner_picMobile, banner_ID
								FROM  movie_banner 
								WHERE banner_ID ='.$id);  
	        		           
		return View::make('backend.bannerFormEdit')-> with('DataSelect', $results);
	}
	
		
	

	public function dragDropBanner(){  
	 
		$result = Input::get('table-1');
		
		//$num = count($result);
		$order  = 0;
		foreach($result as $value) {
			$order++;
			DB::table('movie_banner')
					->where('banner_ID', $value)
					->update(array('orderBy' => $order));
			
			
			}#end foreach
	}

}
?>