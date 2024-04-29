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
		url: base_url+'reports_standards/get_divisions',
		method: "post",
        success: function(response)
        {
            $('#division_id').html(response);
        }
	});
}
