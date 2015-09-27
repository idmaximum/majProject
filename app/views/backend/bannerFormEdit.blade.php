@extends('layout.master')
@section('content')
<ul class="breadcrumbs">
  <li><a href="cenima">Home &gt;<i class="iconfa-home"></i></a> <span class="separator"></span></li>
  <li>News</li>
</ul>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%"><h1 class="pagetitle">News Edit</h1></td>
    <td width="30%" class="text-center"></td>
  </tr>
</table>
<p class="line-brown"></p>
<div class="detail-page"> @foreach ($DataSelect as $row)
  <form method="post" enctype="multipart/form-data" name="newsForm" class="form-horizontal form-page formular"id="newsForm" role="form">
    <div class="form-group">
      <label for="banner_name" class="col-lg-3 control-label">หัวข้อ</label>
      <div class="col-lg-9">
        <input  name="banner_name" type="text" class="validate[required] form-control" id="title" placeholder="หัวข้อ" value="{{$row->banner_name}}">
      </div>
    </div>
   
    <div class="form-group">
      <label for="file1" class="col-lg-3 control-label">อัพโหลดรูปประกอบ</label>
      <div class="col-lg-9">
        <input name="file1" type="file"id="imgInp" >
        <p class="help-block">ขนาดความกว้าง 1024x320 พิกเซล ขนาดไฟล์ไม่เกิน 1 MB.<br />
          (อนุญาติเฉพาะไฟล์ .gif  .png .jpg .jpeg เท่านั้น)</p>
        <div class="pic-img"> <img id="targetEdit" src="{{asset('uploads/banner')}}/{{$row->banner_pic}}" alt="your image"style="max-width:400px;  max-height:250px"/> </div>
      </div>
    </div>
    <div class="form-group">
      <label for="file2" class="col-lg-3 control-label">อัพโหลดรูปประกอบ</label>
      <div class="col-lg-9">
        <input name="file2" type="file"id="imgInp2" >
        <p class="help-block">ขนาดความกว้าง 2048x640 พิกเซล ขนาดไฟล์ไม่เกิน 1 MB.<br />
          (อนุญาติเฉพาะไฟล์ .gif  .png .jpg .jpeg เท่านั้น)</p>
        <div class="pic-img"> <img id="targetEdit2" src="{{asset('uploads/banner')}}/{{$row->banner_picMobile}}" alt="your image"style="max-width:400px;  max-height:250px"/> </div>
      </div>
    </div>
     <div class="form-group">
      <label for="banner_url" class="col-lg-3 control-label">Url</label>
      <div class="col-lg-9">
        <input  name="banner_url" type="text" class="validate[required] form-control" id="title" placeholder="Url" value="{{$row->banner_url}}">
      </div>
    </div>
    
   
    <div class="form-group">
      <div class="col-lg-offset-3 col-lg-9">
        <input type="submit" name="action" value="บันทึก | Save" class="btn btn-primary" />
        <input name="action" type="hidden" id="action" value="submit" />
        <input name="oldImage" type="hidden" id="banner_pic" value="{{$row->banner_pic}}" />
        <input name="oldImageMobile" type="hidden" id="banner_picMobile" value="{{$row->banner_picMobile}}" />
        <input name="banner_ID" type="hidden" id="banner_ID" value="{{$row->banner_ID}}" />
      </div>
    </div>
  </form>
  @endforeach </div>
<p class="line-brown clear"></p>
{{ HTML::script('packages/ckeditor_/ckeditor.js') }} 
<script>
jQuery(document).ready(function(){
	CKEDITOR.replace( 'editor1' );
	// binds form submission and fields to the validation engine
	jQuery("#newsForm").validationEngine('attach', {promptPosition : "topLeft"});	
	
	 function readURL(input) {
	  if (input.files && input.files[0]) {
		  var reader = new FileReader();            
		  reader.onload = function (e) {
			 jQuery(target).fadeIn(1500);
			 jQuery(target).attr('src', e.target.result);
		  }
		  
		  reader.readAsDataURL(input.files[0]);
	  }
 	 }
    
    jQuery("#imgInp").change(function(){
        readURL(this,'#targetEdit');
   	 });	  
	  jQuery("#imgInp2").change(function(){
        readURL(this,'#targetEdit2');
   	 });	   
	});
</script> 
@stop 