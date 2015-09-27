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
@foreach($rowData as $rowDetail)
<div class="detail-page"> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="10">
          <tr>
            <td width="191" valign="top"><strong>Address :</strong></td>
            <td width="784"><textarea name="pages_address" class="validate[required] form-control"  cols="90" rows="5" id="pages_address">{{$rowDetail->pages_address}}</textarea></td>
            <td width="19">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><strong>Tel :</strong></td>
            <td><input type="text" class="validate[required] form-control"  name="pages_tel" id="pages_tel" placeholder="Tel" value="{{$rowDetail->pages_tel}}"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><strong>Email :</strong></td>
            <td><input type="text" class="validate[required] form-control"  name="pages_email" id="pages_email" placeholder="Email" value="{{$rowDetail->pages_email}}"></td>
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
            <td>  <textarea name="pages_getByTrain" class="validate[required] form-control"  cols="90" rows="5" id="pages_getByTrain">{{$rowDetail->pages_getByTrain}}</textarea></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><strong>BUS :</strong></td>
            <td> 
              <textarea name="pages_getByBus" class="validate[required] form-control"  cols="90" rows="5" id="pages_getByBus">{{$rowDetail->pages_getByBus}}</textarea></td>
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