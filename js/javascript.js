// JavaScript Document
function addCommas(NumberStr)
{
    NumberStr+= '';
	var NumberStr = NumberStr.substring(0, NumberStr.length-2);
    NumberData = NumberStr.split('.');
    Number1 = NumberData[0];
    Number2 = NumberData.length > 1 ? '.' + NumberData[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(Number1)) {
        Number1 = Number1.replace(rgx, '$1' + ',' + '$2');
    }
    return Number1 + Number2;
}

var selectedSeats = [];
var seatWithName = [];
var seatWithNameTable = [];

for (var idx = 0; idx < reservedSeats.length; idx++) 
{
	selectedSeats.push(reservedSeats[idx]['SeatData']);
} 
	var seatPositionBefore =  selectedSeats.join(', ');
	jQuery( ".seatPosition" ).val(seatPositionBefore);
	jQuery( ".selectedSeats" ).val(JSON.stringify(reservedSeats));
	 
///*******************
for (var idx = 0; idx < ticketList.length; idx++) {
	//sizeof(); 
	var TextTicketName = ticketName[idx];
	 
	seatWithNameTable.push("<tr><td width='33%'>"+TextTicketName +" <span class='txtWhite18'>"+ "" + "</span></td><td width='33%'>Seat No. <span class='txtWhite18'>" + ticketList[idx]+ "</span></td><td width='33%'>Price <span class='txtWhite18'>" + addCommas(ticketPrice[idx]) + " Baht</span></td></tr>"); 
	 
} 
seatWithNameTable.sort();

$('#detailPaymentTicket').html(seatWithNameTable);
///******************* 

