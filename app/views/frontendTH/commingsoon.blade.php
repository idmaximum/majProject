<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Embassy Diplomat Screens by AIS</title>
<meta property="og:image" content="http://www.embassycineplex.com/images/share.jpg" />
{{HTML::style('css/reset.css')}}
{{HTML::style('css/font.css')}}
{{HTML::style('css/screen.css')}}
{{HTML::style('css/screen2.css')}}
{{HTML::style('js/bxslider/jquery.bxslider.css')}}
{{HTML::style('js/DropDown/css/style.css')}}
{{HTML::style('css/screenTH.css')}}
@include('frontendTH.incScriptTop')
<style type="text/css">
.rowMonth .rowMovie .rowShowTodayImage {
	padding: 6px 8px 5px 8px;background-image: url(../images/1_homepage_11_ss.png);position:relative;
}
.booknow {
	position: absolute;	width: 99px;height: 94px;z-index: 1;left: 8px;top: 6px;background-image:url(images/btn_buynow.png);	background-repeat: no-repeat;	background-position: left top;
}
</style> 
</head>
<body>
<div id="main">
  @include('frontendTH.incHeader')  
  <div id="content" class="content-main"> 
    <h1 class="showToday">COMING SOON</h1>
    <div class="contentPage" id="contentComingsoon"> 
        <?php 
		   $yearNow =  date('Y');
			$monthNow =  date('m');
		
		for($monthNum = 0; $monthNum < 6 ;$monthNum++){
			 $getMounthComingsoon = date('Y-m', strtotime(" +$monthNum month"));
				    $getStart = date('Y-m-01', strtotime(" +$monthNum month"));
				 	$getEnd = date('Y-m-31', strtotime(" +$monthNum month")); 
					  
				    $numMovie = countMovieComingsoon($getStart, $getEnd ); 
					  
				 if($numMovie != '0'){
			?>
        	<?php $mounthComingsoon = date('F Y', strtotime(" +$monthNum month   $yearNow-$monthNow-01"))?>
       <div class="rowMonth">
        <p class="txtWhite25 titleMonth">{{$mounthComingsoon}}</p>
         @foreach($rowComingsoon as $movieComingsoon)
           @if($mounthComingsoon === date('F Y', strtotime($movieComingsoon->movie_ReleaseDate)) ) 
       	 <div class="rowMovie">
         <?php 
		 	$nameMovie  = $movieComingsoon->movie_Name_TH;
		 	$nameMovieSub =  str_replace_text($nameMovie); 
		 ?>
       	  <div class="rowShowTodayImage"><a href="{{URL::to("th/comingsoon/$movieComingsoon->movieID/$nameMovieSub")}}" title="{{$nameMovie}}" ><img src="{{asset("uploads/movie/$movieComingsoon->movie_Img_Thumb")}}" width="117" height="177" class="hoverImg08"  alt="{{$nameMovie}}"></a></div>
       	  
         <div class="detailMovieComingsoon">
            <h2 class="txtGold24 fontTHLang titleMovieName">{{$nameMovie}}</h2>
            <p class="txtBrown20_2 icCal">{{date('d F Y', strtotime($movieComingsoon->movie_ReleaseDate))}}</p>
          <?php if($movieComingsoon->movie_Youtube != ""){ ?>
            <p class="txtBrown20_2 icTrail"><a href="{{URL::to("th/comingsoon/$movieComingsoon->movieID/$nameMovieSub")}}" title="Trailer {{$nameMovie}}">Trailer</a></p>
            <?php }#end if?>
            <?php 
				$countShowtimeComingsoon = '';
				$countShowtimeComingsoon =  countShowtimeComingsoon($movieComingsoon->movie_strID);
				if($countShowtimeComingsoon != ''){
			?>
            <p><a href="{{URL::to("th/comingsoonbooking/$movieComingsoon->movieID/$nameMovieSub")}}"><img src="{{asset("images/btn-comingsoon-booknow.png")}}" width="120" height="42" class="hoverImg08"  alt="Booking Now"></a></p>
            <?php }?>
          </div>
          <p class="clear"></p>
        </div>
      	   @endif
         @endforeach 
		<p class="clear"></p>
      </div>
      	<?php }#end if?>  
      <?php }#end for?>  
    </div>
  </div> 
  @include('frontendTH.incFooter')
</div> 
@include('frontendTH.incScriptBottom') 
</body>
</html>