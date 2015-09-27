<?php
class BackofficepromotionController extends Controller{

	public function promotion($id = null){ 		  
		
		  
		$action_up = Input::get('action_up');		
		 
		if($action_up != ''){//  Check select dropdown
		 	
	
			$input = Input::all();	
			$promotionID = $input['promotionID'];		  
			$num =  count($promotionID);	
			  
			switch($action_up){
				case "ลบ | Delete" : 
				for( $i = 0; $i < $num; $i++){					
					//************** 
				 	$sbdpromotion = DB::select('select promotion_imageThumb 
										  FROM  movie_promotion 
										  WHERE promotion_ID = '.$promotionID["$i"]); 
					foreach ($sbdpromotion as $row)
					  {
						 File::delete('uploads/promotion/'.$row->promotion_imageThumb);
					  }
					//*************  
					
					DB::delete('delete from movie_promotion where promotion_ID = '.$promotionID["$i"]);
						   
						    
				}#end for del
					
				break;
				case "เผยแพร่ | Publish" :
				$query = "update movie_promotion set promotion_publish='1' where ";
				for( $i = 0; $i < $num; $i++){
					$query .= "(promotion_ID = $promotionID[$i])";
					if($i < $num-1){
						$query .= " or ";
					}
				}  
				DB::update($query);	
					  
					 
				break;					  
				case "ซ่อน | Unpublish" :
				$query = "update movie_promotion set promotion_publish='0' where ";
				for( $i = 0; $i < $num; $i++){
					$query .= "(promotion_ID = $promotionID[$i])";
					if($i < $num-1){
						$query .= " or ";
					}
				}  
				DB::update($query);	 
				break;
			} 
			  
			   
		}#end input Select *************
	    
		//** Select Start movie_promotion ****
		$sbdpromotion = DB::select('select promotion_ID,promotion_title_th,
			promotion_imageThumb,promotion_createDate,promotion_publish
			FROM  movie_promotion 
			WHERE promotion_ID != 0 
			ORDER BY orderBy asc'); 
		//** Select End movie_promotion ****
								 
		 return View::make('backend.promotion') -> with('sbdpromotion', $sbdpromotion); 
	}

	public function promotionForm(){   
	
		$action = Input::get('action'); 
		if($action != ''){	  
		
			   $file = Input::file('file1');
			   $file2 = Input::file('file2');
			   
			   if($file != ''){	
			   	 	$destinationPath = 'uploads/promotion/';
					$nowTime = date("YmdHi");
					$filename = str_random(10).''.$nowTime.'.'.$file->getClientOriginalExtension();
					Input::file('file1')->move($destinationPath, $filename);
				}else{
					$filename = '';
				}
				 
			   if($file2 != ''){	
			   	 	$destinationPath = 'uploads/promotion/';
					$nowTime = date("YmdHi");
					$filename2 = str_random(10).''.$nowTime.'.'.$file2->getClientOriginalExtension();
					Input::file('file2')->move($destinationPath, $filename2);
				}else{
					$filename2 = '';
				}
		
			// Add Data **** 
			DB::table('movie_promotion')-> insert(
			
				array('promotion_title_th' => Input::get('title_th'), 		
					'promotion_title_cn' => Input::get('title_cn'), 
					'promotion_title_en' => Input::get('title_en'), 
					'promotion_datetime' => Input::get('promotion_datetime'), 	
					
					'promotion_abstract_cn' => Input::get('promotion_abstract_cn'),						
					'promotion_abstract_en' => Input::get('promotion_abstract_en'),	
					'promotion_abstract_th' => Input::get('promotion_abstract_th'),	
													
					'promotion_detail_th' => Input::get('detail_th'),						
					'promotion_detail_en' => Input::get('detail_en'),	
					'promotion_detail_cn' => Input::get('detail_cn'),											
					'promotion_imageThumb' => $filename,
					'promotion_image' 	=> $filename2,
					'promotion_publish' => '1',
					'promotion_createDate' => date("Y-m-d")));
			return Redirect::to('backoffice_management/promotion#content');
		} 

		return View::make('backend.promotionForm');

	}
	public function promotionFormEdit($id = null){
			
		$promotionID = Input::get('promotionID');	
		
		if($promotionID != ''){//  Check Edit
		
			$file = Input::file('file1');	
			$file2 = Input::file('file2');	 
			
			if($file != ''){
				$destinationPath = 'uploads/promotion/';
				$nowTime = date("YmdHi");
				$filename = str_random(10).''.$nowTime.'.'.$file->getClientOriginalExtension();
				Input::file('file1')->move($destinationPath, $filename);
				
					
			}else{//end if file
				$filename = Input::get('oldImage');	
			}
			
			if($file2 != ''){
				$destinationPath = 'uploads/promotion/';
				$nowTime = date("YmdHi");
				$filename2 = str_random(10).''.$nowTime.'.'.$file2->getClientOriginalExtension();
				Input::file('file2')->move($destinationPath, $filename2);
				
					
			}else{//end if file
				$filename2 = Input::get('oldImageLarge');	
			}
		
			$promotionID = Input::get('promotionID');	
			$title_th = Input::get('title_th');
			$title_cn = Input::get('title_cn');
			$title_en = Input::get('title_en');
			
			$detail_th = Input::get('detail_th');	
			$detail_cn = Input::get('detail_cn');	
			$detail_en = Input::get('detail_en');	
			
			$promotion_datetime =  Input::get('promotion_datetime'); 	
			
			$promotion_abstract_cn =  Input::get('promotion_abstract_cn'); 
			$promotion_abstract_en =  Input::get('promotion_abstract_en'); 
			$promotion_abstract_th =  Input::get('promotion_abstract_th'); 	 
					
			DB::table('movie_promotion')
			->where('promotion_ID', $promotionID)
			->update(array('promotion_title_th' => $title_th,
					'promotion_title_en' => $title_en,
					'promotion_title_cn' => $title_cn,					
					'promotion_imageThumb' => $filename,
					'promotion_image' => $filename2,
					
					'promotion_datetime' => $promotion_datetime,	
					'promotion_abstract_cn' => $promotion_abstract_cn,	
					'promotion_abstract_en' => $promotion_abstract_en,	
					'promotion_abstract_th' => $promotion_abstract_th,	
					
					'promotion_detail_th' => $detail_th,
					'promotion_detail_en' => $detail_en,
					'promotion_detail_cn' => $detail_cn));
            			   
			return Redirect::to('backoffice_management/promotion#content');
		}
		  
		 
		$results = DB::select('select promotion_ID,promotion_title_th,promotion_title_en,promotion_title_cn,
		           	promotion_detail_th,promotion_detail_en,promotion_detail_cn,		     
					promotion_imageThumb, promotion_image, promotion_publish, promotion_datetime, 
					promotion_abstract_cn, promotion_abstract_en, promotion_abstract_th
					FROM  movie_promotion 
					WHERE promotion_ID ='.$id);  
	        		           
		return View::make('backend.promotionFormEdit')-> with('promotion', $results);
	}
	public function dragDropPromotion(){  
	 
		$result = Input::get('table-1');
		
		//$num = count($result);
		$order  = 0;
		foreach($result as $value) {
			$order++;
			DB::table('movie_promotion')
					->where('promotion_ID', $value)
					->update(array('orderBy' => $order));
			
			
			}#end foreach
	}

}
?>