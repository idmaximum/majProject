@extends('layout.master')
@section('content')
<ul class="breadcrumbs">
  <li><a href="cenima">Home &gt;<i class="iconfa-home"></i></a> <span class="separator"></span></li>
  <li>Banner</li>
</ul>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%"><h1 class="pagetitle"> Add Banner</h1></td>
    <td width="30%" class="text-center"></td>
  </tr>
</table>
<p class="line-brown"></p>
<div class="detail-page">
<form method="post" enctype="multipart/form-data" name="bannerAdd" class="form-horizontal form-page formular"id="bannerAdd" role="form">
  <div class="form-group">
    <label for="banner_name" class="col-lg-3 control-label">หัวข้อ </label>
    <div class="col-lg-9">
      <input type="text" class="validate[required] form-control"  name="banner_name" id="banner_name" placeholder="หัวข้อ">
    </div>
  </div>
   
  <div class="form-group">
    <label for="file1" class="col-lg-3 control-label">อัพโหลดรูปประกอบ</label>
    <div class="col-lg-9">
      <input name="file1" type="file"id="imgInp" class="validate[required] " >
      <p class="help-block">ขนาดความกว้าง 1024x320 พิกเซล ขนาดไฟล์ไม่เกิน 1 MB.<br />
        (อนุญาติเฉพาะไฟล์ .gif  .png .jpg .jpeg เท่านั้น)</p>
      <div class="pic-img"> <img id="target" src="#" alt="your image"style="max-width:250px;  max-height:250px"/> </div>
    </div>
  </div>
  <div class="form-group">
    <label for="file2" class="col-lg-3 control-label">อัพโหลดรูปประกอบ</label>
    <div class="col-lg-9">
      <input name="file2" type="file"id="imgInp2" >
      <p class="help-block">ขนาดความกว้าง 2048x640 พิกเซล ขนาดไฟล์ไม่เกิน 1 MB.<br />
        (อนุญาติเฉพาะไฟล์ .gif  .png .jpg .jpeg เท่านั้น)</p>
      <div class="pic-img"> <img id="target2" src="#" alt="your image"style="max-width:250px;  max-height:250px"/> </div>
    </div>
  </div>
  
   <div class="form-group">
    <label for="banner_url" class="col-lg-3 control-label">Url </label>
    <div class="col-lg-9">
      <input type="text" class="form-control"  name="banner_url" id="banner_url" placeholder="Url">
      <br />
      Ex. http://www.website.com
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-lg-offset-3 col-lg-9">
      <input type="submit" name="action" value="บันทึก | Save" class="btn btn-primary" />
      <input name="action" type="hidden" id="action" value="submit" />
    </div>
  </div>
</form>
</div>
<p class="line-brown clear"></p>
<script>
jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#bannerAdd").validationEngine('attach', {promptPosition : "topLeft"});	
	
	 function readURL(input,target) {
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
        readURL(this,'#target');
   	 });	
	 
	  jQuery("#imgInp2").change(function(){
        readURL(this,'#target2');
   	 });     
	});
</script> 
@stop 