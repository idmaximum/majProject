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
{{HTML::style('css/infomation.css')}}
{{HTML::style('js/DropDown/css/style.css')}}
{{HTML::style('js/bxslider/jquery.bxslider_info.css')}}
@include('frontendTH.incScriptTop')
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
 
<?php 
	$sessionDate = md5($dateNow);
	Session::put('landingPage', $sessionDate);
 }
?> 
<div id="main">
  @include('frontendTH.incHeader')  
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
        <h1 class="showToday">INFORMATION</h1>
    <div class="contentPage" style="background-color:#000000">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
          <tr>
            <td height="540" style="background-image:url({{asset('images/bg_info_top.jpg')}}); background-repeat:no-repeat">&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><p><span class="txtGold30">Embassy Diplomat Screens</span></p>
              <p><br>
                <span class="txtBrown18_2" style="font-style:italic"> The latest REAL-D XL projection technology together with the most advanced <br>sound system will give you the best movie experience in a class of its own.</span></p>
              <p>&nbsp;</p>
              <p><img src="images/divide_info.jpg" width="80" height="1" alt=""/></p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p></td>
          </tr>
          <tr>
            <td height="571" style="background-image:url({{asset('images/bg_hall_1.jpg')}}); background-repeat:no-repeat; background-position:top center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" class="txtGold30"><p>Theater One will redefine your movie experience<br>
                and make it one that is truly memorable.</p>
              <p>&nbsp;</p>
              <p class="txtBrown18_2">A smaller hall than the rest, it also means unmatched exclusivity. Thirty-one <br>
              seats in a variety of styles, a private bar, and headphones that provide language options, <br>
              Theatre One is a cinema with the luxury of a great living room.</p></td>
          </tr>
          <tr>
            <td height="460" align="center"><ul class="bxslider">
                <li><img src="{{asset('images/grand_sofa.png')}}" /></li>
                <li><img src="{{asset('images/large_day.png')}}" /></li>
                <li><img src="{{asset('images/couch.png')}}" /></li>
                <li><img src="{{asset('images/day_bed.png')}}" /></li>
                <li><img src="{{asset('images/loft.png')}}" /></li>
              </ul></td>
          </tr>
          <tr>
            <td height="640" style="background-image:url({{asset('images/bg_hall_2.jpg')}}); background-repeat:no-repeat">&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><p><img src="{{asset('images/cocoon.png')}}" alt="CoCoon Seat"/></p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p class="txtBrown18_2">Cocoon seats are all about maximum comfort. They are specially designed to respond to your body. <br>Forget business class plane seats. These are very much beyond.
</p>
              <p class="txtBrown18_2">&nbsp;</p>
              <p class="txtBrown18_2">&nbsp;</p>
       <?php    /*   <p class="txtBrown18_2"><img src="{{asset('images/divide_info.jpg')}}" width="80" height="1" alt=""/></p>
              <p class="txtBrown18_2">&nbsp;</p>
              <p class="txtBrown18_2">&nbsp;</p>
              <p class="txtBrown18_2" style="font-style:italic"> A great cinema experience is never without great food.<br>
            That’s why we have prepared for you special delicacies from DEAN &amp; DELUCA</p>
              <p class="txtBrown18_2" style="font-style:italic">and The Oriental Shop.             </p>*/ ?>
              <p class="txtBrown18_2" style="font-style:italic">&nbsp;</p>
              </p></td>
          </tr>
          <tr>
            <td valign="bottom" bgcolor="#1f2022"><img src="{{asset('images/bg_info_footer.jpg')}}" width="1024" height="170" alt=""/></td>
          </tr>
        </tbody>
      </table>
    </div>
    </div> 
    @endforeach
  @include('frontendTH.incFooter')
</div> 
@include('frontendTH.incScriptBottom')
<script src="http://www.embassycineplex.com/js/bxslider/jquery.bxslider.min.js"></script>
<script type="text/javascript"> 
 jQuery(function() { 
  	jQuery('.bxslider').bxSlider({auto: true, pager : true , infiniteLoop: false  });
	
  }); 
</script>
</body>
</html>