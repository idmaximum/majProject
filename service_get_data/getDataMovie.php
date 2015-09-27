<?php

//$wsdl = "http://10.121.130.25/WSVistaWebClient/DataService.asmx?WSDL"; 
$wsdl = "http://10.100.101.146/WSVistaWebClient/DataService.asmx?WSDL"; 
 
$client = new SoapClient($wsdl, array('trace' => true)); 

$params = array('OptionalCinemaId' 			=> "0000000003", # 0000000001_0000008003
				'OptionalOrderByOperator' 	=> false,
				'OptionalBizStartTimeOfDay' => 0,
				'OptionalIncludeGiftStores' => false);

$result = $client->__soapCall('GetMovieList', array($params));

$parser = xml_parser_create();
xml_parse_into_struct($parser, $result->DatasetXML, $values, $index);
xml_parser_free($parser);

$isInTable = false;
$nMovie = 0;
$movies = array();

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
      $nMovie++;
    }
    
    if ($isInTable && $value['tag'] != 'TABLE')
    {
    	if (array_key_exists('value', $value))
    	{
    	  $movies[$nMovie][$value['tag']] = $value['value'];
    	}
    	else
    	{
    	  $movies[$nMovie][$value['tag']] = $value['tag'];
    	}
    }
  }
}

//$connection = mysql_connect("10.121.128.10", "embassy", "embassy@2014");
$connection = mysql_connect("10.100.101.236", "embassy", "embassy@2014");
mysql_query("SET NAMES 'utf8'");

