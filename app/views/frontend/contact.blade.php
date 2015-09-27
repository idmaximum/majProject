<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Embassy Diplomat Screens by AIS</title>
<meta name="description" content="Embassy Diploment Screens" />
<meta name="keywords" content="embassy, diplomat, ais, central, ดูหนัง, หนังใหม่, โรงหนัง, โรงภาพยนตร์"/>
<meta property="og:image" content="http://www.embassycineplex.com/images/share.jpg" />
{{HTML::style('css/reset.css')}}
{{HTML::style('css/font.css')}}
{{HTML::style('css/screen.css')}}
{{HTML::style('css/screen2.css')}}
{{HTML::style('css/screen2.css')}}
{{HTML::style('css/screenInside.css')}}
{{HTML::style('js/formValidator/css/validationEngine.jquery.css')}} 
{{HTML::style('js/DropDown/css/style.css')}}
@include('frontend.incScriptTop')
<style type="text/css">
.contact-content-right sup {font-size:12px}
</style>
</head>
<body>
<div id="main">
  @include('frontend.incHeader') 
    @foreach($rowData as $rowDetail) 
 	 <div id="content" class="content-main">
    <h1 class="showToday">CONTACT US</h1>
    <div class="contentPage">
      <div class="contact-content-left">
        <iframe width="630" height="435" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.co.th/maps/ms?msa=0&amp;msid=214690672533320494157.0004f8ca093fe2e8d418a&amp;hl=th&amp;ie=UTF8&amp;ll=13.743585,100.547369&amp;spn=0,0&amp;t=m&amp;output=embed"></iframe>
        <p><a href="https://www.google.co.th/maps/ms?msa=0&amp;msid=214690672533320494157.0004f8ca093fe2e8d418a&amp;hl=th&amp;ie=UTF8&amp;ll=13.743585,100.547369&amp;spn=0,0&amp;t=m&amp;source=embed" target="_blank"><img src="images/view_contact_map.jpg" width="630" height="40" style="margin-top:-2px"></a></p>
        <?php  /* <p style="height:55px"> </p>
        <p class="txtGold24">Contact Form</p>
        <p class="line-brown">&nbsp;</p>
     <div class="form-contact">
          <form action="contactSend" method="post" accept-charset="utf-8" id="formContact">
            <p>&nbsp;</p>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><p>
                    <label for="name">Your Name</label>
                    <br />
                    <input type="text" name="name" value="" id="name" class="validate[required] inputContact">
                  </p></td>
                <td><p>
                    <label for="email">Email</label>
                    <br />
                    <input type="text" name="email" value="" id="email" class="validate[required,custom[email]]  inputContact">
                  </p></td>
              </tr>
              <tr>
                <td><p>
                    <label for="subject">Subject</label>
                    <br />
                    <input type="text" name="subject" value="" id="subject" class="validate[required] inputContact">
                  </p></td>
                <td><p>
                    <label for="tel">Phone No.</label>
                    <br />
                    <input type="text" name="tel" value="" id="tel" class="validate[required] inputContact">
                  </p></td>
              </tr>
              <tr>
                <td colspan="2"><p>
                    <label for="comment">Comment</label>
                    <br />
                    <textarea cols="30" rows="10" name="comment" id="comment" class="validate[required] inputContact"></textarea>
                  </p></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><input type="image" src="images/btn_send.png" class="button-contact"></td>
              </tr>
            </table>
          </form>
        </div>*/ ?>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
      </div>
      <div class="contact-content-right">
        <p class="txtGold24">Address</p>
        <p class="line-brown">&nbsp;</p>
        <div class="txtBrown18_2">{{nl2br($rowDetail->pages_address)}}</div>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <div class="txtBrown18_2">
          <div class="row-contact">
            <div class="row-contact-left">Tel :</div>
            <div class="row-contact-right">{{nl2br($rowDetail->pages_tel)}}</div>
          </div>
           <div class="row-contact">
            <div>Event &amp; Group Booking : 02-160-5696</div> 
          </div>
         <div class="row-contact">
            <div class="row-contact-left">E-mail :</div>
            <div class="row-contact-right">{{nl2br($rowDetail->pages_email)}}</div>
          </div> 
        </div><br>
        <p>&nbsp;</p>
        <p class="txtGold24">How to Get There</p>
        <p class="line-brown">&nbsp;</p>
        <div class="txtBrown18_2"><br>
          <div class="row-contact">
            <div class="row-contact-left"><img src="images/ic-train-bts.png" width="85" height="65"></div>
            <div class="row-contact-right">
              <p>BTS Sky Train</p>
              <p>{{nl2br($rowDetail->pages_getByTrain)}}</p>
            </div>
          </div><br><br>
          <div class="row-contact">
            <div class="row-contact-left"><img src="images/ic-bus.png" width="85" height="53"></div>
            <div class="row-contact-right">
              <p>BUS</p>
              <p>{{nl2br($rowDetail->pages_getByBus)}}</p>
            </div>
          </div>
        </div>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
      </div>
      <div class="clear" style="height:100px"></div>
    </div>
  </div> 
   @endforeach
  @include('frontend.incFooter')
</div> 
@include('frontend.incScriptBottom') 
<script src="js/formValidator/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script> 
<script src="js/formValidator/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script> 
<script src="js/InFieldLabels/jquery.infieldlabel.min.js" type="text/javascript" charset="utf-8"></script> 
<script type="text/javascript" charset="utf-8">
  jQuery(function(){ 
  	  jQuery("label").inFieldLabels();
	 jQuery("#formContact").validationEngine('attach', {promptPosition : "topLeft"});
 });
</script>
</body>
</html>