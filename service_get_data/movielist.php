<?php

$wsdl = "http://10.121.130.25/WSVistaWebClient/DataService.asmx?WSDL"; 
$client = new SoapClient($wsdl, array('trace' => true)); 

$params = array('OptionalCinemaId' 			=> "0000008001", 
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

$connection = mysql_connect("10.121.128.10", "embassy", "embassy@2014");
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
}

mysql_close($connection);

?>