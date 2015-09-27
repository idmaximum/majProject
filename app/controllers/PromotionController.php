<?php
class PromotionController extends BaseController {

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
	 
     public function promotioList(){   
		  
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
		 
		  $SelectPromotion = DB::table('movie_promotion') 
						  ->select('promotion_ID', 'promotion_title_en', 'promotion_abstract_en', 'promotion_imageThumb', 'promotion_datetime')
						  ->where('promotion_publish' , '1')
						  ->orderBy('orderBy', 'asc')  
						  ->paginate(6); 
	
	  return View::make('frontend.promotion')-> with('rowPromotion', $SelectPromotion); 
	}#end fn Promotion
	
	public function promotioListTH(){  
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
		 
		  $SelectPromotion = DB::table('movie_promotion') 
						  ->select('promotion_ID', 'promotion_title_th', 
						  'promotion_abstract_th', 'promotion_imageThumb', 'promotion_datetime')
						  ->where('promotion_publish' , '1')
						  ->orderBy('orderBy', 'asc')  
						  ->paginate(6); 
	
	  return View::make('frontendTH.promotion')-> with('rowPromotion', $SelectPromotion); 
	}#end fn Promotion TH
	
    public function promotionDetail($name = null){ 
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
		   }	
		$results = DB::select("select promotion_ID, promotion_title_en, 
							  promotion_detail_th, promotion_detail_en, promotion_detail_cn,		     
							  promotion_imageThumb,promotion_publish, promotion_datetime, promotion_image,
							  promotion_abstract_en
							  FROM  movie_promotion 
							  WHERE promotion_ID ='$name'");  
	  	
		return View::make('frontend.promotiondetail')-> with('rowPromotion', $results);
	} #end promotionDetail
	
	public function promotionDetailTH($name = null){ 
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
			   }	
		$results = DB::select("select promotion_ID, promotion_title_th, 
							  promotion_detail_th, promotion_image, 	     
							  promotion_imageThumb,promotion_publish, promotion_datetime , promotion_abstract_th
							  FROM  movie_promotion 
							  WHERE promotion_ID ='$name'");  
	  	
		return View::make('frontendTH.promotiondetail')-> with('rowPromotion', $results);
	}#end fn promotionDetailTH
 
}