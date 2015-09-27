<?php
	 include 'security.php' ;	
		
	foreach($_REQUEST as $name => $value) {
		$params[$name] = $value;	 
	  }#end for 
	
?>
<html>
<head>
<title>Embassy Diplomat Screens by AIS</title>
<link rel="stylesheet" type="text/css" href="payment.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
body {
   font-family:Arial, Helvetica, sans-serif;
	font-size:14px
}
</style> 
</head> 
<body>
<div style="text-align:center; padding:50px">ระบบกำลังดำเนินการ กรุณารอสักครู่<br>
Please wait while your action is being processed </div> 
<form action="https://secureacceptance.cybersource.com/pay " method="post" id="formSubmit"/>
    <?php
        foreach($params as $name => $value) {
            echo "<input type=\"hidden\" id=\"" . $name . "\" name=\"" . $name . "\" value=\"" . $value . "\"/>\n";
        }
        echo "<input type=\"hidden\" id=\"signature\" name=\"signature\" value=\"" . sign($params) . "\"/>\n";
    ?>
	 
</form>
<!--[if lt IE 8]>
   <script src="http://www.embassycineplex.com/js/jquery-1.8.js"></script>
<![endif]-->
<!--[if lt IE 9]>
    <script src="http://www.embassycineplex.com/js/jquery-1.9.1.min.js"></script>
<![endif]--> 
<script src="http://www.embassycineplex.com/js/jquery-2.0.2.min.js"></script>
<script type="text/javascript">
  //document.getElementById('formSubmit').submit(); // SUBMIT FORM  
 jQuery(function(){ 
	 jQuery('#formSubmit').submit();
 });  
</script>
</body>
</html>