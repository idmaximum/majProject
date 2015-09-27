@extends('layout.master')
@section('content')

<ul class="breadcrumbs">
  <li><a href="cenima">Home &gt;<i class="iconfa-home"></i></a> <span class="separator"></span></li>
  <li>News</li>
</ul>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%"><h1 class="pagetitle">News Add</h1></td>
    <td width="30%" class="text-center"></td>
  </tr>
</table>
<p class="line-brown"></p>
<ul>
  @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
  @endforeach
</ul>
<div class="detail-page">
  <form action="{{URL::to('backoffice_management/create#admin')}} " method="post" name="newsForm" class="form-horizontal form-page formular"id="newsForm" role="form">
    <div class="form-group">
      <label for="title" class="col-lg-3 control-label">Name</label>
      <div class="col-lg-9">
        <input type="text" class="validate[required] form-control"  name="name" id="name" placeholder="Name">
      </div>
    </div>
    
     <div class="form-group">
      <label for="title" class="col-lg-3 control-label">Username :</label>
      <div class="col-lg-9">
        <input type="text" class="validate[required,minSize[6],custom[onlyLetterNumber]] form-control"  name="username" id="username" placeholder="Username">
      </div>
    </div>
     <div class="form-group">
      <label for="title" class="col-lg-3 control-label">Password :</label>
      <div class="col-lg-9">
        <input type="password" class="validate[required,minSize[6]] form-control"  name="password" id="password" placeholder="Password">
      </div>
    </div>
     <div class="form-group">
      <label for="title" class="col-lg-3 control-label">Confirm Password :</label>
      <div class="col-lg-9">
        <input type="password" class="validate[required,equals[password]]  form-control"  name="cf_password" id="cf_password" placeholder="Confirm Password">
      </div>
    </div>
     <div class="form-group">
      <label for="title" class="col-lg-3 control-label">Email</label>
      <div class="col-lg-9">
        <input type="text" class="validate[required] form-control"  name="email" id="email" placeholder="email">
      </div>
    </div>
     <div class="form-group">
      <label for="title" class="col-lg-3 control-label">Level :</label>
      <div class="col-lg-9">
        <select name="level"  class="form-control">
          <option value="1" >Administor</option>
          <option value="2"  >Staff Web Management</option>
          <option value="3"  >Staff Report Management</option>
        </select>
      </div>
    </div>
  
    <div class="form-group">
      <div class="col-lg-offset-3 col-lg-9">
        <input type="submit" name="action" value="บันทึก | Save" class="btn btn-primary" />
        <input name="action" type="hidden" id="action" value="submit" />
      </div>
    </div>
     <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
  </form>
</div>
<p class="line-brown clear"></p>
<script>
jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
  jQuery("#newsForm").validationEngine('attach', {promptPosition : "topLeft"});
	 
});
</script>
@stop