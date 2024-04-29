var pageFunctions = function () {
   
    return {
        //main function to initiate the module
        init: function () {
		  init_select2();
		  is_outstanding_payments();
			
        }
    };

}();

function init_select2(){
	 $(".select2, .select2-multiple").select2({
            placeholder: "select state",
            width: null
        });
}

function get_divisions(standard_id) {
	$.ajax({

		data: {"standard_id" : standard_id},
		type: "POST",
		url: base_url+'reminders/get_divisions',
        success: function(response) {
            $('#division_id').html(response);
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

function get_applicable_students() {

	$.ajax({

		data: {"division_id" : $("#division_id").val()},
		type: "POST",
		url: base_url+'reminders/get_applicable_students',
        success: function(response)
        {
            $('#applicable_student_id').html(response);
        }
	});
}
function get_outstanding_reports() {

	$.ajax({
		data: {"standard_instalment_id" : $("#standard_instalment_id").val(),
				"standard_id" : $("#standard_id").val()},
		type: "POST",
		url: base_url+'reminders/get_outstanding_reports',
        success: function(response)
        {
            $('#outstanding_table_container').html(response);
        }
	});
}