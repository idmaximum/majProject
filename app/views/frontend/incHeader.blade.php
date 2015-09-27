<?php $filename = Request::path(); ?>
<div style="width:100%; text-align:center; background: rgba(0,0,0,0.2); border-bottom:solid 1px #414242" class="top__downloads">
<div style="width:1024px; margin:auto; font-size:16px; " class="txtBrown18_2">
<table width="1024" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="95" height="60" align="left" valign="middle">Follow us on</td>
      <td height="60" align="left" valign="middle">
      <a href="https://www.facebook.com/embassycineplex" target="_blank"><img src="{{asset('images/icon_top_fb.png')}}" class="hoverImg08"></a>&nbsp;
      <a href="https://www.twitter.com/embassycineplex" target="_blank"><img src="{{asset('images/icon_top_tw.png')}}" class="hoverImg08"></a>&nbsp;
      <a href="http://instagram.com/embassyscreens" target="_blank"><img src="{{asset('images/icon_top_ig.png')}}" class="hoverImg08"></a>&nbsp;
      <a href="http://www.youtube.com/user/embassycineplex" target="_blank"><img src="{{asset('images/icon_top_yt.png')}}" class="hoverImg08"></a></td>
      <td height="60" align="right" valign="middle"> Get Embassy Screens app on </td>
      <td width="245" height="60" align="right" valign="middle"><a href="https://itunes.apple.com/th/app/embassy-screens/id882209348?mt=8" target="_blank"><img src="{{asset('images/download_appstore.png')}}" class="hoverImg08"></a>&nbsp;&nbsp;<a href="https://play.google.com/store/apps/details?id=th.co.invp.EmbassyActivity&hl=en" target="_blank"><img src="{{asset('images/download_googleplay.png')}}" class="hoverImg08"></a></td>
    </tr>
  </tbody>
</table>
</div>
</div>
<div id="header" >
  <div id="divlogo" class="content-main"> <a href="{{URL::to('/')}}"><img src="{{asset('images/logo.png')}}" width="171" height="124" alt="Embassy" class="hoverImgLogo"></a> </div>
  <div class="menuTop">
    <div class="content-main on_mobile__h">
      <ul>
        <li <?php echo ($filename  == "/")? "class=\"select\"" : "";?>><a href="{{URL::to('/')}}">Today</a></li>
        <li <?php echo ($filename =="advancebooking")? "class=\"select\"" : "";?>><a href="{{URL::to('advancebooking')}}">Advance Booking</a></li>
        <li <?php echo ($filename =="comingsoon")? "class=\"select\"" : "";?>><a href="{{URL::to('comingsoon')}}">Coming soon</a></li>
        <li <?php echo ($filename =="information")? "class=\"select\"" : "";?>><a href="{{URL::to('information')}} ">information</a></li>
        <?php   /* <li <?php echo ($filename =="contactus")? "class=\"select\"" : "";?>><a href="{{URL::to('contactus')}} ">CONTACT US</a></li> */ ?>
        <li <?php echo ($filename =="promotion" || $filename =="promotionDetail")? "class=\"select\"" : "";?>><a href="{{URL::to('promotion')}}">promotion</a></li>
        <li <?php echo ($filename =="event_activity" || $filename =="event_activityDetail.php")? "class=\"select\"" : "";?>><a href="{{URL::to('event_activity')}}">Event &amp; Activity</a></li>
      </ul>
      <div class="wrapper-demo on_mobile__h">
        <div id="dd" class="wrapper-dropdown-2" tabindex="1">EN
          <ul class="dropdown">
          <?php if($filename !="selectSeats"){?>  <li><a href="{{URL::to("th/"."$filename")}}">TH</a></li><?php }?>
        <?php   /* <li><a href="#">CN</a></li>*/?>
          </ul>
        </div>
      </div>
    </div>
    
    <div class="content-main on_mobile__s">
      <ul>
        <li <?php echo ($filename  == "/")? "class=\"select\"" : "";?>><a href="{{URL::to('/')}}">Today</a></li>
        <li <?php echo ($filename =="advancebooking")? "class=\"select\"" : "";?>><a href="{{URL::to('advancebooking')}}">Advance Booking</a></li>
        <li <?php echo ($filename =="comingsoon")? "class=\"select\"" : "";?>><a href="{{URL::to('comingsoon')}}">Coming soon</a></li>
        </ul>
       
    </div>
  </div>
</div>