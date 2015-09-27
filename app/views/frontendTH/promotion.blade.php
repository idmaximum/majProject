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
</head>
<body>
<div id="main">
  @include('frontendTH.incHeader')  
  <div id="content" class="content-main"> 
    <h1 class="showToday">PROMOTION</h1>
    <div class="contentPage" id="pagePromotion">
    <div class="txtBrown20_3 fontTHLang" style="text-align:center">
    	  <p>โรงภาพยนตร์ เอ็มบาซซี่ ดิโพลแมท สกรีน ได้นำคุณภาพเป็นเลิศในราคาที่เริ่มต้นที่ไม่แพง <br>
ถ้าเทียบกับโรงภาพยนตร์วีไอพีทั่วโลกโดยได้รับการสนับสนุนจาก<br>
สปอนเซอร์อย่างเป็นทางการของโรงภาพยนตร์ไม่ว่าจะเป็น เอไอเอส, ธนาคารกรุงศรีอยุธยา, เมอร์เซเดซ เบนซ์, โนเบิล, ธนาคารกรุงเทพ</p>
    	  <p>&nbsp;</p><p>&nbsp;</p>
    	  
    	  <p>&nbsp;</p>
    	  <p>&nbsp;</p>
      </div> 
    <?php  $numRow = 1; ?>
    	 @foreach($rowPromotion as $row)
         <?php
      	 $promotionName  = $row->promotion_title_th;
		 $nameMovieSub =  str_replace_text($promotionName); 
	  ?><div class="row-promotion <?php if($numRow%3 == 0){?>last<?php }?>">
            <p class="timeShow">{{$row->promotion_datetime}}</p>
            <p style="height:200px; overflow:hidden; text-align:center"><a href="{{URL::to('th/promotion/'.$row->promotion_ID.'/'.$nameMovieSub)}}" title="{{$promotionName}}"><img src="{{asset('uploads/promotion/'.$row->promotion_imageThumb)}}" width="300" class="hoverImg08" alt="{{$promotionName}}" ></a></p>
            <h2 class="txtWhite20 fontTHLang titleMovieName"><a href="{{URL::to('th/promotion/'.$row->promotion_ID.'/'.$nameMovieSub)}}">{{$promotionName}}</a></h2>
            <p class="txtBrown18_2 fontTHLang">{{$row->promotion_abstract_th}}</p>
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
  @include('frontendTH.incFooter')
</div> 
@include('frontendTH.incScriptBottom') 
</body>
</html>