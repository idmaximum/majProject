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
  <li>Movie Coming Soon</li>
</ul>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%"><h1 class="pagetitle">Add Coming Soon</h1></td>
    <td width="30%" class="text-center"></td>
  </tr>
</table>
<p class="line-brown"></p>
<div class="detail-page"> @foreach ($rowMovie as $row)
  <form method="post" enctype="multipart/form-data" name="movieEdit" class="form-horizontal form-page formular"id="newsForm" role="form">
  	<div class="form-group">
      <label for="title" class="col-lg-3 control-label">Movie ID</label>
      <div class="col-lg-9">
        <input  name="movie_strID" type="text" class="validate[required] form-control" id="title" placeholder="หัวข้อ" value="{{$row->movie_strID}}">
      </div>
    </div>
    <div class="form-group">
      <label for="title" class="col-lg-3 control-label">ชื่อเรื่อง (TH)</label>
      <div class="col-lg-9">
        <input  name="movie_Name_TH" type="text" class="validate[required] form-control" id="title" placeholder="หัวข้อ" value="{{$row->movie_Name_TH}}">
      </div>
    </div>
    <div class="form-group">
      <label for="title_en" class="col-lg-3 control-label">ชื่อเรื่อง (EN)</label>
      <div class="col-lg-9">
        <input type="text" class="validate[required] form-control" name="movie_Name_EN"  id="title_en" placeholder="หัวข้อ (EN)" value="{{$row->movie_Name_EN}}">
      </div>
    </div>
    <div class="form-group">
      <label for="title_ch" class="col-lg-3 control-label">ชื่อเรื่อง (CN)</label>
      <div class="col-lg-9">
        <input type="text" class="validate[required] form-control" name="movie_Name_CN"  id="title_cn" placeholder="หัวข้อ (CN)" value="{{$row->movie_Name_CN}}">
      </div>
    </div>
    <div class="form-group">
      <label for="file1" class="col-lg-3 control-label">อัพโหลดรูปประกอบ</label>
      <div class="col-lg-9">
        <input name="file1" type="file"id="imgInp" >
        <p class="help-block">ขนาดความกว้าง 230x340 พิกเซล ขนาดไฟล์ไม่เกิน 1 MB.<br />
          (อนุญาติเฉพาะไฟล์ .gif  .png .jpg .jpeg เท่านั้น)</p>
        <div class="pic-img">
           @if($row->movie_Img_Thumb != '')
        <img id="targetEdit" src="{{asset('uploads/movie')}}/{{$row->movie_Img_Thumb}}" alt="your image"style="max-width:250px;  max-height:250px"/>
         @else
               ไม่มีรูปประกอบ
              @endif 
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="news_detail" class="col-lg-3 control-label">เนื้อเรื่องย่อ (TH)</label>
      <div class="col-lg-9">
        <textarea name="movie_Synopsis_TH" class="validate[required] form-control"  cols="90" rows="10" id="detail_th">{{$row->movie_Synopsis_TH}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="news_detail" class="col-lg-3 control-label">เนื้อเรื่องย่อ (EN) </label>
      <div class="col-lg-9">
        <textarea name="movie_Synopsis_EN" class="validate[required] form-control"  cols="90" rows="10" id="detail_en" >{{$row->movie_Synopsis_EN}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="news_detail" class="col-lg-3 control-label">เนื้อเรื่องย่อ (CH) </label>
      <div class="col-lg-9">
        <textarea name="movie_Synopsis_CN" class="validate[required] form-control"  cols="90" rows="10" id="detail_cn" >{{$row->movie_Synopsis_CN}}</textarea>
      </div>
    </div>
    
    <div class="form-group">
      <label for="title" class="col-lg-3 control-label">Youtube  Trailer</label>
      <div class="col-lg-9">
        <input  name="movie_Youtube" type="text" class="form-control" id="movie_Youtube" placeholder="Youtube  Trailer" value="{{$row->movie_Youtube}}">
        <br />
        Ex. http://www.youtube.com/watch?v=G3Rzy7YqUVU
      </div>
    </div> 
     <div class="form-group">
      <label for="movie_Duration" class="col-lg-3 control-label">Duration</label>
      <div class="col-lg-9">
        <input  name="movie_Duration" type="text" class="form-control" id="movie_Duration" placeholder="Duration" value="{{$row->movie_Duration}}">
      </div>
    </div>
     <div class="form-group">
      <label for="movie_ReleaseDate" class="col-lg-3 control-label">Release Date</label>
      <div class="col-lg-9">
        <input  name="movie_ReleaseDate" type="text" class="form-control datepicker" id="movie_ReleaseDate" placeholder="Release Date" value="{{date("Y-m-d", strtotime($row->movie_ReleaseDate)) }}"> 
        EX.2014-04-24
      </div>
    </div>
     <div class="form-group">
      <label for="movie_Categories" class="col-lg-3 control-label">Genres</label>
      <div class="col-lg-9">
        <input  name="movie_Categories" type="text" class="form-control" id="movie_Categories" placeholder="Genres" value="{{$row->movie_Categories}}">
      </div>
    </div>
     <div class="form-group">
      <label for="movie_Directors" class="col-lg-3 control-label">Directors</label>
      <div class="col-lg-9">
        <input  name="movie_Directors" type="text" class="form-control" id="movie_Directors" placeholder="Directors" value="{{$row->movie_Directors}}">
      </div>
    </div>
     <div class="form-group">
       <label for="movie_Actors" class="col-lg-3 control-label">Actors</label>
      <div class="col-lg-9">
        <input  name="movie_Actors" type="text" class="form-control" id="movie_Actors" placeholder="Actors" value="{{$row->movie_Actors}}">
      </div>
    </div>
    
    <div class="form-group">
      <div class="col-lg-offset-3 col-lg-9">
        <input type="submit" name="action" value="บันทึก | Save" class="btn btn-primary" />
        <input name="action" type="hidden" id="action" value="submit" />
        <input name="oldImage" type="hidden" id="movie_Img_Thumb" value="{{$row->movie_Img_Thumb}}" />
        <input name="movieID" type="hidden" id="movieID" value="{{$row->movieID}}" /> 
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
	jQuery( ".datepicker" ).datepicker({ minDate: 0,   dateFormat: "yy-mm-dd" });
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