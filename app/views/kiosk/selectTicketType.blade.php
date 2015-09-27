@foreach($movie_DataDetail as $movie)<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Embassy Diplomat Screens by AIS</title>
<meta property="og:image" content="http://www.embassycineplex.com/images/share.jpg" /> 
{{HTML::style('css/reset.css')}}
{{HTML::style('css/font.css')}}
{{HTML::style('css/screenKiosk.css')}}
{{HTML::style('css/screen2.css')}}
{{HTML::style('css/screenInside.css')}}
{{HTML::style('css/screenTickets.css')}}
{{HTML::style('js/formValidator/css/validationEngine.jquery.css')}}
{{HTML::style('js/colorbox-master/example3/colorbox.css')}}
@include('kiosk.incScriptTop')
<?php  
$movieName =	$movie->movie_Name_EN;  
$sessID = $movie->showtime_Session_strID;

//************ XML Start *************//////////////
$wsdl = "http://10.121.130.25/WSVistaWebClient/DataService.asmx?WSDL"; 
//$wsdl = "http://10.100.101.146/WSVistaWebClient/DataService.asmx?WSDL"; 
$client = new SoapClient($wsdl, array('trace' => true)); 

$params = array('CinemaId' 									=> "0000008001", 
				'SessionId'									=> $sessID,
				'OptionalLoyaltyTicketMatchesHOCode'		=> false,
				'OptionalShowNonATMTickets'					=> false,
				'OptionalReturnAllRedemptionAndCompTickets'	=> false,
				'OptionalReturnAllLoyaltyTickets'			=> false,
				'OptionalReturnLoyaltyRewardFlag'			=> false,
				'OptionalSeparatePaymentBasedTickets'		=> false,
				'OptionalShowLoyaltyTicketsToNonMembers' 	=> false,
				'OptionalEnforceChildTicketLogic'			=> false,
				'OptionalIncludeZeroValueTickets'			=> false);

$result = $client->__soapCall('GetTicketTypeList', array($params));

$parser = xml_parser_create();
xml_parse_into_struct($parser, $result->DatasetXML, $values, $index);
xml_parser_free($parser);

$isInTable = false;
$nTicket = 0;
$tickets = array();
//*********** ***************************/////
 foreach ($values as $value)
	  {
		  if ($value['type'] == 'open' || $value['type'] == 'close' || $value['type'] == 'complete')
		  {
			  if ($value['tag'] == 'TABLE' && $value['type'] == 'open')
			  {
				  $isInTable = true;
			  }
			  if ($value['tag'] == 'TABLE' && $value['type'] == 'close')
			  {
				  $isInTable = false;
				  $nTicket++;
			  }
	  
			  if ($isInTable && $value['tag'] != 'TABLE')
			  {
				  if (array_key_exists('value', $value))
				  {
					  $tickets[$nTicket][$value['tag']] = $value['value'];
				  }
				  else
				  {
					  $tickets[$nTicket][$value['tag']] = $value['tag'];
				  }
			  }
		  }
	  } #end foreach
