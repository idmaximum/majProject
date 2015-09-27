<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
{{HTML::style('css/font.css')}}
{{HTML::style('js/bootstrap/css/bootstrap.css')}}
{{HTML::style('js/bootstrap/css/bootstrap-theme.css')}}
{{HTML::style('css/css-bof.css')}}
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
.picImg{ display:none}
</style>
</head> 
<body>
<div id="main-template" >
<form method="post" enctype="multipart/form-data" name="promotionForm" class="form-horizontal form-page formular"id="promotionForm" role="form">
 
 <h1 class="pagetitle">Add News Gallery </h1> 
 <div style="padding:10px">
 	
 	<p class="line-brown"></p>
    </div>
     <div class="form-group">
      <label for="file2" class="col-lg-3 control-label">อัพโหลดรูปประกอบ</label>
      <div class="col-lg-9">
        <input name="file1" type="file"id="imgInp1" >
        <p class="help-block">ขนาดความกว้าง 640*400 พิกเซล ขนาดไฟล์ไม่เกิน 1 MB.<br />
          (อนุญาติเฉพาะไฟล์ .gif  .png .jpg .jpeg เท่านั้น)</p>
        <div class="pic-img"> <img id="target1" src="#" alt="your image"style="max-width:250px;  max-height:250px" class="picImg"/> </div>
      </div>
    </div>
    <div class="form-group">
      <label for="file2" class="col-lg-3 control-label">อัพโหลดรูปประกอบ</label>
      <div class="col-lg-9">
        <input name="file2" type="file"id="imgInp2" >
        <p class="help-block">ขนาดความกว้าง 640*400 พิกเซล ขนาดไฟล์ไม่เกิน 1 MB.<br />
        (อนุญาติเฉพาะไฟล์ .gif  .png .jpg .jpeg เท่านั้น)</p>
        <div class="pic-img"> <img id="target2" src="#" alt="your image"style="max-width:250px;  max-height:250px"  class="picImg"/> </div>
      </div>
    </div>
    <div class="form-group">
      <label for="file2" class="col-lg-3 control-label">อัพโหลดรูปประกอบ</label>
      <div class="col-lg-9">
        <input name="file3" type="file"id="imgInp3" >
        <p class="help-block">ขนาดความกว้าง 640*400 พิกเซล ขนาดไฟล์ไม่เกิน 1 MB.<br />
        (อนุญาติเฉพาะไฟล์ .gif  .png .jpg .jpeg เท่านั้น)</p>
        <div class="pic-img"> <img id="target3" src="#" alt="your image"style="max-width:250px;  max-height:250px"  class="picImg"/> </div>
      </div>
    </div>
    <div class="form-group">
      <label for="file2" class="col-lg-3 control-label">อัพโหลดรูปประกอบ</label>
      <div class="col-lg-9">
        <input name="file4" type="file" id="imgInp4" >
        <p class="help-block">ขนาดความกว้าง 640*400 พิกเซล ขนาดไฟล์ไม่เกิน 1 MB.<br />
        (อนุญาติเฉพาะไฟล์ .gif  .png .jpg .jpeg เท่านั้น)</p>
        <div class="pic-img"> <img id="target4" src="#" alt="your image"style="max-width:250px;  max-height:250px"  class="picImg"/> </div>
      </div>
    </div>
    <div class="form-group">
      <label for="file2" class="col-lg-3 control-label">อัพโหลดรูปประกอบ</label>
      <div class="col-lg-9">
        <input name="file5" type="file"id="imgInp5" >
        <p class="help-block">ขนาดความกว้าง 640*400 พิกเซล ขนาดไฟล์ไม่เกิน 1 MB.<br />
        (อนุญาติเฉพาะไฟล์ .gif  .png .jpg .jpeg เท่านั้น)</p>
        <div class="pic-img"> <img id="target5" src="#" alt="your image"style="max-width:250px;  max-height:250px"  class="picImg"/> </div>
      </div>
    </div>
     <div class="form-group">
      <div class="col-lg-offset-3 col-lg-9">
        <input type="submit" name="action" value="บันทึก | Save" class="btn btn-primary" />
        <input name="action" type="hidden" id="action" value="submit" />
      </div>
    </div>
 
 <input name="news_ID" type="hidden" value="{{$news_ID}}">
 </form>
 </div>
 {{ HTML::script('js/jquery-1.8.js') }}
 <script>
jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine  
	 
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
    
    jQuery("#imgInp1").change(function(){
        readURL(this, "#target1");
   	 });
	  jQuery("#imgInp2").change(function(){
        readURL(this, "#target2");
   	 });
	  jQuery("#imgInp3").change(function(){
        readURL(this, "#target3");
   	 });
	  jQuery("#imgInp4").change(function(){
        readURL(this, "#target4");
   	 });
	  jQuery("#imgInp5").change(function(){
        readURL(this, "#target5");
   	 });
	      
	});
</script> 
</body>
</html>