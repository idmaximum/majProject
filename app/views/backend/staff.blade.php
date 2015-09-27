@extends('layout.master')
@section('content')
<ul class="breadcrumbs">
  <li><a href="movie#theater">Home &gt;<i class="iconfa-home"></i></a> <span class="separator"></span></li>
  <li>ผู้ดูแล / STAFF</li>
</ul>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%"><h1 class="pagetitle">ผู้ดูแล / STAFF</h1></td>
    <td width="30%" class="text-center"> </td>
  </tr>
</table>
<p class="line-brown"></p>
<div class="detail-page">
  <form action="" method="post">
  
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="4" cellpadding="0">
            <tr>
              <td width="71%" align="left"><a class="btn btn-success" href="{{URL::to('backoffice_management/staffadd#admin')}}">เพิ่ม | Add New</a></td>
              <td width="18%" align="left">
          <?php     /*<select name="action_up" class="form-control"id="action_up" style="float:right">
                  <option value="" selected="selected">-เลือก-</option>
                  <option value="เผยแพร่ | Publish">เผยแพร่ | Publish</option>
                  <option value="ซ่อน | Unpublish">ซ่อน | Unpublish</option>
                  <option value="ลบ | Delete">ลบ | Delete</option>
                </select><input type="submit" name="submit" value="Apply" class="btn btn-primary" style="margin-left:5px" />*/ ?></td>
              <td width="11%" align="left"></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="table table-striped">
            <thead>
              <tr align="center">
                <td width="31%"><strong>Username</strong></td>
                <td width="20%"><strong> Username</strong></td>
                <td width="16%"><strong>วันที่สร้าง/
                  วันที่แก้ไข</strong></td>
                <td width="18%"><strong>Level</strong></td>
                <td width="6%"><strong>Edit</strong></td>
              </tr>
            </thead>
            <tbody> 
            @foreach($DBStaff as $row)
            <tr>
              <td>{{$row->staff_username}}</td>
              <td align="center">
              {{$row->staff_username}}
              </td>
              <td align="center">{{date("d F Y", strtotime($row->staff_created)) }}</td>
              <td align="center">  
              <?php
              		if($row->staff_level == '1'){
						echo "Administor";
					}else if($row->staff_level == '2'){
						echo "Staff Web Management";
					}else if($row->staff_level == '3'){
						echo "Staff Report Management";		
					}
			  ?> 
           </td>
              <td align="center"><a href="staffEdit/{{$row->staff_ID}}"><img src="{{asset('images/png/glyphicons_030_pencil.png')}}" width="20" height="20" /></a></td>
            </tr>
            @endforeach
              </tbody>
            
          </table></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
  </form>
</div>
<p class="line-brown clear"></p>
@stop