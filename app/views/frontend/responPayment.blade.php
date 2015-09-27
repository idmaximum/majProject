<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Embassy Diplomat Screens by AIS</title>
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
</head>
<body> 
<div id="main">
  @include('frontend.incHeader')  
   	 <div id="content" class="content-main"> 
     <form action="http://10.100.101.222/WEB_V1/payment_process_vista/response" method="post" id="formSubmit" >
  		  <?php
          	foreach($allvar as $name => $value) {
				$params[$name] = $value;	 
			  }#end for 
		  ?>
          
            <?php
				foreach($params as $name => $value) {
					echo "<input type=\"hidden\" id=\"" . $name . "\" name=\"" . $name . "\" value=\"" . $value . "\"/>\n";
				}
				//echo "<input type=\"hidden\" id=\"signature\" name=\"signature\" value=\"" . sign($params) . "\"/>\n";
			?>
          <input type="hidden" name="url" id="url" value="url">  
          </form>
    </div> 
  @include('frontend.incFooter')
</div> 
@include('frontend.incScriptBottom') 
<script type="text/javascript"> 
 jQuery(function(){ 
	 jQuery('#formSubmit').submit();
 });  
</script> 
</body>
</html>