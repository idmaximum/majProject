<!--[if lt IE 8]>
    <script src="https://www.embassycineplex.com/js/jquery-1.8.js"></script>
<![endif]-->
<!--[if lt IE 9]> 
    <script src="https://www.embassycineplex.com/js/jquery-1.9.1.min.js"></script>
<![endif]-->
<script src="https://www.embassycineplex.com/js/jquery-2.0.2.min.js"></script>
<script src="https://www.embassycineplex.com/js/bootstrap.min.js"></script>
<script type="text/javascript">	
function DropDown(el) {
this.dd = el;
this.initEvents();
}
DropDown.prototype = {
initEvents : function() {
var obj = this;
obj.dd.on('click', function(event){
jQuery(this).toggleClass('active');
event.stopPropagation();
});	}
}
jQuery(function() {jQuery( "#buttonLanding" ).click(function() {	jQuery("#mainTopLanding").fadeOut(500);});
jQuery( "#divLandingPage" ).delay( 5000 ).fadeOut( 500 );var dd = new DropDown( jQuery('#dd') );
jQuery(document).click(function() {jQuery('.wrapper-dropdown-2').removeClass('active');});
});
</script>