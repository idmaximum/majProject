@foreach ($rowNews as $row)<?php 
	 $newsName =	$row->news_title_en;
	 $newsNameSub =  str_replace_text($newsName); 
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>{{$newsName}}</title> 
<meta property="og:image" content="http://www.embassycineplex.com/uploads/news/{{$row->news_imageThumb}}" />
<meta name="description" content="{{$row->news_abstract_en}}" />
<meta name="keywords" content="embassy, diplomat, ais, central, ดูหนัง, หนังใหม่, โรงหนัง, โรงภาพยนตร์"/>

{{HTML::style('css/reset.css')}}
{{HTML::style('css/font.css')}}
{{HTML::style('css/screen.css')}}
{{HTML::style('css/screen2.css')}} 
{{HTML::style('css/screenInside.css')}} 
{{HTML::style('js/DropDown/css/style.css')}}
{{HTML::style('js/ADGallery/lib/jquery.ad-gallery.css')}}
@include('frontend.incScriptTop') 
</head>
<body>
<div id="main">
  @include('frontend.incHeader') 
  	<div id="content" class="content-main">
    <div class="title-promotion">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="614"><a href="{{URL::to('event_activity')}}"><img src="{{asset('images/btn-back.png')}}" width="90" height="30" class="hoverImg08"></a></td>
          <td width="319" align="right"><img src="{{asset('images/title-share.png')}}" width="50" height="30"></td>
          <td width="91" align="center">
          <a href="http://www.facebook.com/sharer.php?u=http://www.embassycineplex.com/event_activity/{{$row->news_ID}}/{{$newsNameSub}}&t={{$newsName}}" class="hoverImg08" target="_blank"><img src="{{asset('images/ic-fb-share.jpg')}}" width="30" height="30"></a> 
              <a href="http://twitter.com/home?status={{$newsName}} http://www.embassycineplex.com/event_activity/{{$row->news_ID}}/{{$newsNameSub}}&t={{$newsName}}" class="hoverImg08" target="_blank"><img src="{{asset('images/ic-tw-share.jpg')}}" width="30" height="30"></a></td>
        </tr>
      </table>
    </div>
    <div class="contentPage">
      <div class="content-left-page">
       @foreach($rowCountGallery as $CountGallery)
          	<?php $CountGallery = $CountGallery->countGallery?>
          @endforeach
         <?php if($CountGallery > 0){?>
        <div id="gallery" class="ad-gallery">
      <div class="ad-image-wrapper">
      </div> 
      <div class="ad-nav">
        <div class="ad-thumbs">
          <ul class="ad-thumb-list">
          @foreach($rowNewsGallery as $rowGallery)
          <?php $GalleryNews = $rowGallery->news_ImageThumb;?>
            <li>
              <a href="{{URL::to("uploads/news/"."$GalleryNews")}}">
                <img src="{{asset('uploads/news')}}/{{$GalleryNews}}" class="image" style="max-height:100px; ">
              </a>
            </li>
             @endforeach
          </ul>
        </div>
      </div>
    </div> 
   		 <?php }else{?>
      	<img src="{{asset('uploads/news/'.$row->news_imageThumb)}}"  style="max-width:630px"> 
      	<?php }?>
       <?php if($row->news_youtube != ""){
		   $item_youtube = substr($row->news_youtube,-11,11);
		?>
      <iframe width="640" height="400" src="//www.youtube.com/embed/{{$item_youtube}}" frameborder="0" allowfullscreen style="margin-top:35px"></iframe>
      <?php }?> 
      </div>
      <div class="content-right-page">
        <h2 class="txtWhite30 fontMobile">{{$row->news_title_en}}</h2>
        <p class="timeShow fontMobile">{{ date('d F Y', strtotime($row->news_datetime))}}</p>
        <div class="txtBrown18_2 fontMobile">{{nl2br($row->news_detail_en)}}</div>
      </div>
      <p class="clear" style="height:60px"></p>
    </div>
  </div>    
  @include('frontend.incFooter')
</div> 
@include('frontend.incScriptBottom') 
</body>
</html>
@endforeach
{{ HTML::script('js/ADGallery/lib/jquery.ad-gallery.js') }} 
<script type="text/javascript">
  jQuery(function() { 
    var galleries = jQuery('.ad-gallery').adGallery(); 
  });
</script>