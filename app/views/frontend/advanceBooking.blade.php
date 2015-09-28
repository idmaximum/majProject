<?php
	 $countMovieShowtimeAll = '';
	 $config_path = "https://www.embassycineplex.com";
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Embassy Diplomat Screens by AIS</title>
<meta property="og:image" content="http://www.embassycineplex.com/images/share.jpg" /> 
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/reset.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/font.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/screen.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/screen2.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/js/DropDown/css/style.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/js/jqueryUI/css/custom-theme/jquery-ui-1.10.4.custom.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/js/OrganicTabs/css/style.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/js/tooltipster/css/tooltipster.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/js/colorbox-master/example3/colorbox.css">
@include('frontend.incScriptTop')
</head>
<body>
<div id="main">@include('frontend.incHeader')
  <div id="content" class="content-main">
    <h1 class="showToday">ADVANCE BOOKING</h1>
    <div class="contentPage">
      <div class="selectDate" style="text-align:center">
       <form action="" method="post" id="formDatepicker"> 
       		<input type="text" id="datepicker" placeholder="Select Date" class="inputDatepicker" name="selectDate"> 
        </form>
      </div>
      <div class="contentAdvance">
      	<div id="showtimeTab">
        <div class="menuContent">
          <ul class="nav ">
            <?php   
					for($dayTime = 0;$dayTime <7; $dayTime++){
						 $dateNowShort  = date('d', strtotime(" +$dayTime day"));
						 $dateNowFull = date('l', strtotime(" +$dayTime day")); 
			   ?>
            <li><a href="#tab{{$dayTime}}"  <?php if($dayTime == 0){?>class="current"<?php }?>>{{$dateNowFull}}<div class="txtBrown36">{{$dateNowShort}}</div></a></li>
            <?php }#end for?>
          </ul>
        </div>
        <div class="list-wrap">
          <?php  
					for($dayTime = 0;$dayTime < 7; $dayTime++){
						
						$dayTowmorrow = $dayTime+1;
					    $dateNow = date('Y-m-d 06:00', strtotime(" +$dayTime day"));  
						$dateEndShowtime = date('Y-m-d 03:00', strtotime(" +$dayTowmorrow day"));
						$dateHrNow = date('Y-m-d H:m');
					?>
          <ul id="tab{{$dayTime}}"  <?php if($dayTime != 0){?> class="hide"<?php }?>>
            <li>@foreach($movie_lists as $movie)  
                <?php  
		  		 $countMovieShowtimeAll = countMovieShowtimeAll($dateNow,$movie->movieID);
			  	 $countMovieShowtime = countShowtime($dateNow, $dateEndShowtime,$movie->movieID,$movie->showtime_SystemType); 
				 
				   $nameMovie  = $movie->movie_Name_EN;
				   $nameMovieSub =  str_replace_text($nameMovie); 
				   if($countMovieShowtime != ''){
				?><div class="rowShowToday">
                	<div class="rowShowTodayImage"><a href="{{URL::to("movie/$movie->movieID/$nameMovieSub")}}"><img src="{{asset("uploads/movie/$movie->movie_Img_Thumb")}}" width="140" height="210" class="hoverImg08"></a></div>
                <div class="rowShowTodayDetail">
                  <h2 class="txtGold24"><a href="{{URL::to("movie/$movie->movieID/$nameMovieSub")}}">{{$movie->movie_Name_EN}}</a></h2>
                  <p class="timeRate txtBrown20_2">{{$movie->movie_Duration}} Min</p>
                  <p><?php
							if($movie->movie_Rating == "ส."){ 
					$imgRate = "rate_raise.png"; 
				   }else if($movie->movie_Rating == "น13+"){ 
					  $imgRate = "rate_up_13_en.png";
				   }else if($movie->movie_Rating == "น15+"){ 
					  $imgRate = "rate_up_15_en.png";
				   }else if($movie->movie_Rating == "น18+"){ 
					  $imgRate = "rate_up_18_en.png";
					}else if($movie->movie_Rating == "ฉ20-"){ 
					  $imgRate = "rate_under_20_en.png";
					}else { 
					$imgRate = "rate_general_en.png";
					
					}
						 //********* System **
						   if($movie->showtime_SystemType == "VS00000001"){ 
								$imgSystem = "type_digital.png";
								$systemName = '2D';
							 }else if($movie->showtime_SystemType == "0000000001"){ 
								$imgSystem = "type_3d.png";
								$systemName = 'D3D';
							 }else if($movie->showtime_SystemType == "0000000002"){ 
								  $imgSystem = "type_hfr_3d.png";
								  $systemName = 'HFR 3D';	
							 }else{
					$imgSystem = "type_digital.png";
					$systemName = '2D';
							 } 
					?><img src="{{asset("images/icon/$imgRate")}}" alt="{{$movie->movie_Rating}}" style="margin-right:3px;width:40px" > <img src="{{asset("images/icon/$imgSystem")}}" alt="{{$systemName}}" style="width:40px" ></p>
                </div>
                <?php	
				  $numKL = 1;
				  $dayTimeNight = date('Y-m-d 03:00', strtotime("$dateNow +1 day")); 
				  $countShowtime =  countMovieShowtimeDay($dateNow, $dayTimeNight, $movie->showtime_Movie_strID , $movie->showtime_SystemType);
				  ?>
                <div class="rowShowTodayShowtime  @if($countShowtime > 6) countShowtime @endif">
            @foreach($movie_showtimes  as $movieShowtime)
             @if($movie->movie_strID === $movieShowtime->showtime_Movie_strID && $movie->showtime_SystemType == $movieShowtime->showtime_SystemType)
              @if( date('Y-m-d H:i', strtotime($movieShowtime->showtime_dtmDate_Time)) >= $dateNow &&   date('Y-m-d H:i', strtotime($movieShowtime->showtime_dtmDate_Time)) <= $dayTimeNight)
                  <?php
				  	   $style45Mins = '';
					   $urlPage = '';
					   if($movieShowtime->showtime_dtmDate_Time < "$dateHrNow"){
							 $classTime = "timeAgo";
							  $urlPage = '';
						}else if($movieShowtime->showtime_dtmDate_Time >= "$dateHrNow"){#if time 
							if($numKL == 1){
							   $classTime = "timeNow";
							  }else{#end if
							   $classTime = "timeFuture";
							 }
							 $numKL++;
							 $urlPage = "selectTicket/$movie->movieID/$movieShowtime->showtime_Session_strID";
							 $dateBooking = date('Y-m-d H:i', strtotime(" +60 minutes")); 
							if($dateBooking > $movieShowtime->showtime_dtmDate_Time){ 
								 $style45Mins = 'noBooking';
							}#end if dateBooking
						}
					 ?><div class="rowShowTime hoverImg08 {{$style45Mins}} {{$classTime}}">@if($movieShowtime->showtime_strName == 'Theatre 1')
                    <div class="showTimeHilight"><span title="Hall 1" class="tooltip theater1Icon"></span></div>@endif 
                    @if($movieShowtime->showtime_strName == 'Theatre 3')
                    <div class="showTimeHilight3"><span title="Hall 1" class="tooltip theater3Icon"></span></div>@endif 
                    <?php 
						   $soundAttributes = $movieShowtime->showtime_soundAttributes;
						   $audio 		= substr($soundAttributes,0,2); 
						   $subtitle 	= substr($soundAttributes, -2);
					  ?>
                   <a href="{{URL::to("$urlPage")}}" title="Audio: {{subLanguage($audio)}}   / Subtitle: {{subLanguage($subtitle)}}" class="tooltip">{{ date('H:i', strtotime($movieShowtime->showtime_dtmDate_Time))}}</a>	
                   <?php
                   		$showtimes =  $movieShowtime->showtime_soundAttributes.";";
						echo	 $showtimes = strstr($showtimes, ';', true); // As of PHP 5.3.0
				   ?></div>
                  		@endif
                  	@endif
                  @endforeach</div>
                <p class="clear"></p>
              </div><?php }#end count movieshowtime?>
             
             @endforeach 
             @if($countMovieShowtimeAll  == '')<div class="noUpdateShowtime">No Updated Showtime</div>@endif
             </li>
          </ul>
          <?php }#end for?>
        </div> 
      </div>
      </div> 
    </div>
  </div>
  <br>
  <br>
  <br>
  @include('frontend.incFooter') </div>