?>
</head>
<body>
<div id="main">
  @include('kiosk.incHeader')   
  <div id="content" class="content-main">
    <div class="titleMovie"> 
      <a href="{{URL::to("kiosk")}}"><img src="{{asset('images/btn-back.png')}}"  alt="Back {{$movieName}}"> </a> 
    </div>
    <div class="contentPage">
      <div class="content-detail-movie">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="18%"><div class="rowShowTodayImage"><img src="{{asset("uploads/movie/$movie->movie_Img_Thumb")}}" width="140" height="210"  alt="{{$movieName}}"></div></td>
            <td width="82%" align="left" valign="top"><h2 class="txtGold24">{{$movieName}}</h2>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="14%">
                  <?php
            	if($movie->movie_Rating == "ส."){ 
					$imgRate = "rate_raise.png";
				 }else if($movie->movie_Rating == "ทป."  || $movie->movie_Rating == "TBC" || $movie->movie_Rating == ""){ 
					$imgRate = "rate_general_en.png";
				 }else if($movie->movie_Rating == "น13+"){ 
					$imgRate = "rate_up_13_en.png";
				 }else if($movie->movie_Rating == "น15+"){ 
					$imgRate = "rate_up_15_en.png";
				 }else if($movie->movie_Rating == "น18+"){ 
					$imgRate = "rate_up_18_en.png";
				  }else if($movie->movie_Rating == "ฉ20-"){ 
					$imgRate = "rate_under_20_en.png";
				   }else{
						$imgRate = "rate_general_en.png";
				 }//***********
				 
				 if($movie->showtime_SystemType == "VS00000001"){ 
					$imgSystem = "type_digital.png";
					$systemName = '2D';
				 }else if($movie->showtime_SystemType == "0000000001"){ 
					$imgSystem = "type_3d.png";
					$systemName = 'D3D';
				  }else if($movie->showtime_SystemType == "0000000002"){ 
					$imgSystem = "type_hfr_3d.png";
					$systemName = 'HFR 3D';		
				  }else{
					$imgSystem = "type_digital.png";
					$systemName = '2D';
				 }  //*************
			?><p><img src="{{asset("images/icon/$imgRate")}}" alt="{{$movie->movie_Rating}}" style="padding:0; padding-right:5px; max-width:40px"> 
                 	<img src="{{asset("images/icon/$imgSystem")}}" alt="{{$systemName}}" style="width:40px; padding:0;"></p></td>
                  <td width="86%" class="txtSoundTrack" style="padding-left:5px"><?php
                   		$showtimes =  $movie->showtime_soundAttributes.";";
						echo	 $showtimes = strstr($showtimes, ';', true); // As of PHP 5.3.0
				   ?></td>
                </tr>
              </table>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <table width="100%" border="0" cellspacing="1" cellpadding="1" class="detailTable">
                <tr>
                  <td width="33%">Date &nbsp;<span class="txtWhite18">{{ date('d F Y', strtotime($movie->showtime_dtmDate_Time)) }}</span></td>
                  <td width="33%">Time &nbsp;<span class="txtWhite18">{{ date('H:i', strtotime($movie->showtime_dtmDate_Time))}}</span></td>
                  <td width="33%">Hall &nbsp;<span class="txtWhite18">{{strReplaceText($movie->showtime_strName)}}</span></td>
                </tr>
              </table>
              <p>&nbsp;</p></td>
          </tr>
        </table>
      </div>
      <div class="movie-step">
        <p>&nbsp;</p>
        <p><img src="{{asset('images/step_seat_type.png')}}" width="820" ></p>
      </div>
      <form action="{{URL::to("kiosk/selectSeats")}}" method="post" class="formTypeSeat">
        <div class="content-seat-type"> 
         <ul> 
      <?php 
	  	 $numSeat = "0";
		 $typeCodes = ""; 
		 
		  function compareSeatPackage($a, $b)
		  {
			  if (intval($a['PRICE_INTTICKET_PRICE']) == intval($b['PRICE_INTTICKET_PRICE'])) 
			  {
				  return 0;
			  }
			  return (intval($a['PRICE_INTTICKET_PRICE']) < intval($b['PRICE_INTTICKET_PRICE'])) ? 1 : -1;
		  }#end Fn compareSeatPackage
		  
		  usort($tickets, 'compareSeatPackage');

		  foreach ($tickets as $ticket){
			  $numSeat++;
			  $PRICE_STRTICKET_TYPE_CODE 		= 	$ticket['PRICE_STRTICKET_TYPE_CODE'];
			  $PRICE_STRTICKET_TYPE_DESCRIPTION =	$ticket['PRICE_STRTICKET_TYPE_DESCRIPTION'];
			  $PRICE_INTTICKET_PRICE			= 	$ticket['PRICE_INTTICKET_PRICE'];
			  $AREACAT_INTSEQ					=	$ticket['AREACAT_INTSEQ'];
			  $subPriceTicket					= 	substr("$PRICE_INTTICKET_PRICE", 0, -2);
			  $AREACAT_STRCODE					=	$ticket['AREACAT_STRCODE'];
			  $typeCodes .= $ticket['PRICE_STRTICKET_TYPE_CODE'] . ",";
			  
			  preg_match('/\d+/', $ticket['PRICE_STRTICKET_TYPE_DESCRIPTION'], $matches);
			  $seatsPerTicket = 1;
		  
			  if ($matches) 
			  {
				  $seatsPerTicket = $matches[0];
			  }	
		?><li><div class="row-seat">
       	    <p><img src="{{asset("images/theater/$PRICE_STRTICKET_TYPE_CODE.png")}}" height="90"></p>
       	    <p class="txtBrown18_2" style="margin:10px">{{$PRICE_STRTICKET_TYPE_DESCRIPTION}}</p>
            <p class="txtWhite22">{{number_format($subPriceTicket) }} Baht</p>
            <p class="txtWhite22">&nbsp;</p> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="divBtnSelectSeat">
              <tr>
                <td width="46" valign="top">
                <div  class="btnSub btnCountSeat" id="btnSub{{$PRICE_STRTICKET_TYPE_CODE}}"><img src="{{asset("images/btnsub-seat-type.png")}}" width="46" height="42" class="hoverImg08"></div></td>
                <td width="63" valign="top"><input type="text" name="nTicket{{$PRICE_STRTICKET_TYPE_CODE}}" id="nTicket{{$PRICE_STRTICKET_TYPE_CODE}}"  value="0"  readonly class="validate[groupRequired[payments],custom[integer]] inputNumCount" ></td>
                <td width="46" valign="top">
                <div class="btnPlus btnCountSeat" id="btnPls{{$PRICE_STRTICKET_TYPE_CODE}}"><img src="{{asset("images/btnplus-seat-type.png")}}" width="45" height="42" class="hoverImg08"></div></td>
              </tr>
            </table>
       	  </div></li>
          <input name="desc{{$PRICE_STRTICKET_TYPE_CODE}}" type="hidden" value="{{$PRICE_STRTICKET_TYPE_DESCRIPTION}}">
          <input name="price{{$PRICE_STRTICKET_TYPE_CODE}}" type="hidden" value="{{$PRICE_INTTICKET_PRICE}}"> 
          <input name="areaCatIntSeq{{$PRICE_STRTICKET_TYPE_CODE}}" type="hidden" value="{{$AREACAT_INTSEQ}}">
         <input name="areaCatCode{{$PRICE_STRTICKET_TYPE_CODE}}" type="hidden" value="{{$AREACAT_STRCODE}}">
         <input name="seatsPerTicket{{$PRICE_STRTICKET_TYPE_CODE}}" type="hidden" value="{{$seatsPerTicket}}">
      <?php }#end foreach?>
      	  <input name="ticket_code" type="hidden" value="{{$typeCodes}}">
          <input name="movieID" type="hidden" value="{{$movie->movieID}}">
          <input name="sessID" type="hidden" value="{{$sessID}}">
          <input name="url" type="hidden" value="" class="url">
         </ul>
          <p class="clear"></p>
        </div>
        <div class="content-next clear">
          <input type="image" src="{{asset('images/btn_seat_next.png')}}" class="buttonBack hoverImg08" >
        </div>
      </form>
    </div>
  </div> 
  @include('kiosk.incFooter')
