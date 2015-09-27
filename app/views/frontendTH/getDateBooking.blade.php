<?php
	$countMovieShowtimeAll = '';
?> 
<div id="showtimeTab">
  <div class="menuContent">
    <ul class="nav">
      <?php 
		for($dayTime = 0;$dayTime <7; $dayTime++){
			$dateTimeTab  = date('Y-m-d', strtotime("$dataDate +$dayTime day")); 
		   
			$dateNowShort  = date('d', strtotime($dateTimeTab)); 
			$dateNowFull 	 = date('l', strtotime($dateTimeTab));  
	   ?>
      <li><a href="#tab{{$dayTime}}" <?php if($dayTime == 0){?>class="current"<?php }?>>{{$dateNowFull}}<br>
        <span class="txtBrown36">{{$dateNowShort}}</span></a></li>
      <?php }#end for?>
    </ul>
  </div>
  <div class="list-wrap">
    <?php   	
		for($dayTime = 0;$dayTime < 7; $dayTime++){ 
		   // $dateNow = date('Y-m-d 06:00', strtotime(" +$dayTime day")); 
			$dateHrNow = date('Y-m-d H:m');  
		   //**********
		     $dateTimeTab  = date('Y-m-d H:m', strtotime("$dataDate +$dayTime day")); 
			 
			 $dayTowmorrow = $dayTime+1;
		     $dateEndShowtime = date('Y-m-d 03:00', strtotime(" +$dayTowmorrow day"));
		   
			//$dateNowShort  = date('d', strtotime($dateTimeTab)); 
			 $dateNow 	 = date('Y-m-d 06:00', strtotime($dateTimeTab)); 
			 $dayTimeNight = date('Y-m-d 03:00', strtotime("$dateNow +1 day"));  
		   //********** 
		?>
    <ul id="tab{{$dayTime}}" <?php if($dayTime != 0){?>class="hide"<?php }?>>
      <li>@foreach($movie_lists as $movie)
        <?php 
			 $movieID = $movie->movieID;
			 
		  	 $countMovieShowtimeAll = countMovieShowtimeAll($dateNow,$movieID);
			 $countMovieShowtime = countShowtime($dateNow, $dayTimeNight, $movieID, $movie->showtime_SystemType);  
			 
			 $nameMovie  = $movie->movie_Name_TH;
			 $nameMovieSub =  str_replace_text($nameMovie); 
			 if($countMovieShowtime != ''){
		  ?>
        <div class="rowShowToday">
          <div class="rowShowTodayImage"><a href="{{URL::to("th/"."movie/$movieID/$nameMovieSub")}}"><img src="{{asset("uploads/movie/$movie->movie_Img_Thumb")}}" width="140" height="210" class="hoverImg08"></a></div>
          <div class="rowShowTodayDetail">
            <h2 class="txtGold24 fontTHLang titleMovieName"><a href="{{URL::to("th/"."movie/$movieID/$nameMovieSub")}}">{{$nameMovie}}</a></h2>
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
		  ?><img src="{{asset("images/icon/$imgRate")}}" alt="{{$movie->movie_Rating}}" style="margin-right:3px;width:40px" > <img src="{{asset("images/icon/$imgSystem")}}" alt="{{$systemName}}" style="width:40px"></p>
          </div>
           <?php	
				  $numKL = 1;
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
								//$style45Mins = 'noBooking';
							}#end if dateBooking
						}
					 ?><div class="rowShowTime {{$classTime}}">@if($movieShowtime->showtime_strName == 'Theatre 1')
              <div class="showTimeHilight"><span title="Theater 1" class="tooltip theater1Icon"></span></div>
              @endif @if($movieShowtime->showtime_strName == 'Theatre 3')
              <div class="showTimeHilight3"><span title="Theater 3" class="tooltip theater3Icon"></span></div>
              @endif
              <?php 
				   $soundAttributes = $movieShowtime->showtime_soundAttributes;
				   $audio 		= substr($soundAttributes,0,2); 
				   $subtitle 	= substr($soundAttributes, -2);
			  ?>
              <a href="{{URL::to("$urlPage")}}" title="Audio: {{subLanguage($audio)}}   / Subtitle: {{subLanguage($subtitle)}} " class="tooltip">{{ date('H:i', strtotime($movieShowtime->showtime_dtmDate_Time))}}</a> <?php
                   		$showtimes =  $movieShowtime->showtime_soundAttributes.";";
						echo	 $showtimes = strstr($showtimes, ';', true); // As of PHP 5.3.0
				   ?></div>
            @endif
            @endif
            @endforeach
            </div>
          <p class="clear"></p>
        </div>
       	 <?php }#end count movieshowtime?> 
      	  @endforeach 
          @if($countMovieShowtimeAll  == '')<div class="noUpdateShowtime">No Updated Showtime</div>@endif
        </li>
    </ul>
    <?php }#end for?>
    </div>
</div>