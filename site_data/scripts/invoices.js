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

function get_years_standards_divisions(current_year_id){
	
	$.ajax({
		type: "post",
		data: {"current_year_id" : current_year_id},
		dataType : "json",
		url: base_url+'students/get_years_standards_divisions',
        success: function(response)
        {
            $('#current_division_id').html(response.divisions);
            $('#new_academic_year_id').html(response.years);
        }
	});
}
function get_standards_divisions(new_year_id){
	
	$.ajax({
		type: "post",
		data: {"new_year_id" : new_year_id},
		dataType : "json",
		url: base_url+'students/get_standards_divisions',
        success: function(response)
        {
            $('#new_division_id').html(response);
        }
	});
}

function allow_staff_discount(){
	var rte = document.getElementById('rte_provision_yes').checked;
	if(rte == true){
		$("#staff_discount").hide();
	}else{
		$("#staff_discount").show();
	}
}

function reset_password(){

	$("#change_password_btn").prop("disabled", true);
	$("#ajax-alert-success-container").hide();
	$("#ajax-alert-danger-container").hide();
	
	$.ajax({

		type: $("#reset_password_form").attr('method'),
		url: $("#reset_password_form").attr('action'),
		data: $("#reset_password_form").serialize(),
		dataType : "json",
        success: function(data)
        {
        	if(data.status == 'error'){
        		$("#reset_password_form")[0].reset();
        		$("#ajax-alert-danger-contents").html(data.message);
				$("#ajax-alert-danger-container").show();
				$("#change_password_btn").prop("disabled", false);
        	}else{
        		
        		$("#reset_password_form")[0].reset();
        		$("#ajax-alert-success-contents").html(data.message);
				$("#ajax-alert-success-container").show();
				$("#change_password_btn").prop("disabled", false);
        	}
        },
        error : function(data) {
			alert("An error occured.");
			$("#change_password_btn").prop("disabled", false);

		}
	});
}

function change_academic_individual(){
	
		$("#btn_academic_transfer").prop("disabled", true);
		$("#ajax-alert-success-container").hide();
		$("#ajax-alert-danger-container").hide();
		
		$.ajax({

			type: $("#academic_transfer_individual_form").attr('method'),
			url: $("#academic_transfer_individual_form").attr('action'),
			data: $("#academic_transfer_individual_form").serialize(),
			dataType : "json",
	        success: function(data)
	        {
	        	if(data.status == 'error'){
	        		$("#academic_transfer_individual_form")[0].reset();
	        		$("#ajax-alert-danger-contents").html(data.message);
					$("#ajax-alert-danger-container").show();
					$("#btn_academic_transfer").prop("disabled", false);
	        	}else{
	        		
	        		$("#academic_transfer_individual_form")[0].reset();
	        		$("#ajax-alert-success-contents").html(data.message);
					$("#ajax-alert-success-container").show();
					$("#btn_academic_transfer").prop("disabled", false);
	        	}
	        },
	        error : function(data) {
				alert("An error occured.");
				$("#btn_academic_transfer").prop("disabled", false);

			}
		});
	}
