@extends('layout.master')
@section('content')

<ul class="breadcrumbs">
  <li><a href="movie#theater">Home &gt;<i class="iconfa-home"></i></a> <span class="separator"></span></li>
  <li>Staff</li>
</ul>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%"><h1 class="pagetitle">Staff Edit</h1></td>
    <td width="30%" class="text-center"></td>
  </tr>
</table>
<p class="line-brown"></p>
@foreach ($DataStaff as $row)
<div class="detail-page">
  <form action="{{URL::to('backoffice_management/staffEdit#admin')}} " method="post" name="newsForm" class="form-horizontal form-page formular"id="newsForm" role="form">
    <div class="form-group">
      <label for="title" class="col-lg-3 control-label">Name</label>
      <div class="col-lg-9">
        <input type="text" class="validate[required] form-control"  name="staff_name" id="staff_name" placeholder="Name" value="{{$row->staff_name}}">
      </div>
    </div>
    
     <div class="form-group">
      <label for="title" class="col-lg-3 control-label">Username :</label>
      <div class="col-lg-9">
        <input  name="username" type="text" disabled="disabled" class="validate[minSize[6],custom[onlyLetterNumber]] form-control" id="username" placeholder="Username" readonly="readonly"  value="{{$row->staff_username}}">
      </div>
    </div>
     <div class="form-group">
      <label for="title" class="col-lg-3 control-label">New Password :</label>
      <div class="col-lg-9">
        <input type="password" class="validate[minSize[6]] form-control"  name="password" id="password" placeholder="Password">
      </div>
    </div>
     <div class="form-group">
      <label for="title" class="col-lg-3 control-label">Confirm Password :</label>
      <div class="col-lg-9">
        <input type="password" class="validate[equals[password]]  form-control"  name="cf_password" id="cf_password" placeholder="Confirm Password">
      </div>
    </div>
     <div class="form-group">
      <label for="staff_email" class="col-lg-3 control-label">Email</label>
      <div class="col-lg-9">
        <input type="text" class="validate[required] form-control"  name="staff_email" id="staff_email" placeholder="email"  value="{{$row->staff_email}}">
      </div>
    </div>
     <div class="form-group">
      <label for="title" class="col-lg-3 control-label">Level :</label>
      <div class="col-lg-9">
       <select name="level"  class="form-control">
          <option value="1" <?php if($row->staff_level == 1){?> selected="selected" <?php }?>>Administor</option>
          <option value="2" <?php if($row->staff_level == 2){?> selected="selected" <?php }?> >Staff Web Management</option>
          <option value="3" <?php if($row->staff_level == 3){?> selected="selected" <?php }?> >Staff Report Management</option>
        </select>
      </div>
    </div>
  
    <div class="form-group">
      <div class="col-lg-offset-3 col-lg-9">
        <input type="submit" name="action" value="บันทึก | Save" class="btn btn-primary" />
        <input name="action" type="hidden" id="action" value="submit" />
        <input name="staff_ID" type="hidden" id="staff_ID" value="{{$row->staff_ID}}" />
      </div>
    </div>
     <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
  </form>
</div>
@endforeach 
<p class="line-brown clear"></p>
<script>
jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
  jQuery("#newsForm").validationEngine('attach', {promptPosition : "topLeft"});
	 
});
</script>
@stop