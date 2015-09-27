<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php /* {{$dateNow = date('Y-m-d')}}*/
	//$dateNow = date('Y-m-d');
	$dateNow = '2014-04-24';
?>
@foreach($movie_lists as $movie)
<p><strong>{{$movie->movie_strName}} </strong></p>
	@foreach($movie_showtimes  as $movieShowtime)
         @if($movie->movie_strID === $movieShowtime->showtime_Movie_strID)
         
    	  <p> 
          	@if( date('Y-m-d', strtotime($movieShowtime->showtime_dtmDate_Time))  == $dateNow)
          	- {{ $movieShowtime->showtime_dtmDate_Time}}
             @endif
           </p>
      	@endif
    @endforeach
@endforeach
</body>
</html>