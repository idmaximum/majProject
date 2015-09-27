<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/ 
Route::any('/','HomeController@home');
Route::any('th/','HomeController@homeTH');
Route::any('home/','HomeController@home'); 
Route::any('th/home/','HomeController@homeTH'); 
Route::any('getCreateDB/','HomeController@getFnCreateDB');
Route::any('pages/{name}/{id}','HomeController@pagesDatail');

Route::any('kiosk/','HomeController@homeKiosk');
Route::any('kiosk/home/','HomeController@homeKiosk'); 
Route::any('kiosk/advancebooking/','AdvanceBookingController@AdvanceBookingKiosk'); 
Route::any('kiosk/selectTicket/{movieID?}/{sessionID?}','MovieBookingController@selectTicketKiosk'); 
Route::any('kiosk/selectSeats/','MovieBookingController@selectSeatKiosk');
Route::any('kiosk/payment/','MovieBookingController@payment'); 

Route::any('kiosk/movie/{name?}/{id?}','MovieController@movieKiosk');
Route::any('kiosk/datepicker/dataTab/','AdvanceBookingController@SelectDatepickerKiosk');
Route::any('kiosk/comingsoon/','ComingsoonController@comingsoonListKiosk'); 
Route::any('kiosk/comingsoon/{name}/{id}','ComingsoonController@comingsoonDetailKiosk'); 
Route::any('kiosk/comingsoonbooking/{id?}/{name?}','AdvanceBookingController@ComingsoonAdvanceBookingKiosk'); 
Route::any('kiosk/submitReserve/','MovieBookingController@submitReserveKiosk'); 

Route::any('kiosk/comingsoonSaveAlert/','ComingsoonController@comingsoonSendAlertEmailKiosk');
Route::any('kiosk/comingsoonsave/{name}/{id}','ComingsoonController@comingsoonSaveEmailKiosk'); 
Route::any('kiosk/selectTicketerror/{movieID?}/{sessionID?}','MovieBookingController@selectTicketErrorKiosk');

Route::any('selectTicket/{movieID?}/{sessionID?}','MovieBookingController@selectTicket');
Route::any('cancelTicket/','MovieBookingController@cancelOrder');
Route::any('selectSeats/','MovieBookingController@selectSeat');
Route::any('submitReserve/','MovieBookingController@submitReserve'); 
Route::any('payment/','MovieBookingController@payment'); 
Route::any('selectTicketerror/{movieID?}/{sessionID?}','MovieBookingController@selectTicketError');

Route::any('paymentError/','MovieBookingController@paymentError'); 
Route::any('cancelOrder/','MovieBookingController@responCancelOrder'); 

Route::any('th/selectTicket/{movieID?}/{sessionID?}','MovieBookingController@selectTicketTH'); 
Route::any('th/selectSeats/','MovieBookingController@selectSeatTH');
Route::any('th/submitReserve/','MovieBookingController@submitReserve'); 
Route::any('th/payment/','MovieBookingController@payment'); 
Route::any('th/selectTicketerror/{movieID?}/{sessionID?}','MovieBookingController@selectTicketError');

Route::any('payment_process_vista/response','MovieBookingController@responseBooking');
Route::any('getUserIDToSendMail/{sessionID?}','MovieBookingController@getUserIDToSendMail'); 
 
Route::any('movie/{name?}/{id?}','MovieController@movie');
Route::any('th/movie/{name?}/{id?}','MovieController@movieTH');

Route::any('advancebooking/','AdvanceBookingController@AdvanceBooking');
Route::any('th/advancebooking/','AdvanceBookingController@AdvanceBookingTH'); 

Route::any('comingsoonbooking/{id?}/{name?}','AdvanceBookingController@ComingsoonAdvanceBooking');
Route::any('th/comingsoonbooking/{id?}/{name?}','AdvanceBookingController@ComingsoonAdvanceBookingTH'); 

Route::any('datepicker/dataTab/','AdvanceBookingController@SelectDatepicker'); 
Route::any('th/datepicker/dataTab/','AdvanceBookingController@SelectDatepickerTH');

Route::any('information/','HomeController@information');
Route::any('th/information/','HomeController@informationTH');

Route::any('promotion/','PromotionController@promotioList');
Route::any('promotion/{name}/{id}','PromotionController@promotionDetail');
Route::any('th/promotion/','PromotionController@promotioListTH');
Route::any('th/promotion/{name}/{id}','PromotionController@promotionDetailTH');
 
Route::any('comingsoon/','ComingsoonController@comingsoonList'); 
Route::any('comingsoon/{name}/{id}','ComingsoonController@comingsoonDetail'); 
Route::any('comingsoonSaveAlert/','ComingsoonController@comingsoonSendAlertEmail');
Route::any('comingsoonsave/{name}/{id}','ComingsoonController@comingsoonSaveEmail'); 

Route::any('th/comingsoon/','ComingsoonController@comingsoonListTH'); 
Route::any('th/comingsoon/{name}/{id}','ComingsoonController@comingsoonDetailTH'); 
Route::any('th/comingsoonSaveAlert/','ComingsoonController@comingsoonSendAlertEmail');
Route::any('th/comingsoonsave/{name}/{id}','ComingsoonController@comingsoonSaveEmail'); 

