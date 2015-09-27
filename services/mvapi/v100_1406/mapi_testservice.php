<?php
  $userSessionID = '02WWW14072223243355785686';

  $homepage = file_get_contents('http://10.121.128.11/getUserIDToSendMail?user_session_id='.$userSessionID);
  //echo $homepage;
 
?>