$('.seatTable tr td').click(function(){

    var tdID = $(this).attr('id');

	var areaNum =  parseInt(tdID.match(/\d+/g)[0]);
	var rowIdx = parseInt(tdID.match(/\d+/g)[1]);
	var colIdx = parseInt(tdID.match(/\d+/g)[2]);

	var isSingleSeat = false;

	if (allSeats[rowIdx][colIdx]['Status'] != 'Empty') 
	{
		//alert('Not Empty');
		return;
	}

	if (allSeats[rowIdx][colIdx]['SeatsInGroup']) 
	{
		if ($.isArray(allSeats[rowIdx][colIdx]['SeatsInGroup']['SeatPosition']))
		{
			var seatsPosition = allSeats[rowIdx][colIdx]['SeatsInGroup']['SeatPosition'];

			var isSelect = false;
			var isGroupEmpty = true;
			var numSeatsAvailable = seatsPosition.length;

			var selectedIndice = [];
			var ticketListIndex = 0;

	    	for (var idx = 0; idx < seatsPosition.length; idx++) 
	    	{
	    		if (allSeats[seatsPosition[idx]['RowIndex']][seatsPosition[idx]['ColumnIndex']]['Status'] != "Empty") 
	    		{
	    			isGroupEmpty = false;
	    			numSeatsAvailable--;
	    		}
	    	}

	    	if (isGroupEmpty) 
	    	{
	    		isSingleSeat = false;

	    		for (var idxSeat = 0; idxSeat < reservedSeats.length; idxSeat++)
				{
					if (reservedSeats[idxSeat]['Position']['AreaNumber'] == areaNum) 
					{
						for (var idxTicket = 0; idxTicket < ticketList.length; idxTicket++) 
						{
							if ((ticketList[idxTicket].search(reservedSeats[idxSeat]['SeatData']) != -1) && (ticketList[idxTicket].split(',').length == seatsPosition.length) && !isSelect) 
							{
								isSelect = true;
								ticketListIndex = idxTicket;
							}
							else if ((ticketList[idxTicket].search(reservedSeats[idxSeat]['SeatData']) != -1) && (ticketList[idxTicket].split(',').length == 1) && !isSelect)
							{
								isSelect = true;
								isSingleSeat = true;
							}
						}
					}
				}

				if (isSelect && !isSingleSeat) 
				{
					var selectedTicketList = ticketList[ticketListIndex].split(',');

					for (var idxSeat = 0; idxSeat < reservedSeats.length; idxSeat++)
					{
						if (reservedSeats[idxSeat]['Position']['AreaNumber'] == areaNum) 
						{
							for (var idxTicket = 0; idxTicket < selectedTicketList.length; idxTicket++) 
							{
								if ((reservedSeats[idxSeat]['SeatData'] == selectedTicketList[idxTicket].trim()) && (selectedIndice.length < selectedTicketList.length))  
								{
									selectedIndice.push(idxSeat);
								}
							}
						}
					}

					selectedIndice.sort(function(a, b){return b-a});

					if (selectedIndice.length == selectedTicketList.length) 
					{
						for (var idx = 0; idx < selectedIndice.length; idx++) 
						{
							var removedSeat = reservedSeats[selectedIndice[idx]]['Position'];
							var imgSrc = $('#_area' + removedSeat['AreaNumber'] + 'row' + removedSeat['RowIndex'] + 'col' + removedSeat['ColumnIndex']).find('img').attr('src');
							$('#_area' + removedSeat['AreaNumber'] + 'row' + removedSeat['RowIndex'] + 'col' + removedSeat['ColumnIndex']).find('img').attr('src', imgSrc.replace('Reserved', 'Empty'));

							reservedSeats.splice(selectedIndice[idx], 1);

							allSeats[removedSeat['RowIndex']][removedSeat['ColumnIndex']]['Status'] = 'Empty';
						}

						selectedIndice.length = 0;
						var newTicketList = [];

						for (var idx = 0; idx < seatsPosition.length; idx++) 
				    	{
				    		var newSeat = allSeats[seatsPosition[idx]['RowIndex']][seatsPosition[idx]['ColumnIndex']];

				    		reservedSeats.push(newSeat);
				    		newTicketList.push(newSeat['SeatData']);

				    		var imgSrc = $('#_area' + newSeat['Position']['AreaNumber'] + 'row' + newSeat['Position']['RowIndex'] + 'col' + newSeat['Position']['ColumnIndex']).find('img').attr('src');
							$('#_area' + newSeat['Position']['AreaNumber'] + 'row' + newSeat['Position']['RowIndex'] + 'col' + newSeat['Position']['ColumnIndex']).find('img').attr('src', imgSrc.replace('Empty', 'Reserved'));

							allSeats[seatsPosition[idx]['RowIndex']][seatsPosition[idx]['ColumnIndex']]['Status'] = 'Reserved';
				    	}

				    	ticketList.splice(ticketListIndex, 1);
				    	ticketList.push(newTicketList.join(', '));

				    	var tempTicketName = ticketName[ticketListIndex];
				    	ticketName.splice(ticketListIndex, 1);
				    	ticketName.push(tempTicketName);
						
						var tempTicketPrice = ticketPrice[ticketListIndex];
				    	ticketPrice.splice(ticketListIndex, 1);
				    	ticketPrice.push(tempTicketPrice);
					}
				}
	    	}

	    	if (!isGroupEmpty && numSeatsAvailable >= 1) 
	    	{
	    		isSingleSeat = true;
	    	}
		}
		else
		{
			isSingleSeat = true;
		}
	}
	else
	{
		isSingleSeat = true;
	}

	if (isSingleSeat) 
	{
		var isSelect = false;
		var selectedIndex = 0;
		var ticketListIndex = 0;
    	for (var idxSeat = 0; idxSeat < reservedSeats.length; idxSeat++)
		{
			if (reservedSeats[idxSeat]['Position']['AreaNumber'] == areaNum) 
			{
				for (var idxTicket = 0; idxTicket < ticketList.length; idxTicket++) 
				{
					if ((ticketList[idxTicket].search(reservedSeats[idxSeat]['SeatData']) != -1) && (ticketList[idxTicket].split(',').length == 1) && !isSelect) 
					{
						isSelect = true;
						selectedIndex = idxSeat;
						ticketListIndex = idxTicket;
					}
				}
			}
		}

		if (isSelect) 
		{
			var removedSeat = reservedSeats[selectedIndex]['Position'];
			reservedSeats.splice(selectedIndex, 1);
			ticketList.splice(ticketListIndex, 1);

			var tempTicketName = ticketName[ticketListIndex];
			ticketName.splice(ticketListIndex, 1);
			
			var tempTicketPrice = ticketPrice[ticketListIndex];
			ticketPrice.splice(ticketListIndex, 1);

			var imgSrc = $(this).find('img').attr('src');
    		$(this).find('img').attr('src', imgSrc.replace('Empty', 'Reserved'));

    		var imgSrc = $('#_area' + removedSeat['AreaNumber'] + 'row' + removedSeat['RowIndex'] + 'col' + removedSeat['ColumnIndex']).find('img').attr('src');
			$('#_area' + removedSeat['AreaNumber'] + 'row' + removedSeat['RowIndex'] + 'col' + removedSeat['ColumnIndex']).find('img').attr('src', imgSrc.replace('Reserved', 'Empty'));

			allSeats[rowIdx][colIdx]['Status'] = 'Reserved';
			allSeats[removedSeat['RowIndex']][removedSeat['ColumnIndex']]['Status'] = 'Empty';

			reservedSeats.push(allSeats[rowIdx][colIdx]);
			ticketList.push(allSeats[rowIdx][colIdx]['SeatData']);

			ticketName.push(tempTicketName);
			ticketPrice.push(tempTicketPrice);
		}
	}
	
	
	var ticketIndex = ticketList.slice(0);

	function sortTicketIndex(a, b)
	{
		if (a.split(',').length == b.split(',').length) 
		{
			if (a.length < b.length) 
			{
				return -1;
			}
			else if (a.length > b.length)
			{
				return 1;
			}
			return 0;
		} 
		return (a.split(',').length < b.split(',').length) ? -1 : 1;
	}

	ticketIndex.sort();
	ticketIndex.sort(sortTicketIndex);

	var seatIndex = {};

	for (var idx = 0; idx < reservedSeats.length; idx++) 
	{
		seatIndex[reservedSeats[idx]['SeatData']] = idx;
	}

	var seatWillReserved = [];

	for (var idx = 0; idx < ticketIndex.length; idx++) 
	{
		if (ticketIndex[idx].split(',').length == 1) 
		{
			seatWillReserved.push(reservedSeats[seatIndex[ticketIndex[idx]]]);
		}
		else
		{
			var tickets = ticketIndex[idx].split(',');

			for (var tIdx = 0; tIdx < tickets.length; tIdx++)
			{
				tickets[tIdx] = tickets[tIdx].trim();
			}

			tickets.sort();
			tickets.sort(sortTicketIndex);

			for (var tIdx = 0; tIdx < tickets.length; tIdx++)
			{
				seatWillReserved.push(reservedSeats[seatIndex[tickets[tIdx]]]);
			}
		}
	}

	var selectedSeats = [];
	var seatWithName = [];
	var seatWithNameTable = [];

	for (var idx = 0; idx < reservedSeats.length; idx++) 
	{
		selectedSeats.push(reservedSeats[idx]['SeatData']);
	} 
	var seatPosition =  selectedSeats.join(', ');
	jQuery( ".seatPosition" ).val(seatPosition);
	jQuery( ".selectedSeats" ).val(JSON.stringify(seatWillReserved));
	 
	///*******************
for (var idx = 0; idx < ticketList.length; idx++) {
	//sizeof(); 
	var TextTicketName = ticketName[idx];
	 
	seatWithNameTable.push("<tr><td width='33%'>"+TextTicketName +" <span class='txtWhite18'>"+ "" + "</span></td><td width='33%'>Seat No. <span class='txtWhite18'>" + ticketList[idx]+ "</span></td><td width='33%'>Price <span class='txtWhite18'>" + addCommas(ticketPrice[idx]) + " Baht</span></td></tr>"); 
	 
} 
seatWithNameTable.sort();

$('#detailPaymentTicket').html(seatWithNameTable);
///******************* v
});