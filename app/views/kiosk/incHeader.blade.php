<?php $filename = Request::path(); ?>
<div id="header-main">
  <div id="header" >
    <div id="divlogo" class="content-main"> 
    	<a href="{{URL::to('kiosk/')}}"><img src="{{asset('images/logo-kiosk.png')}}" width="342" height="123" alt="Embassy" class="hoverImgLogo" id="logoKiosk"></a> 
    	<div id="clock-1"></div>
    </div>
    <div class="menuTop">
      <div class="content-main">
        <ul>
          <li <?php echo ($filename  == "kiosk/" || $filename  == "kiosk")? "class=\"select\"" : "";?>><a href="{{URL::to('kiosk/')}}">Today</a></li>
          <li <?php echo ($filename =="kiosk/advancebooking")? "class=\"select\"" : "";?>><a href="{{URL::to('kiosk/advancebooking')}}">Advance Booking</a></li>
          <li <?php echo ($filename =="kiosk/comingsoon" )? "class=\"select\"" : "";?>><a href="{{URL::to('kiosk/comingsoon')}}">Coming soon</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>