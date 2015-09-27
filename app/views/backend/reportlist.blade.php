<?php 
	if(Session::get('_EMAIL') == "" || Session::get('_GRPID') == "" || Session::get('_ID') == "" || Session::get('_GRPID') == "2" ){  #  
		header("Location: login");
		exit();
	}/**/
	
	$keywordKey = ($keyword != '')? "?keyword=$keyword": "";
	$dateTime = ($dateTime != '')? "?dateTime=$dateTime": ""; 
	
	if($keywordKey != ''){
			$getMonth = ($getMonth != '')? "&getMonth=$getMonth": "";
    }else{
			$getMonth = ($getMonth != '')? "?getMonth=$getMonth": "";
	 } #end
	 
	 	if($dateTime != ''){
			$paymentType	= ($paymentType != '')? "&paymentType=$paymentType": "";
			$Status 				= ($Status != '')? "&Status=$Status": "";
		}else{
			 $paymentType = ($paymentType != '')? "?paymentType=$paymentType": "";
		 } #
	 $ProfileID = Session::get('_ID');
	 
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Backoffice' Major Cineplex Cambodia</title>
{{HTML::style('css/font.css')}}
{{HTML::style('js/FooTable/demos/css/bootstrap.css')}}
{{HTML::style('js/bootstrap/css/bootstrap.css')}}
{{HTML::style('js/bootstrap/css/bootstrap-theme.css')}}
{{HTML::style('js/colorbox-master/example4/colorbox.css')}}
{{HTML::style('js/FooTable/css/footable.core.css?v=2-0-1')}}
{{HTML::style('js/FooTable/demos/css/footable-demos.css')}}
{{HTML::style('js/jqueryUI/development-bundle/themes/base/jquery.ui.all.css')}}
{{HTML::style('js/colorbox-master/example4/colorbox.css')}}
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10%"><h1 class="pagetitle">Report </h1> </td>
    <td width="60%" style="padding-top:25px"> <a href="{{URL::to("backoffice_management/profile/$ProfileID")}}" title="Change Password" class="iframe">{{Session::get('_NAME') }} </a> | <a href="  {{URL::to('backoffice_management/logout')}}" target="_self">Log Out &nbsp; <img src="{{asset('images/png/glyphicons_151_new_window.png')}}" width="26" height="22" /> </a></td>
    <td width="30%" align="right"> 
      <form name="form1" method="post" action="" role="form" style="width:350px; float:right; margin-right:5px; margin-top:15px">
         
        <table width="100%">
          <tr>
            <td width="78%" valign="top"> 
              <input type="text" name="keyword" id="keyword" class="form-control" style=" height:34px"  placeholder="Search">
            </td>
            <td width="22%" valign="top"> 
              <input name="Submit" type="submit"  class="btn btn-primary" value="Search">
            </td>
          </tr>
        </table>
        *Keyword Search Ex. Pincode, TID, Name, Email, Tel &nbsp; &nbsp;
      </form> </td>
  </tr>
</table> 
<div style="padding:0 15px; position:relative" >
<div style="position: absolute; right: 0px; top: -3px; width: 688px;">
	<form action="" method="post"> 
        <table width="100%">
      <tr>
        <td width="31%" valign="top"> 
          <input  name="dateTime" type="text" class="form-control datepicker" id="dateTime" placeholder="Select Date" style="padding:16px; width:200px"> 
       </td>
        <td width="30%" valign="top">
        	  <select id="paymentType" name='paymentType' style="height:34px; width:200px">
                 <option value="">---Filter Payment Type--</option>
              	<option value="PAYMENT">Payment</option>
                <option value="BOOKING">Booking</option>
            </select>  
        </td>
        <td width="30%" valign="top"><select id="Status" name='Status'  style="height:34px; width:200px">
                 <option value="">---Filter Status--</option>
                 <option value="SUCCESS">SUCCESS</option>
                 <option value="WAIT">WAIT</option>
                 <option value="CANCEL">CANCEL</option>
            </select></td>
        <td width="9%" valign="top"> 
        <input name="Submit" type="submit"  class="btn btn-primary" value="Search">
        <input name="action" type="hidden" value="filter">
        </td>
      </tr>
    </table>
	</form>
</div>
<form action="" method="post" id="myForm"> 
  <select id="selectMonth" name='getMonth'>
 	 <option value="">---Select Month--</option>
	<?php for($dayTime = 0;$dayTime <4; $dayTime++){?>
      <option value="<?php echo  $dateNowShort  = date('Y_m', strtotime(" - $dayTime month"));?>"><?php echo  $dateNowShort  = date('F Y', strtotime(" - $dayTime month"));?></option>
    <?php }?>
