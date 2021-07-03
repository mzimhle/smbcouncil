$(document).ready(function(){
	
	getCalendarList();
	
	/* Setup Date Range. */
	$( "#from" ).datepicker({
		defaultDate: "+1w",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		numberOfMonths: 3,
		onClose: function( selectedDate ) {
			$( "#to" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	
	$( "#to" ).datepicker({
		defaultDate: "+1w",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		numberOfMonths: 3,
		onClose: function( selectedDate ) {
			$( "#from" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
	
	/* Search for mentors. */
	$( "#usersearch").autocomplete({
		source: "/feeds/participants.php?type=12",
		minLength: 2,
		select: function( event, ui ) {
		
			if(ui.item.id == '') {
				$('#useridname').html('');
				$('#userid').val('');					
			} else { 
				$('#useridname').html('<b>' + ui.item.value + '</b>');
				$('#userid').val(ui.item.id);									
			}				
			$('#usersearch').val('');										
		}
	});
});

function clearsearch() {
	
	$('#from').val('');
	$('#to').val('');
	$('#useridname').val('');
	$('#userid').val('');
	$('#useridname').html('');
	$('[name=type]').val('');
	
	return false;
}


function searchForm() {

	getCalendarList();
	return false;	
}	

function deletecalendar(code) {
	
	if(confirm('Are you sure you want to remove this meeting/event?')) {
	
		var sendemail = 0;
		if(confirm('Would you like to send an email to all attendees notifying them of the cancellation of the meeting or event?')) {
			sendemail = 1;
		}
		
		$.post("?action=deletecalendar", {
				code		: code,
				sendemail	: sendemail
			},
			function(data) {
				if(data.result) {
					if(data.error != '') {
						alert(data.error);	
					}
					window.location.href=window.location.href
				} else {
					alert(data.error);
				}
			},
			'json'
		);	
	}
	return false;
}

function getCalendarList() {	
	
	var tblhtml					= '';
	var html 						= ''
	var oMeetingListTable	= null;	
	
	/* Clear table contants first. */			
	$('.content_table').html('<img src="/images/ajax-loader-2.gif" />');
	
	var from					= $('#from').val();
	var to						= $('#to').val();
	var userid				= $('#userid').val();
	var type					= $('#type :selected').val();
	
	$.post("?action=searchcalendar", {
			from					: from,
			to						: to,
			userid				: userid,
			type					: type
		},
		function(data) {
			if(data.result) {
			
				var item = null;

				for(var i = 0; i < data.records.length; i++) {

					item 	= data.records[i];
					
					html += '<tr>';					
					html += '<td valign="top">' + item.calendar_added + '</td>';	
					html += '<td valign="top"><a href="/administration/calendar/view/details.php?code='+item.calendar_code+'">' + item.calendar_name + '</a></td>';
					html += '<td valign="top">' + item.calendar_startdate +' - '+ item.calendar_enddate +'</td>';
					html += '<td valign="top">' + item.calendar_address +'</td>';		
					if( item.attendees != '' &&  item.attendees != null) {
					html += '<td valign="top">' + item.attendees +'</td>';								
					} else {
					html += '<td valign="top">N/A</td>';								
					}
					html += '<td valign="top"><button onclick="deletecalendar(\''+item.calendar_code+'\')">Cancel / Delete</button></td>';		
					html += '</tr>';
				}
			} else {
				html = '';
			}
			
			tblhtml = '<table id="dataTable" class="display" style="table-layout: fixed"><thead><tr><th>Added</th><th>Name</th><th>Date</th><th>Address</th><th>Attendees</th><th></th></tr></thead><tbody id="dataTableContent">'+html+'</tbody></table>';
	
			$(".content_table").html(tblhtml);
			
			// $('#content_table').css('width', '100%');
			
			oMeetingListTable = $('#dataTable').dataTable({											
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",							
				"bSort": true,
				"bFilter": true,
				"bInfo": false,
				"iDisplayLength": 20,
				"bLengthChange": false					
			});				
			 		

			$('#content_table tr td.dataTables_empty').html('There are no items to display.');	

			$('#content_table_filter').hide();
			$('.content_table_filter').hide();		
		
		},
		'json'
	);
	
	return false;
}