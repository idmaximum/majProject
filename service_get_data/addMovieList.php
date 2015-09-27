<?php

$connection = mysql_connect("10.121.128.10", "embassy", "embassy@2014");
mysql_query("SET NAMES 'utf8'");

if ($connection)
{
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
}

mysql_close($connection);

?>