<?php
	$checkBot = $_POST['website'];
	$bill_to_forename	= $_POST['cname']; 
	 $userSessionID	= $_POST['reference_number']; 
	
	if($checkBot == '' && $bill_to_forename != '' && $userSessionID != ''){
	include 'security.php' ;	  
	
	$theatreName	= $_POST['theatreName']; 
	$timeShowing	= $_POST['timeShowing'];  
	 $movieName		= $_POST['movieName'];  
	
	
	$seatsFromSeatTable	= $_POST['seatsFromSeatTable']; 
	$sessID			= $_POST['sessID']; 
	$seatPosition	= $_POST['seatPosition'];	
	$selectedSeats	= $_POST['selectedSeats'];	 
	$bill_to_phone	= $_POST['mobile']; 
	$bill_to_email	= $_POST['email']; 
	
	$valueInCents	= $_POST['valueInCents'];
	$SeatPrice	 	= 	substr("$valueInCents", 0, -2);
	
	$ticketList = array();
	$ticketName = array();
	$ticketPrice = array(); 
	$selectedSeats = array();
	
	$seatsWillSelected = json_decode($seatsFromSeatTable, true);
	
	//******************
   $transaction_uuid['bill_to_forename']	= $bill_to_forename;
   $transaction_uuid['bill_to_phone']		= $bill_to_phone;
   $transaction_uuid['bill_to_email']		= $bill_to_email;
	 
	$transaction_uuid['valueInCents']		= $SeatPrice;
	$transaction_uuid['transaction_uuid']	= $_POST['transaction_uuid'];		
	
	$paymentRequest =  json_encode($transaction_uuid);
	//******************
	
 		$wsdl = "http://10.121.130.25/WSVistaWebClient/TicketingService.asmx?WSDL"; 
	   //$wsdl = "http://10.100.101.146/WSVistaWebClient/TicketingService.asmx?WSDL";  
	
	$client = new SoapClient($wsdl, array('trace' => true)); 	
	
	foreach ($seatsWillSelected as $seat) 
	{
		$selectedSeats['SelectedSeat'][] = array(	'AreaCategoryCode'	=> $seat['AreaCategoryCode'],
													'AreaNumber'		=> $seat['Position']['AreaNumber'],
													'RowIndex'			=> $seat['Position']['RowIndex'],
													'ColumnIndex'		=> $seat['Position']['ColumnIndex']);
	}
	
	$params = array(	'OptionalClientClass'			=> "WWW",
						'OptionalClientId' 				=> "111.111.111.112", 
						'OptionalClientName'			=> "WEB",
						'CinemaId'						=> "0000008001",
						'SessionId'						=> $sessID,
						'UserSessionId'					=> $userSessionID,
						'ReturnOrder'					=> true,
						'SelectedSeats'					=> $selectedSeats);
	
	$result = $client->__soapCall('SetSelectedSeats', array($params));
	
	$setSeatResult = $result->Result;
	$setSeatRequest = json_encode($params);
	$setSeatResponse = json_encode($result->Order->Sessions->Session->Tickets->Ticket);
	
	//****************
	$connection = mysql_connect("10.121.128.10", "embassy", "embassy@2014");
	mysql_query("SET NAMES 'utf8'");
	
	$logExists = false;
	$logTable = "";
	
	if ($connection)
	{
	 
		$logTable = "log_vistaws_" . date('Y_m');	
		$db = mysql_select_db("www_embassycineplex_com"); 	 
	
		$updateQuery = "UPDATE `www_embassycineplex_com`.`$logTable` SET `soap_process` = CONCAT(`soap_process`, ', SetSelectedSeats'),
																	`status` = '$setSeatResult',
																	`order_payment` = 'PAYMENT',
																	`order_status` = 'WAIT',																	
																	`amount` = '$SeatPrice',
																																		
																	`theater` = '$theatreName',
																	`movie` = '$movieName',
																	`show_time` = '$timeShowing',
																	
																	`cname` = '$bill_to_forename',
																	`email` = '$bill_to_email',
																	`phone` = '$bill_to_phone',
																	`channel` = 'WEB', 
																	
																	`seat` = '$seatPosition',	
																	`payment_request` = '$paymentRequest',																
																	`setselectedseat_request` = '$setSeatRequest',
																	`setselectedseat_response` = '$setSeatResponse' 
																	WHERE user_session_id = '$userSessionID'";
																	
																 
		mysql_query($updateQuery);/**/
	}else{
		echo 'No Connect Database';
	}
	
	mysql_close($connection);
	//****************
	
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
   <script src="https://www.embassycineplex.com/js/jquery-1.8.js"></script>
<![endif]-->
<!--[if lt IE 9]>
    <script src="https://www.embassycineplex.com/js/jquery-1.9.1.min.js"></script>
<![endif]--> 
<script src="https://www.embassycineplex.com/js/jquery-2.0.2.min.js"></script>
<script type="text/javascript">
  //document.getElementById('formSubmit').submit(); // SUBMIT FORM  
 jQuery(function(){ 
	 jQuery('#formSubmit').submit();
 });  
</script>
</body>
</html>
<?php }else{ 
header( "location: https://www.embassycineplex.com" );
exit(0);}#end exit?>