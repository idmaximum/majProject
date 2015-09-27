<?php
class BackofficeBookingController extends Controller{ 
			
	public function reportlists($id = null){ 
	
		$keyword		 = '';
	    $getMonth 	 = '';
		$dateTime 		= '';
		$paymentType				= '';	
		$Status				= '';	
		$Status				= '';	
		
		 $sqlPaymentType		= '';
		 $sqlStatus 				= '';
	    $sqlLoading 			    = '';
		$sqldateTime				= '';	
	
		$getMonth = Input::get('getMonth');
	 	$keyword = Input::get('keyword');	
		
		$dateTime = Input::get('dateTime');
		$paymentType = Input::get('paymentType');	
		$Status = Input::get('Status');	
		
	  if($getMonth != ''){
			$logTable = "log_vistaws_" .$getMonth;	
		}else{
			 $logTable = "log_vistaws_" . date('Y_m');		
		}			
	 	  if($dateTime != ''){
			  $sqldateTime 	= 	"and DATE_FORMAT(date_time,'%Y-%m-%d') =  '$dateTime'";   
			  
			  $getMonthDate 		= date('Y_m', strtotime($dateTime));
			  $logTable 		= "log_vistaws_" .$getMonthDate;	
		   } 
		  if($keyword == '' && $getMonth == '' &&   $dateTime == ''){
			 $dateNow = date('Y-m-d');
			 $sqlLoading = 	"and DATE_FORMAT(date_time,'%Y-%m-%d') =  '$dateNow'";    
		 } 
	  
		     if($paymentType != ''){
			  $sqlPaymentType = 	"and order_payment =  '$paymentType'";   
		   } 
		     if($Status != ''){
			  $sqlStatus = 	"and order_status =  '$Status'";   
		   } 	 	
	 	
	 	 $DataLogBooking = DB::select("SELECT *
													FROM $logTable			 
													WHERE order_status != ''
														 $sqldateTime 
													 $sqlLoading
													  $sqlStatus
													  $sqlPaymentType
													and order_payment != ''
													and (cname LIKE '%$keyword%' OR pincode LIKE '%$keyword%'   
													OR phone LIKE '%$keyword%'  OR email LIKE '%$keyword%')
													order by log_id desc");	 
								
			return  View::make('backend.reportlist')-> with('resultDataLogBooking', $DataLogBooking)
																   	 -> with('getMonth', $getMonth)
																	 -> with('dateTime', $dateTime)
																	 -> with('paymentType', $paymentType)
																	 -> with('Status', $Status)
																	 -> with('keyword', $keyword); 
								
	}#end fn reportlists
	 public function ExcelReportlist($id = null){ 	
	  
	 		$keyword		 = '';
	    $getMonth 	 = '';
		$dateTime 		= '';
		$paymentType				= '';	
		$Status				= '';	
		$Status				= '';	
		
		 $sqlPaymentType		= '';
		 $sqlStatus 				= '';
	    $sqlLoading 			    = '';
		$sqldateTime				= '';	
	
		$getMonth = Input::get('getMonth');
	 	$keyword = Input::get('keyword');	
		
		$dateTime = Input::get('dateTime');
		$paymentType = Input::get('paymentType');	
		$Status = Input::get('Status');	
		
	  if($getMonth != ''){
			$logTable = "log_vistaws_" .$getMonth;	
		}else{
			 $logTable = "log_vistaws_" . date('Y_m');		
		}			
	 	  if($dateTime != ''){
			  $sqldateTime 	= 	"and DATE_FORMAT(date_time,'%Y-%m-%d') =  '$dateTime'";   
			  
			  $getMonthDate 		= date('Y_m', strtotime($dateTime));
			  $logTable 		= "log_vistaws_" .$getMonthDate;	
		   } 
		  if($keyword == '' && $getMonth == '' &&   $dateTime == ''){
			 $dateNow = date('Y-m-d');
			 $sqlLoading = 	"and DATE_FORMAT(date_time,'%Y-%m-%d') =  '$dateNow'";    
		 } 
	  
		     if($paymentType != ''){
			  $sqlPaymentType = 	"and order_payment =  '$paymentType'";   
		   } 
		     if($Status != ''){
			  $sqlStatus = 	"and order_status =  '$Status'";   
		   } 	 	
	 	
	 	 
	 	 $DataLogBooking = DB::select("SELECT *
													FROM $logTable			 
													WHERE order_status != ''
													 $sqldateTime 
													 $sqlLoading
													  $sqlStatus
													  $sqlPaymentType
													and (cname LIKE '%$keyword%' OR pincode LIKE '%$keyword%'   
													OR phone LIKE '%$keyword%'  OR email LIKE '%$keyword%')
													order by log_id desc");	
								
			 return  View::make('backend.genExcelReportlist')-> with('resultDataLogBooking', $DataLogBooking); 
								
	}#end fn reportlists
	
	public function reportView($id = null){
		 $getMonth = '';
	
		$getMonth = Input::get('getMonth');
	 	$keyword = Input::get('keyword');	
		
		if($getMonth != ''){
			$logTable = "log_vistaws_" .$getMonth;	
		}else{
			 $logTable = "log_vistaws_" . date('Y_m');		
		}		
		
		 $dataReport = DB::table($logTable) 
								->where('log_id','=', $id) 
								->orderBy('log_id', 'desc') 
								->get();  
	 
		
		return  View::make('backend.reportDetail')-> with('resultReport', $dataReport);
		
	}#end fn reportView

}
?>