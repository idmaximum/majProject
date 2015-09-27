<?php
	
	$userSessionID = $_POST['userSessionID'];// 01WWW14091716554633900001
	$movieName = $_POST['movieName'];		// Ninja
	$timeShowing =  $_POST['timeShowing'];	// 2014-09-17 16:55:46
	$theatreName =  $_POST['theatreName'];	// Theater 1
 	$priceTotal =  $_POST['priceTotal'];			// 1000

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
	
	//***************
		//****************
	function str_replace_text($word){
	      $strwordArr = array("#",":"," ","'","/","\"","-","--") ;
		#  $strwordArr = array("#",":"," ") ;
		  $strCensor = " " ;
		  $num  = 50;
		  	if(strlen($word) >= $num ) {
				$word = iconv_substr($word, 0, $num,"UTF-8")."";				
				foreach ($strwordArr as $value) {
				  $word = str_replace($value,$strCensor ,$word);
				}
				
			}else{ 		  
				foreach ($strwordArr as $value) {
				  $word = str_replace($value,$strCensor ,$word);
				}
			  } #ens if
			  
		  return ( $word) ;
	 }	
	
	 function strCrop($txt,$num) { #ข้อความ,จำนวน
		if(strlen($txt) >= $num ) {
			$txt = iconv_substr($txt, 0, $num,"UTF-8")."...";
		}
		return $txt;
	}
    $movieName =  str_replace_text($movieName);
  	 $movieName =  strCrop($movieName,16);
	//***************

    $connection = mysql_connect("10.121.128.10", "embassy", "embassy@2014");
    mysql_query("SET NAMES 'utf8'");

    $logTable = "";

    if ($connection)
    {
        $logTable = "log_vistaws_20" . substr($userSessionID, 5, 2) . "_" . substr($userSessionID, 7, 2);

        $db = mysql_select_db("www_embassycineplex_com");
        $updateQuery = "UPDATE `www_embassycineplex_com`.`$logTable` SET `order_payment` = 'PAYMENT',
                                                                    `order_status` = 'WAIT',
                                                                    `cname` = '$name',
                                                                    `email` = '$email',
                                                                    `phone` = '$phone'
                                                                    WHERE user_session_id = '$userSessionID'";
        mysql_query($updateQuery);
    }

    mysql_close($connection);
	
	 include 'security.php' ;	
 
?><html>
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
<form action="payment_confirmationMoblie.php" method="post" id="formSubmit"/>
    <?php
     /*   foreach($params as $name => $value) {
            echo "<input type=\"hidden\" id=\"" . $name . "\" name=\"" . $name . "\" value=\"" . $value . "\"/>\n";
        }
        echo "<input type=\"hidden\" id=\"signature\" name=\"signature\" value=\"" . sign($params) . "\"/>\n";*/
    ?>
	
      			<input type="hidden" name="transaction_uuid" value="<?php echo uniqid() ?>">
                <input type="hidden" name="signed_field_names"
               value="access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency">
                <input type="hidden" name="unsigned_field_names" size="40" value="ship_to_address_line1,bill_to_forename,bill_to_phone,bill_to_email,bill_to_company_name,bill_to_address_line1,bill_to_address_line2,bill_to_address_city,bill_to_address_state,bill_to_address_postal_code,bill_to_address_country,bill_to_surname">
                <input type="hidden" name="ship_to_address_line1" size="60" value="<?php echo $movieName;?> | <?php echo date('d F Y', strtotime( $timeShowing)) ;?> (<?php echo date('H:i', strtotime( $timeShowing))?>)">
                <input type="hidden" name="bill_to_forename" size="60" value="<?php echo $name;?>" id="bill_to_forename">
                <input type="hidden" name="bill_to_surname" size="60" value="EDS" id="bill_to_surname" >
                <input type="hidden" name="bill_to_phone" size="60" value="<?php echo $phone;?>" id="bill_to_phone">
                <input type="hidden" name="bill_to_email" size="60" value="<?php echo $email;?>" id="bill_to_email"> 
                
                
                <input type="hidden" name="bill_to_address_postal_code" size="60" value="10330">
                <input type="hidden" name="bill_to_address_state" size="60" value="Bangkok">
                <input type="hidden" name="bill_to_address_city" size="60" value="Pathumwan">
                <input type="hidden" name="bill_to_address_line1" size="60" value="6th Floor , Central Embassy 1031">
                <input type="hidden" name="bill_to_address_line2" size="60" value="Ploenchit road">
                <input type="hidden" name="bill_to_company_name" size="60" value="Executive Cinema Corporation">
                <input type="hidden" name="transaction_type" size="25" value="sale">
                <input type="hidden" name="bill_to_address_country" size="60" value="TH">
                <input type="hidden" name="currency" size="25" value="THB">
                <input type="hidden" name="reference_number" size="40" value="<?php echo $userSessionID;?>">
                <input type="hidden" name="userSessionID"value="{{$userSessionID}}" id="userSessionID">
                <input type="hidden" name="amount" size="25" value="<?php echo $priceTotal;?>">
                <input type="hidden" name="signed_date_time" value="<?php echo gmdate("Y-m-d\TH:i:s\Z"); ?>">
                <input type="hidden" name="locale" value="en">
                <input name="website" type="text" class="url">
                <input name="theatreName" type="hidden" value="<?php echo $theatreName;?>">
                <input name="timeShowing" type="hidden" value="<?php echo $timeShowing;?>">
                <input name="movieName" type="hidden" value="<?php echo $movieName;?>">
                
                 <input type="hidden" name="access_key" value="cbed4a5d2e2d325a8bda05d0722f44bf">
                <input type="hidden" name="profile_id" value="8EC01B2E-D8F7-449E-8054-2C32C4D2B4CA">
   <?php /**/ ?> 

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
