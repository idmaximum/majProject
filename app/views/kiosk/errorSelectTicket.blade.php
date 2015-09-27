<?php echo $movieID = $data['movieID'];
	  echo $sessID = $data['sessionID']; 
?>
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
{{HTML::style('css/screenKiosk.css')}}
{{HTML::style('css/screen2.css')}} 
{{HTML::style('css/screenInside.css')}}
{{HTML::style('css/infomation.css')}} 
@include('kiosk.incScriptTop')
</head>
<body>
<div id="main">
  @include('kiosk.incHeader')   
   	 <div id="content" class="content-main">
     <div class="titleMovie"> 
      <a href="{{URL::to("kiosk/selectTicket/$movieID/$sessID")}}"><img src="{{asset("images/btn-back.png")}}"  alt="btn Back"></a>
    </div><br><br> 
 		<p class="txtBrown18_2 fontSynopis" style="text-align:center; font-size:24px">There is a connection problem please click previous </p>
 		<p class="txtBrown18_2 fontSynopis" style="text-align:center; font-size:24px">or call Box Office Hotline at 0-2160-5999 </p>
    	<br><br><br><br>
		<div class="content-next clear" style="text-align:center">  
 		 <a href="{{URL::to("kiosk/selectTicket/$movieID/$sessID")}}"><img src="{{asset("images/btn_seat_prev.png")}}" width="120" height="46"></a> &nbsp; &nbsp; &nbsp; </div> <br>
<br>
<br>

  @include('kiosk.incFooter')
</div> 
@include('kiosk.incScriptBottom') 
</body>
</html>