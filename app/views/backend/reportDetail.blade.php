<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
{{HTML::style('css/font.css')}}
{{HTML::style('js/bootstrap/css/bootstrap.css')}}
{{HTML::style('js/bootstrap/css/bootstrap-theme.css')}} 
</head> 
<body>
<div style="width:680px; margin:auto">
 @foreach($resultReport as $rowReport)
  <table width="100%" class="table table-bordered"> 
    <tbody>
       <tr>
        <td width="24%"><strong>Pincode</strong></td>
        <td width="76%">{{$rowReport->pincode}}</td>
      </tr>
        <tr>
        <td width="24%"><strong>UserSessionid</strong></td>
        <td width="76%">{{$rowReport->user_session_id}}</td>
      </tr> 
      <tr>
        <td><strong>Name</strong></td>
        <td>{{$rowReport->cname}}</td>
      </tr>
      <tr>
        <td><strong>Email</strong></td>
        <td>{{$rowReport->email}}</td>
      </tr>
      <tr>
        <td><strong>Phone</strong></td>
        <td>{{$rowReport->phone}}</td>
      </tr> 
      <tr>
        <td><strong>Payment Type</strong></td>
        <td>{{$rowReport->order_payment}}</td>
      </tr>
      <tr>
        <td><strong>Movie</strong></td>
        <td>{{$rowReport->movie}}</td>
      </tr>
         <tr>
        <td><strong>Showtime</strong></td>
        <td>{{$rowReport->show_time}}</td>
      </tr>
           <tr>
        <td><strong>Amount</strong></td>
        <td>{{$rowReport->amount}} THB</td>
      </tr>
           <tr>
        <td><strong>Theater</strong></td>
        <td>{{$rowReport->theater}}</td>
      </tr>
      
      <tr>
        <td><strong>Seat</strong></td>
        <td>{{$rowReport->seat}}</td>
      </tr>
      <tr>
        <td><strong>Channel</strong></td>
        <td>{{$rowReport->channel}}</td>
      </tr>
      <tr>
        <td><strong>Time</strong></td>
        <td>{{$rowReport->date_time}}</td>
      </tr>
      </tbody>
    </table>
  @endforeach
</div>
</body>
</html>