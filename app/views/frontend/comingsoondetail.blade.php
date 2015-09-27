@foreach($rowComingsoon as $movie)<?php
	 
	 $movieName =	$movie->movie_Name_EN;
	 $nameMovieSub =  str_replace_text($movieName); 
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>{{$movieName}}</title>
<meta name="description" content="{{$movie->movie_Synopsis_EN}}" />
<meta name="keywords" content="embassy, diplomat, ais, central, ดูหนัง, หนังใหม่, โรงหนัง, โรงภาพยนตร์"/>
<meta property="og:image" content="http://www.embassycineplex.com/uploads/movie/{{$movie->movie_Img_Thumb}}" />
{{HTML::style('css/reset.css')}}
{{HTML::style('css/font.css')}}
{{HTML::style('css/screen.css')}}
{{HTML::style('css/screen2.css')}}
{{HTML::style('css/screen2.css')}}
{{HTML::style('css/screenInside.css')}}
{{HTML::style('js/DropDown/css/style.css')}}
{{HTML::style('js/formValidator/css/validationEngine.jquery.css')}} 
@include('frontend.incScriptTop')
<style type="text/css">
#content {padding-top: 24px;}
.rowShowTodayShowtime {	padding-top: 20px;float: right}
.rowShowTodayShowtime1 {padding-top: 20px;float: right}
</style>
<?php 
	 $dateNow = date('Y-m-d');
	 $dateHrNow = date('Y-m-d H:i:s'); 
	   $name = Input::get('name'); 
?>
</head><body>
<div id="main"> @include('frontend.incHeader')
  <div id="content" class="content-main">
    <div class="contentPage">
      <div class="titleMovie">
        <div class="content-movie-left" style="padding-top:10px"><a href="{{URL::to('comingsoon')}}"><img src="{{asset('images/6_movie_detail_09.png')}}" width="88" height="20" class="hoverImg08"></a></div>
        <div class="content-movie-right">
          <h1 class="txtGold36">{{$movieName}}</h1>
          <span class="txtBrown24" style="float:right"><span style=" bottom:10px; position:relative; ">Share</span>  
          <a href="http://www.facebook.com/sharer.php?u=http://www.embassycineplex.com/comingsoon/{{$movie->movieID}}/{{$nameMovieSub}}&t={{$movieName}}" target="_blank"><img src="{{asset('images/ic-fb-share.png')}} " width="34" height="30" class="hoverImg08"></a> 
           
          <a href="http://twitter.com/home?status={{$movieName}} http://www.embassycineplex.com/comingsoon/{{$movie->movieID}}/{{$nameMovieSub}}&t={{$movieName}}" target="_blank"><img src="{{asset('images/ic-tw-share.png')}}" width="32" height="30" class="hoverImg08"></a></span></div>
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
      	  <p class="txtWhite20 fontSynopis">{{$movie->movie_Duration}} Min</p>
      	  <p>&nbsp;</p><p>&nbsp;</p>
          @endif
           @if($movie->movie_Categories != '')
          <p class="txtBrown20_2">Genres</p>
          <p style="padding:3px;"></p>
      	  <p class="txtWhite20 fontSynopis">{{$movie->movie_Categories}}</p>
      	  <p>&nbsp;</p><p>&nbsp;</p>
           @endif
           @if($movie->movie_Directors != '')
          <p class="txtBrown20_2">Director</p>
          <p style="padding:3px;"></p>
      	  <p class="txtWhite20 fontSynopis">{{$movie->movie_Directors}}</p>
          @endif  
          @if($movie->movie_Actors != '')
      	  <p>&nbsp;</p><p>&nbsp;</p>
           <p class="txtBrown20_2">Actor</p>
           <p style="padding:3px;"></p>
      	  <p class="txtWhite20 fontSynopis">{{$movie->movie_Actors}}</p>
          @endif 
            <p>&nbsp;</p>
            <p>&nbsp;</p>
          </div>
        </div>
        <div class="content-movie-right">
          <?php
			  $item_youtube = substr($movie->movie_Youtube,-11,11);
		?>
          <iframe width="732" height="350" src="//www.youtube.com/embed/{{$item_youtube}}?autoplay=1" frameborder="0" allowfullscreen></iframe>
          <p>&nbsp;</p>
        <?php if($movie->movie_strID != ""){ ?>
		  <p class="txtBrown20_2 titleDetail">&nbsp;</p>  
    		<p style="padding:45px; text-align:center"><a href="{{URL::to("comingsoonbooking/$movie->movieID/$nameMovieSub")}}"><img src="{{asset('images/btn-booknow.png')}}" width="246" height="51"></a></p>  
            <p>&nbsp;</p> 
            <?php }#end if?>
          <p class="txtBrown20_2 titleDetail"><span style="background-color:#1f2022; padding-right:10px">Synopsis</span></p>
          <p>&nbsp;</p>
          <div class="txtWhite20 fontSynopis">{{$movie->movie_Synopsis_EN}}</div>
          <p style="height:80px">&nbsp;</p>
          <p class="txtBrown20_2 titleDetail"><span style="background-color:#1f2022; padding-right:10px">Alert Me</span></p>
          <form action="{{URL::to('comingsoonSaveAlert')}}" method="post"  id="formAlertMe">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top">
              	  <p>
                    <label for="email">Your Email</label>
                    <br />
                    <input name="email" type="text" id="email" class="validate[required,custom[email]] email-alertme">
                  </p>
                   <input name="url" type="text" class="url">
                   <input name="action" type="hidden" value="sendmail">
                   <input name="movie_Name_EN" type="hidden" value="{{$movieName}}">
                   <input name="movieID" type="hidden" value="{{$movie->movieID}}">
                </td>
                <td><input type="image" src="{{asset('images/btn-alertme.png')}}" class="button-contact"></td>
              </tr>
            </table>
          </form>
          <p>&nbsp;</p>
        </div>
        <p class="clear" style="height:80px"></p>
      </div>
    </div>
  </div>
  
  <div style='display:none'>
    <a class='inline' href="#inline_content"></a>
    <div id='inline_content' style='padding:20px; background:#111; text-align:center'>
        <p class="txtGold24">Successfully information</p> 
    </div>
</div>

  @include('frontend.incFooter')</div>
@include('frontend.incScriptBottom')
{{ HTML::script('js/formValidator/js/languages/jquery.validationEngine-en.js') }}
{{ HTML::script('js/formValidator/js/jquery.validationEngine.js') }}
{{ HTML::script('js/InFieldLabels/jquery.infieldlabel.min.js') }}  
<script type="text/javascript" charset="utf-8">
  jQuery(function(){ 
  	 jQuery("label").inFieldLabels();
	 jQuery("#formAlertMe").validationEngine('attach', {promptPosition : "topLeft"}); 
 
 });
</script>
</body>
</html>
@endforeach