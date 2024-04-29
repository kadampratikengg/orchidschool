var pageFunctions = function () {
   
    return {
        //main function to initiate the module
        init: function () {
          
        }
    };

}();

function get_divisions(standard_id) {
	$.ajax({

		data: {"standard_id" : standard_id},
		url: base_url+'academic_fees/get_divisions',
		method: "post",
        success: function(response)
        {
            $('#division_id').html(response);
        }
	});
}
function get_instalments(standard_id){
	$.ajax({

		data: {"standard_id" : standard_id},
		url: base_url+'academic_fees/get_instalments',
		method: "post",
        success: function(response)
        {
            $('#standard_instalment_id').html(response);
        }
	});
}