if ($connection)
{
  $db = mysql_select_db("www_embassycineplex_com");
  
  if (mysql_query("TRUNCATE `www_embassycineplex_com`.`raw_GetMovieList`"))
  {
    echo "table cleared" . "<br />";
  }
  
  foreach ($movies as $movie)
  {
    $strSQL = "INSERT INTO `www_embassycineplex_com`.`raw_GetMovieList` (	`CINEMA_STRID`, 
    																		`MOVIE_STRID`, 
    																		`MOVIE_STRNAME`, 
    																		`MOVIE_STRRATING`, 
    																		`MOVIE_STRNAME_2`, 
    																		`MOVIE_STRRATING_2`, 
    																		`MOVIE_HOFILMCODE`, 
    																		`MOVIE_INTFCODE`, 
    																		`EVENT_STRCODE`, 
    																		`MEMBERMOVIE`, 
    																		`HOPK`, 
    																		`MOVIE_INTLIST_POS`) 
    																		VALUES (	
    																		'{$movie['CINEMA_STRID']}', 
    																		'{$movie['MOVIE_STRID']}', 
    																		'{$movie['MOVIE_STRNAME']}', 
    																		'{$movie['MOVIE_STRRATING']}', 
    																		'{$movie['MOVIE_STRNAME_2']}', 
    																		'{$movie['MOVIE_STRRATING_2']}', 
    																		'{$movie['MOVIE_HOFILMCODE']}', 
    																		'{$movie['MOVIE_INTFCODE']}', 
    																		'{$movie['EVENT_STRCODE']}',
    																		'{$movie['MEMBERMOVIE']}',  
    																		'{$movie['HOPK']}', 
    																		'{$movie['MOVIE_INTLIST_POS']}');";
    $query = mysql_query($strSQL);
    
    echo "add " . ($query? "finish":"fail") . "<br />";
  }
}# end getMovie
//************** Get movie Showtime
  $db = mysql_select_db("www_embassycineplex_com"); 
  if (mysql_query("TRUNCATE `www_embassycineplex_com`.`raw_GetMovieShowTimes`"))
  {
    echo "table cleared" . "<br />";
  }
  
  for ($idx = 0; $idx < 30; $idx++)
  { 
    $dateToFetch = date("Ymd000000", strtotime("+" . $idx . " days"));
	$params = array(	'CinemaId' 								=> '0000000003',
						'BizDate' 								=> $dateToFetch,
						'BizStartTimeOfDay' 					=> '0',
						'OptionalClientClass' 					=> 'WWW',
						'OrderMode' 							=> 'MOVIE',
						'OptionalSessionDisplayCutOffInMins' 	=> '0',
						'AllSalesChannels' 						=> true);

	$result = $client->__soapCall('GetMovieShowTimes', array($params));

	$parser = xml_parser_create();
	xml_parse_into_struct($parser, $result->DatasetXML, $values, $index);
	xml_parser_free($parser);

	$isInTable = false;
	$nMovie = 0;
	$movies = array();

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
      	  $nMovie++;
    	}
    
    	if ($isInTable && $value['tag'] != 'TABLE')
    	{
    	  if (array_key_exists('value', $value))
    	  {
    	    $movies[$nMovie][$value['tag']] = $value['value'];
    	  }
    	  else
    	  {
    	    $movies[$nMovie][$value['tag']] = $value['tag'];
    	  }
    	}
  	  }
	}
  
  foreach ($movies as $movie)
  {
    $strSQL = "INSERT INTO `www_embassycineplex_com`.`raw_GetMovieShowTimes` (	`CINEMA_STRID`, 
    																			`SESSION_STRID`, 
    																			`SESSION_DTMDATE_TIME`, 
    																			`SESSION_DECDAY_OF_WEEK`, 
    																			`SESSION_DECSEATS_AVAILABLE`, 
    																			`SESSION_STRSEATALLOCATION_ON`, 
    																			`PRICE_STRGROUP_CODE`, 
    																			`SESSION_STRCHILD_ALLOWED`, 
    																			`SESSION_STRNOFREELIST`,
    																		 	`SCREEN_BYTNUM`, 
    																		 	`SCREEN_STRNAME`, 
    																		 	`SCREEN_INTREMOTESALESCUTOFF`, 
    																		 	`SESSION_STRATTRIBUTES`, 
    																		 	`SESSION_INTID`, 
    																		 	`MOVIE_STRID`, 
    																		 	`MOVIE_STRNAME`, 
    																		 	`MOVIE_STRRATING`, 
    																		 	`MOVIE_STRNAME_2`, 
    																		 	`MOVIE_STRRATING_2`, 
    																		 	`MOVIE_STRRATING_DESCRIPTION`, 
    																		 	`MOVIE_STRRATING_DESCRIPTION_2`, 
    																		 	`CINEMA_STRNAME`, 
    																		 	`CINEMA_STRNAME_2`, 
    																		 	`FILMCAT_STRNAME`, 
    																		 	`FILM_STRCODE`, 
    																		 	`FILM_STRCENSOR`, 
    																		 	`FILM_STRCONTENT`, 
    																		 	`FILM_STRTITLE`, 
    																		 	`FILM_INTDURATION`, 
    																		 	`FILM_STRURL1`, 
    																		 	`FILM_STRURL2`, 
    																		 	`FILM_STRTITLEALT`, 
    																		 	`FILM_STRCENSORALT`, 
    																		 	`FILM_STRCONTENTALT`, 
    																		 	`FILM_STRDESCRIPTIONALT`, 
    																		 	`FILM_STRURL1DESCRIPTION`, 
    																		 	`FILM_STRURL2DESCRIPTION`, 
    																		 	`FILM_STRURLFORGRAPHIC`, 
    																		 	`FILM_STRURLFORFILMNAME`, 
    																		 	`FILM_STRURLFORTRAILER`, 
    																		 	`FILM_STRMOVIEFORMAT`, 
    																		 	`FILM_STRSOUNDFORMAT`, 
    																		 	`FILM_STRUPCOMINGFEATUREFLAG`, 
    																		 	`FILM_STRFEATUREFLAG`, 
    																		 	`FILM_STRNOWSHOWINGFLAG`, 
    																		 	`FILM_DTMOPENINGDATE`, 
    																		 	`FILM_STRDESCRIPTIONLONG`, 
    																		 	`SESSION_STRSALESCHANNELS`) 
    																		 	VALUES (
    																		 	'{$movie['CINEMA_STRID']}', 
    																		 	'{$movie['SESSION_STRID']}', 
    																		 	'{$movie['SESSION_DTMDATE_TIME']}', 
    																		 	'{$movie['SESSION_DECDAY_OF_WEEK']}', 
    																		 	'{$movie['SESSION_DECSEATS_AVAILABLE']}', 
    																		 	'{$movie['SESSION_STRSEATALLOCATION_ON']}', 
    																		 	'{$movie['PRICE_STRGROUP_CODE']}', 
    																		 	'{$movie['SESSION_STRCHILD_ALLOWED']}', 
    																		 	'{$movie['SESSION_STRNOFREELIST']}', 
    																		 	'{$movie['SCREEN_BYTNUM']}', 
    																		 	'{$movie['SCREEN_STRNAME']}', 
    																		 	'{$movie['SCREEN_INTREMOTESALESCUTOFF']}', 
    																		 	'{$movie['SESSION_STRATTRIBUTES']}', 
    																		 	'{$movie['SESSION_INTID']}', 
    																		 	'{$movie['MOVIE_STRID']}', 
    																		 	'{$movie['MOVIE_STRNAME']}', 
    																		 	'{$movie['MOVIE_STRRATING']}', 
    																		 	'{$movie['MOVIE_STRNAME_2']}', 
    																		 	'{$movie['MOVIE_STRRATING_2']}', 
    																		 	'{$movie['MOVIE_STRRATING_DESCRIPTION']}', 
    																		 	'{$movie['MOVIE_STRRATING_DESCRIPTION_2']}', 
    																		 	'{$movie['CINEMA_STRNAME']}', 
    																		 	'{$movie['CINEMA_STRNAME_2']}', 
    																		 	'{$movie['FILMCAT_STRNAME']}', 
    																		 	'{$movie['FILM_STRCODE']}', 
    																		 	'{$movie['FILM_STRCENSOR']}', 
    																		 	'{$movie['FILM_STRCONTENT']}', 
    																		 	'{$movie['FILM_STRTITLE']}', 
    																		 	'{$movie['FILM_INTDURATION']}', 
    																		 	'{$movie['FILM_STRURL1']}', 
    																		 	'{$movie['FILM_STRURL2']}', 
    																		 	'{$movie['FILM_STRTITLEALT']}', 
    																		 	'{$movie['FILM_STRCENSORALT']}', 
    																		 	'{$movie['FILM_STRCONTENTALT']}', 
    																		 	'{$movie['FILM_STRDESCRIPTIONALT']}', 
    																		 	'{$movie['FILM_STRURL1DESCRIPTION']}', 
    																		 	'{$movie['FILM_STRURL2DESCRIPTION']}', 
    																		 	'{$movie['FILM_STRURLFORGRAPHIC']}', 
    																		 	'{$movie['FILM_STRURLFORFILMNAME']}', 
    																		 	'{$movie['FILM_STRURLFORTRAILER']}', 
    																		 	'{$movie['FILM_STRMOVIEFORMAT']}', 
    																		 	'{$movie['FILM_STRSOUNDFORMAT']}', 
    																		 	'{$movie['FILM_STRUPCOMINGFEATUREFLAG']}', 
    																		 	'{$movie['FILM_STRFEATUREFLAG']}', 
    																		 	'{$movie['FILM_STRNOWSHOWINGFLAG']}', 
    																		 	'{$movie['FILM_DTMOPENINGDATE']}', 
    																		 	'{$movie['FILM_STRDESCRIPTIONLONG']}', 
    																		 	'{$movie['SESSION_STRSALESCHANNELS']}');";
    $query = mysql_query($strSQL);
    
    echo "add " . ($query? "finish":"fail") . "<br />";
  }

  }
