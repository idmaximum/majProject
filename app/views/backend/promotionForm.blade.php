@extends('layout.master')
@section('content')
<ul class="breadcrumbs">
  <li><a href="cenima">Home &gt;<i class="iconfa-home"></i></a> <span class="separator"></span></li>
  <li>promotion</li>
</ul>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%"><h1 class="pagetitle">promotion Add</h1></td>
    <td width="30%" class="text-center"></td>
  </tr>
</table>
<p class="line-brown"></p>
<div class="detail-page">
  <form method="post" enctype="multipart/form-data" name="promotionForm" class="form-horizontal form-page formular"id="promotionForm" role="form">
    <div class="form-group">
      <label for="title" class="col-lg-3 control-label">หัวข้อ (TH)</label>
      <div class="col-lg-9">
        <input type="text" class="validate[required] form-control"  name="title_th" id="title_th" placeholder="หัวข้อ">
      </div>
    </div>
    <div class="form-group">
      <label for="title_en" class="col-lg-3 control-label">หัวข้อ (EN)</label>
      <div class="col-lg-9">
        <input type="text" class="validate[required] form-control" name="title_en"  id="title_en" placeholder="หัวข้อ (EN)">
      </div>
    </div>
    <div class="form-group">
      <label for="title_ch" class="col-lg-3 control-label">หัวข้อ (CN)</label>
      <div class="col-lg-9">
        <input type="text" class="validate[required] form-control" name="title_cn"  id="title_cn" placeholder="หัวข้อ (CN)">
      </div>
    </div>
    <div class="form-group">
      <label for="promotion_datetime" class="col-lg-3 control-label">วันจัดกิจกรรม</label>
      <div class="col-lg-9">
        <input type="text" class="validate[required] form-control"  name="promotion_datetime" id="promotion_datetime" placeholder="EX. 24 April – 22 May 2557">
      </div>
    </div>
    
    <div class="form-group">
      <label for="promotion_abstract_th" class="col-lg-3 control-label">คำเกริ่น (TH)</label>
      <div class="col-lg-9">
        <textarea name="promotion_abstract_th" class="validate[required] form-control"  cols="90" rows="10" id="promotion_abstract_th" ></textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="promotion_abstract_en" class="col-lg-3 control-label">คำเกริ่น (EN)</label>
      <div class="col-lg-9">
        <textarea name="promotion_abstract_en" class="validate[required] form-control"  cols="90" rows="10" id="promotion_abstract_en" ></textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="promotion_abstract_cn" class="col-lg-3 control-label">คำเกริ่น (CN)</label>
      <div class="col-lg-9">
        <textarea name="promotion_abstract_cn" class="validate[required] form-control"  cols="90" rows="10" id="promotion_abstract_cn" ></textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="file1" class="col-lg-3 control-label">อัพโหลดรูปประกอบ</label>
      <div class="col-lg-9">
        <input name="file1" type="file"id="imgInp" >
        <p class="help-block">ขนาดความกว้าง 300x200 พิกเซล ขนาดไฟล์ไม่เกิน 1 MB.<br />
          (อนุญาติเฉพาะไฟล์ .gif  .png .jpg .jpeg เท่านั้น)</p>
        <div class="pic-img"> <img id="target" src="#" alt="your image"style="max-width:250px;  max-height:250px"/> </div>
      </div>
    </div>
    <div class="form-group">
      <label for="file2" class="col-lg-3 control-label">อัพโหลดรูปประกอบ</label>
      <div class="col-lg-9">
        <input name="file2" type="file"id="imgInp2" >
        <p class="help-block">ขนาดความกว้าง 640 พิกเซล ขนาดไฟล์ไม่เกิน 1 MB.<br />
          (อนุญาติเฉพาะไฟล์ .gif  .png .jpg .jpeg เท่านั้น)</p>
        <div class="pic-img"> <img id="target2" src="#" alt="your image"style="max-width:250px;  max-height:250px"/> </div>
      </div>
    </div>
    <div class="form-group">
      <label for="promotion_detail" class="col-lg-3 control-label">รายละเอียด (TH)</label>
      <div class="col-lg-9">
        <textarea name="detail_th" class="validate[required] form-control"  cols="90" rows="20" id="detail_th" ></textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="promotion_detail" class="col-lg-3 control-label">รายละเอียด (EN) </label>
      <div class="col-lg-9">
        <textarea name="detail_en" class="validate[required] form-control"  cols="90" rows="20" id="detail_en" ></textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="promotion_detail" class="col-lg-3 control-label">รายละเอียด (CN) </label>
      <div class="col-lg-9">
        <textarea name="detail_cn" class="validate[required] form-control"  cols="90" rows="20" id="detail_cn" ></textarea>
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
	jQuery("#promotionForm").validationEngine('attach', {promptPosition : "topLeft"});	
	
	 function readURL(input, target) {
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
	 var _URL = window.URL || window.webkitURL; 
	 var image, file;
    
		if ((file = this.files[0])) { 
			image = new Image(); 
			image.onload = function() { 
				if(this.width >  300){
					 alert("ความกว้างของภาพมีขนาดเกินที่กำหนดไว้"); 
					 
					}// end if chk
			};  
			 image.src = _URL.createObjectURL(file);  
			
		}
        readURL(this, "#target");
   	 });	
	 
	 jQuery("#imgInp2").change(function(){
        readURL(this, "#target2");
   	 });     
	});
</script> 
@stop 