@extends('layout.master')
@section('content')
{{HTML::style('js/formValidator/css/validationEngine.jquery.css')}}
{{HTML::style('js/jqueryUI/development-bundle/themes/base/jquery.ui.all.css')}}
<style type="text/css">
.ui-datepicker{  
    width:220px;  
    font-family:tahoma;  
    font-size:10px;  
    text-align:center;  
}  
</style>
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
<div class="detail-page"> @foreach ($News as $row)
  <form method="post" enctype="multipart/form-data" name="newsForm" class="form-horizontal form-page formular"id="newsForm" role="form">
    <div class="form-group">
      <label for="title" class="col-lg-3 control-label">หัวข้อ</label>
      <div class="col-lg-9">
        <input  name="title_th" type="text" class="validate[required] form-control" id="title" placeholder="หัวข้อ" value="{{$row->news_title_th}}">
      </div>
    </div>
    <div class="form-group">
      <label for="title_en" class="col-lg-3 control-label">หัวข้อ (EN)</label>
      <div class="col-lg-9">
        <input type="text" class="validate[required] form-control" name="title_en"  id="title_en" placeholder="หัวข้อ (EN)" value="{{$row->news_title_en}}">
      </div>
    </div>
    <div class="form-group">
      <label for="title_ch" class="col-lg-3 control-label">หัวข้อ (CN)</label>
      <div class="col-lg-9">
        <input type="text" class="validate[required] form-control" name="title_cn"  id="title_cn" placeholder="หัวข้อ (CN)" value="{{$row->news_title_cn}}">
      </div>
    </div>
      <div class="form-group">
      <label for="news_datetime" class="col-lg-3 control-label">วันจัดกิจกรรม</label>
      <div class="col-lg-9">
        <input type="text" class="validate[required] form-control datepicker" name="news_datetime"  id="news_datetime" placeholder="หัวข้อ (CN)" value="{{date('Y-m-d', strtotime($row->news_datetime))  }}">
      </div>
    </div>
    
    <div class="form-group">
      <label for="news_abstract_th" class="col-lg-3 control-label">คำเกริ่น (TH)</label>
      <div class="col-lg-9">
        <textarea name="news_abstract_th" class="validate[required] form-control"  cols="90" rows="10" id="news_abstract_th">{{$row->news_abstract_th}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="news_abstract_en" class="col-lg-3 control-label">คำเกริ่น (EN)</label>
      <div class="col-lg-9">
        <textarea name="news_abstract_en" class="validate[required] form-control"  cols="90" rows="10" id="news_abstract_en">{{$row->news_abstract_en}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="news_abstract_cn" class="col-lg-3 control-label">คำเกริ่น (CN)</label>
      <div class="col-lg-9">
        <textarea name="news_abstract_cn" class="validate[required] form-control"  cols="90" rows="10" id="news_abstract_cn">{{$row->news_abstract_cn}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="file1" class="col-lg-3 control-label">อัพโหลดรูปประกอบ</label>
      <div class="col-lg-9">
        <input name="file1" type="file"id="imgInp" >
        <p class="help-block">ขนาดความกว้าง 640x400  พิกเซล ขนาดไฟล์ไม่เกิน 1 MB.<br />
          (อนุญาติเฉพาะไฟล์ .gif  .png .jpg .jpeg เท่านั้น)</p>
        <div class="pic-img"> <img id="targetEdit" src="{{asset('uploads/news')}}/{{$row->news_imageThumb}}" alt="your image"style="max-width:250px;  max-height:250px"/> </div>
      </div>
    </div>
    <div class="form-group">
      <label for="title" class="col-lg-3 control-label">VDO Youtube </label>
      <div class="col-lg-9">
        <input type="text" class="form-control"  name="news_youtube" id="news_youtube" placeholder="VDO Youtube" value="{{$row->news_youtube}}">
      </div>
    </div>
    <div class="form-group">
      <label for="news_detail" class="col-lg-3 control-label">รายละเอียด</label>
      <div class="col-lg-9">
        <textarea name="detail_th" class="validate[required] form-control"  cols="90" rows="20" id="detail_th">{{$row->news_detail_th}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="news_detail" class="col-lg-3 control-label">รายละเอียด (EN) </label>
      <div class="col-lg-9">
        <textarea name="detail_en" class="validate[required] form-control"  cols="90" rows="20" id="detail_en" >{{$row->news_detail_th}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="news_detail" class="col-lg-3 control-label">รายละเอียด (CH) </label>
      <div class="col-lg-9">
        <textarea name="detail_cn" class="validate[required] form-control"  cols="90" rows="20" id="detail_cn" >{{$row->news_detail_cn}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-offset-3 col-lg-9">
        <input type="submit" name="action" value="บันทึก | Save" class="btn btn-primary" />
        <input name="action" type="hidden" id="action" value="submit" />
        <input name="oldImage" type="hidden" id="news_imageThumb" value="{{$row->news_imageThumb}}" />
        <input name="newsID" type="hidden" id="news_ID" value="{{$row->news_ID}}" />
      </div>
    </div>
  </form>
  @endforeach </div>
<p class="line-brown clear"></p>
{{ HTML::script('js/jqueryUI/development-bundle/ui/jquery.ui.core.js') }}
{{ HTML::script('js/jqueryUI/development-bundle/ui/jquery.ui.widget.js') }}
{{ HTML::script('js/jqueryUI/development-bundle/ui/jquery.ui.datepicker.js') }}  
<script>
jQuery(document).ready(function(){
	jQuery( ".datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
	// binds form submission and fields to the validation engine
	jQuery("#newsForm").validationEngine('attach', {promptPosition : "topLeft"});	
	
	 function readURL(input) {
	  if (input.files && input.files[0]) {
		  var reader = new FileReader();            
		  reader.onload = function (e) {
			  jQuery('#targetEdit').fadeIn(1500);
			  jQuery('#targetEdit').attr('src', e.target.result);
		  }
		  
		  reader.readAsDataURL(input.files[0]);
	  }
 	 }
    
    jQuery("#imgInp").change(function(){
        readURL(this);
   	 });	     
	});
</script> 
@stop 