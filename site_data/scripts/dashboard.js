var pageFunctions = function () {
   
    return {
        //main function to initiate the module
        init: function () {
        	initate_autocomplete();
        	init_datatables();
			
        }
    };

}();

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
                    
                }
            },

            /*"bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.*/
            
            /*"columnDefs": [ {
                "targets": 5,
                "orderable": false,
                "searchable": false
            }],*/

            "lengthMenu": [
                [5, 10, 15, -1],
                [5, 10, 15, "All"] // change per page values here
            ],
		  
            // set the initial value
            "pageLength": 5,            
            /*"pagingType": "bootstrap_full_number",*/
            "order": [
                [0, "asc"]
            ] // set first column as a default sort by asc
        });
}


function initate_autocomplete(){
	$('#student_name').autocomplete({
		source:function(request, response){
		    $.ajax({
		        url: base_url + "dashboard/search_students_source",
		        type: "POST",
		        dataType: "json",
		        data: { search_term: request.term },
		        success: function(responseData){
		            var array = responseData.map(function(element) {
		                return {value: element['name'], id: element['id']};
		            });
		            response(array);
		        }
		    });},
		    minLength:3,
	    select: function (event, ui) {
	        $("#student_name").val(ui.item.value); // display the selected text
	        $("#search_student_id").val(ui.item.id); // save selected id to
														// hidden input
	    }
	});
}

$(document).ready(function() {
	  $('#search_student_from').on('submit', function(e){
	    if( $ ( "#search_student_id" ).val ( ) == "" ) {
	      e.preventDefault();
	    }
	  });
	});