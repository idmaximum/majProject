@extends('layout.master')
@section('content')
<ul class="breadcrumbs">
  <li><a href="cenima">Home &gt;<i class="iconfa-home"></i></a> <span class="separator"></span></li>
  <li>News</li>
</ul>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%"><h1 class="pagetitle">News</h1></td>
    <td width="30%" class="text-center"><form class="form-inline" role="form">
        <div class="form-group">
          <label class="sr-only" for="exampleInputEmail2">Keyword</label>
          <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Keyword">
        </div>
        <button type="submit" class="btn btn-default">Search</button>
      </form></td>
  </tr>
</table>
<p class="line-brown"></p>
<div class="detail-page">
  <form action="news" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="4" cellpadding="0">
            <tr>
              <td width="71%" align="left"><a class="btn btn-success" href="newsForm#content">เพิ่ม | Add New</a></td>
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
            <tbody> 
            @foreach($sbdNews as $row)
            <tr>
              <td>{{$row->news_title}}</td>
              <td align="center">
              @if($row->news_image_thumb != '')
              <img src="{{asset('uploads/news')}}/{{$row->news_image_thumb}}" alt="{{$row->news_title}}" id="img_{{$row->news_id}}" style="max-width:300px" />
              @else
               ไม่มีรูปประกอบ
              @endif
              </td>
              <td align="center">{{date("d F Y", strtotime($row->news_create_date)) }}</td>
              <td>&nbsp;</td>
              <td align="center"><a href="newsForm/{{$row->news_id}}"><img src="{{asset('images/png/glyphicons_030_pencil.png')}}" width="20" height="20" /></a></td>
              <td align="center">
              <label class="checkbox-inline">
                  <input type="checkbox"   name="newsID[]"  value="{{$row->news_id}}">
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
@stop