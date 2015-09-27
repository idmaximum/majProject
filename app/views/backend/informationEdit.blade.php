@extends('layout.master')
@section('content')
<ul class="breadcrumbs">
  <li><a href="cenima">Home &gt;<i class="iconfa-home"></i></a> <span class="separator"></span></li>
  <li>Information</li>
</ul>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%"><h1 class="pagetitle">Information</h1></td>
    <td width="30%" class="text-center">&nbsp;</td>
  </tr>
</table>
<p class="line-brown"></p>
  <form method="post" enctype="multipart/form-data" name="contactEdit" class="form-horizontal form-page formular"id="contactEdit" role="form">
@foreach($rowPageInfomation as $rowDetail)
<div class="detail-page"> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><textarea name="pages_infomation" class="validate[required] form-control"  cols="90" rows="20" id="pages_infomation">{{$rowDetail->pages_infomation}}</textarea></td>
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
            <td align="center">
               <input type="submit" name="action" value="บันทึก | Save" class="btn btn-primary" />
       		  <input name="action" type="hidden" id="action" value="submit" /> </td>
          </tr>
        </table></td>
    </tr>
    
    <tr>
      <td></td>
    </tr>
  </table>
</div>
 @endforeach
 </form>
<p class="line-brown clear"></p>
@stop