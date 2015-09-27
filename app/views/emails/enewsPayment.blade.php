<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<style type="text/css">
body{
	line-height: 1.3;
	
}
p{ margin:0; padding:0}
#main {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #000;
}.title{ color:#8e8e8e}
</style>
</head> 
<body>
<div id="main" style="width:740px">
<p><strong>Thank you for payment with us</strong>, {{ $cname }}</p>
<p>&nbsp;</p>
<p>Please pick up your tickets at the Box Office.</p>
<p>&nbsp;</p>
<div style="border: 1px solid #999999; padding:8px">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="14%" align="center"><div class="rowShowTodayImage"><img src="http://www.embassycineplex.com/uploads/movie/{{$imgPoster}}" width="100" class="hoverImg08" alt="{{$movieName}}"></div></td>
      <td width="86%" align="left" valign="top"><h2 class="txtGold24">{{$movieName}}</h2> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="17%">
              <p><img src="http://www.embassycineplex.com/images/icon/{{$imgRate}}" style="padding:0; width:40px"> 
                <img src="http://www.embassycineplex.com/images/icon/{{$imgSystem}}" alt="{{$systemName}}" style=" width:40px"></p></td>
            <td width="83%" class="txtSoundTrack"><?php echo	 $showtimes ; ?></td>
            </tr>
          </table>
        <p>&nbsp;</p>
        <table width="100%" border="0" cellspacing="2" cellpadding="5" class="detailComplate">
          <tr>
            <td width="15%" style=" color:#8e8e8e">Date </td>
            <td width="27%" >{{ date('d F Y', strtotime($movieSession)) }}</td>
            <td width="11%"  style=" color:#8e8e8e">Hall</td>
            <td width="16%" >{{$hall}}</td>
            <td width="15%"  style=" color:#8e8e8e">Total Price</td>
            <td width="16%" ><?php  echo number_format($SeatPrice)?>  Baht</td>
            </tr>
          <tr>
            <td  style=" color:#8e8e8e">Time</td>
            <td >{{ date('H:i', strtotime($movieSession))}}</td>
            <td  style=" color:#8e8e8e"> Seat No.</td>
            <td colspan="3" >
              <?php    echo rtrim(trim($seatPosition), ',') . "";?>
              </td>
            </tr>
          <tr>
            <td  style="color:#8e8e8e">Your Name</td>
            <td >{{$cname}}</td>
            <td  style="color:#8e8e8e"> Phone</td>
            <td >{{$mobile}}</td>
            <td><span style="color:#8e8e8e">Booking No.</span></td>
            <td>{{$pincode}}</td>
            </tr>
          </table>
        </td>
      </tr>
  </table>
</div>
<br><?php	$pincodeQR = 	sprintf("%07d",$pincode);  ?> 
<div class="contentQrcode"  style="width:200px; padding:5px; background-color:#000; margin:auto">
<p style="text-align:center"><img src="https://chart.googleapis.com/chart?chs=200x200&amp;cht=qr&amp;chl={{$pincodeQR}}&amp;choe=UTF-8" alt="QR code"></p>
<p style="text-align:center; color:#FFF; font-size:20px">Booking No. {{$pincode}}</p>
</div>
<p>&nbsp;</p> 
</div>
</body>
</html>