</div> 
<div style='display:none'>
    <div id='inline_content' style='padding:30px; background:#f6eeda;text-align:center'>
    <p  class="txtBlack20"><strong><img src="{{asset("images/icon_alert_small.png")}}">&nbsp;&nbsp;Please select seat type</strong></p> 
    </div>
    <div id='inline_limit' style='padding:30px; background:#f6eeda;text-align:center'>
    <p  class="txtBlack20"><strong><img src="{{asset("images/icon_alert_small.png")}}">&nbsp;&nbsp;Maximum 6 seats per transaction.</strong></p> 
    </div>
</div>
@include('kiosk.incScriptBottom') 
{{ HTML::script('js/formValidator/js/languages/jquery.validationEngine-en.js') }}
{{ HTML::script('js/formValidator/js/jquery.validationEngine.js') }}
{{ HTML::script('js/colorbox-master/jquery.colorbox.js') }}
<script type="text/javascript" >
jQuery(function(){ 
	jQuery( ".formTypeSeat" ).submit(function( event ) {
	 	 if (<?php  $numSeatJS = 0;
		 		 foreach ($tickets as $ticket){
					  $PRICE_STRTICKET_TYPE_CODE = 	$ticket['PRICE_STRTICKET_TYPE_CODE'];
					  $numSeatJS++;?> jQuery( "#nTicket<?php echo $PRICE_STRTICKET_TYPE_CODE;?>" ).val() == '0' <?php if($numSeatJS != $numSeat){?> && <?php }
				  }?> 
		   ){ 
			    $.colorbox({width:"30%", inline:true, href:"#inline_content"});
			 	return false;
	      }
		<?php if($movie->showtime_strName == 'Theatre 1'){?>
		var var1 = parseInt(jQuery("#nTicket0017").val());
		var var1 = var1*2;		
		var var2 = parseInt(jQuery("#nTicket0047").val());
		var var2 = var2*2;		
		var var3 = parseInt(jQuery("#nTicket0013").val());
		var var3 = var3*3;		
		var var4 = parseInt(jQuery("#nTicket0015").val());
		var var4 = var4*2;		
		var var5 = parseInt(jQuery("#nTicket0009").val()); 
	    var allVal = var1+var2+var3+var4+var5;
	   <?php }else{?> 
		var var6 = parseInt(jQuery("#nTicket0002").val());		
		var var7 = parseInt(jQuery("#nTicket0045").val()); 
		var var7 = var7*2;
		var allVal = var6+var7;
		<?php }#end Theater?>
	  if(allVal >6){ 
			 jQuery.colorbox({width:"30%", inline:true, opacity : 0.5, href:"#inline_limit"});  
			 	return false; 
		 } else{ //End if
		     jQuery.ajax({
				url : '{{URL::to("getCreateDB")}}', 
					type:"GET", cache: false
			});   
		 }
	}); 
	//******************  
});
</script>
{{ HTML::script('js/jsTicketSeat.js') }}
</body>
</html>
@endforeach