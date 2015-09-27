<?php 
	if(Session::get('_EMAIL') == "" || Session::get('_GRPID') == "" || Session::get('_ID') == "" ){ 
		header("Location: login");
		exit();
	}/**/
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Backoffice' Central embassy</title>
{{HTML::style('css/font.css')}}
{{HTML::style('js/bootstrap/css/bootstrap.css')}}
{{HTML::style('js/bootstrap/css/bootstrap-theme.css')}}
{{HTML::style('css/css-bof.css')}}
{{HTML::style('js/accordion/style.css')}}
{{HTML::style('js/formValidator/css/validationEngine.jquery.css')}}
@include('layout.incBofHeaderTop')
</head>
<body>
<div id="main">  
  @include('layout.incBofHeader')
  <div class="content">
  @include('layout.incBofMenuLeft') 
  @include('layout.incScript') 
  <div class="content-bof-right">
    @yield('content')
  </div> 
  </div>
  <p class="clear"></p>  
</div>
<script type="text/javascript">
	jQuery('#syncFileServer').click(function (e) {
			jQuery.ajax({
				url : '{{URL::to("backoffice_management/syncServer#syncContent")}}', 
					type:"GET", cache: false, 	  	
					success :function(data){
						alert('Sync File Complate'); 
				 }
			});    
	  });  
	  jQuery('#syncUpdateShowtime').click(function (e) {
			jQuery.ajax({
				url : 'http://www.embassycineplex.com/service_get_data/getDataMovie.php', 
					type:"GET", cache: false, 	  	
					success :function(data){
						alert('Update Showtime Complate'); 
				 }
			});    
	  });  
</script>

</body>
</html>