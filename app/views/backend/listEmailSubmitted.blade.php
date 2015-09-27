@extends('layout.master')
@section('content')
<ul class="breadcrumbs">
  <li><a href="movie#theater">Home &gt;<i class="iconfa-home"></i></a> <span class="separator"></span></li>
  <li>Email Submitted</li>
</ul>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%"><h1 class="pagetitle">Email Submitted</h1></td>
    <td width="30%" class="text-center"> </td>
  </tr>
</table>
<p class="line-brown"></p>
<div class="detail-page">
  <form action="" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php /*<table width="100%" border="0" cellspacing="4" cellpadding="0">
            <tr>
              <td width="71%" align="left"> </td>
              <td width="18%" align="left"><select name="action_up" class="form-control"id="action_up" style="float:right">
                  <option value="" selected="selected">-เลือก-</option>
                  <option value="เผยแพร่ | Publish">เผยแพร่ | Publish</option>
                  <option value="ซ่อน | Unpublish">ซ่อน | Unpublish</option>
                  <option value="ลบ | Delete">ลบ | Delete</option>
                </select></td>
              <td width="11%" align="left"><input type="submit" name="submit" value="Apply" class="btn btn-primary" style="margin-left:5px" /></td>
            </tr>
          </table>*/?></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="table table-striped">
            <thead>
              <tr align="center">
                <td width="31%"><strong>Email</strong></td>
                <td width="25%"><strong>Movie</strong></td>
                <td width="13%"><strong>Date Submitted</strong></td> 
              </tr>
            </thead>
            <tbody> 
            @foreach($rowData as $row)
            <tr>
              <td align="center">{{$row->email}}</td>
              <td align="center">{{$row->movie_Name_EN}}</td>
              <td align="center">{{$row->signupDate}}</td>
              
            </tr>
            @endforeach
              </tbody>
            
          </table></td>
      </tr>
      <tr>
        <td>&nbsp; </td>
      </tr>
    </table>
  </form>
</div>
<p class="line-brown clear"></p>
@stop