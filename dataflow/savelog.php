<?php

$connection = mysql_connect("10.100.101.236", "embassy", "embassy@2014"); //!Qq73q3n
mysql_query("SET NAMES 'utf8'");

if ($connection)
{
  $logDB = "log_VistaWS_" . date('Y_m');

  $db = mysql_select_db("www_embassycineplex_com");
  $tableList = mysql_query("SHOW TABLES FROM www_embassycineplex_com WHERE Tables_in_www_embassycineplex_com LIKE '$logDB'");

  if (mysql_num_rows($tableList))
  {

  }
  else
  {
  	$createQuery = "CREATE TABLE  	`$logDB` (
 									`log_id` INT NOT NULL ,
 									`date_time` DATETIME NOT NULL ,
 									`soap_process` VARCHAR( 100 ) NOT NULL ,
                  `email` VARCHAR( 100 ) NOT NULL ,
                  `phone` VARCHAR( 15 ) NOT NULL ,
                  `channel` VARCHAR( 5 ) NOT NULL ,
                  `status` VARCHAR( 20 ) NOT NULL ,
                  `amount` INT NOT NULL ,
                  `theater` VARCHAR( 20 ) NOT NULL ,
                  `movie` VARCHAR( 200 ) NOT NULL ,
                  `show_time` DATETIME NOT NULL ,
                  `qty` INT NOT NULL ,
                  `seat` VARCHAR( 100 ) NOT NULL ,
                  `merchance_id` VARCHAR( 30 ) NOT NULL ,
                  `user_session_id` VARCHAR( 30 ) NOT NULL ,
 									`vista_request` VARCHAR( 1000 ) NOT NULL ,
 									`vista_response` VARCHAR( 1000 ) NOT NULL) ENGINE = MYISAM";

	$createSuccess = mysql_query($createQuery);

	if ($createSuccess) 
	{
		echo "Success";
	}
	else
	{
		echo "Fail";
	}
  }
}

mysql_close($connection);

?>