Route::any('contactus/','HomeController@contactUS'); 
Route::any('contactSend/','HomeController@contactSend'); 
Route::any('th/contactus/','HomeController@contactUSTH'); 
Route::any('th/contactSend/','HomeController@contactSend'); 
 
Route::any('event_activity/','NewsController@newsList');
Route::any('event_activity/{name}/{id}','NewsController@newsDetail'); 
Route::any('th/event_activity/','NewsController@newsListTH');
Route::any('th/event_activity/{name}/{id}','NewsController@newsDetailTH'); 

Route::any('backoffice_management/genExcelReportlist','BackofficeBookingController@ExcelReportlist');
Route::any('backoffice_management/reportlists','BackofficeBookingController@reportlists');

//*********** BOF*****************

Route::get('/backoffice_management/', function(){
	return View::make('layout.master');
});
 if(Session::get('_EMAIL') != "" || Session::get('_GRPID') != "" || Session::get('_ID') != ""){  
 	Route::any('backoffice_management/syncServer','BackofficeController@syncServer');
	
	 Route::any('backoffice_management/staffEdit/{id}','BackofficeStaffController@getStaffEdit');
	 Route::any('backoffice_management/profile/{id}','BackofficeStaffController@profileReportEdit');
	 
	 Route::any('backoffice_management/staffEdit','BackofficeStaffController@getStaffEdit');
	 Route::any('backoffice_management/profile','BackofficeStaffController@profileReportEdit');
	
	Route::any('backoffice_management/news/{id?}','BackofficeNewsController@news');
	Route::any('backoffice_management/newsForm/{id?}','BackofficeNewsController@newsForm');
	Route::any('backoffice_management/newsFormEdit/{id?}','BackofficeNewsController@newsFormEdit');
	Route::any('backoffice_management/news/ajaxCheck/dragDropNews','BackofficeNewsController@dragDropNews');
	
	Route::any('backoffice_management/newsGallery/{id?}','BackofficeNewsController@newsGallery');
	Route::any('backoffice_management/newsGalleryAdd/{id?}','BackofficeNewsController@newsGalleryAdd');
	
	
	Route::any('backoffice_management/pages/{id?}','BackofficePagesController@pages');
	Route::any('backoffice_management/pagesForm/{id?}','BackofficePagesController@pagesForm');
	Route::any('backoffice_management/pagesFormEdit/{id?}','BackofficePagesController@pagesFormEdit');
	Route::any('backoffice_management/pages/ajaxCheck/dragDroppages','BackofficePagesController@dragDropPages');
	
	Route::any('backoffice_management/promotion/{id?}','BackofficePromotionController@promotion');
	Route::any('backoffice_management/promotionForm/{id?}','BackofficePromotionController@promotionForm');
	Route::any('backoffice_management/promotionFormEdit/{id?}','BackofficePromotionController@promotionFormEdit');
	Route::any('backoffice_management/promotion/ajaxCheck/dragDropPromotion','BackofficePromotionController@dragDropPromotion');
	
	Route::any('backoffice_management/movievistait/{id?}','BackofficeGetMovieVistaITController@movie'); 
	
	Route::any('backoffice_management/banner/{id?}','BackofficeBannerController@banner');
	Route::any('backoffice_management/bannerAdd/{id?}','BackofficeBannerController@bannerForm');
	Route::any('backoffice_management/bannerEdit/{id?}','BackofficeBannerController@bannerFormEdit'); 
	Route::any('backoffice_management/banner/ajaxCheck/dragDropBanner','BackofficeBannerController@dragDropBanner');
 
	Route::any('backoffice_management/movie','BackofficeMovieListController@movieList');
	Route::any('backoffice_management/movielist/{id?}','BackofficeMovieListController@movieList');
	Route::any('backoffice_management/movieAdd/{id?}','BackofficeMovieListController@movieForm');
	Route::any('backoffice_management/movieComingsoonEdit/{id?}','BackofficeMovieListController@movieComingsoonFormEdit'); 
	Route::any('backoffice_management/movieListEdit/{id?}','BackofficeMovieListController@movieListEdit'); 
	Route::any('backoffice_management/comingsoonlist/{id?}','BackofficeMovieListController@comingsoonList');
	 
	Route::any('backoffice_management/movielist/ajaxCheck/dragDropMovieList','BackofficeMovieListController@dragDropMovieList'); 
	
	Route::any('backoffice_management/emailsubmitted/{id?}','BackofficeComingsoonController@listEmailSubmitted');
	
	Route::any('backoffice_management/information/{id?}','BackofficeController@informationView');
	Route::any('backoffice_management/informationEdit/{id?}','BackofficeController@informationEdit');
	
	Route::any('backoffice_management/contact/{id?}','BackofficeController@contactView');
	Route::any('backoffice_management/contactEdit/{id?}','BackofficeController@contactEdit'); /* */ 
 }#end if
 
Route::controller('backoffice_management', 'BackofficeStaffController');