//***************End get movie Showtime *************************
//*********** Add movie ********////
$db = mysql_select_db("www_embassycineplex_com");
  
  $movieList = mysql_query("SELECT * FROM `www_embassycineplex_com`.`raw_GetMovieList`");
  
  $movies = array();
  
  while ($eachMovie = mysql_fetch_assoc($movieList))
  {
  	$movies[] = $eachMovie;
  }
  
  /*
  if (	mysql_query("DELETE FROM `www_embassycineplex_com`.`movie_list` WHERE `movieID` != 0") && 
  		mysql_query("ALTER TABLE `www_embassycineplex_com`.`movie_list` AUTO_INCREMENT = 1"))
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
  
    $numRowQuery = mysql_query("SELECT movie_strID FROM `www_embassycineplex_com`.`movie_list` WHERE movie_strID = '{$movie['MOVIE_STRID']}'");
    
    $nRow = mysql_num_rows($numRowQuery);
  
    if ($nRow == 0)
    {
		$strSQL = "INSERT INTO `www_embassycineplex_com`.`movie_list` (	`movieID`, 
																		`movie_strID`, 
																		`movie_strName`, 
																		`movie_HOFilmCode`, 
																		`movie_Name_CN`, 
																		`movie_Name_EN`, 
																		`movie_Name_TH`, 
																		`movie_Img_Thumb`, 
																		`movie_Youtube`, 
																		`movie_Synopsis_CN`, 
																		`movie_Synopsis_EN`, 
																		`movie_Synopsis_TH`, 
																		`movie_Rating`, 
																		`movie_SystemType`, 
																		`movie_ReleaseDate`, 
																		`movie_Duration`, 
																		`movie_Categories`, 
																		`movie_Directors`, 
																		`movie_Actors`, 
																		`movie_Publish`) 
																		VALUES (
																		NULL, 
																		'{$movie['MOVIE_STRID']}', 
																		'{$movie['MOVIE_STRNAME']}', 
																		'{$movie['MOVIE_HOFILMCODE']}', 
																		NULL, 
																		'$movieNameEN', 
																		'$movieNameTH', 
																		NULL, 
																		NULL, 
																		NULL, 
																		NULL, 
																		NULL, 
																		'{$movie['MOVIE_STRRATING']}', 
																		'$movieSystem', 
																		NULL, 
																		NULL, 
																		NULL, 
																		NULL, 
																		NULL, 
																		'0');";
		$query = mysql_query($strSQL);
		
		echo "add " . ($query? "finish":"fail") . "<br />";
    }
    else
    {
        echo "movie exists<br />";
    }
  } 
//************End movie ********////

