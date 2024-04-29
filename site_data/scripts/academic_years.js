var pageFunctions = function () 
{
   
    return {
        //main function to initiate the module
        init: function () {
          
	  init_datatables();
	  init_select2();
			
        }
    };

}();
function init_select2()
{
	 $(".select2, .select2-multiple").select2({
            placeholder: "select state",
            width: null
        });
}
function init_datatables()
{
	$("#managed_datatable").dataTable(
	{

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

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "columnDefs": [ {
                "targets": 0,
                "orderable": false,
                "searchable": false
            }],

            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
		  
            // set the initial value
            "pageLength": 5,            
            "pagingType": "bootstrap_full_number",
            "columnDefs": [{  // set default column settings
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });
}

function get_year(year) 
{
	if(year != ""){
		$.ajax({
			data: {"year" : year},
			url: base_url+'academic_years/get_toyear',
			type: 'get',
	        success: function(response)
	        {
	            $("#to_year").html(response);
	        }
		});
	}
	
	
}
