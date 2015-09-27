<?php 
	 $config_path = "https://www.embassycineplex.com";
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Embassy Diplomat Screens by AIS</title>
<meta property="og:image" content="{{$config_path}}/images/share.jpg" /> 
<meta name="description" content="Embassy Diplomat Screens brings you the highest quality in cinema at a reasonable">
<meta name="keywords" content="embassy, cinema, cineplex, movie, theatre, best, diplomat, screen, booking, เอ็มบาสซี่, โรงหนัง, โรงภาพยนตร์, เช็ครอบฉาย, ดูหนัง, เช็ครอบหนัง, หนังเข้าใหม่, จองตั๋วหนัง, ซื้อตั๋วหนัง"> 
<!--<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/bootstrap.css">-->
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/reset.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/font.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/screen.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/js/bxslider/jquery.bxslider.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/js/DropDown/css/style.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/js/tooltipster/css/tooltipster.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/js/colorbox-master/example3/colorbox.css"> 
@include('frontend.incScriptTop')
</head>
<body><?php 
	$dateNow = date('Y-m-d 06:00'); 
	$dateHrNow = date('Y-m-d H:i');  
	$dayTimeNight = date('Y-m-d 03:00', strtotime(" +1 day"));  
  ?>
<div id="main"> @include('frontend.incHeader')
  <div id="content" class="content-main" style="padding-top:18px"> 
 	 <ul class="bxslider">
      @foreach($movie_banner as $banner)
      <?php if($banner->banner_url != ""){ ?>
      <li><a href="{{$banner->banner_url}}" target="_blank"><img src="{{asset("uploads/banner/$banner->banner_pic")}}" /></a></li>
      <?php }else{?>
      <li><img src="{{asset("uploads/banner/$banner->banner_pic")}}" /></li>
      <?php  } #end if ?>
      @endforeach
    </ul> 
    <h1 class="titleShowToday on_mobile__h">Showtimes</h1>
    @foreach($movie_lists as $movie)
      <?php
      	 $nameMovie  = $movie->movie_Name_EN;
		 $nameMovieSub =  str_replace_text($nameMovie); 
		 $styleMobileMargine = '';	
		   
		 $countShowtime =  countMovieShowtimeDay($dateNow, $dayTimeNight, $movie->showtime_Movie_strID , $movie->showtime_SystemType);
	   
	   if($countShowtime > 6){
		   	$styleMobileMargine = "margineBottom";
		   }
	  ?>
    <div class="rowShowToday  ">
      <div class="rowShowTodayImage {{$styleMobileMargine}}"><a href="{{URL::to("movie/$movie->movieID/$nameMovieSub")}}" title="{{$nameMovie}}"><img src="{{asset("uploads/movie/$movie->movie_Img_Thumb")}}" width="140" height="210" class="hoverImg08"></a></div>
      <div class="rowShowTodayDetail">
        <h2 class="txtGold24"><a title="{{$nameMovie}}" href="{{URL::to("movie/$movie->movieID/$nameMovieSub")}}">{{$nameMovie}}</a></h2>
        <p class="timeRate txtBrown20_2">{{$movie->movie_Duration}} Min</p>
        <p class="img__rating">
           <?php
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
				 
			?>
          <img src="{{asset("images/icon/$imgRate")}}" alt="{{$movie->movie_Rating}}" style="margin-right:3px; width:40px" >
   		  <img src="{{asset("images/icon/$imgSystem")}}" alt="{{$systemName}}" style="width:40px"></p> 
      </div>
      <?php
	  	 $numKL = 1;
		
      	
	  ?><div class="rowShowTodayShowtime @if($countShowtime > 6) countShowtime @endif" >@foreach($movie_showtimes  as $movieShowtime)
    	    @if($movie->movie_strID === $movieShowtime->showtime_Movie_strID && $movie->showtime_SystemType == $movieShowtime->showtime_SystemType)
       		 @if( date('Y-m-d H:i', strtotime($movieShowtime->showtime_dtmDate_Time))>= $dateNow &&   date('Y-m-d H:i', strtotime($movieShowtime->showtime_dtmDate_Time)) <= $dayTimeNight)<?php
			    $countShowtime ;
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
				
			  }# end if 
			 	
		   ?><div class="rowShowTime hoverImg08 {{$style45Mins}} {{$classTime}}">
           @if($movieShowtime->showtime_strName == 'Theatre 1')<div class="showTimeHilight"><span title="Hall 1" class="tooltip theater1Icon"></span></div>@endif
		   @if($movieShowtime->showtime_strName == 'Theatre 3')<div class="showTimeHilight3"><span title="Hall 3" class="tooltip theater3Icon"></span></div>@endif<?php 
            	 $soundAttributes = $movieShowtime->showtime_soundAttributes;
				 $audio 		= substr($soundAttributes,0,2); 
				 $subtitle 	= substr($soundAttributes, -2);
			?><a href="{{URL::to("$urlPage")}}" title="Audio: {{subLanguage($audio)}}   / Subtitle: {{subLanguage($subtitle)}} " class="tooltip">{{ date('H:i', strtotime($movieShowtime->showtime_dtmDate_Time))}}</a> <p class="on_mobile__h"><?php
                   		$showtimes =  $movieShowtime->showtime_soundAttributes.";";
						echo	 $showtimes = strstr($showtimes, ';', true);  
				   ?></p></div>@endif
            @endif
            @endforeach</div>
      <p class="clear"></p>
    </div>@endforeach</div>
  <br><br><br> 
  @include('frontend.incFooter')</div>
@include('frontend.incScriptBottom')
   <div class="url">
     <div id='inline_content' style='padding:30px; background:#fff;text-align:center;'>
       <p  class="txtBlack20 fontSynopis"><strong>You can reserve/buy 60 minutes before showtime. <br/>Please call 02-160-5999.</strong></p> 
       </div>
   </div>
<script src="{{$config_path}}/js/bxslider/jquery.bxslider.min.js"></script>
<script src="{{$config_path}}/js/tooltipster/js/jquery.tooltipster.js"></script>
<script src="{{$config_path}}/js/colorbox-master/jquery.colorbox.js"></script>
<script type="text/javascript"> 
 jQuery(function() { 
  	jQuery('.bxslider').bxSlider({auto: true, pager : false   });
	jQuery('.timeAgo a').click(function () {return false;}); 
	jQuery('.tooltip').tooltipster();
	jQuery('.noBooking a').click(function () { 
		 jQuery.colorbox({width:"30%", inline:true, href:"#inline_content"});
		return false;
	});  
  }); 
</script>
</body>
</html>