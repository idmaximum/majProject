<?php 
	$userSessionID = '01WWW14062118202141500001';
	
	//01WWW14062118202141500001
	$params = array(	'OptionalClientClass'	=> "WWW",
					'OptionalClientId' 		=> "111.111.111.112", 
					'OptionalClientName'	=> "WEB",
					'UserSessionId'			=> $userSessionID);

echo "<br /><br />";					
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ******** ********<br />";
echo "******** CancelOrder Below ********" . "<br /><br />";

  json_encode($params) . "<br /><br />";
$result = $client->__soapCall('CancelOrder', array($params));

echo json_encode($result);
?>