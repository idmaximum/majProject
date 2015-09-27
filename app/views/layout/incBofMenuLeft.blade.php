<div class="content-bof-left">
  <div id="wrap">
    <div class="nav-page">NAVIGATION</div>
    
   <h3 class="toggler"><a href="#theater" onfocus="this.blur();"><strong>จัดการภาพยนตร์</strong></a></h3>
    <div class="accordion">
      <ul>
        <li><a href="{{URL::to('backoffice_management/movievistait#theater')}}" onfocus="this.blur();"> <img src="{{asset('images/png/glyphicons_263_bank.png')}}" alt="" width="20" height="20" /> <span>VISTAIT Movie List</span></a></li>
          <li><a href="{{URL::to('backoffice_management/movielist#theater')}}" onfocus="this.blur();"> <img src="{{asset('images/png/glyphicons_263_bank.png')}}" alt="" width="20" height="20" /> <span>Now Showing</span></a> </li>
        <li><a href="{{URL::to('backoffice_management/comingsoonlist#theater')}}" onfocus="this.blur();"> <img src="{{asset('images/png/glyphicons_263_bank.png')}}" alt="" width="20" height="20" /> <span>Coming Soon</span></a> </li>
      </ul>
    </div> 
     <h3 class="toggler"><a href="#alertme" onfocus="this.blur();"><strong>Alert Me</strong></a></h3>
    <div class="accordion">
      <ul>
        <li><a href="{{URL::to('backoffice_management/emailsubmitted#alertme')}}" onfocus="this.blur();"> <img src="{{asset('images/png/glyphicons_263_bank.png')}}" alt="" width="20" height="20" /> <span>รายชื่อผู้ส่ง Alert Me</span></a> </li>
        
       
      </ul>
    </div> 
    
    <h3 class="toggler"><a href="#content" onfocus="this.blur();"><strong>เมนูหลัก | Content Management </strong></a></h3>
    <div class="accordion">
      <ul>
       
        <li><a href="{{URL::to('backoffice_management/news#content')}}" onfocus="this.blur();"> <img src="{{asset('images/png/glyphicons_029_notes_2.png')}}" alt="" width="15" height="20" /> <span> News &amp; Event</span></a> </li> 
         <li><a href="{{URL::to('backoffice_management/promotion#content')}}" onfocus="this.blur();"> <img src="{{asset('images/png/glyphicons_029_notes_2.png')}}" alt="" width="15" height="20" /> <span>Promotion</span></a> </li> 
       
         <li><a href="{{URL::to('backoffice_management/contact#content')}}" onfocus="this.blur();"> <img src="{{asset('images/png/glyphicons_029_notes_2.png')}}" alt="" width="15" height="20" /> <span>Contact us</span></a> </li> 
         
      <li><a href="{{URL::to('backoffice_management/banner#content')}}" onfocus="this.blur();" > <img src="{{asset('images/png/glyphicons_029_notes_2.png')}}" alt="" width="15" height="20" /> <span>Banner</span></a> </li>
       <?php /*
	     <li><a href="{{URL::to('backoffice_management/information#content')}}" onfocus="this.blur();"> <img src="{{asset('images/png/glyphicons_029_notes_2.png')}}" alt="" width="15" height="20" /> <span>Information</span></a> </li> <li><a href="{{URL::to('backoffice_management/pages#content')}}" onfocus="this.blur();"> <img src="{{asset('images/png/glyphicons_029_notes_2.png')}}" alt="" width="15" height="20" /> <span>Create Pages</span></a> </li> */ ?>
      </ul>
    </div>
    
    <h3 class="toggler"><a href="#syncContent" onfocus="this.blur();"><strong>Update Sync Content</strong></a></h3>
    <div class="accordion">
      <ul> 
        <li><a href="#" onfocus="this.blur();" id="syncFileServer"> <img src="{{asset('images/png/glyphicons_081_refresh.png')}}" alt="" width="20" /><span>Update Sync File</span></a> </li>   
        <li><a href="#" onfocus="this.blur();" id="syncUpdateShowtime"> <img src="{{asset('images/png/glyphicons_081_refresh.png')}}" alt="" width="20" /><span>Update Showtime</span></a> </li>   
        
      </ul>
    </div>
    
    <h3 class="toggler"><a href="#admin" onfocus="this.blur();"><strong>ผู้ดูแลระบบ</strong></a></h3>
    <div class="accordion">
      <ul>
       
        <li><a href="{{URL::to('backoffice_management/staff#admin')}}" onfocus="this.blur();"> <img src="{{asset('images/png/glyphicons_003_user.png')}}" alt="" width="23" height="22" /> <span>เจ้าหน้าที่ / STAFF</span></a> </li>  
    	<?php if (Auth::check()){?>
        <li>xxxxxxxxxxxxx</li>
       <?php  } ?>
      </ul>
    </div> 
  </div>
</div> 