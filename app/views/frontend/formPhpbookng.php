<?php 

	  echo "<form action='getSeats.php' method='post'>";
/*	  echo "<input type='hidden' name='movie_name' value='" . $_POST['movie_name'] . "'>";
	  echo "<input type='hidden' name='session_id' value='" . $_POST['session_id'] . "'>";
	  echo "<input type='hidden' name='theatre' value='" . $_POST['theatre'] . "'>";*/
	  
	  $typeCodes = "";
	  
	  foreach ($tickets as $ticket)
	  {
		  echo "<img src='../../images/theater/" . $ticket['PRICE_STRTICKET_TYPE_CODE'] . ".png'><br />";
		  echo "Type : " . $ticket['PRICE_STRTICKET_TYPE_DESCRIPTION'] . " : " . $ticket['PRICE_STRTICKET_TYPE_CODE'] . "<br />";
		  echo "Price : " . $ticket['PRICE_INTTICKET_PRICE'] . "<br />";
		  echo "<input type='hidden' name='desc" . $ticket['PRICE_STRTICKET_TYPE_CODE'] . "' value='" . $ticket['PRICE_STRTICKET_TYPE_DESCRIPTION'] . "'>";
		  echo "<input type='hidden' name='price" . $ticket['PRICE_STRTICKET_TYPE_CODE'] . "' value='" . $ticket['PRICE_INTTICKET_PRICE'] . "'>";
		  echo "<input type='number' name='nTicket" . $ticket['PRICE_STRTICKET_TYPE_CODE'] . "' value='0' min='0' max='10' style='width:100px;'>";
		  echo "<input type='hidden' name='areaCat" . $ticket['PRICE_STRTICKET_TYPE_CODE'] . "' value='" . $ticket['AREACAT_INTSEQ'] . "'>";
		  echo "<br /><br /><br /><br />";
	  
		  echo $typeCodes .= $ticket['PRICE_STRTICKET_TYPE_CODE'] . ",";
	  }
	  
	  echo "<input type='hidden' name='ticket_code' value='" . $typeCodes . "'>";
	  echo "<input type='submit' value='Submit'>";
	  echo "</form>";
?>