//**********
 $db = mysql_select_db("www_embassycineplex_com");
  
  $movieList = mysql_query("SELECT * FROM `www_embassycineplex_com`.`raw_GetMovieShowTimes`");
  
  $movies = array();
  
  while ($eachMovie = mysql_fetch_assoc($movieList))
  {
  	$movies[] = $eachMovie;
  }
  
  if (mysql_query("DELETE FROM `www_embassycineplex_com`.`movie_showtimes` WHERE `showtime_dtmDate_Time` > DATE_ADD(NOW(), INTERVAL 15 MINUTE)"))
  {
    echo mysql_affected_rows() . " rows cleared at ";
    echo date('Y-m-d H:i:s') . "<br />";
  }
  
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
    
    $wsdl = "http://10.100.101.146/WSVistaWebClient/DataService.asmx?WSDL"; 
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

    $numRowQuery = mysql_query("SELECT showtime_Session_strID FROM `www_embassycineplex_com`.`movie_showtimes` 
      WHERE showtime_Session_strID = '{$movie['SESSION_STRID']}'");
    
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
      $strSQL = "UPDATE `www_embassycineplex_com`.`movie_showtimes` SET `showtime_Movie_strID` = '{$movie['MOVIE_STRID']}', 
                                        `showtime_Movie_strName` = '$movieNameEN', 
                                        /*`showtime_Session_strID` = '{$movie['SESSION_STRID']}',*/ 
                                        `showtime_dtmDate_Time` = '{$movie['SESSION_DTMDATE_TIME']}', 
                                        `showtime_decSeats_Available` = '{$movie['SESSION_DECSEATS_AVAILABLE']}', 
                                        `showtime_strSeatAllocation_On` = '{$movie['SESSION_STRSEATALLOCATION_ON']}', 
                                        `showtime_Price_strGroup_Code` = '{$movie['PRICE_STRGROUP_CODE']}', 
                                        `showtime_bytNum` = '{$movie['SCREEN_BYTNUM']}', 
                                        `showtime_strName` = '{$movie['SCREEN_STRNAME']}', 
                                        `showtime_intRemoteSalesCutoff` = '{$movie['SCREEN_INTREMOTESALESCUTOFF']}', 
                                        `showtime_soundAttributes` = '{$movie['SESSION_STRATTRIBUTES']}', 
                                        `showtime_SystemType` = '{$sessions[0]['FORMAT_STRCODE']}' 
                  WHERE showtime_Session_strID = '{$movie['SESSION_STRID']}' AND `showtime_dtmDate_Time` > DATE_ADD(NOW(), INTERVAL 15 MINUTE)";
      $query = mysql_query($strSQL);

      echo "showtime exists" . "<br />";;
    }
  }
//**********

mysql_close($connection);

?>