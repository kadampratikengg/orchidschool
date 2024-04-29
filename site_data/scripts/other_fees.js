var pageFunctions = function () {
   
    return {
        //main function to initiate the module
        init: function () {
          
		  init_datatables();
		  init_select2();
		  hide_asper_compulsory();	
        }
    };

}();

function init_select2(){
	 $(".select2, .select2-multiple").select2({
            placeholder: "select students",
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
                "targets": 3,
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

function get_divisions(standard_id) {
	$.ajax({

		data: {"standard_id" : standard_id},
		url: base_url+'other_fees/get_class_divisions',
		method: "post",
        success: function(response)
        {
            $('#division_id').html(response);
        }
	});
}

function get_students() {
	$.ajax({

		data: {"division_id" : $("#division_id").val()},
		url: base_url+'other_fees/get_students',
		method: "post",
        success: function(response)
        {
            $('#student_id').html(response);
        }
	});
}

function hide_asper_compulsory(){
	if($('input[name=compulsory]:checked', '#apply_fees_form').val()=='no'){
		$("#late_fees_container").hide();
		$("#due_date_container").hide();
	}else{
		$("#late_fees_container").show();
		$("#due_date_container").show();
	}
}
function get_divisions(standard_id) {
	$.ajax({

		data: {"standard_id" : standard_id},
		url: base_url+'other_fees/get_divisions',
		method:"post",
        success: function(response)
        {
            $('#division_id').html(response);
        }
	});
}