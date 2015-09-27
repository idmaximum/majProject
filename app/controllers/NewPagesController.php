<?php
class NewPagesController extends BaseController {

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
	 
     public function pagesList(){  
	 			$Selectpages = DB::table('movie_pages') 
							->select('pages_ID', 'pages_title_en', 'pages_abstract_en', 'pages_imageThumb', 'pages_datetime')
							->where('pages_publish' , '1')
							->orderBy('orderBy', 'asc') 
							->get();
	 
	  
		return View::make('frontend.event_activity')-> with('rowData', $Selectpages); 
	}
	
    public function pagesDetail($name = null){ 
	
		$results = DB::select("select pages_ID, pages_title_en, 
							  pages_detail_th, pages_detail_en, pages_detail_cn,		     
							  pages_imageThumb,pages_publish, pages_datetime, 
							  pages_abstract_en
							  FROM  movie_pages 
							  WHERE pages_ID ='$name'");  
	  
		return View::make('frontend.event_activitydetail')-> with('rowData', $results);
	}
 
}