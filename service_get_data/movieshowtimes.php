<?php

$wsdl = "http://10.121.130.25/WSVistaWebClient/DataService.asmx?WSDL"; 
$client = new SoapClient($wsdl, array('trace' => true)); 

/*
$params = array(	'CinemaId' 								=> '0000000001',
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
*/

$connection = mysql_connect("10.121.128.10", "embassy", "embassy@2014");
mysql_query("SET NAMES 'utf8'");

if ($connection)
{
  $db = mysql_select_db("www_embassycineplex_com");
  
  if (mysql_query("TRUNCATE `www_embassycineplex_com`.`raw_GetMovieShowTimes`"))
  {
    echo "table cleared" . "<br />";
  }
  
  for ($idx = 0; $idx < 30; $idx++)
  { 
    $dateToFetch = date("Ymd000000", strtotime("+" . $idx . " days"));
	$params = array(	'CinemaId' 								=> '0000008001',
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
}

mysql_close($connection);

?>