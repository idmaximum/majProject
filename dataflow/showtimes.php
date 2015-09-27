<html>
<head></head>
<body>

<?php 
echo 'xxxxxxx';
$connection = mysql_connect("110.121.128.10", "embassy", "embassy@2014");
mysql_query("SET NAMES 'utf8'");

if ($connection)
{
	$db = mysql_select_db("www_embassycineplex_com");

	$movieList = mysql_query("SELECT * FROM  `movie_showtimes` WHERE showtime_dtmDate_Time >= NOW()");

	$movies = array();

	while ($eachMovie = mysql_fetch_assoc($movieList))
	{
		$movies[] = $eachMovie;
	}
  
  	foreach ($movies as $movie)
  	{	
  		echo $movie['showtime_Movie_strID'] . " : " . $movie['showtime_Movie_strName'] . " : " . $movie['showtime_SystemType'] . "<br />";
  		echo $movie['showtime_Session_strID'] . " : " . $movie['showtime_dtmDate_Time'] . "<br />";
        echo $movie['showtime_strName'] . "<br />";
  		echo "<form action='ticketType.php' method='post'>";
  		echo "<input type='hidden' name='movie_name' value='" . $movie['showtime_Movie_strName'] . "'>";
  		echo "<input type='hidden' name='date_time' value='" . $movie['showtime_dtmDate_Time'] . "'>";
  		echo "<input type='hidden' name='session_id' value='" . $movie['showtime_Session_strID'] . "'>";
      echo "<input type='hidden' name='theatre' value='" . $movie['showtime_strName'] . "'>";
  		echo "<input type='submit' value='Submit'>";
  		echo "</form>";
  		echo "<br /><br />";
	}

	mysql_close($connection);
}

?>

</body>
</html>