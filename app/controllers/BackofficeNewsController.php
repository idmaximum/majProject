<?php
class BackofficeNewsController extends Controller{

	public function news($id = null){ 		  
		
		  
		$action_up = Input::get('action_up');		
		 
		if($action_up != ''){//  Check select dropdown
		 	
	
			$input = Input::all();	
			$newsID = $input['newsID'];		  
			$num =  count($newsID);	
			  
			switch($action_up){
				case "ลบ | Delete" : 
				for( $i = 0; $i < $num; $i++){					
					//************** 
				 	$sbdNews = DB::select('select news_imageThumb 
										  FROM  movie_news 
										  WHERE news_ID = '.$newsID["$i"]); 
					foreach ($sbdNews as $row)
					  {
						 File::delete('uploads/news/'.$row->news_imageThumb);
					  }
					//*************  
					
					DB::delete('delete from movie_news where news_ID = '.$newsID["$i"]);
						   
						    
				}#end for del
					
				break;
				case "เผยแพร่ | Publish" :
				$query = "update movie_news set news_publish='1' where ";
				for( $i = 0; $i < $num; $i++){
					$query .= "(news_ID = $newsID[$i])";
					if($i < $num-1){
						$query .= " or ";
					}
				}  
				DB::update($query);	
					  
					 
				break;					  
				case "ซ่อน | Unpublish" :
				$query = "update movie_news set news_publish='0' where ";
				for( $i = 0; $i < $num; $i++){
					$query .= "(news_ID = $newsID[$i])";
					if($i < $num-1){
						$query .= " or ";
					}
				}  
				DB::update($query);	 
				break;
			} 
			  
			   
		}#end input Select *************
	    
		//** Select Start movie_news ****
		$sbdNews = DB::select('select news_ID,news_title_th,
			news_imageThumb,news_createDate,news_publish
			FROM  movie_news 
			WHERE news_ID != 0 
			ORDER BY orderBy asc'); 
		//** Select End movie_news ****
								 
		return View::make('backend.news') -> with('sbdNews', $sbdNews);
	}

	public function newsForm(){  
	 
	
		$action = Input::get('action'); 
		if($action != ''){	  
			   $file = Input::file('file1');
			   if($file != ''){	
			   	 	$destinationPath = 'uploads/news/';
					$nowTime = date("YmdHi");
					$filename = str_random(10).''.$nowTime.'.'.$file->getClientOriginalExtension();
					Input::file('file1')->move($destinationPath, $filename);
					
					
				}else{
					$filename = '';
				}
		
			// Add Data **** 
			DB::table('movie_news')-> insert(
				array('news_title_th' => Input::get('title_th'), 		
					'news_title_cn' => Input::get('title_cn'), 
					'news_title_en' => Input::get('title_en'), 
					
					'news_datetime' => Input::get('news_datetime'), 	
					
					'news_abstract_cn' => Input::get('news_abstract_cn'),						
					'news_abstract_en' => Input::get('news_abstract_en'),	
					'news_abstract_th' => Input::get('news_abstract_th'),
					'news_youtube' => Input::get('news_youtube'),	 
																						
					'news_detail_th' => Input::get('detail_th'),						
					'news_detail_en' => Input::get('detail_en'),	
					'news_detail_cn' => Input::get('detail_cn'),											
					'news_imageThumb' => $filename,
					'news_publish' => '1',
					'news_createDate' => date("Y-m-d")));
			return Redirect::to('backoffice_management/news#content');
		} 

		return View::make('backend.newsForm');

	}
	public function newsFormEdit($id = null){
			
		$newsID = Input::get('newsID');	
		
		if($newsID != ''){//  Check Edit
		
			$file = Input::file('file1');		 
			
			if($file != ''){
				$destinationPath = 'uploads/news/';
				$nowTime = date("YmdHi");
				$filename = str_random(10).''.$nowTime.'.'.$file->getClientOriginalExtension();
				Input::file('file1')->move($destinationPath, $filename);
				
					
			}else{//end if file
				$filename = Input::get('oldImage');	
			}
		
			$newsID = Input::get('newsID');	
			$title_th = Input::get('title_th');
			$title_cn = Input::get('title_cn');
			$title_en = Input::get('title_en');
			
			$detail_th = Input::get('detail_th');	
			$detail_cn = Input::get('detail_cn');	
			$detail_en = Input::get('detail_en');	
			$news_youtube = Input::get('news_youtube'); 
			$news_datetime =  Input::get('news_datetime'); 	
			
			$news_abstract_cn =  Input::get('news_abstract_cn'); 
			$news_abstract_en =  Input::get('news_abstract_en'); 
			$news_abstract_th =  Input::get('news_abstract_th'); 	
		
			DB::table('movie_news')
			->where('news_ID', $newsID)
			->update(array('news_title_th' => $title_th,
					'news_title_en' => $title_en,
					'news_title_cn' => $title_cn,					
					'news_imageThumb' => $filename,
					'news_detail_th' => $detail_th,
					'news_youtube' => $news_youtube,
					
					'news_datetime' => $news_datetime,	
					'news_abstract_cn' => $news_abstract_cn,	
					'news_abstract_en' => $news_abstract_en,	
					'news_abstract_th' => $news_abstract_th,	
					
					'news_detail_en' => $detail_en,
					'news_detail_cn' => $detail_cn));
            			   
			return Redirect::to('backoffice_management/news#content');
		}
		  
		 
		$results = DB::select('select news_ID,news_title_th,news_title_en,news_title_cn,
		           	news_detail_th,news_detail_en,news_detail_cn,	news_youtube,	     
					news_imageThumb,news_publish, news_datetime, 
					news_abstract_cn, news_abstract_en, news_abstract_th
					FROM  movie_news 
					WHERE news_ID ='.$id);  
	        		           
		return View::make('backend.newsFormEdit')-> with('News', $results);
	}
	public function dragDropNews(){  
	 
	 	$result = Input::get('table-1');
		
		//$num = count($result);
		$order  = 0;
		foreach($result as $value) {
			$order++;
			DB::table('movie_news')
					->where('news_ID', $value)
					->update(array('orderBy' => $order));
			
			
			}#end foreach
	}
	public function newsGallery($id = null){
		 $action_up = Input::get('action_up');		
		 
		if($action_up != ''){//  Check select dropdown
		 	
	
			$input = Input::all();	
			$news_Image_ID = $input['news_Image_ID'];		  
			$num =  count($news_Image_ID);	
			  
			switch($action_up){
				case "ลบ | Delete" : 
				for( $i = 0; $i < $num; $i++){					
					//************** 
				 	$sbdNews = DB::select('select news_ImageThumb 
										  FROM  movie_image_gallery 
										  WHERE news_Image_ID = '.$news_Image_ID["$i"]); 
					foreach ($sbdNews as $row)
					  {
						 File::delete('uploads/news/'.$row->news_ImageThumb);
					  }
					//*************  
					
					DB::delete('delete from movie_image_gallery where news_Image_ID = '.$news_Image_ID["$i"]); 
				}#end for del 
				break;
				 
			} 
			  
			   
		}#end input Select *************
		
		    $news_ID = $id;	
			
			$dataGallery = DB::select('select *
					FROM  movie_image_gallery 
					WHERE news_ID ='.$id);  
		
			return View::make('backend.newsGallery')-> with('NewsGallery', $dataGallery)
													-> with('news_ID', $news_ID);/**/
	}#end fn newsGallery
	
	public function newsGalleryAdd($id = null){
		    $news_ID = $id;	
			
			$action = Input::get('action');
			if($action != ''){ 
					
					$file1 = Input::file('file1');	
					$file2 = Input::file('file2');	
					$file3 = Input::file('file3');	
					$file4 = Input::file('file4');	
					$file5 = Input::file('file5');	
					$news_ID = Input::get('news_ID');
					
				 if($file1 != ''){
					  $destinationPath = 'uploads/news/'; 
					  $nowTime = date("YmdHi");
					  $filename = str_random(10).''.$nowTime.'.'.$file1->getClientOriginalExtension();
					  $file1->move($destinationPath, $filename);
				
						DB::table('movie_image_gallery')-> insert(
						 		   array('news_ID' => $news_ID,  
								  'news_imageThumb' => $filename ));
				 }#end if file 1
				 
				 if($file2 != ''){
					  $destinationPath = 'uploads/news/'; 
					  $nowTime = date("YmdHi");
					  $filename = str_random(10).''.$nowTime.'.'.$file2->getClientOriginalExtension();
					  $file2->move($destinationPath, $filename);
				
						DB::table('movie_image_gallery')-> insert(
						 		   array('news_ID' => $news_ID,  
								  'news_imageThumb' => $filename ));
				 }#end if file 2
				 
				 if($file3 != ''){
					  $destinationPath = 'uploads/news/'; 
					  $nowTime = date("YmdHi");
					  $filename = str_random(10).''.$nowTime.'.'.$file3->getClientOriginalExtension();
					  $file3->move($destinationPath, $filename);
				
						DB::table('movie_image_gallery')-> insert(
						 		   array('news_ID' => $news_ID,  
								  'news_imageThumb' => $filename ));
				 }#end if file 3
				 
				 if($file4 != ''){
					  $destinationPath = 'uploads/news/'; 
					  $nowTime = date("YmdHi");
					  $filename = str_random(10).''.$nowTime.'.'.$file4->getClientOriginalExtension();
					  $file4->move($destinationPath, $filename);
				
						DB::table('movie_image_gallery')-> insert(
						 		   array('news_ID' => $news_ID,  
								  'news_imageThumb' => $filename ));
				 }#end if file 4
				 
				 if($file5 != ''){
					  $destinationPath = 'uploads/news/'; 
					  $nowTime = date("YmdHi");
					  $filename = str_random(10).''.$nowTime.'.'.$file4->getClientOriginalExtension();
					  $file5->move($destinationPath, $filename);
				
						DB::table('movie_image_gallery')-> insert(
						 		   array('news_ID' => $news_ID,  
								  'news_imageThumb' => $filename ));
				 }#end if file 5
					
				return Redirect::to('backoffice_management/newsGallery/'."$news_ID");	
						
			 }#end if  
		
			return View::make('backend.newsGalleryAdd')-> with('news_ID', $news_ID);/**/
	}#end fn newsGallery

}
?>