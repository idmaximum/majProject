@foreach($movie_DataDetail as $movie)
 <?php
	$movieID =	$movie->movieID;  
	$sessID = $movie->showtime_Session_strID; 
	 $config_path = "https://www.embassycineplex.com";
 ?>
@endforeach<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Embassy Diplomat Screens by AIS</title>
<meta name="description" content="Embassy Diploment Screens" />
<meta name="keywords" content="embassy, diplomat, ais, central, ดูหนัง, หนังใหม่, โรงหนัง, โรงภาพยนตร์"/>
<meta property="og:image" content="http://www.embassycineplex.com/images/share.jpg" />
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/reset.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/font.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/screen.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/screen2.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/screenInside.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/css/infomation.css">
<link media="all" type="text/css" rel="stylesheet" href="{{$config_path}}/js/DropDown/css/style.css">
@include('frontend.incScriptTop')
</head>
<body>
<div id="main">
@include('frontend.incHeader')
<div id="content" class="content-main" style="padding:40px 0 0 0">
  <div style="padding:60px; background-color:#101010;border: 1px solid #3e3e3e;">
    <p class="txtRed24" style="text-align:center; font-size:22px"> <img src="{{asset("images/ic_cancel_order.png")}}"  alt="Cancel order"></p><br>    
    <p class="txtRed24 " style="text-align:center; font-size:22px">Your purchase has been cancelled</p>
    <p>&nbsp;</p>
    <p><br>    </p>
    <p class="txtBrown18_2" style="text-align:center; font-size:18px">For more information at Tel. 02-160-5999</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <div class="content-next clear" style="text-align:center">  
 		 <a href="{{URL::to("selectTicket/$movieID/$sessID")}}"><img src="{{asset("images/btn_seat_prev.png")}}" width="120" height="46"></a> &nbsp; &nbsp; &nbsp; </div>
  </div>
  <p class="clear" style="height:40px"></p>
  @include('frontend.incFooter') </div>
@include('frontend.incScriptBottom')
</body>
</html>