</select>  
</form><?php /**/ ?></div>
<div class="detail-page" style="margin:15px">
  <form action="" method="post"> 
    <div class="tab-pane active" id="demo"> Page Size:
      <select id="change-page-size">
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
        <option value="150">150</option>
      </select>      
      &nbsp; &nbsp; &nbsp;  <a href="http://www.embassycineplex.com/backoffice_management/genExcelReportlist{{$keywordKey}}{{$getMonth}}{{$dateTime}}{{$paymentType}}{{$Status}}" target="_blank">Export To Excel</a>
<table width="2301" border="0" cellspacing="0" cellpadding="0"  class="table demo table table-striped">
        <thead>
          <tr align="center" style="white-space:nowrap">
           <th width="209"><strong>Log Time</strong></th>
            <th width="100" data-toggle="true"><strong> Pincode </strong></th> 
            <th width="100"><strong>Amount (THB)</strong></th>
            <th width="409"><strong>Name-Surname</strong></th>
            <th width="250"><strong>Email</strong></th>
            <th width="208"><strong>Tel</strong></th>
            <th width="255"><strong>Movie Name</strong></th>
            <th width="213"><strong>Showtime</strong></th>
            <th width="170"><strong>Seat</strong></th>
            <th width="195"><strong>Channel</strong></th>
            <th width="241"><strong>Payment Type</strong></th>
            <th width="222"><strong>Status</strong></th> 
          </tr>
        </thead>
        <tbody>
        
        @foreach($resultDataLogBooking as $rowDataLogBooking)
        <tr align="center" style="font-size:14px; white-space:nowrap">
         <td>{{$rowDataLogBooking->date_time}}</td> 
          <td><?php 
			  $pincode = $rowDataLogBooking->pincode;
			  if($pincode != ''){
				  echo $pincode;
			  }else{
				echo '-';  
				  }
				  ?></td> 
          <td>{{$rowDataLogBooking->amount}}</td>
          <td>{{$rowDataLogBooking->cname}}</td>
          <td>{{$rowDataLogBooking->email}}</td>
          <td>{{$rowDataLogBooking->phone}}</td>
          <td>{{$rowDataLogBooking->movie}}</td>
          <td>{{$rowDataLogBooking->show_time}}</td>
          <td>{{$rowDataLogBooking->seat}}</td>
          <td>{{$rowDataLogBooking->channel}}</td>
          <td>{{$rowDataLogBooking->order_payment}}&nbsp;</td>
          <td>{{$rowDataLogBooking->order_status}}</td>  
        </tr>
        @endforeach
          </tbody> 
        <tfoot>
          <tr>
            <td colspan="15" style="text-align:center"><div class="pagination pagination-centered"></div></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </form>
</div>
<p class="line-brown clear"></p>
{{ HTML::script('js/jquery-1.8.js') }}
{{ HTML::script('js/bootstrap/js/bootstrap.min.js') }}
{{ HTML::script('js/colorbox-master/jquery.colorbox.js') }}
{{ HTML::script('js/FooTable/js/footable.js?v=2-0-1') }}
{{ HTML::script('js/FooTable/js/footable.paginate.js?v=2-0-1') }}
{{ HTML::script('js/FooTable/js/footable.sort.js?v=2-0-1') }}
{{ HTML::script('js/FooTable/demos/js/bootstrap-tab.js') }}
{{ HTML::script('js/FooTable/demos/js/demos.js') }}
{{ HTML::script('js/jqueryUI/development-bundle/ui/jquery.ui.core.js') }}
{{ HTML::script('js/jqueryUI/development-bundle/ui/jquery.ui.widget.js') }}
{{ HTML::script('js/jqueryUI/development-bundle/ui/jquery.ui.datepicker.js') }}
{{ HTML::script('js/colorbox-master/jquery.colorbox.js') }} 
<script type="text/javascript">
	jQuery(document).ready(function(){ 
		jQuery(".iframe").colorbox({iframe:true, width:780, height:560});  
			jQuery( ".datepicker" ).datepicker({ maxDate: 0,   dateFormat: "yy-mm-dd" });
			jQuery('table').footable(); 
		 	  var pageSize = 25;		   
			  jQuery('.footable').data('page-size', pageSize);
			  jQuery('.footable').trigger('footable_initialized');			  
			  
		  jQuery('#change-page-size').change(function (e) {
			  e.preventDefault();
			  var pageSize = $(this).val();
			  jQuery('.footable').data('page-size', pageSize);
			  jQuery('.footable').trigger('footable_initialized');
		  });

		  jQuery('#change-nav-size').change(function (e) {
			  e.preventDefault();
			  var navSize = $(this).val();
			  jQuery('.footable').data('limit-navigation', navSize);
			  jQuery('.footable').trigger('footable_initialized');
		  });
		  
		   $('.sort-column').click(function (e) {
			e.preventDefault();

			//get the footable sort object
			var footableSort = $('table').data('footable-sort');
			//get the index we are wanting to sort by
			var index = $(this).data('index');
			footableSort.doSort(index, 'toggle');
		});
	 	jQuery("#selectMonth").change(function () { 
			jQuery("#myForm").submit();
	  });
	}); 
</script>
</body>
</html>