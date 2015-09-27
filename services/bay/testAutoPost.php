<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Major</title>
</head>

<body>
<form action="testRespon.php" method="post" id="formSubmit">
	<input type="hidden" name="uid"  id="uid"value="11111"> 
    <input type="hidden" name="name" id="name" value="Test Name"> 
	<input type="hidden" name="amount" id="name" value="8">     
</form>



<script src="http://www.majorcineplex.com.kh/cinema/js/jquery.js"></script>
<script type="text/javascript">
 jQuery(function(){ 
	 jQuery('#formSubmit').submit();
 });  
</script>
</body>
</html>