<?php
class BackofficeNewsController extends Controller {

	public function news($id = null) { 		  
			
	     $action_up = Input::get('action_up');		
		 
		 if($action_up != ''){//  Check select dropdown
		 
			  $input = Input::all();	
			  $newsID = $input['newsID'];		  
			  $num =  count($newsID);	
			  
			  switch($action_up){
			         case "ลบ | Delete" : 
					  	for( $i = 0; $i < $num; $i++){
						    DB::delete('delete from news where news_id='.$newsID["$i"]);
						}#end for del
					
					 break;
					 case "เผยแพร่ | Publish" :
					 	$query = "update news set news_publish='1' where ";
						for( $i = 0; $i < $num; $i++){
							$query .= "(news_id = $newsID[$i])";
							if($i < $num-1){
								$query .= " or ";
							}
						}  
						DB::update($query);	
					  
					 
					  break;					  
					 case "ซ่อน | Unpublish" :
						$query = "update news set news_publish='0' where ";
						for( $i = 0; $i < $num; $i++){
							$query .= "(news_id = $newsID[$i])";
							if($i < $num-1){
								$query .= " or ";
							}
						}  
						DB::update($query);	 
					 break;
			  } 
			  
			   
		 }#end input Select *************
	    
		//** Select Start news ****
		$sbdNews = DB::select('select news_id,news_title,
							   news_image_thumb,news_create_date,news_publish
	        		           FROM  news 
	        		           WHERE news_id != 0 '); 
		//** Select End news ****
								 
		return View::make('backend.news') -> with('sbdNews', $sbdNews);
	}

	public function newsForm($id = null) { 
	
		$action = Input::get('action'); 
		if ($action != '') {		
			$nowTime = date("YmdHi");
		    $file = Input::file('file1');
			$destinationPath = 'uploads/news/';
			$filename = str_random(10).''.$nowTime.'.'.$file->getClientOriginalExtension();
			Input::file('file1')->move($destinationPath, $filename);
		
			// Add Data **** 
			DB::table('news')-> insert(
									  array('news_title' => Input::get('title'), 
											'news_title_en' => Input::get('title_en'), 
											'news_title_ch' => Input::get('title_ch'),
											'news_image_thumb' => $filename,
											'news_create_date' => date("Y-m-d") ));
			 return Redirect::to('admin/news/');
		} 

		return View::make('backend.newsForm');

	}

}
?>