<?php

$comingsoonID = '0';

if ($_POST['comingsoon_id'])
{
  $comingsoonID = $_POST['comingsoon_id'];
}

if ($_GET['comingsoon_id'])
{
  $comingsoonID = $_GET['comingsoon_id'];
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

$connection = mysql_connect("10.121.128.10", "embassy", "embassy@2014"); //!Qq73q3n

mysql_query("SET NAMES 'utf8'");

if ($connection)
{
  $db = mysql_select_db("www_embassycineplex_com");
  
  mysql_query("SET SESSION group_concat_max_len = 1000000");
  $dateNow = date('Y-m');
  $today = date('Y-m-d');
  
  $movieList = mysql_query("SELECT movie_comingsoon.movieID AS comingsoon_id,
                    COALESCE(movie_comingsoon.movie_strID, '') AS movie_id,
  									movie_comingsoon.movie_Name_EN AS title_en,
  									movie_comingsoon.movie_Name_TH AS title_th,
                    movie_comingsoon.movie_Name_CN AS title_cn,
                    COALESCE((SELECT 
                        MIN(movie_showtimes.showtime_dtmDate_Time)
                      FROM movie_showtimes 
                      WHERE movie_showtimes.showtime_Movie_strID = movie_comingsoon.movie_strID AND
                        movie_showtimes.showtime_dtmDate_Time >= DATE_ADD(CURDATE(), INTERVAL 6 HOUR)), '') AS first_showtime,
  									COALESCE(CONCAT('http:\/\/www.embassycineplex.com\/uploads\/movie\/', movie_comingsoon.movie_Img_Thumb), '') AS poster,
  									COALESCE(movie_comingsoon.movie_ReleaseDate, '') AS release_date,
                    COALESCE(movie_comingsoon.movie_Rating, '') AS movie_rating,
                    COALESCE(movie_comingsoon.movie_Duration, 0) AS duration,
                    COALESCE(movie_comingsoon.movie_Youtube, '') AS trailer,
                    COALESCE(movie_comingsoon.movie_Categories, '') AS genre,
                    COALESCE(movie_comingsoon.movie_Directors, '') AS director,
                    COALESCE(movie_comingsoon.movie_Actors, '') AS actor,
                    COALESCE(movie_comingsoon.movie_Synopsis_EN, '') AS synopsis_en,
                    COALESCE(movie_comingsoon.movie_Synopsis_TH, '') AS synopsis_th,
                    COALESCE(movie_comingsoon.movie_Synopsis_CN, '') AS synopsis_cn,
                    CONCAT('http:\/\/www.embassycineplex.com\/comingsoon\/', movie_comingsoon.movieID, '\/', movie_comingsoon.movie_Name_EN) AS web_url
  								FROM movie_comingsoon 
  								WHERE movie_comingsoon.movie_Publish = '1' AND
                    movie_comingsoon.movieID = $comingsoonID
								and movie_ReleaseDate > CURDATE() 
  								ORDER BY movie_comingsoon.movie_ReleaseDate ASC");

  $movies = array();
  $results = array();
  
  while ($result = mysql_fetch_assoc($movieList))
  {
    $comingsoon = $result;
    $movieTitle = "";
    $movieSynopsis = "";

    if (strtolower($lang) == "en") 
    {
      $movieTitle['EN'] = $comingsoon['title_en'];
      $movieSynopsis['EN'] = $comingsoon['synopsis_en'];
    }
    elseif (strtolower($lang) == "th") 
    {
      $movieTitle['TH'] = $comingsoon['title_th'];
      $movieSynopsis['TH'] = $comingsoon['synopsis_th'];
    }
    elseif (strtolower($lang) == "cn") 
    {
      $movieTitle['CN'] = $comingsoon['title_cn'];
      $movieSynopsis['CN'] = $comingsoon['synopsis_cn'];
    }
    else
    {
      $movieTitle['EN'] = $comingsoon['title_en'];
      $movieTitle['TH'] = $comingsoon['title_th'];
      $movieTitle['CN'] = $comingsoon['title_cn'];
      $movieSynopsis['EN'] = $comingsoon['synopsis_en'];
      $movieSynopsis['TH'] = $comingsoon['synopsis_th'];
      $movieSynopsis['CN'] = $comingsoon['synopsis_cn'];
    }

    unset($comingsoon['title_en']);
    unset($comingsoon['title_th']);
    unset($comingsoon['title_cn']);
    unset($comingsoon['synopsis_en']);
    unset($comingsoon['synopsis_th']);
    unset($comingsoon['synopsis_cn']);
    
    $comingsoon['movie_title'] = $movieTitle;
    $comingsoon['movie_synopsis'] = $movieSynopsis;

    $poster['image'] = $comingsoon['poster'];
    $poster['crc32'] = hash_file('crc32', $comingsoon['poster']);
    $comingsoon['poster'] = $poster;

    $results[date('Y-m', strtotime($result['release_date']))][] = $comingsoon;
  }
  
  ksort($results);
  
  foreach ($results as $key => $value)
  {
    //$movie['release_month'] = $key;
    //$movie['movies'] = $value;
    
    $movies['comingsoon_detail'] = $value;
  }

  if (sizeof($movies['comingsoon_detail']) > 0) 
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