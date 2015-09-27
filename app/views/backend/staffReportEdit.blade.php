<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
{{HTML::style('css/font.css')}}
{{HTML::style('js/bootstrap/css/bootstrap.css')}}
{{HTML::style('js/bootstrap/css/bootstrap-theme.css')}}
{{HTML::style('css/css-bof.css')}}
{{HTML::style('js/formValidator/css/validationEngine.jquery.css')}}
<style type="text/css">
body {
	margin: 0px;
	padding: 0px;
	background-image: none
}
#main-template {
	margin: auto;
	width: 800px;
	padding-top: 30px;
}
</style>
</head> 
<body>
@foreach ($DataStaff as $row)
<div class="detail-page">
<?php if($submitStatus){ ?>
<div class="well well-sm">Update Profile Successfully</div>
    <?php }?>
  <form action="{{URL::to('backoffice_management/profile#admin')}} " method="post" name="newsForm" class="form-horizontal form-page formular"id="newsForm" role="form" style="width:550px;"> 
     <div class="form-group">
      <label for="title" class="col-lg-3 control-label">Username :</label>
      <div class="col-lg-9">
        <input  name="username" type="text" disabled="disabled" class="validate[minSize[6],custom[onlyLetterNumber]] form-control" id="username" placeholder="Username" readonly="readonly"  value="{{$row->staff_username}}"  style="width:550px;">
      </div>
    </div>
     <div class="form-group">
      <label for="title" class="col-lg-3 control-label">New Password :</label>
      <div class="col-lg-9">
        <input type="password" class="validate[minSize[6]] form-control"  name="password" id="password" placeholder="Password"  style="width:550px;">
      </div>
    </div>
     <div class="form-group">
      <label for="title" class="col-lg-3 control-label">Confirm Password :</label>
      <div class="col-lg-9">
        <input type="password" class="validate[equals[password]]  form-control"  name="cf_password" id="cf_password" placeholder="Confirm Password"  style="width:550px;">
      </div>
    </div> 
       <div class="form-group">
      <label for="staff_email" class="col-lg-3 control-label">Email</label>
      <div class="col-lg-9">
        <input type="text" class="validate[required] form-control"  name="staff_email" id="staff_email" placeholder="email"  value="{{$row->staff_email}}" style="width:550px;">
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
{{ HTML::script('js/jquery-1.8.js') }}
{{ HTML::script('js/bootstrap/js/bootstrap.min.js') }}
{{ HTML::script('js/formValidator/js/languages/jquery.validationEngine-en.js') }}
{{ HTML::script('js/formValidator/js/jquery.validationEngine.js') }}
<script>
jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
  jQuery("#newsForm").validationEngine('attach', {promptPosition : "topLeft"}); 
});
</script>
</body>
</html>