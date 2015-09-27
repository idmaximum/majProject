@extends('layout.master')
@section('content')
<ul class="breadcrumbs">
  <li><a href="movie#theater">Home &gt;<i class="iconfa-home"></i></a> <span class="separator"></span></li>
  <li>Information</li>
</ul>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%"><h1 class="pagetitle">Information</h1></td>
    <td width="30%" class="text-center">&nbsp;</td>
  </tr>
</table>
<p class="line-brown"></p>
  @foreach($rowPageInfomation as $rowDetail)
<div class="detail-page">
 
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table  style="width:1024px;background-image:url({{asset('images/bg_infomation.jpg')}}); min-height:650px" border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="568">&nbsp;</td>
            <td width="429">&nbsp;</td>
            <td width="27">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" class="txtWhite14">{{nl2br($rowDetail->pages_infomation)}}</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="4" cellpadding="0">
          <tr>
            <td align="center"><p>&nbsp;</p>
            <p><a class="btn btn-success" href="informationEdit#content">Edit Page</a></p></td>
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