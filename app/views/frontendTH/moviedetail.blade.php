@foreach($movie_lists_detail as $movie)
<?php 
	 $movieName =	$movie->movie_Name_TH;
	 $nameMovieSub =  str_replace_text($movieName); 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>{{$movieName}}</title> 
<meta property="og:image" content="{{asset("uploads/movie/$movie->movie_Img_Thumb")}}" />
<meta name="description" content="{{$movie->movie_Synopsis_TH}}">
{{HTML::style('css/reset.css')}}
{{HTML::style('css/font.css')}}
{{HTML::style('css/screen.css')}}
{{HTML::style('css/screen2.css')}}
{{HTML::style('css/screenInside.css')}}
{{HTML::style('css/screenMovieDetail.css')}}
{{HTML::style('js/DropDown/css/style.css')}}
{{HTML::style('js/tooltipster/css/tooltipster.css')}}
{{HTML::style('js/colorbox-master/example3/colorbox.css')}}
{{HTML::style('css/screenTH.css')}}
@include('frontendTH.incScriptTop')
<?php 
	 $dateNow = date('Y-m-d 06:00');
	 $dateHrNow = date('Y-m-d H:i:s'); 
?>
</head><body>
<div id="main"> @include('frontendTH.incHeader')  
 
  <div id="content" class="content-main">
    <div class="contentPage">
      <div class="titleMovie">
        <div class="content-movie-left" style="padding-top:10px"><a href="{{URL::to('advancebooking')}}"><img src="{{asset('images/6_movie_detail_09.png')}}" width="88" height="20" class="hoverImg08"></a></div>
        <div class="content-movie-right">
          <h1 class="fontTHLang titleMovieName txtGold36">{{$movie->movie_Name_TH}}</h1>
          <span class="txtBrown24" style="float:right"><span style=" bottom:10px; position:relative; ">Share</span> 
           <a href="http://www.facebook.com/sharer.php?u=http://www.embassycineplex.com/movie/{{$movie->movieID}}/{{$nameMovieSub}}&t={{$movieName}}" target="_blank"><img src="{{asset('images/ic-fb-share.png')}} " width="34" height="30" class="hoverImg08" ></a> 
          <a href="http://twitter.com/home?status={{$movieName}} http://www.embassycineplex.com/movie/{{$movie->movieID}}/{{$nameMovieSub}}&t={{$movieName}}" target="_blank"><img src="{{asset('images/ic-tw-share.png')}}" width="32" height="30" class="hoverImg08"></a></span></div>
        <p class="clear"></p>
      </div>
      <div class="detailMovie">
        <div class="content-movie-left">
          <p><img src="{{asset("uploads/movie/$movie->movie_Img_Thumb")}}" width="230" height="340"></p>
          <div style="padding-left:8px">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p class="txtBrown20_2">Release Date</p>
            <p style="padding:3px;"></p>
            <p class="txtWhite20">{{date("d F Y", strtotime($movie->movie_ReleaseDate)) }}</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            @if($movie->movie_Duration != '0')
            <p class="txtBrown20_2">Duration</p>
            <p style="padding:3px;"></p>
            <p class="txtWhite20">{{$movie->movie_Duration}} Min</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            @endif
            @if($movie->movie_Categories != '')
            <p class="txtBrown20_2">Genres</p>
            <p style="padding:3px;"></p>
            <p class="txtWhite20 fontTHLang">{{$movie->movie_Categories}}</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            @endif
            @if($movie->movie_Directors != '')
            <p class="txtBrown20_2">Director</p>
            <p style="padding:3px;"></p>
            <p class="txtWhite20 fontTHLang">{{$movie->movie_Directors}}</p>
            @endif  
            @if($movie->movie_Actors != '')
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p class="txtBrown20_2">Actor</p>
            <p style="padding:3px;"></p>
            <p class="txtWhite20 fontTHLang">{{$movie->movie_Actors}}</p>
            @endif
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p class="txtBrown20_2">Rate</p>
            <p style="padding:3px;"></p>
            <?php
            	if($movie->movie_Rating == "ส."){ 
					$imgRate = "rate_raise.png";
				 }else if($movie->movie_Rating == "ทป."){ 
					$imgRate = "rate_general.png";
				 }else if($movie->movie_Rating == "น13+"){ 
					$imgRate = "rate_up_13.png";
				 }else if($movie->movie_Rating == "น15+"){ 
					$imgRate = "rate_up_15.png";
				 }else if($movie->movie_Rating == "น18+"){ 
					$imgRate = "rate_up_18.png";
				  }else if($movie->movie_Rating == "ฉ20-"){ 
					$imgRate = "rate_under_20.png";
				 }else{
						$imgRate = "rate_general.png";
				 }
			?>
            <p ><img src="{{asset("images/icon/$imgRate")}}" alt="{{$movie->movie_Rating}}" style="padding:0; max-width:55px"></p>
          </div>
        </div>
        <div class="content-movie-right">
          <?php   $item_youtube = substr($movie->movie_Youtube,-11,11); ?>
          <iframe width="732" height="350" src="//www.youtube.com/embed/{{$item_youtube}}?autoplay=1" frameborder="0" allowfullscreen></iframe>
          <p class="titleDetail clear" style="height:1px"></p>
          <p style="height:30px">&nbsp;</p>
          <div class="contentShowtimeMovie">@foreach($movie_lists as $rowMovieShowTime)
            @if($movie->movie_strID  == $rowMovieShowTime->showtime_Movie_strID )
            <div class="rowSystemMovie">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="22%" valign="top" class="txtBrown20_2"><br/>
                    <span style=" bottom:10px; position:relative; padding-right:10px; ">System Type</span><br/>
                    <?php
            if($rowMovieShowTime->showtime_SystemType == "VS00000001"){ 
					$imgSystem = "type_digital.png";
					$systemName = '2D';
				 }else if($rowMovieShowTime->showtime_SystemType == "0000000001"){ 
					$imgSystem = "type_3d.png";
					$systemName = 'D3D';
					 }else if($rowMovieShowTime->showtime_SystemType == "0000000002"){ 
					$imgSystem = "type_hfr_3d.png";
					$systemName = 'HFR 3D';		  
				 }else{
					$imgSystem = "type_digital.png";
					$systemName = '2D';
				 } 
			?><img src="{{asset("images/icon/$imgSystem")}}" alt="{{$systemName}}"></td>
                  <td width="78%" align="right" style="padding-top:10px"><?php	$numKL = 1;
					  $dayTimeNight = date('Y-m-d 03:00', strtotime("$dateNow +1 day")); 
					  ?>
                    @foreach($movie_showtimes  as $movieShowtime)
                    @if($rowMovieShowTime->movie_strID === $movieShowtime->showtime_Movie_strID && $rowMovieShowTime->showtime_SystemType == $movieShowtime->showtime_SystemType) 
                    @if( date('Y-m-d H:i', strtotime($movieShowtime->showtime_dtmDate_Time)) >= $dateNow &&   date('Y-m-d H:i', strtotime($movieShowtime->showtime_dtmDate_Time)) <= $dayTimeNight) <?php
					  $style45Mins = '';
					  $urlPage = '';
					 if("$movieShowtime->showtime_dtmDate_Time" < "$dateHrNow"){
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
					  }
				   ?><div class="rowShowTime  {{$style45Mins}} {{$classTime}}"> @if($movieShowtime->showtime_strName == 'Theatre 1')
                      <div class="showTimeHilight"><span title="Hall 1" class="tooltip theater1Icon"></span></div>
                      @endif
                      @if($movieShowtime->showtime_strName == 'Theatre 3')
                      <div class="showTimeHilight3"><span title="Hall 1" class="tooltip theater3Icon"></span></div>
                      @endif
                      <?php 
						   $soundAttributes = $movieShowtime->showtime_soundAttributes;
						   $audio 		= substr($soundAttributes,0,2); 
						   $subtitle 	= substr($soundAttributes, -2);
					  ?><a href="{{URL::to("$urlPage")}}" title="Audio: {{subLanguage($audio)}}   / Subtitle: {{subLanguage($subtitle)}} " class="tooltip">{{ date('H:i', strtotime($movieShowtime->showtime_dtmDate_Time))}}</a> <?php
                   		$showtimes =  $movieShowtime->showtime_soundAttributes.";";
						echo	 $showtimes = strstr($showtimes, ';', true); // As of PHP 5.3.0
				   ?></div>
                    @endif
                    @endif
                    @endforeach </td>
                </tr>
              </table>
            </div>
            <p class="borderBottom"></p>
            @endif
            @endforeach</div>
          <br>
          <p class="txtBrown20_2 titleDetail "><span style="background-color:#1f2022; padding-right:10px">Synopsis</span></p>
          <p>&nbsp;</p>
          <div class="txtWhite20 fontTHLang">{{$movie->movie_Synopsis_TH}}</div>
        </div>
        <p class="clear" style="height:80px"></p>
      </div>
    </div>
  </div>
<div class="url">
     <div id='inline_content' style='padding:30px; background:#fff;text-align:center;'>
       <p  class="txtBlack20 fontSynopis"><strong>กรุณาทำการจองและซื้อบัตรชมภาพยนตร์<br>
ก่อนรอบฉาย 60 นาที</strong></p> 
       </div>
   </div>
  @include('frontendTH.incFooter')</div>
@include('frontendTH.incScriptBottom')
{{ HTML::script('js/tooltipster/js/jquery.tooltipster.js')}}
{{ HTML::script('js/colorbox-master/jquery.colorbox.js') }}
<script>
  jQuery(function() { 
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
@endforeach 