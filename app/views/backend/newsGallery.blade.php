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
</style>
</head> 
<body>
<form action="" method="post" enctype="multipart/form-data">
 <div id="main-template">
 <div style="padding:10px">
      <table width="100%" border="0" cellspacing="4" cellpadding="0" style="padding:10px"> 
        <tr>
          <td width="18%" align="left"><a class="btn btn-success" href="{{URL::to('backoffice_management/newsGalleryAdd/'."$news_ID")}} ">เพิ่ม | Add New</a></td>
          <td width="47%" align="left"><span class="panel-heading"><strong>จัดการ </strong><strong>News Gallery </strong></span></td>
          <td width="24%" align="left"> 
          	<select name="action_up" class="form-control"id="action" style="float:right">
            <option value="" selected="selected">-เลือก-</option>
     		  <?php  /*<option value="เผยแพร่ | Publish">เผยแพร่ | Publish</option>
            <option value="ซ่อน | Unpublish">ซ่อน | Unpublish</option>   */ ?>
            <option value="ลบ | Delete">ลบ | Delete</option>
            </select>
          </td>
          <td width="11%" align="left"><input type="submit" name="submit" value="Apply" class="btn btn-primary" style="margin-left:5px" /></td>
        </tr>
      </table>
    </div>
    <table width="100%" class="table">
      <thead>
        <tr>
          <th width="8%">#</th>
          <th width="65%"><strong>Images</strong></th>
          <th width="12%">&nbsp;</th>
          <th width="15%"><strong>Func.</strong> </th>
        </tr>
      </thead>
      <tbody><?php $num = '1';?>
      @foreach($NewsGallery as $row)
      
        <tr>
          <td align="center">{{$num++}}</td>
          <td><img src="{{asset('uploads/news')}}/{{$row->news_ImageThumb}}" alt="{{$row->news_ImageThumb}}"  style="max-width:300px" /></td>
          <td align="center">&nbsp;</td>
          <td align="center">  <label class="checkbox-inline">
                  <input type="checkbox"   name="news_Image_ID[]"  value="{{$row->news_Image_ID}}">
                </label></td>
        </tr> 
        @endforeach
      </tbody>
    </table>
 </div>
 </form>
</body>
</html>