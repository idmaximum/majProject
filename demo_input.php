<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="js/colorbox-master/example3/colorbox.css" />
</head>

<body>
<form action="2" method="post" id="formSeatType">
<table width="300" border="0" cellspacing="0" cellpadding="0">
<?php 
$i = 0;
for($iN=40;$iN<45;$iN++){?>
  <tr>
    <td><a href="#" class="btnSub" id="btnSub<?php echo $iN;?>">delete</a></td>
    <td><label for="textfield"></label>
      	<input type="text" name="nTicket" id="nTicket<?php echo $iN;?>" class="numCount"  value="0"/></td>
    <td><a href="#" class="btnPlus" id="btnPls<?php echo $iN;?>">add</a></td>
  </tr>
  <tr>
    <td>&nbsp; </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <?php $i++;}?>
  
</table> 
<?php echo $i;?>
	<input name="" type="submit" value="Submit" />
</form>

<div style='display:none'>
    <div id='inline_content' style='padding:10px; background:#fff;'>
    <p><strong>Please select seat type</strong></p> 
    </div>
</div>
<script src="http://localhost/embassy/js/jquery-2.0.2.min.js"></script> 
<script src="js/colorbox-master/jquery.colorbox.js"></script>
<script type="text/javascript" >
jQuery(function() 
{
	jQuery(".btnPlus").click(function(){									  
		//****************** 
		var btnID = jQuery(this).attr("id");
		var subBtnID = btnID.substr(6,4);  
		var txtID = jQuery('#nTicket'+subBtnID).attr("id");	// Get Input id
		 var varInput = jQuery("#"+txtID).val();
		 
		 if(varInput == ''){
			 var varInput = 0;
		 }else{
			var varInput = parseInt(jQuery("#"+txtID).val());  
		 }
		 
		 
		 if(btnID == 'btnPls40'){
			 if(varInput <4){ 
			  	var varSeat = varInput+2;
			 }else{//end if
			 	var varSeat = varInput;
			 }
		 }else if(btnID == 'btnPls41'){
			 var varSeat = varInput+3; 
		 }else if(btnID == 'btnPls42'){
			 var varSeat =  varInput+2; 
		 }// if 
		 jQuery("#"+txtID).val(varSeat); 
	});// end click
	
	jQuery(".btnSub").click(function(){									  
		//****************** 
		var btnID = jQuery(this).attr("id");
		 
		var subBtnID = btnID.substr(6,4);  
		var txtID = jQuery('#nTicket'+subBtnID).attr("id");	// Get Input id
		var varInput = jQuery("#"+txtID).val() ; 
		 
		  if(varInput > 0){ 
			  if(btnID == 'btnSub40'){ 
				   var varInput = varInput-2; 
			   }else if(btnID == 'btnSub41'){
				   var varInput = varInput-3; 
			   }else if(btnID == 'btnSub42'){
				   var varInput =  varInput-2; 
			   }// if 	/* */
		  }//end if
		 
		 jQuery("#"+txtID).val(varInput); 
	});// end click
	
	jQuery( "#formSeatType" ).submit(function( event ) {
	 	 if (<?php  $iBoottom = 0;
		 		 for($iN=40;$iN<45;$iN++){ $iBoottom++;?> jQuery( "#nTicket<?php echo $iN;?>" ).val() == '0' <?php if($iBoottom != $i){?> && <?php }
				  }?> 
		   ){
			   //	alert('Please select seat type');
			    $.colorbox({width:"30%", inline:true, href:"#inline_content"});
			 	return false;
	      }  
 	
	});
});
</script>
 <?php echo $iBoottom?>
</body>
</html>