<!--[if lt IE 8]>
    <script src="https://www.embassycineplex.com/js/jquery-1.8.js"></script>
<![endif]-->
<!--[if lt IE 9]> 
    <script src="https://www.embassycineplex.com/js/jquery-1.9.1.min.js"></script>
<![endif]--> 
<script src="https://www.embassycineplex.com/js/jquery-2.0.2.min.js"></script>
<script src="https://www.embassycineplex.com/js/timeTo/jquery.timeTo.min.js"></script> 
<script type="text/javascript">
 function closeOpenedWindow(){    
     window.open('','_parent','');
     window.close();
	 window.open('','_self',''); window.close(); 
}
jQuery(function() {
	jQuery( "#buttonLanding" ).click(function() {	jQuery("#mainTopLanding").fadeOut(500);});
	jQuery(document).click(function() {jQuery('.wrapper-dropdown-2').removeClass('active');});
	jQuery(document).bind("contextmenu",function(e){ return false;});
 	// jQuery('.btnHome').click(function () {	closeOpenedWindow()	});   
	
	var box1 = document.getElementById('logoKioskFooter')

	 box1.addEventListener('touchstart', function(e){
		  var win = window.open('', '_self');
  		  win.close();return false;
	 }, false)
 
	jQuery('#clock-1').timeTo({ 
		   fontFamily: "'mongolian_baitiregular',Sans-Serif, Arial, Helvetica",
		  displayCaptions: true,
		  fontSize: 50,
		  captionSize: 16
	  }); 
 
});   
</script>