<?php

$connection = mysql_connect("10.121.128.10", "embassy", "embassy@2014");
mysql_query("SET NAMES 'utf8'");

if ($connection)
{
  $db = mysql_select_db("www_embassycineplex_com");
  
  $movieList = mysql_query("SELECT * FROM `www_embassycineplex_com`.`raw_GetMovieShowTimes`");
  
  $movies = array();
  
  while ($eachMovie = mysql_fetch_assoc($movieList))
  {
  	$movies[] = $eachMovie;
  }
  /*
  if (	mysql_query("DELETE FROM `www_embassycineplex_com`.`movie_showtimes` WHERE `showtime_ID` != 0") && 
  		mysql_query("ALTER TABLE `www_embassycineplex_com`.`movie_showtimes` AUTO_INCREMENT = 1"))
  {
    echo "table cleared" . "<br />";
  }
  */
  foreach ($movies as $movie)
  {
    $matches = array();
    $regexRet = preg_match('/.*\((.*)\)/', $movie['MOVIE_STRNAME'], $matches);
    
    $movieNameEN = $movie['MOVIE_STRNAME'];
    $movieSystem = "";
  
    if ($regexRet)
    {
      $movieNameEN = preg_replace('/\((.*)\)/', '', $movie['MOVIE_STRNAME']);
      $movieSystem = $matches[1];
    }
    
    $regexRet = preg_match('/.*\((.*)\)/', $movie['MOVIE_STRNAME_2'], $matches);
    
    $movieNameTH = $movie['MOVIE_STRNAME_2'];
    
    if ($regexRet)
    {
      $movieNameTH = preg_replace('/\((.*)\)/', '', $movie['MOVIE_STRNAME_2']);
    }
    
    $wsdl = "http://10.121.130.25/WSVistaWebClient/DataService.asmx?WSDL"; 
	$client = new SoapClient($wsdl, array('trace' => true)); 

	$params = array('CinemaId' 	=> $movie['CINEMA_STRID'], 
					'SessionId' => $movie['SESSION_STRID']);

	$result = $client->__soapCall('GetSessionInfo', array($params));

	$parser = xml_parser_create();
	xml_parse_into_struct($parser, $result->DatasetXML, $values, $index);
	xml_parser_free($parser);

	$isInTable = false;
	$nSession = 0;
	$sessions = array();

	foreach($values as $value)
	{
	  if($value['type'] == 'open' || $value['type'] == 'close' || $value['type'] == 'complete')
	  {
		if ($value['tag'] == 'TABLE' && $value['type'] == 'open')
		{
		  $isInTable = true;
		}
		if ($value['tag'] == 'TABLE' && $value['type'] == 'close')
		{
		  $isInTable = false;
		  $nSession++;
		}
	
		if ($isInTable && $value['tag'] != 'TABLE')
		{
			if (array_key_exists('value', $value))
			{
			  $sessions[$nSession][$value['tag']] = $value['value'];
			}
			else
			{
			  $sessions[$nSession][$value['tag']] = $value['tag'];
			}
		}
	  }
	}

    $numRowQuery = mysql_query("SELECT showtime_Session_strID FROM `www_embassycineplex_com`.`movie_showtimes` WHERE showtime_Session_strID = '{$movie['SESSION_STRID']}'");
    
    $nRow = mysql_num_rows($numRowQuery);
  
    if ($nRow == 0)
    {
      $strSQL = "INSERT INTO `www_embassycineplex_com`.`movie_showtimes` (`showtime_ID`, 
      																	`showtime_Movie_strID`, 
      																	`showtime_Movie_strName`, 
      																	`showtime_Session_strID`, 
      																	`showtime_dtmDate_Time`, 
      																	`showtime_decSeats_Available`, 
      																	`showtime_strSeatAllocation_On`, 
      																	`showtime_Price_strGroup_Code`, 
      																	`showtime_bytNum`, 
      																	`showtime_strName`, 
      																	`showtime_intRemoteSalesCutoff`, 
      																	`showtime_soundAttributes`, 
      																	`showtime_SystemType`) 
      																	VALUES (
      																	NULL, 
      																	'{$movie['MOVIE_STRID']}', 
      																	'$movieNameEN', 
      																	'{$movie['SESSION_STRID']}', 
      																	'{$movie['SESSION_DTMDATE_TIME']}', 
      																	'{$movie['SESSION_DECSEATS_AVAILABLE']}', 
      																	'{$movie['SESSION_STRSEATALLOCATION_ON']}', 
      																	'{$movie['PRICE_STRGROUP_CODE']}', 
      																	'{$movie['SCREEN_BYTNUM']}', 
      																	'{$movie['SCREEN_STRNAME']}', 
      																	'{$movie['SCREEN_INTREMOTESALESCUTOFF']}', 
      																	'{$movie['SESSION_STRATTRIBUTES']}', 
      																	'{$sessions[0]['FORMAT_STRCODE']}');";
      $query = mysql_query($strSQL);

      echo "add " . ($query? "finish":"fail") . "<br />";
    }
    else
    {
        echo "showtime exists<br />";
    }
  }
}

mysql_close($connection);

?>