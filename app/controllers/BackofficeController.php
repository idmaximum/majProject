<?php
class BackofficeController extends Controller {
	
	
	 public function syncServer(){ 
	 	
	 		$path = '/home/innovationplus/bin/sync-contents.sh';
			passthru($path);
			
			return 'Sync File Complate';
	 }
	 
	 public function contactView($id = null){ 
	 	
	 	 $results = DB::table('movie_pages_infomation')
		 			->where('pages_ID', '1') 
					->get();
	 	 
		 return View::make('backend.contact')-> with('rowData', $results);
	 }
	 
	   public function contactEdit($id = null){  
		 
		 $action  			= Input::get('action');	
		 $pages_tel 		= Input::get('pages_tel');	
		 $pages_address 	= Input::get('pages_address');
		 $pages_email 		= Input::get('pages_email');
		 $pages_getByTrain 	= Input::get('pages_getByTrain');
		 $pages_getByBus 	= Input::get('pages_getByBus');
		 
		if($action != ''){//  Check select dropdown
					  DB::table('movie_pages_infomation')
								->where('pages_ID', '1')
								->update(array('pages_tel' => $pages_tel,
										'pages_address' => $pages_address
										,'pages_email' => $pages_email
										,'pages_getByTrain' => $pages_getByTrain
										,'pages_getByBus' => $pages_getByBus  ));
											   
								return Redirect::to('backoffice_management/contact#content');
			  
		}#end action
		
		 $results = DB::table('movie_pages_infomation')
		 			->where('pages_ID', '1') 
					->get();
	 	 
		 return View::make('backend.contactEdit')-> with('rowData', $results);
	   }
	 	
 
	 public function informationView($id = null){ 
	 	
	 	 $results = DB::table('movie_pages_infomation')
		 			->where('pages_ID', '1')
					->select(DB::raw('count(*) as numPageID, pages_infomation') )
					->get();
	 	 
		 return View::make('backend.information')-> with('rowPageInfomation', $results);
	 }
	  public function informationEdit($id = null){ 
	  		
		 
		 $action  = Input::get('action');	
		 $pages_infomation = Input::get('pages_infomation');	
		 
		if($action != ''){//  Check select dropdown
					  DB::table('movie_pages_infomation')
								->where('pages_ID', '1')
								->update(array('pages_infomation' => $pages_infomation ));
											   
								return Redirect::to('backoffice_management/information#content');
			  
		}#end action
	 	
	 	 $results = DB::table('movie_pages_infomation')
		 			->where('pages_ID', '1')
					->select(DB::raw('count(*) as numPageID, pages_infomation') )
					->get();
	 	 
		 return View::make('backend.informationEdit')-> with('rowPageInfomation', $results);
	 }
	 

}
?>