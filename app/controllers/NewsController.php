<?php
class NewsController extends BaseController {

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
	 
     public function newsList(){  
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
			 
			$Selectnews = DB::table('movie_news') 
						->select('news_ID', 'news_title_en', 'news_abstract_en', 'news_imageThumb', 'news_datetime')
						->where('news_publish' , '1')
						->orderBy('orderBy', 'asc') 
						->paginate(6); 
	  
		return View::make('frontend.event_activity')-> with('rowNews', $Selectnews); 
	}
	
	  public function newsListTH(){  
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
			 
			$Selectnews = DB::table('movie_news') 
						->select('news_ID', 'news_title_th', 'news_abstract_th', 'news_imageThumb', 'news_datetime')
						->where('news_publish' , '1')
						->orderBy('orderBy', 'asc') 
						->paginate(6); 
	  
		return View::make('frontendTH.event_activity')-> with('rowNews', $Selectnews); 
	}
	 
  	  public function newsDetail($id = null){ 
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
		  }	#end fn str
			   
		$resultNews = DB::select("select news_ID, news_title_en, news_youtube,  
							  news_detail_th, news_detail_en, news_detail_cn,		     
							  news_imageThumb,news_publish, news_datetime, 
							  news_abstract_en
							  FROM  movie_news 
							  WHERE news_ID = '$id'"); 
							   
		$resultNewsGallery = DB::select('select  * 
								FROM  movie_image_gallery 
								WHERE news_ID ='.$id); 
								 
	    $resultNewsGalleryCount = DB::select('select count(*) as countGallery 
									FROM  movie_image_gallery 
									WHERE news_ID ='.$id);  
	  
		return View::make('frontend.event_activitydetail')-> with('rowNews', $resultNews)
														  -> with('rowNewsGallery', $resultNewsGallery)
														  -> with('rowCountGallery', $resultNewsGalleryCount);
	}
	
	  public function newsDetailTH($id = null){ 
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
		  }	#end fn str
			   
		$resultNews = DB::select("select news_ID, news_title_th, news_youtube,  
							  news_detail_th, news_detail_en, news_detail_cn,		     
							  news_imageThumb,news_publish, news_datetime, 
							  news_abstract_en
							  FROM  movie_news 
							  WHERE news_ID = '$id'"); 
							   
		$resultNewsGallery = DB::select('select  * 
								FROM  movie_image_gallery 
								WHERE news_ID ='.$id); 
								 
	    $resultNewsGalleryCount = DB::select('select count(*) as countGallery 
									FROM  movie_image_gallery 
									WHERE news_ID ='.$id);  
	  
		return View::make('frontendTH.event_activitydetail')-> with('rowNews', $resultNews)
														  -> with('rowNewsGallery', $resultNewsGallery)
														  -> with('rowCountGallery', $resultNewsGalleryCount);
	}#end fn
 
}