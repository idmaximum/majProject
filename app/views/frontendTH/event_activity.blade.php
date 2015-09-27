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
{{HTML::style('css/screenTH.css')}}
{{HTML::style('css/screenInside.css')}} 
{{HTML::style('js/DropDown/css/style.css')}}
@include('frontendTH.incScriptTop') 
<style type="text/css">
.timeShow {	margin-top: 30px;margin-bottom: 10px;}
</style>
</head>
<body>
<div id="main">
  @include('frontendTH.incHeader')  
  <div id="content" class="content-main"> 
    <h1 class="showToday">Event &amp; Activity</h1>
    <div class="contentPage">
      <?php  $numRow = 1; ?>
  	   @foreach($rowNews as $row)
         <?php
      	 $newsName  = $row->news_title_th;
		 $nameNewsSub =  str_replace_text($newsName); 
	  ?>
   		  <div class="rowEventNews <?php if($numRow  == 1){?>frist<?php }?>"> 
     	<div class="divImgNews"><a href="{{URL::to('th/event_activity/'.$row->news_ID.'/'.$nameNewsSub)}}" title="{{$newsName}}"><img src="{{asset('uploads/news/'.$row->news_imageThumb)}}" style="max-width:300px" class="hoverImg08"></a></div>
        <div class="divDetailNews">
       	  <h2 class="txtWhite20 fontTHLang titleMovieName"><a href="{{URL::to('th/event_activity/'.$row->news_ID.'/'.$nameNewsSub)}}" title="{{$newsName}}">{{$newsName}}</a></h2>
             <p class="timeShow">{{ date('d F Y', strtotime($row->news_datetime))}}</p>
          <p class="txtBrown18_2 fontTHLang">{{$row->news_abstract_th}}</p>
        </div>
   	  </div>
  	    <?php $numRow++?>
         @endforeach
       <p class="clear"></p>
       <br><br> 
        <?php echo $rowNews->links();  ?>
         <br><br> 
   </div>
  </div> 
  @include('frontendTH.incFooter')
</div> 
@include('frontendTH.incScriptBottom') 
</body>
</html>