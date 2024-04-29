var pageFunctions = function () {
   
    return {
        //main function to initiate the module
        init: function () {
          
        }
    };

}();

function show_receivable(){
	
	$.ajax({

		data: {"standard_id" : standard_id, "division_id" : division_id},
		url: base_url+'reports_standards/receivable_reports',
		method: "post",
        success: function(response)
        {
            $('#show_details_container').html(response);
        }
	});
}
function show_received(){
	
	$.ajax({

		data: {"standard_id" : standard_id, "division_id" : division_id},
		url: base_url+'reports_standards/received_reports',
		method: "post",
        success: function(response)
        {
            $('#show_details_container').html(response);
        }
	});
}
function show_discout_offered(){

	$.ajax({

		data: {"standard_id" : standard_id, "division_id" : division_id},
		url: base_url+'reports_standards/discount_offered_reports',
		method: "post",
        success: function(response)
        {
            $('#show_details_container').html(response);
        }
	});
}
function show_outstanding(){
	
	$.ajax({

		data: {"standard_id" : standard_id, "division_id" : division_id},
		url: base_url+'reports_standards/outstanding_reports',
		method: "post",
        success: function(response)
        {
            $('#show_details_container').html(response);
        }
	});
}