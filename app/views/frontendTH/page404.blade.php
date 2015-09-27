<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>404 Embassy Diplomat Screens by AIS</title>
<meta property="og:image" content="http://www.embassycineplex.com/images/share.jpg" />
{{HTML::style('css/reset.css')}}
{{HTML::style('css/font.css')}}
{{HTML::style('css/screen.css')}}
{{HTML::style('css/screen2.css')}}
{{HTML::style('css/screen2.css')}}
{{HTML::style('css/screenInside.css')}}
{{HTML::style('css/infomation.css')}}
{{HTML::style('js/DropDown/css/style.css')}}
@include('frontend.incScriptTop')
<style type="text/css">
#divLandingPage {
	position: fixed;
	width: 100%;
	height: 100%;
	z-index: 9999999;
	left: 0;
	top: 0;
	background-color: #000;
}
</style>
</head>
<body>
<?php 
	$dateNow = date('Y-m-d 06:00'); 
	$dateHrNow = date('Y-m-d H:i');   
?>
<?php  if (Session::get('landingPage') == ''){  ?>
<div id="mainTopLanding">
<div id="divLandingPage">
  <div class="divCrop">
    <div class="contentLandingPage"><span id="buttonLanding" class="buttonText"></span></div>
  </div>
</div>
</div>
<?php 
	$sessionDate = md5($dateNow);
	Session::put('landingPage', $sessionDate);
 }
?> 
<div id="main">
  @include('frontend.incHeader')  
    @foreach($rowData as $rowDetail)
   	 <div id="content" class="content-main">
   <?php   /*<div class="page-information">
        <h1 class="showToday">Information</h1> 
         <div id="head-information"> 
           <p class="txtGold30">&nbsp;</p>
           <div class="txtBrown14_2">{{nl2br($rowDetail->pages_infomation)}}</div>
           <p class="txtWhite18">&nbsp;</p>
         </div> 
      </div>*/ ?>
      ERROR 404
    </div> 
    @endforeach
  @include('frontend.incFooter')
</div> 
@include('frontend.incScriptBottom') 
</body>
</html>