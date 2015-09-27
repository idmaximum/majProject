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

  foreach ($movies as $movie)
  {
    
    echo $movie['CINEMA_STRID'] . " : " . $movie['MOVIE_STRID'] . " : " . $movie['SESSION_STRID'] . "<br />"; 
    
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
	
	echo $movie['CINEMA_STRID'] . " : " . $movie['MOVIE_STRID'] . " : " . $movie['SESSION_STRID'] . " : " . $sessions[0]['MOVIE_STRNAME'] . " : " . $sessions[0]['FORMAT_STRCODE'] . "<br /><br />";
	
  }
}

mysql_close($connection);

?>