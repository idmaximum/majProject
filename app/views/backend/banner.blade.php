@extends('layout.master')
@section('content')
<ul class="breadcrumbs">
  <li><a href="movie#theater">Home &gt;<i class="iconfa-home"></i></a> <span class="separator"></span></li>
  <li>Banner</li>
</ul>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%"><h1 class="pagetitle">Banner</h1></td>
    <td width="30%" class="text-center"> </td>
  </tr>
</table>
<div id="result" class="well well-sm" style="margin:10px 20px">ได้ทำการแก้ไขอันดับการแสดงผลเรียบร้อยแล้วค่ะ</div> 
<p class="line-brown"></p>
<div class="detail-page">
  <form action="banner#content" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="4" cellpadding="0">
            <tr>
              <td width="71%" align="left"><a class="btn btn-success" href="{{URL::to('backoffice_management/bannerAdd#content')}}">เพิ่ม | Add New</a></td>
              <td width="18%" align="left">
              <select name="action_up" class="form-control"id="action_up" style="float:right">
                  <option value="" selected="selected">-เลือก-</option>
                  <option value="เผยแพร่ | Publish">เผยแพร่ | Publish</option>
                  <option value="ซ่อน | Unpublish">ซ่อน | Unpublish</option>
                  <option value="ลบ | Delete">ลบ | Delete</option>
                </select></td>
              <td width="11%" align="left"><input type="submit" name="submit" value="Apply" class="btn btn-primary" style="margin-left:5px" /></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="table table-striped">
            <thead>
              <tr align="center">
                <td width="31%"><strong>หัวเรื่อง</strong></td>
                <td width="25%"><strong> รูปประกอบ</strong></td>
                <td width="13%"><strong>วันที่สร้าง/
                  วันที่แก้ไข</strong></td>
                <td width="10%"><strong>เผยแพร่</strong></td>
                <td width="12%"><strong>Edit</strong></td>
                <td width="9%"><strong>Func.</strong></td>
              </tr>
            </thead>
            <tbody id="table-1"> 
            @foreach($sbdBanner as $row)
            <tr id="{{$row->banner_ID}}">
              <td>{{$row->banner_name}}</td>
              <td align="center">
              @if($row->banner_pic != '')
              <img src="{{asset('uploads/banner')}}/{{$row->banner_pic}}" alt="{{$row->banner_name}}" id="img_{{$row->banner_ID}}" style="max-width:300px" />
              @else
               ไม่มีรูปประกอบ
              @endif
              </td>
              <td align="center">{{date("d F Y", strtotime($row->banner_create)) }}</td>
              <td align="center">  
              @if($row->banner_publish == '1')
                เผยแพร่
              @else
           	   <em>ซ่อนการเผยแพร่</em> @endif</td>
              <td align="center"><a href="bannerEdit/{{$row->banner_ID}}#content"><img src="{{asset('images/png/glyphicons_030_pencil.png')}}" width="20" height="20" /></a></td>
              <td align="center">
              <label class="checkbox-inline">
                  <input type="checkbox"   name="banner_ID[]"  value="{{$row->banner_ID}}">
                </label></td>
            </tr>
            @endforeach
              </tbody>
            
          </table></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
  </form>
</div>
<p class="line-brown clear"></p> 
{{ HTML::script('js/jquery.tablednd_0_5.js') }} 
<script type="text/javascript">
	jQuery(document).ready(function(){ 
		 
		jQuery('#table-1').tableDnD({
        	onDrop: function(table, row) {
			var order= jQuery.tableDnD.serialize('id');
			jQuery.ajax({type: "GET",url: "banner/ajaxCheck/dragDropBanner", data: order, 
			 success:
				 jQuery("#result").fadeIn(500).delay(5000).fadeOut(500)});
    		}
    	});
	}); 
</script> 
@stop