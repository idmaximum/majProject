@extends('layout.master')
@section('content')
<ul class="breadcrumbs">
  <li><a href="movie#theater">Home &gt;<i class="iconfa-home"></i></a> <span class="separator"></span></li>
  <li>EDS Movies</li>
</ul>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%"><h1 class="pagetitle">EDS Movies</h1></td>
    <td width="30%" class="text-center">  </td>
  </tr>
</table>
<div id="result" class="well well-sm" style="margin:10px 20px">ได้ทำการแก้ไขอันดับการแสดงผลเรียบร้อยแล้วค่ะ</div> 
<p class="line-brown"></p>
<div class="detail-page">
  <form action="movielist#theater" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="4" cellpadding="0">
            <tr>
              <td width="71%" align="left"> </td>
              <td width="18%" align="left">
              <select name="actionMovieList" class="form-control"id="action_up" style="float:right">
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
                <td width="13%"><strong>วันที่เข้าฉาย</strong></td>
                <td width="10%"><strong>เผยแพร่</strong></td>
                <td width="12%"><strong>Edit</strong></td>
                <td width="9%"><strong>Func.</strong></td>
              </tr>
            </thead>
            <tbody id="table-1"> 
            @foreach($movie_lists as $row)
            <tr id="{{$row->movieID}}">
              <td>{{$row->movie_Name_EN}}</td>
              <td align="center">
              @if($row->movie_Img_Thumb != '')
              <img src="{{asset('uploads/movie')}}/{{$row->movie_Img_Thumb}}" alt="{{$row->movie_strName}}" id="img_{{$row->movieID}}" style="max-width:140px" />
              @else
               ไม่มีรูปประกอบ
              @endif
              </td>
              <td align="center">{{date("d F Y", strtotime($row->movie_ReleaseDate)) }}</td>
              <td align="center" class="txtBrown12">  
              @if($row->movie_Publish == '1')
                เผยแพร่
              @else
           	   <em class="txtRed12">ซ่อนการเผยแพร่</em> @endif</td>
              <td align="center"><a href="movieListEdit/{{$row->movieID}}#theater"><img src="{{asset('images/png/glyphicons_030_pencil.png')}}" width="20" height="20" /></a></td>
              <td align="center">
              <label class="checkbox-inline">
                  <input type="checkbox"   name="movie_Name_EN[]"  value="{{$row->movie_Name_EN}}"> 
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
</div><br />
<br /> 

<?php /*<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%"><h1 class="pagetitle">Movie Coming Soon</h1></td>
    <td width="30%" class="text-center">  </td>
  </tr>
</table>
<p class="line-brown"></p>
<div class="detail-page">
  <form action="movielist#theater" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="4" cellpadding="0">
            <tr>
              <td width="71%" align="left"><a class="btn btn-success" href="{{URL::to('backoffice_management/movieAdd#theater')}}">เพิ่ม | Add New</a></td>
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
                <td width="13%"><strong>วันที่เข้าฉาย</strong></td>
                <td width="10%"><strong>เผยแพร่</strong></td>
                <td width="12%"><strong>Edit</strong></td>
                <td width="9%"><strong>Func.</strong></td>
              </tr>
            </thead>
            <tbody> 
            @foreach($dataComingsoon as $row)
            <tr>
              <td>{{$row->movie_Name_EN}}</td>
              <td align="center">
              @if($row->movie_Img_Thumb != '')
              <img src="{{asset('uploads/movie')}}/{{$row->movie_Img_Thumb}}" alt="{{$row->movie_strName}}" id="img_{{$row->movieID}}" style="max-width:140px" />
              @else
               ไม่มีรูปประกอบ
              @endif
              </td>
              <td align="center">{{date("d F Y", strtotime($row->movie_ReleaseDate)) }}</td>
              <td align="center" class="txtBrown12">  
              @if($row->movie_Publish == '1')
                เผยแพร่
              @else
           	   <em class="txtRed12">ซ่อนการเผยแพร่</em> @endif</td>
              <td align="center"><a href="movieComingsoonEdit/{{$row->movieID}}#theater"><img src="{{asset('images/png/glyphicons_030_pencil.png')}}" width="20" height="20" /></a></td>
              <td align="center">
              <label class="checkbox-inline">
                  <input type="checkbox"   name="movie_Name_EN[]"  value="{{$row->movie_Name_EN}}"> 
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
</div>*/ ?>
<p class="line-brown clear"></p>
{{ HTML::script('js/jquery.tablednd_0_5.js') }} 
<script type="text/javascript">
	jQuery(document).ready(function(){  
		jQuery('#table-1').tableDnD({
        	onDrop: function(table, row) {
			var order= jQuery.tableDnD.serialize('id');
			jQuery.ajax({type: "GET",url: "movielist/ajaxCheck/dragDropMovieList", data: order, 
			 success:
				 jQuery("#result").fadeIn(500).delay(5000).fadeOut(500)});
    		}
    	});
	}); 
</script> 
@stop