<?php

$movieID = '0';

if ($_POST['movie_id'])
{
  $movieID = $_POST['movie_id'];
}

if ($_GET['movie_id'])
{
  $movieID = $_GET['movie_id'];
}

$movieDate = date('Y-m-d');
$isToday = 1;

if ($_POST['date'])
{
  $movieDate = date('Y-m-d', strtotime($_POST['date']));
  $isToday = 0;
}
  
if ($_GET['date'])
{
  $movieDate = date('Y-m-d', strtotime($_GET['date']));
  $isToday = 0;
}

$lang = "";

if ($_POST['lang'])
{
  $lang = $_POST['lang'];
}
  
if ($_GET['lang'])
{
  $lang = $_GET['lang'];
}

$systemTypeCode = "";

if ($_POST['system_typecode'])
{
  $systemTypeCode = $_POST['system_typecode'];
}

if ($_GET['system_typecode'])
{
  $systemTypeCode = $_GET['system_typecode'];
}

$connection = mysql_connect("10.121.128.10", "embassy", "embassy@2014"); //!Qq73q3n
mysql_query("SET NAMES 'utf8'");

if ($connection)
{
  $db = mysql_select_db("www_embassycineplex_com");
  
  mysql_query("SET SESSION group_concat_max_len = 1000000");
  $movieList = mysql_query("SELECT 	CONCAT(	'[', 
  											GROUP_CONCAT(
  												CONCAT('{', 
  													'\'time\':', '\'', TIME_FORMAT(showtime_dtmDate_Time, '%H:%i'), '\'\,', 
  													'\'date_time\':', '\'', showtime_dtmDate_Time, '\'\,', 
  													'\'time_state\':', '\'', 
  														IF(DATE_SUB(NOW(), INTERVAL 15 MINUTE) > showtime_dtmDate_Time, '0', '2'), '\'\,', 
  													'\'session_id\':', '\'', showtime_Session_strID, '\'\,',
  													'\'sound_attributes\':', '\'', SUBSTRING_INDEX(showtime_soundAttributes, ';', 1), '\'\,',
                            '\'screen_num\':', '\'', showtime_bytNum, '\'\,',
  													'\'theatre\':', '\'', showtime_strName, '\'}'
  													) 
  												ORDER BY movie_showtimes.showtime_dtmDate_Time ASC
  												SEPARATOR ','), ']'
  												) AS showtimes,
  									movie_list.movie_strID AS movie_id,
  									movie_list.movie_Name_EN AS title_en,
  									movie_list.movie_Name_TH AS title_th,
                    movie_list.movie_Name_CN AS title_cn,
  									IF(movie_showtimes.showtime_SystemType LIKE 'VS%', 'Digital', 'Digital3D') AS movie_type,
                    movie_showtimes.showtime_SystemType AS system_typecode,
  									movie_list.movie_Rating AS movie_rating,
  									COALESCE(movie_list.movie_Duration, 0) AS duration,
  									COALESCE(CONCAT('http:\/\/www.embassycineplex.com\/uploads\/movie\/', movie_list.movie_Img_Thumb), '') AS poster,
  									COALESCE(movie_list.movie_Youtube, '') AS trailer,
  									COALESCE(movie_list.movie_Categories, '') AS genre,
  									COALESCE(movie_list.movie_ReleaseDate, '') AS release_date,
  									COALESCE(movie_list.movie_Directors, '') AS director,
  									COALESCE(movie_list.movie_Actors, '') AS actor,
  									COALESCE(movie_list.movie_Synopsis_EN, '') AS synopsis_en,
  									COALESCE(movie_list.movie_Synopsis_TH, '') AS synopsis_th,
                    COALESCE(movie_list.movie_Synopsis_CN, '') AS synopsis_cn,
                    CONCAT('http:\/\/www.embassycineplex.com\/movie\/', movie_list.movieID, '\/', movie_list.movie_Name_EN) AS web_url
  								FROM movie_list 
  								LEFT JOIN movie_showtimes
  								ON movie_list.movie_strID = movie_showtimes.showtime_Movie_strID
  								WHERE movie_list.movie_Publish = '1' AND 
  									movie_list.movie_strID = '$movieID' AND
  									movie_showtimes.showtime_dtmDate_Time >= DATE_ADD('$movieDate', INTERVAL 6 HOUR) AND
  									movie_showtimes.showtime_dtmDate_Time <= DATE_ADD('$movieDate', INTERVAL 30 HOUR)
  								GROUP BY movie_showtimes.showtime_Movie_strID, movie_showtimes.showtime_SystemType");

  $movies = array();
  
  while ($result = mysql_fetch_assoc($movieList))
  {
    $movie = $result;
    $movie['showtimes'] = json_decode(
    						preg_replace(	"/\"time_state\":\"2\"/", 
    										"\"time_state\":\"1\"", 
    										preg_replace("/\'/", "\"", $result['showtimes']), 
    										1));
    //$movie['poster'] = "http://eds.invp.net/embassy/uploads/movie/CWwFtNuo2D201404232321.jpg";

    $movieTitle = "";
    $movieSynopsis = "";

    if (strtolower($lang) == "en") 
    {
      $movieTitle['EN'] = $movie['title_en'];
      $movieSynopsis['EN'] = $movie['synopsis_en'];
    }
    elseif (strtolower($lang) == "th") 
    {
      $movieTitle['TH'] = $movie['title_th'];
      $movieSynopsis['TH'] = $movie['synopsis_th'];
    }
    elseif (strtolower($lang) == "cn") 
    {
      $movieTitle['CN'] = $movie['title_cn'];
      $movieSynopsis['CN'] = $movie['synopsis_cn'];
    }
    else
    {
      $movieTitle['EN'] = $movie['title_en'];
      $movieTitle['TH'] = $movie['title_th'];
      $movieTitle['CN'] = $movie['title_cn'];

      $movieSynopsis['EN'] = $movie['synopsis_en'];
      $movieSynopsis['TH'] = $movie['synopsis_th'];
      $movieSynopsis['CN'] = $movie['synopsis_cn'];
    }

    unset($movie['title_en']);
    unset($movie['title_th']);
    unset($movie['title_cn']);
    unset($movie['synopsis_en']);
    unset($movie['synopsis_th']);
    unset($movie['synopsis_cn']);

    $movie['movie_title'] = $movieTitle;
    $movie['synopsis'] = $movieSynopsis;

    $poster['image'] = $movie['poster'];
    $poster['crc32'] = hash_file('crc32', $movie['poster']);
    $movie['poster'] = $poster;

    if (strlen($systemTypeCode) > 0) 
    {
      if ($movie['system_typecode'] == $systemTypeCode) 
      {
        $movies['movie_detail'][] = $movie;
      }
    }
    else
    {
      $movies['movie_detail'][] = $movie;
    }
  }

  if (sizeof($movies['movie_detail']) > 0) 
  {
    $resultJSON['result'] = "OK";
    $resultJSON['code'] = "000";
  }
  else
  {
    $resultJSON['result'] = "ERROR";
    $resultJSON['code'] = "002";
  }

  $resultJSON['version'] = "1.10";
  $resultJSON['date_time'] = date('Y-m-d H:i:s');
  $resultJSON['data'] = $movies;

  echo json_encode($resultJSON);
}

mysql_close($connection);

?>