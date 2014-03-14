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
<div class="detail-page">
  <form method="post" enctype="multipart/form-data" name="newsForm" class="form-horizontal form-page formular"id="newsForm" role="form">
    <div class="form-group">
      <label for="title" class="col-lg-3 control-label">หัวข้อ</label>
      <div class="col-lg-9">
        <input type="text" class="validate[required] form-control"  name="title" id="title" placeholder="หัวข้อ">
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
        <input type="text" class="validate[required] form-control" name="title_ch"  id="title_ch" placeholder="หัวข้อ (CN)">
      </div>
    </div>
    <div class="form-group">
            <label for="file1" class="col-lg-3 control-label">อัพโหลดรูปประกอบ</label>
            <div class="col-lg-9">
              <input name="file1" type="file" id="file1">
    <p class="help-block">ขนาดความกว้าง 800x600 พิกเซล ขนาดไฟล์ไม่เกิน 1 MB.<br />
(อนุญาติเฉพาะไฟล์ .gif  .png .jpg .jpeg เท่านั้น)</p>
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
	  jQuery("#formID1").validationEngine('attach', {promptPosition : "topLeft"});		     
	});
</script>
@stop
