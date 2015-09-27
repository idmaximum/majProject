<?php
class BackofficeStaffController extends BaseController{

	protected $layout = "layout.master";
	
	public function getStaffEdit($id = null) {
		 
		 $ID = $id;	 
		 $staff_ID = Input::get('staff_ID');	
		
		if($staff_ID != ''){//  Check Edit
			
			$staff_name =  Input::get('staff_name'); 	
			
			$password =  Hash::make('embassy'.Input::get('password').'Theater'); 	
			
			
			$staff_email =  Input::get('staff_email'); 	
			$level =  Input::get('level'); 	
			
				//***********
						DB::table('movie_staff')
								->where('staff_ID', $staff_ID)
								->update(array('staff_updated' => date("Y-m-d H:i:s") ));
					//***********
			
		 if(Input::get('password') != ''){
			 
			 	DB::table('movie_staff')
					->where('staff_ID', $staff_ID)
					->update(array('staff_name' => $staff_name,
							'password' => $password,
							'staff_email' => $staff_email,	 
							'staff_level' => $level ));
			 }else{
				 	DB::table('movie_staff')
					->where('staff_ID', $staff_ID)
					->update(array('staff_name' => $staff_name, 
											'staff_email' => $staff_email,	 
											'staff_level' => $level ));
				 }
		
	 
			
			return Redirect::to('backoffice_management/staff#staff') ;
		}#End IF
		 
	 	 $results = DB::select('select *
					FROM  movie_staff 
					WHERE staff_ID ='.$id);  
	        		           
		return View::make('backend.staffEdit')-> with('DataStaff', $results);
	  
	}#end Fn
	
	 public function profileReportEdit($id = null) {
		 
		 $ID = $id;	 
		 $staff_ID = Input::get('staff_ID');	
		 $submitStatus = '';
		
		if($staff_ID != ''){//  Check Edit
			 
			$password =  Hash::make('embassy'.Input::get('password').'Theater'); 	  
			$staff_email =  Input::get('staff_email'); 	 
		
		 	//***********
						DB::table('movie_staff')
								->where('staff_ID', $staff_ID)
								->update(array('staff_updated' => date("Y-m-d H:i:s") ));
					//***********
			
		 if(Input::get('password') != ''){
			 
			 	DB::table('movie_staff')
					->where('staff_ID', $staff_ID)
					->update(array( 
							'password' => $password,
							'staff_email' => $staff_email));
			 }else{
				 	DB::table('movie_staff')
					->where('staff_ID', $staff_ID)
					->update(array('staff_email' => $staff_email));
				 }
				 
		 $submitStatus = 'OK';	 
		 
		 $results = DB::select('select *
					FROM  movie_staff 
					WHERE staff_ID ='.$staff_ID);  
 
			 View::make('backend.staffReportEdit')-> with('DataStaff', $results)
																			 -> with('submitStatus', $submitStatus);
		}#End IF
		 
	 	 $results = DB::select('select *
					FROM  movie_staff 
					WHERE staff_ID ='.$id);  
	        		           
		return View::make('backend.staffReportEdit')-> with('DataStaff', $results)
																		-> with('submitStatus', $submitStatus);
	  
	}#end Fn
	
	public function getStaffadd() {    	
		$this->layout->content = View::make('backend.staffAdd');		 
	}
	
	public function postCreate() {
		 	
				/*$user = new Staff;
			$user->staff_name = Input::get('name');
			$user->staff_username = Input::get('username');
			$user->staff_email = Input::get('email');
			$user->staff_level = Input::get('level'); 
			$user->password = Hash::make('embassy'.Input::get('password').'Theater');
			$user->save();*/
			//********
			 $password = Hash::make('embassy'.Input::get('password').'Theater');
			 
				DB::table('movie_staff')-> insert(
					array('staff_name' => Input::get('name'), 		
					'staff_username' => Input::get('username'), 
					'staff_email' => Input::get('email'), 				 	
					'staff_level' => Input::get('level'),	
					'password' =>$password,
					'staff_created' => date("Y-m-d H:i:s") ));
			//*********
			 
			return Redirect::to('backoffice_management/staff#staff') ;
		 
	}
	
	public function getStaff() {
		$DBStaff = DB::select('select *
			FROM  movie_staff 
			WHERE staff_ID != 0 
			ORDER BY staff_ID desc'); 
		//** Select End movie_staff ****
					
		$this->layout->content = View::make('backend.staff')-> with('DBStaff', $DBStaff);
	}	
	
	/******* ******* ******* *******  Login *******  ******* *******/
	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
	    $this->beforeFilter('auth', array('only'=>array('movievistait')));
		
	}/**/
	 
	 public function getLogin() {
		  return View::make('frontend.login') ;
	}
	 public function getLoginfailed() {
		 
		 
		  return View::make('frontend.login')
					  ->with('message', 'Your username/password combination was incorrect') ;
					  exit();/**/
	}
	public function postSignin() {
		
	      $Username = Input::get('giFormUsername');   
		  $PassWord = 'embassy'.Input::get('giFormPassword').'Theater'; 
		 
		if (Auth::attempt(array('staff_username'=>$Username, 'password'=>$PassWord))) {
    		    // 
			 	if (Auth::check()){
					//***********
						DB::table('movie_staff')
								->where('staff_ID', Auth::user()->staff_ID)
								->update(array('staff_lastlogin' => date("Y-m-d H:i:s") ));
					//***********
					
				 	Session::put('_EMAIL', Auth::user()->staff_email);
					Session::put('_GRPID'	, Auth::user()->staff_level);
					Session::put('_ID'	, Auth::user()->staff_ID); 
					Session::put('_NAME'	, Auth::user()->staff_name);  
					
					  $staff_level = 	Auth::user()->staff_level;
				  
				  if($staff_level  != 3){
					   return Redirect::intended('backoffice_management/movievistait#theater');  
				   }else{ 
					  return Redirect::intended('backoffice_management/reportlists');  
				  } 
				 
				 }#end If check Auth
				 
			} else { 
   			    return Redirect::to('backoffice_management/loginfailed');  
			    exit();
			}	 /* */	
	}
	/******* ******* ******* *******  Login *******  ******* *******/
	
	public function getDashboard() {
   	 	$this->layout->content = View::make('backend.movieList');
	}
	
	public function getLogout() {
   		Auth::logout();
		Session::flush();
    	return Redirect::to('backoffice_management/login')->with('message', 'Your are now logged out!');
	}
}
?>