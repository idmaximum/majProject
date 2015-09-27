@foreach ($rowPromotion as $row)<?php
	 
	 $promotionName =	$row->promotion_title_th;
	 $promotionNameSub =  str_replace_text($promotionName); 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>{{$promotionName}}</title> 
<meta property="og:image" content="http://www.embassycineplex.com/uploads/promotion/{{$row->promotion_imageThumb}}" />
<meta name="description" content="{{$row->promotion_abstract_th}}" />
<meta name="keywords" content="embassy, diplomat, ais, central, ดูหนัง, หนังใหม่, โรงหนัง, โรงภาพยนตร์"/>
{{HTML::style('css/reset.css')}}
{{HTML::style('css/font.css')}}
{{HTML::style('css/screen.css')}}
{{HTML::style('css/screen2.css')}}
{{HTML::style('css/screenTH.css')}}
{{HTML::style('css/screenInside.css')}} 
{{HTML::style('js/DropDown/css/style.css')}}
@include('frontendTH.incScriptTop') 
</head>
<body>
<div id="main">
  @include('frontendTH.incHeader')   
      <div id="content" class="content-main">
        <div class="title-promotion">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="614"><a href="{{URL::to('th/promotion')}}"><img src="{{asset('images/btn-back.png')}}" width="90" height="30" class="hoverImg08"></a></td>
              <td width="319" align="right"><img src="{{asset('images/title-share.png')}}" width="50" height="30"></td>
              <td width="91" align="center">
              <a href="http://www.facebook.com/sharer.php?u=http://www.embassycineplex.com/promotion/{{$row->promotion_ID}}/{{$promotionNameSub}}&t={{$promotionName}}" class="hoverImg08" target="_blank"><img src="{{asset('images/ic-fb-share.jpg')}}" width="30" height="30"></a> 
              <a href="http://twitter.com/home?status={{$promotionName}} http://www.embassycineplex.com/promotion/{{$row->promotion_ID}}/{{$promotionNameSub}}&t={{$promotionName}}" class="hoverImg08" target="_blank"><img src="{{asset('images/ic-tw-share.jpg')}}" width="30" height="30"></a></td>
            </tr>
          </table>
        </div>
        <div class="contentPage">
          <div class="content-left-page"><img src="{{asset('uploads/promotion/'.$row->promotion_image)}}"  style="max-width:639px" > </div>
          <div class="content-right-page">
            <h2 class="txtWhite30 fontTHLang fontTHLang24">{{$promotionName}}</h2>
            <p class="timeShow">{{$row->promotion_datetime}}</p>
            <div class="txtBrown18_2 fontTHLang">{{nl2br($row->promotion_detail_th)}}</div>
          </div>
          <p class="clear" style="height:60px"></p>
        </div>
      </div> 
  @include('frontendTH.incFooter')
</div> 
@include('frontendTH.incScriptBottom') 
</body>
</html>
@endforeach