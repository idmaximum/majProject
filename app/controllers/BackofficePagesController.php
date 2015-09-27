<?php
class BackofficePagesController extends Controller{

	public function pages($id = null){ 		  
		
		  
		$action_up = Input::get('action_up');		
		 
		if($action_up != ''){//  Check select dropdown
		 	
	
			$input = Input::all();	
			$pagesID = $input['pagesID'];		  
			$num =  count($pagesID);	
			  
			switch($action_up){
				case "ลบ | Delete" : 
				for( $i = 0; $i < $num; $i++){					
					//************** 
				 	$sbdpages = DB::select('select pages_imageThumb 
										  FROM  movie_pages 
										  WHERE pages_ID = '.$pagesID["$i"]); 
					foreach ($sbdpages as $row)
					  {
						 File::delete('uploads/pages/'.$row->pages_imageThumb);
					  }
					//*************  
					
					DB::delete('delete from movie_pages where pages_ID = '.$pagesID["$i"]);
						   
						    
				}#end for del
					
				break;
				case "เผยแพร่ | Publish" :
				$query = "update movie_pages set pages_publish='1' where ";
				for( $i = 0; $i < $num; $i++){
					$query .= "(pages_ID = $pagesID[$i])";
					if($i < $num-1){
						$query .= " or ";
					}
				}  
				DB::update($query);	
					  
					 
				break;					  
				case "ซ่อน | Unpublish" :
				$query = "update movie_pages set pages_publish='0' where ";
				for( $i = 0; $i < $num; $i++){
					$query .= "(pages_ID = $pagesID[$i])";
					if($i < $num-1){
						$query .= " or ";
					}
				}  
				DB::update($query);	 
				break;
			} 
			  
			   
		}#end input Select *************
	    
		//** Select Start movie_pages ****
		$results = DB::select('select pages_ID,pages_title_th,
			pages_imageThumb,pages_createDate,pages_publish
			FROM  movie_pages 
			WHERE pages_ID != 0 
			ORDER BY orderBy asc'); 
		//** Select End movie_pages ****
								 
		return View::make('backend.pages') -> with('rowData', $results);
	}

	public function pagesForm(){  
	 
	
		$action = Input::get('action'); 
		if($action != ''){	  
			   $file = Input::file('file1');
			   if($file != ''){	
			   	 	$destinationPath = 'uploads/pages/';
					$nowTime = date("YmdHi");
					$filename = str_random(10).''.$nowTime.'.'.$file->getClientOriginalExtension();
					Input::file('file1')->move($destinationPath, $filename);
				}else{
					$filename = '';
				}
		
			// Add Data **** 
			DB::table('movie_pages')-> insert(
				array('pages_title_th' => Input::get('title_th'), 		
					'pages_title_cn' => Input::get('title_cn'), 
					'pages_title_en' => Input::get('title_en'), 
					
					'pages_datetime' => Input::get('pages_datetime'), 	
					
					'pages_abstract_cn' => Input::get('pages_abstract_cn'),						
					'pages_abstract_en' => Input::get('pages_abstract_en'),	
					'pages_abstract_th' => Input::get('pages_abstract_th'),	 
																						
					'pages_detail_th' => Input::get('detail_th'),						
					'pages_detail_en' => Input::get('detail_en'),	
					'pages_detail_cn' => Input::get('detail_cn'),											
					'pages_imageThumb' => $filename,
					'pages_publish' => '1',
					'pages_createDate' => date("Y-m-d")));
			return Redirect::to('backoffice_management/pages#content');
		} 

		return View::make('backend.pagesForm');

	}
	public function pagesFormEdit($id = null){
			
		$pagesID = Input::get('pagesID');	
		
		if($pagesID != ''){//  Check Edit
		
			$file = Input::file('file1');		 
			
			if($file != ''){
				$destinationPath = 'uploads/pages/';
				$nowTime = date("YmdHi");
				$filename = str_random(10).''.$nowTime.'.'.$file->getClientOriginalExtension();
				Input::file('file1')->move($destinationPath, $filename);
				
					
			}else{//end if file
				$filename = Input::get('oldImage');	
			}
		
			$pagesID = Input::get('pagesID');	
			$title_th = Input::get('title_th');
			$title_cn = Input::get('title_cn');
			$title_en = Input::get('title_en');
			
			$detail_th = Input::get('detail_th');	
			$detail_cn = Input::get('detail_cn');	
			$detail_en = Input::get('detail_en');	
			
			$pages_datetime =  Input::get('pages_datetime'); 	
			
			$pages_abstract_cn =  Input::get('pages_abstract_cn'); 
			$pages_abstract_en =  Input::get('pages_abstract_en'); 
			$pages_abstract_th =  Input::get('pages_abstract_th'); 	
		
			DB::table('movie_pages')
			->where('pages_ID', $pagesID)
			->update(array('pages_title_th' => $title_th,
					'pages_title_en' => $title_en,
					'pages_title_cn' => $title_cn,					
					'pages_imageThumb' => $filename,
					'pages_detail_th' => $detail_th,
					
					'pages_datetime' => $pages_datetime,	
					'pages_abstract_cn' => $pages_abstract_cn,	
					'pages_abstract_en' => $pages_abstract_en,	
					'pages_abstract_th' => $pages_abstract_th,	
					
					'pages_detail_en' => $detail_en,
					'pages_detail_cn' => $detail_cn));
            			   
			return Redirect::to('backoffice_management/pages#content');
		}
		  
		 
		$results = DB::select('select pages_ID,pages_title_th,pages_title_en,pages_title_cn,
		           	pages_detail_th,pages_detail_en,pages_detail_cn,		     
					pages_imageThumb,pages_publish, pages_datetime, 
					pages_abstract_cn, pages_abstract_en, pages_abstract_th
					FROM  movie_pages 
					WHERE pages_ID ='.$id);  
	        		           
		return View::make('backend.pagesFormEdit')-> with('pages', $results);
	}
	public function dragDroppages(){  
	 
		$result = Input::get('table-1');
		
		//$num = count($result);
		$order  = 0;
		foreach($result as $value) {
			$order++;
			DB::table('movie_pages')
					->where('pages_ID', $value)
					->update(array('orderBy' => $order));
			
			
			}#end foreach
	}

}
?>