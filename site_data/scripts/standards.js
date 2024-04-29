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
            placeholder: "select state",
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
		url: base_url+'students/get_class_divisions',
        success: function(response)
        {
            $('#division_id').html(response);
        }
	});
}


function check_standard_prefix(prefix) 
{
	$.ajax({
		data: {"prefix" : prefix, "standard_id" : $("#standard_id").val()},
		url: base_url+'standards/check_standard_prefix/'+prefix+'/'+$("#standard_id").val(),
        success: function(response)
        {
            $('#prefix_msg').html(response);
        }
	});
}

$( "#save" ).click(function() {
	$('#is_add').val("FALSE");
	});

$( "#save_and_add" ).click(function() {
	$('#is_add').val("TRUE");
	});

function save_particular() {

	$("#save_particular_btn").prop("disabled", true);
	$("#ajax-alert-success-container").hide();
	$("#ajax-alert-danger-container").hide();

	$.ajax({
		url : $("#save_particular_form").attr('action'),
		data : $("#save_particular_form").serialize(),
		type : 'post',
		cache : false,
		dataType : "json",
		success : function(data) {
			if (data.status == "success_message") {
				$("#save_particular_form")[0].reset();
				$("#ajax-alert-success-contents").html(data.message);
				$("#ajax-alert-success-container").show();
				$("#save_particular_btn").prop("disabled", false);
			} else {
				$("#ajax-alert-danger-contents").html(data.message);
				$("#ajax-alert-danger-container").show();
				$("#save_particular_btn").prop("disabled", false);
			}
		},
		error : function(data) {
			alert("An error occured.");
			$("#save_particular_btn").prop("disabled", false);

		}
	});

}