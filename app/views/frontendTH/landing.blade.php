<?php
	$dateNow = date('Y-m-d 06:00'); 
	$dateHrNow = date('Y-m-d H:i');  
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Embassy Diplomat Screens by AIS</title>
<meta property="og:image" content="http://www.invp.co.th/media_file/images/share.jpg" /> 
{{HTML::style('css/reset.css')}}
{{HTML::style('css/font.css')}}
{{HTML::style('css/screen.css')}}
{{HTML::style('js/bxslider/jquery.bxslider.css')}}
{{HTML::style('js/DropDown/css/style.css')}}
{{HTML::style('js/tooltipster/css/tooltipster.css')}}
{{HTML::style('js/colorbox-master/example3/colorbox.css')}}
@include('frontend.incScriptTop')
<style type="text/css">
	#divLandingPage {position: fixed;width: 100%;height: 100%;z-index: 9999999;left: 0;top: 0;background-color: #000;}
</style>
</head>
<body> 
<div id="mainTopLanding">
<div id="divLandingPage">
  <div class="divCrop">
    <div class="contentLandingPage"><span id="buttonLanding" class="buttonText"></span></div>
  </div>
</div>
</div> 
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
    <h1 class="titleShowToday">Showtimes</h1>
    @foreach($movie_lists as $movie)
      <?php
      	 $nameMovie  = $movie->movie_Name_EN;
		 $nameMovieSub =  str_replace_text($nameMovie); 
	  ?>
    <div class="rowShowToday  ">
      <div class="rowShowTodayImage"><a href="{{URL::to("movie/$movie->movieID/$nameMovieSub")}}" title="{{$nameMovie}}"><img src="{{asset("uploads/movie/$movie->movie_Img_Thumb")}}" width="140" height="210" class="hoverImg08"></a></div>
      <div class="rowShowTodayDetail">
        <h2 class="txtGold24"><a title="{{$nameMovie}}" href="{{URL::to("movie/$movie->movieID/$nameMovieSub")}}">{{$nameMovie}}</a></h2>
        <p class="timeRate txtBrown20_2">{{$movie->movie_Duration}} Min</p>
        <p>
           <?php
            	if($movie->movie_Rating == "ส."){ 
					$imgRate = "rate_raise.png"; 
				 }else if($movie->movie_Rating == "น13+"){ 
					$imgRate = "rate_up_13.png";
				 }else if($movie->movie_Rating == "น15+"){ 
					$imgRate = "rate_up_15.png";
				 }else if($movie->movie_Rating == "น18+"){ 
					$imgRate = "rate_up_18.png";
				  }else if($movie->movie_Rating == "ฉ20-"){ 
					$imgRate = "rate_under_20.png";
				 }else { 
					$imgRate = "rate_general.png";
				 }
		 
            if($movie->showtime_SystemType == "VS00000001"){ 
					$imgSystem = "type_digital.png";
					$systemName = '2D';
				 }else if($movie->showtime_SystemType == "0000000001"){ 
					$imgSystem = "type_3d.png";
					$systemName = 'D3D';
				 } 
			?><img src="{{asset("images/icon/$imgRate")}}" alt="{{$movie->movie_Rating}}" style="margin-right:3px;width:40px" > <img src="{{asset("images/icon/$imgSystem")}}" alt="{{$systemName}}" style="width:40px"></p> 
      </div>
      <?php
	  	 $numKL = 1;
		   $dayTimeNight = date('Y-m-d 03:00', strtotime(" +1 day"));  
      	   $countShowtime =  countMovieShowtimeDay($dateNow, $dayTimeNight, $movie->showtime_Movie_strID , $movie->showtime_SystemType);
	  ?>
      <div class="rowShowTodayShowtime @if($countShowtime > 6)countShowtime@endif" >
      	@foreach($movie_showtimes  as $movieShowtime)
    	    @if($movie->movie_strID === $movieShowtime->showtime_Movie_strID && $movie->showtime_SystemType == $movieShowtime->showtime_SystemType)
       		 @if( date('Y-m-d H:i', strtotime($movieShowtime->showtime_dtmDate_Time))>= $dateNow &&   date('Y-m-d H:i', strtotime($movieShowtime->showtime_dtmDate_Time)) <= $dayTimeNight)<?php
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
				   $urlPage = "th/selectTicket/$movie->movieID/$movieShowtime->showtime_Session_strID";
				 $dateBooking = date('Y-m-d H:i', strtotime(" +60 minutes")); 
				if($dateBooking > $movieShowtime->showtime_dtmDate_Time){ 
					$style45Mins = 'noBooking';
				}#end if dateBooking 
			  }# end if  
		   ?><<div class="rowShowTime {{$style45Mins}} {{$classTime}}">
           @if($movieShowtime->showtime_strName == 'Theatre 1')<div class="showTimeHilight"><span title="Hall 1" class="tooltip theater1Icon"></span></div>@endif<?php 
            	 $soundAttributes = $movieShowtime->showtime_soundAttributes;
				 $audio 		= substr($soundAttributes,0,2); 
				 $subtitle 	= substr($soundAttributes, -2);
			?><a href="{{URL::to("$urlPage")}}" title="Audio: {{subLanguage($audio)}}   / Subtitle: {{subLanguage($subtitle)}} " class="tooltip">{{ date('H:i', strtotime($movieShowtime->showtime_dtmDate_Time))}}</a><?php
                   		$showtimes =  $movieShowtime->showtime_soundAttributes.";";
						echo	 $showtimes = strstr($showtimes, ';', true); // As of PHP 5.3.0
				   ?></div>@endif
            @endif
        @endforeach</div>
      <p class="clear"></p>
    </div>@endforeach</div>
  <br>
  <br>
  <br>
  <div class="url">
     <div id='inline_content' style='padding:30px; background:#fff;text-align:center;'>
       <p  class="txtBlack20 fontSynopis"><strong>กรุณาทำการจองและรับบัตรชมภาพยนตร์<br>
ก่อนรอบฉาย 60 นาที</strong></p> 
       </div>
   </div>
  @include('frontend.incFooter')</div>
@include('frontend.incScriptBottom')
{{ HTML::script('js/bxslider/jquery.bxslider.min.js') }}
{{ HTML::script('js/tooltipster/js/jquery.tooltipster.js') }}
{{ HTML::script('js/colorbox-master/jquery.colorbox.js') }}
<script type="text/javascript"> 
 jQuery(function() { 
  	jQuery('.bxslider').bxSlider({auto: true, pager : false  });
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