@include('frontend.incScriptBottom')
<div class="url">
   <div id='inline_content' style='padding:30px; background:#fff;text-align:center;'>
     <p  class="txtBlack20 fontSynopis"><strong>You can reserve/buy 60 minutes before showtime. <br/>Please call 02-160-5999.</strong></p> 
     </div>
 </div>
 <script src="{{$config_path}}/js/jqueryUI/js/jquery-ui-1.10.4.custom.js"></script>
 <script src="{{$config_path}}/js/placeholders.min.js"></script>
 <script src="{{$config_path}}/js/OrganicTabs/js/organictabs.jquery.js"></script>
 <script src="{{$config_path}}/js/tooltipster/js/jquery.tooltipster.js"></script>
 <script src="{{$config_path}}/js/colorbox-master/jquery.colorbox.js"></script>
<script>
  jQuery(function() {
    jQuery( "#datepicker" ).datepicker({ minDate: "+1d", maxDate: "+12D" , dateFormat: "yy-mm-dd",
		 onSelect: function(dateText, inst) { 
			  var dateAsString = dateText; //the first parameter of this function 
			  var data = jQuery("#formDatepicker").serialize();	
			  
			   jQuery.ajax({
					   type: "GET",
					   url: "datepicker/dataTab",
					   data: data,
					   cache: false,
					success: function(data){ 
					  jQuery('.contentAdvance').html(data); 
					  jQuery("#showtimeTab").organicTabs({"speed": 200});
					  jQuery('.tooltip').tooltipster();
					}
				  });	
		   }				   
	});	 
	jQuery("#showtimeTab").organicTabs({"speed": 200});
	jQuery('.tooltip').tooltipster(); 
	jQuery('.timeAgo a').click(function () {return false;}); 
	jQuery('.noBooking a').click(function () { 
		 jQuery.colorbox({width:"30%", inline:true, href:"#inline_content"});
		return false;
	});  
  });
  </script>
</body>
</html>