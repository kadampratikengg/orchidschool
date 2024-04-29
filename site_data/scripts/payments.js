var pageFunctions = function () {
   
    return {
        //main function to initiate the module
        init: function () {
          
		  init_datatables();
		  init_select2();
        }
    };

}();



function init_select2(){
	 $(".select2, .select2-multiple").select2({
            placeholder: "Select",
            width: null
        });
}
function init_datatables(){
	$("#managed_datatable").dataTable({

            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoEmpty": "No records found",
                "infoFiltered": "(filtered1 from _MAX_ total records)",
                "lengthMenu": "Show _MENU_",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "previous":"Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },

            /*"bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.*/
            
            "columnDefs": [ {
                "targets": 5,
                "orderable": false,
                "searchable": false
            }],

            "lengthMenu": [
                [15, 30, 50, -1],
                [15, 30, 50, "All"] // change per page values here
            ],
		  
            // set the initial value
            "pageLength": 15,            
            "pagingType": "bootstrap_full_number",
            "order": [
                [0, "asc"]
            ] // set first column as a default sort by asc
        });
}

function get_students() {
	$.ajax({

		data: {"division_id" : $("#division_id").val()},
		url: base_url+'payments/get_students',
		method: 'post',
        success: function(response)
        {
            $('#student_id').html(response);
        }
	});
}

function get_invoices(){

	$.ajax({
		
		data: {'student_id' : $('#student_id').val()},
		url : base_url + 'payments/get_invoices',
		method: 'POST',
		success: function(response){
			$('#invoice_id').html(response);
		}
	});
}

function get_payment_amount(){

	$.ajax({
		data : {'invoice_id' : $('#invoice_id').val()},
		url : base_url + 'payments/get_payment_amount',
		method : 'POST',
		success : function(response){
			var data = JSON.parse(response);
			$("#payment_amount").val(data.outstanding_amount);
		}
	});
}

function get_late_fees(){
	
	$.ajax({
		data : {
			'payment_date' : $("#payment_date").val(),
			'invoice_id' : $("#invoice_id").val()
			},
		url : base_url + 'payments/get_late_fees',
		method : 'POST',
		success : function(response){

			$("#late_fee_amount").val(response);
		}
	});
}

function get_instalmetns(standard_id) {
	$.ajax({

		data: {"standard_id" : standard_id},
		type: "POST",
		url: base_url+'reminders/get_instalmetns',
        success: function(response) {
            $('#standard_instalment_id').html(response);
        }
	});
}

$('#admission_no').focusout(function(){
	var admission_no = $('#admission_no').val();
	$.ajax({

		data: {"admission_no" : admission_no},
		type: "POST",
		url: base_url+'payments/get_students',
		dataType : 'JSON',
        success: function(response) {
            
        	if(response.student_count<1){
        		$('#student').val("Student not found");
        	}else{
        		$('#student_id').val(response.student_data['student_id']);
            	$('#student').val(response.student_data['name']);
            	
            	get_invoices();
        	}
        }
        
	});
});