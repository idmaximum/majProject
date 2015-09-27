// JavaScript Document
jQuery(function() 
{
	jQuery(".formTypeSeat").validationEngine('attach', {promptPosition : "topLeft"});
	jQuery(".btnPlus").click(function(){	 
		 
		var btnID = jQuery(this).attr("id");
		var subBtnID = btnID.substr(6,4);  
		var txtID = jQuery('#nTicket'+subBtnID).attr("id");	// Get Input id
		//	alert(txtID);
		 var varInput = jQuery("#"+txtID).val();
		 
		 if(varInput == ''){
			 var varInput = 0;
		 }else{
			var varInput = parseInt(jQuery("#"+txtID).val());  
		 }
	 if(btnID == 'btnPls0045' || btnID == 'btnPls0017' || btnID == 'btnPls0047' || btnID == 'btnPls0015' ){
			 if(varInput <3){ 
			    
			  	var varSeat = varInput+1;
			 }else{//end if
			 	var varSeat = varInput;
			 }
		 
		 }else if(btnID == 'btnPls0009' ){
			  if(varInput <5){ 
			  	var varSeat = varInput+1;
			 }else{//end if
			 	var varSeat = varInput;
			 }
		 }else if(btnID == 'btnPls0002'){
			  if(varInput <1){ 
			  	var varSeat = varInput+1;
			 }else{//end if
			 	var varSeat = varInput;
			 }
		 }else if(btnID == 'btnPls0013'){
			 if(varInput < 2){ 
			  	var varSeat = varInput+1;
			 }else{//end if
			 	var varSeat = varInput;
			 }
		 }/**/// if 
	 
		 jQuery("#"+txtID).val(varSeat); 
		 
	});// end click
	
	jQuery(".btnSub").click(function(){									  
		//****************** 
		var btnID = jQuery(this).attr("id");
		
		var subBtnID = btnID.substr(6,4);  
		var txtID = jQuery('#nTicket'+subBtnID).attr("id");	// Get Input id 
		var varInput = jQuery("#"+txtID).val() ; 
		 
		  if(varInput > 0){ 
			 if(btnID == 'btnSub0045' || btnID == 'btnSub0017' || btnID == 'btnSub0047' || btnID == 'btnSub0015' ){ 
				   var varInput = varInput-1; 
			   }else if(btnID == 'btnSub0009' || btnID == 'btnSub0002'){
				   var varInput = varInput-1; 
			   }else if(btnID == 'btnSub0013'){
				   var varInput =  varInput-1; 
			   }// if 	/* */
		  }//end if
		 
		 jQuery("#"+txtID).val(varInput); 
	});// end click
	
	jQuery( ".formTypeSeat" ).submit(function( event ) {
	 	 if ( jQuery( "#nTicket40" ).val() == '' && 
		 	  jQuery( "#nTicket44" ).val() == ''  ){
			 	alert('Error');
			 	return false;
	      }  
 	
	});
});