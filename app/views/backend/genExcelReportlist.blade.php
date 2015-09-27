<?php
header ('Content-type: text/html; charset=utf-8');
header("Content-Type: application/vnd.ms-excel"); 
header('Content-Disposition: attachment; filename="downloads.xls"');#ชื่อไฟล์
?><!doctype html>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta charset="utf-8">
<title>Backoffice' Major Cineplex Cambodia</title> 
</head>
<body> 
<table width="2301" border="0" cellspacing="0" cellpadding="0"  class="table demo table table-striped"   x:str BORDER=”1″>
      <thead>
        <tr align="center" style="white-space:nowrap">
         <th width="209" data-toggle="true"><strong>Log Time</strong></th>
          <th width="100"><strong> Pincode </strong></th> 
          <th width="100"><strong>Amount (THB)</strong></th>
          <th width="409"><strong>Name-Surname</strong></th>
          <th width="250"><strong>Email</strong></th>
          <th width="208"><strong>Tel</strong></th>
          <th width="255"><strong>Movie Name</strong></th>
          <th width="213"><strong>Showtime</strong></th>
          <th width="170"><strong>Seat</strong></th>
          <th width="195"><strong>Channel</strong></th>
          <th width="241"><strong>Payment Type</strong></th>
          <th width="222"><strong>Status</strong></th> 
        </tr>
      </thead>
      <tbody> 
      @foreach($resultDataLogBooking as $rowDataLogBooking)
      <tr align="center" style="font-size:14px; white-space:nowrap">
        <td>{{$rowDataLogBooking->date_time}}</td>
        <td><?php 
            $pincode = $rowDataLogBooking->pincode;
            if($pincode != ''){
                echo $pincode;
            }else{
              echo '-';  
                }
                ?></td>       
        <td>{{$rowDataLogBooking->amount}}</td>
        <td>{{$rowDataLogBooking->cname}}</td>
        <td>{{$rowDataLogBooking->email}}</td>
        <td>{{$rowDataLogBooking->phone}}</td>
        <td>{{$rowDataLogBooking->movie}}</td>
        <td>{{$rowDataLogBooking->show_time}}</td>
        <td>{{$rowDataLogBooking->seat}}</td>
        <td>{{$rowDataLogBooking->channel}}</td>
        <td>{{$rowDataLogBooking->order_payment}}&nbsp;</td>
        <td>{{$rowDataLogBooking->order_status}}</td> 
      </tr>
      @endforeach
        </tbody>  
    </table>
</body>
</html>