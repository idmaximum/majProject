<?php

$connection = mysql_connect("10.121.128.10", "embassy", "embassy@2014"); //!Qq73q3n
mysql_query("SET NAMES 'utf8'");

if ($connection)
{
  $db = mysql_select_db("www_embassycineplex_com");
  
  //mysql_query("SET SESSION group_concat_max_len = 1000000");
  
  $bannerList = mysql_query("SELECT banner_picMobile, banner_url FROM movie_banner WHERE banner_publish = '1' ORDER BY orderBy ASC");
  
  $banners = array();
  
  while ($result = mysql_fetch_assoc($bannerList))
  {
    $banner['poster'] = 'http://www.embassycineplex.com/uploads/banner/' . $result['banner_picMobile'];

    $poster['image'] = $banner['poster'];
    $poster['crc32'] = hash_file('crc32', $banner['poster']);
    $banner['poster'] = $poster;

    $banner['type'] = strlen($result['banner_url']) > 0 ? 1 : 0;
    $banner['action'] = $result['banner_url'];
    
    if (strpos($result['banner_url'], 'youtu') !== false) 
    {
    	$banner['type'] = 2;
    }
    
    $banners[] = $banner;
  }
  
  $movies['banners'] = $banners;

  if (sizeof($movies['banners']) > 0) 
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