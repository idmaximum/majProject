<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Embassy Diplomat Screens by AIS</title>
<meta name="description" content="Embassy Diploment Screens" />
<meta name="keywords" content="embassy, diplomat, ais, central, ดูหนัง, หนังใหม่, โรงหนัง, โรงภาพยนตร์"/>
<meta property="og:image" content="http://www.embassycineplex.com/images/share.jpg" />
{{HTML::style('css/reset.css')}}
{{HTML::style('css/font.css')}}
{{HTML::style('css/screen.css')}}
{{HTML::style('css/screen2.css')}} 
{{HTML::style('css/screenInside.css')}} 
{{HTML::style('js/DropDown/css/style.css')}}
@include('frontend.incScriptTop') 
</head>
<body>
<div id="main">
  @include('frontend.incHeader')  
  <div id="content" class="content-main"> 
    <h1 class="showToday">PROMOTION</h1>
    <div class="contentPage" id="pagePromotion"> 
    	<div class="txtBrown18_2" style="text-align:center">
    	  <p>Embassy Diplomat Screens brings you the highest quality<br>
    	    in cinema at a reasonable price made possible by our exclusive partners;<br> 
    	    AIS, Bank of Ayudhya, Mercedes Benz, Noble, Bangkok Bank.</p>
    	  <p>&nbsp;</p><p>&nbsp;</p>
    	  
    	  <p>&nbsp;</p>
          <p>&nbsp;</p>
      </div> 
    <?php  $numRow = 1; ?>
    	 @foreach($rowPromotion as $row)
         <?php
      	 $promotionName  = $row->promotion_title_en;
		 $nameMovieSub =  str_replace_text($promotionName); 
	  ?>
           <div class="row-promotion <?php if($numRow%3 == 0){?>last<?php }?>">
            <p class="timeShow">{{$row->promotion_datetime}}</p>
            <p style="height:200px; overflow:hidden; text-align:center"><a href="{{URL::to('promotion/'.$row->promotion_ID.'/'.$nameMovieSub)}}" title="{{$promotionName}}"><img src="{{asset('uploads/promotion/'.$row->promotion_imageThumb)}}" width="300" class="hoverImg08" alt="{{$promotionName}}" ></a></p>
            <h2 class="txtWhite20_2 fontSynopis"><a href="{{URL::to('promotion/'.$row->promotion_ID.'/'.$nameMovieSub)}}">{{$row->promotion_title_en}}</a></h2>
            <p class="txtBrown20_3 fontSynopis">{{$row->promotion_abstract_en}}</p>
          </div>
          
         <?php if($numRow%3 == 0){?><p class="clear"></p><?php }?>
          <?php $numRow++?>
         @endforeach
        <p class="clear"></p>  
        <?php echo $rowPromotion->links();  ?>
        <br><br> 
    </div>
  </div> 
  <p style="text-align:center"><img src="{{asset('images/sponsor_logo.png')}}" width="682" alt="sponsor_logo"  ></p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  
  @include('frontend.incFooter')
</div> 
@include('frontend.incScriptBottom') 
</body>
</html>