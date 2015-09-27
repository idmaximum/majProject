@extends('layout.master')
@section('content')
<ul class="breadcrumbs">
  <li><a href="movie#theater">Home &gt;<i class="iconfa-home"></i></a> <span class="separator"></span></li>
  <li>Contact</li>
</ul>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%"><h1 class="pagetitle">Contact</h1></td>
    <td width="30%" class="text-center">&nbsp;</td>
  </tr>
</table>
<p class="line-brown"></p>
  @foreach($rowData as $rowDetail)
<div class="detail-page">
 
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table border="0" cellspacing="0" cellpadding="5" >
          <tr>
            <td width="193" valign="top"><strong>Address :</strong></td>
            <td width="774">{{nl2br($rowDetail->pages_address)}}</td>
            <td width="27">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><strong>Tel :</strong></td>
            <td align="left"  >{{nl2br($rowDetail->pages_tel)}}</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><strong>Email :</strong></td>
            <td>{{nl2br($rowDetail->pages_email)}}</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><strong>How to Get There</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><strong>BTS Sky Train :</strong></td>
            <td>{{nl2br($rowDetail->pages_getByTrain)}}</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><strong>BUS :</strong></td>
            <td>{{nl2br($rowDetail->pages_getByBus)}}</td>
            <td>&nbsp;</td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="4" cellpadding="0">
          <tr>
            <td align="center"><p>&nbsp;</p>
            <p><a class="btn btn-success" href="contactEdit#content">Edit Page</a></p></td>
          </tr>
        </table></td>
    </tr>
    
    <tr>
      <td></td>
    </tr>
  </table>
</div>
 @endforeach
<p class="line-brown clear"></p>
@stop